<?php
session_start();
include_once("./classes/config/database.php");
include_once("./classes/config/mail.php");

if(!isset($_SESSION['logedin'])) {
    $_SESSION['logedin'] = false;
} else {
    // return();
}

if(isset($_POST['login_submit'])) {
    $email = $_POST['email_login'];
    $password = $_POST["password_login"];

    $query = 'SELECT * FROM account WHERE (email = :email)';
    $statement = $conn->prepare($query); 
    $statement->execute([':email' => $email]);  
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    
    if (is_array($row)) {
        if (password_verify($password, $row['userpassword'])){
            if ($row["ban"] == 1) {
                echo "<script type='text/javascript'>alert('Dit account is verbannen!');</script>";
            }
            else {
                $_SESSION['account_id'] = $row['account_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['permission'] = $row['permission'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['logedin'] = true;
            header("Location: /panel");
            }
            
        } else {
            echo "Wachtwoord is onjuist!";
        }
    }
}

if(isset($_POST["register_submit"])) {
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST["email"]);
    $userPassword = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT); // Changed variable name to $userPassword

    $sql = "SELECT * FROM account WHERE email = :email";
    $sth = $conn->prepare($sql);
    $sth->execute([':email' => $email]);
    $exists = $sth->fetch();

    if ($exists) {
        echo "<script>alert('Email is al ingebruik')</script>";
    } else {
        $sql = "INSERT INTO account (username, email, userpassword) VALUES (:username,:email,:userpassword)";
        $sth = $conn->prepare($sql);
        $sth->execute(['username' => $username, 'email' => $email, 'userpassword' => $userPassword]);

        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '22966c4970ed6b';
            $mail->Password = '4b80655fb3c310';
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('info@knowitall.nl', 'KnowItAll');
            $mail->addAddress("$email", "$username");
            $mail->isHTML(true);
            $mail->Subject =    'Registratie bij KnowItAll';
            $mail->Body    = ' <style>
            * {
                font-family: Arial;
                font-weight: bold;
            }
    
            body {
                background-color: #eee;
            }
    
            .tekst {
                width: 600px;
                margin: 0 auto;
                padding: 0 20px 10px 20px;
                background-color: #fff;
                border: 1px solid rgba(0,0,0,.25);
                text-align: center;
            }
    
            a {
                    color: #000;
                    margin: 0 auto;
                    padding: 7px 13px;
                    border-radius: 100px;
                    text-decoration: none;
                    border: 3px solid black;
                    transition: .3s ease;
            }
    
            a:hover {
                background-color: #000;
                color: #fff;
            }
    
            h1 {
                font-family: helvetica;
            }
            </style>
    
            <div class="tekst">
            <h1>KnowItAll</h1>
            <p>Welkom ' . $username . ',<br> <br>
            leuk dat je je geregistreerd hebt bij KnowItAll. Klik op de knop hier beneden om weer naar de website te gaan. </p>
            <a href="http://knowitall.local/" target="_blank">Website</a> <br> <br>
            KnowItAll team. <br> <br> <br>
            <footer>&copy 2023 Team zonder GPT</footer>
            </div>';
            $mail->send();
            echo "<script>console.log('Bericht is verzonden')</script>";
        } catch (Exception $e) {
            echo "<script>console.log('Bericht kon niet verzonden worden. Mailer Error: ' . {$mail->ErrorInfo} . ')</script>";
        }
    }
}

?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KnowItAll</title>

    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="#" class="nav-logo">KnowItAll</a>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="/" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/weetjes" class="nav-link">Weetjes</a>
                </li>
                <li class="nav-item">
                    <a href="/contact" class="nav-link">Contact</a>
                </li>
                <li class="nav-item">
                    <a onclick="login(<?php echo $_SESSION['logedin'] ?>)" class="nav-link"><i class="fa-solid fa-person"></i></a>
                </li>
            </ul>
            <div class="hamburger" id="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>


    <div class="form login" id="login_form">
        <i class="fa-solid fa-x" onclick="closeLogin(1)"></i>
        <h1 class="logo">KnowItAll</h1>
        <form action="" method="post">
            <div class="email">
                <label for="email_login">Email Adress</label> <br>
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" name="email_login" id="email_login" required=true placeholder="username@mail.com">
            </div> <br>
            <div class="password">
                <label for="password_login">Password</label> <br>
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input type="password" name="password_login" id="id_password_1" required=true placeholder="············">
                <ion-icon name="eye-outline" id="eye_1" onclick="togglePassword(1)"></ion-icon>
            </div> <br>
            <input type="submit" class="submitButton" name="login_submit" value="Inloggen"> <br>
            <p>Geen account? <a onclick="openRegister()">Registreer</a></p> <br> 
        </form>
    </div>

    <div class="form register" id="register_form">
        <i class="fa-solid fa-x" onclick="closeLogin(2)"></i>
        <h1>Register</h1>
        <form action="" method="post">
            <div class="username">
                <label for="username">username</label> <br>
                <ion-icon name="text-outline"></ion-icon>
                <input type="text" name="username" id="username" required=true placeholder="username">
            </div><br>
            <div class="mail">
                <label for="email">E-mail adress</label> <br>
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" name="email" id="email" required=true placeholder="username@mail.com">
            </div><br>
            <div class="password">
                <label for="password">Password</label> <br>
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input type="password" name="password" id="id_password_2" required=true placeholder="············">
                <ion-icon name="eye-outline" id="eye_2" onclick="togglePassword(2)"></ion-icon>
            </div><br>

            <input type="submit" class="submitButton" name="register_submit" value="Registreren"> <br> <br>
        </form>
    </div>



    <div class="page">

        <div class="content">
            <h1>Weetje van de dag!</h1>
            <?php
                    $date = date("Y-m-d");
                    $query = $conn->query("SELECT * FROM message INNER JOIN account on message.account_account_id = account.account_id WHERE approval = 2 AND fact_date = '$date' ORDER BY message_id DESC");
                    if ($query->rowCount() === 0) {
                        echo "<div class='no-sql'>
                            <h3>Er is voor vandaag nog geen weetje</h2>
                            <p>Login om een weetje aan te maken of klik <a href='/weetjes'>hier</a> om alle weetjes te zien.</p>
                            <p>KnowItAll Team</p>
                        </div>";
                        // exit();
                    } else {
                        while($row = $query->fetch()) {                        
                            echo "
                            <div class='box'>
                                <div class='content'> 
                                    <div class='images'>
                                        <img src='./assets/images/weetjes/" . $row['image'] . "' alt='" . $row['image'] . "'>
                                    </div>
                                    <div class='tekst'>
                                        <h2 class='titel'>" . $row['title'] . "</h2>
                                        <p class='date italic'>" . $row['fact_date'] . "</p>
                                        <p>" . $row['description'] . "</p>
                                        <p class='italic'>Auteur: " . $row['username'] . "</p>
                                        <p class='date italic'>" . $row['post_date'] . "</p>
                                    </div>
                                </div>
                            </div>";
                        }
                    }
            
                    
            ?>
        </div> 
    </div>

    <div class="footer">
        <p class="italic">© 2023 Team zonder GPT</p>
    </div>
    <script src="https://kit.fontawesome.com/e6d99cb95a.js" crossorigin="anonymous"></script>
    <script src="./assets/js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", "http://knowitall.local/");
        }
    </script>
</body>
</html>