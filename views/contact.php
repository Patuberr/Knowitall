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
            $_SESSION['account_id'] = $row['account_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['permission'] = $row['permission'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['logedin'] = true;
            header("Location: /panel");
        } else {
        }
    }
}

if(isset($_POST['contact_submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    try {
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'f407c60d88a282';
        $mail->Password = '25c87a7bc30d5b';
	    $mail->SMTPSecure = 'tls';
	    $mail->setFrom($email, $name);
	    $mail->addAddress('info@knowitall.nl', 'KnowItAll');
	    $mail->isHTML(true);
	    $mail->Subject =    $subject;
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
            text-align: left;
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

        footer {
            text-align: center;
        }
        </style>

        <div class="tekst">
        <p>E-mail: ' . $email . '</p>
        <p>Naam: ' . $name . '</p>
        <p>Datum: ' . date('D d M Y') . '</p>
        <p>Onderwerp: ' . $subject . '</p>
        <p>Bericht: ' . $message . '</p><br> <br> <br>
        <footer>&copy 2023 Team zonder GPT</footer>
        </div>';
	    $mail->send();
	    echo "<script>console.log('Bericht is verzonden')</script>";
	} catch (Exception $e) {
	    echo "<script>console.log('Bericht kon niet verzonden worden. Mailer Error: ' . {$mail->ErrorInfo} . ')</script>";
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
            $mail->Username = 'f407c60d88a282';
            $mail->Password = '25c87a7bc30d5b';
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
            <input type="submit" name="login_submit" class="submitButton" value="Inloggen"> <br>
            <p>Geen account? <a onclick="openRegister()">Registreer</a></p> <br> 
        </form>
    </div>

    <div class="form register" id="register_form">
        <i class="fa-solid fa-x" onclick="closeLogin(2)"></i>
        <h1>Register</h1>
        <form action="" method="post">
            <div class="firstname">
                <label for="firstname">Username</label> <br>
                <ion-icon name="text-outline"></ion-icon>
                <input type="text" name="username" id="firstname" required=true placeholder="username">
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
            <input type="submit" name="register_submit" class="submitButton" value="Registreren"> <br> <br>
        </form>
    </div>

    <div class="page">

        <div class="content">
            <h1>Contact</h1>
            <div class="box">
                <h2 class="contact titel">Verstuur ons een bericht!</h2>
                <form method="post">
                    <input type="text" id="name" name="name" placeholder="Naam"> <br>
                    <input type="email" id="email" name="email" placeholder="E-mail"> <br>
                    <input type="text" id="subject" name="subject" placeholder="Onderwerp"> <br> 
                    <textarea name="message" id="message" placeholder="Bericht"></textarea> <br> 
                    <input type="submit" name="contact_submit" id="submit" value="Verzenden">
                </form> <br>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p class="italic">© 2023 Team zonder GPT</p>
    </footer>
    <script src="https://kit.fontawesome.com/e6d99cb95a.js" crossorigin="anonymous"></script>
    <script src="./assets/js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", "http://knowitall.local/contact");
        }
    </script>
</body>
</html>