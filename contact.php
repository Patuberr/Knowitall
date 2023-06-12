<?php
session_start();

include_once("./classes/config/database.php");

if(isset($_POST['login_submit'])) {
    $email = $_POST['email_login'];
    $password = $_POST["password_login"];

    $query = 'SELECT * FROM account WHERE (email = :email)';
    $statement = $conn->prepare($query); 
    $statement->execute([':email' => $email]);  
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (is_array($row)) {
        if (password_verify($password, $row['userpassword'])){
            echo "Wachtwoord is juist!";
        } else {
            echo "Wachtwoord is onjuist!";
        }
    }
}

if(isset($_POST["register_submit"])) {
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST["email"]);
    $userPassword = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT); // Changed variable name to $userPassword


    $sql = "INSERT INTO account (username, email, userpassword) VALUES (:username,:email,:userpassword)";
    $sth = $conn->prepare($sql);
    $sth->execute(['username' => $username, 'email' => $email, 'userpassword' => $userPassword]);
}

?>

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
                    <a href="./index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="./weetjes.php" class="nav-link">Weetjes</a>
                </li>
                <li class="nav-item">
                    <a href="./contact.php" class="nav-link">Contact</a>
                </li>
                <li class="nav-item">
                    <a onclick="login()" class="nav-link"><i class="fa-solid fa-person"></i></a>
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
            <input type="submit" name="submit" value="Inloggen"> <br>
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
            <input type="submit" name="register_submit" value="Registreren"> <br> <br>
        </form>
    </div>

    <div class="page">

        <div class="content">
            <h1>Contact</h1>
            <div class="box">
                <h2 class="contact titel">Verstuur ons een bericht!</h2>
                <form action="">
                    <input type="text" id="name" name="name" placeholder="Naam"> <br>
                    <input type="email" id="email" name="email" placeholder="E-mail"> <br>
                    <input type="text" id="subject" name="subject" placeholder="Onderwerp"> <br> 
                    <textarea name="message" id="message" placeholder="Bericht"></textarea> <br> 
                    <input type="submit" name="submit" id="submit" value="Verzenden">
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
</body>
</html>