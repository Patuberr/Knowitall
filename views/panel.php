<?php
session_start();
include_once("../classes/config/database.php");


$credentialsUser= "SELECT username, email, permission FROM account";
$email = "SELECT username FROM email";

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KnowItAll</title>

    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
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
            <input type="submit" name="login_submit" value="Inloggen"> <br>
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

            <input type="submit" name="register_submit" value="Registreren"> <br> <br>
        </form>
    </div>



    <div class="page">
        <ul class="bar-panel">
            <li onclick="openStatusWeetjes()">Status Weetjes</li>
            <li onclick="OpenWeetjesAanmaken()">Weetje aanmaken</li>
            <li onclick="openIngestuurdeWeetjes()">Ingestuurde weetjes</li>
            <li onclick="openOverzichtWeetjes()">Overzicht weetjes</li>
            <li onclick="openGebruikers()">Gebruikers</li>
        </ul>

    <div class="form status-weetjes" id="status-weetjes-form">
        <i class="fa-solid fa-x" onclick="closeLogin(4)"></i>
        <h1>Status van jou weetjes!</h1>
        <div class="overzicht">
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p style="color: green;">Goedgekeurd</p>
            </div>
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p style="color: red;">Afgekeurd</p>
            </div>
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p style="color: orange;">In afwachting</p>
            </div>
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p style="color: green;">Goedgekeurd</p>
            </div>
        </div> <br>
        
    </div>

    <div class="form weetjes-aanmaken" id="weetjes-aanmaken-form">
        <i class="fa-solid fa-x" onclick="closeLogin(5)"></i>
        <h1>Maak een weetje aan!</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="titel">
                <label for="titel">Titel</label> <br>
                <ion-icon name="text-outline"></ion-icon>
                <input type="text" name="titel" id="titel" required=true placeholder="Titel"> 
            </div><br>
            <div class="weetje">
                <label for="weetje">Weetje</label> <br>
                <ion-icon name="document-text-outline"></ion-icon> <br>
                <textarea name="weetje" id="weetje" cols="30" rows="10" placeholder="Weetje"></textarea>
            </div><br>
            <div class="file">
                <label for="images" class="drop-container">
                <span class="drop-title">Drop files here</span>
                or
                <input type="file" id="images" name="my_image" required=true>
                </label>
            </div> <br>
            <input type="submit" name="itemSubmit" value="Toevoegen"> <br> <br>
        </form>
    </div>

    <div class="form ingestuurde-weetjes" id="ingestuurde-weetjes-form">
        <i class="fa-solid fa-x" onclick="closeLogin(6)"></i>
        <h1>Status van jou weetjes!</h1>
        <div class="overzicht">
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p>Julian Berle</p>
                <select name="status-geven" id="status-geven">
                    <option value="afwachting">In afwacthing</option>
                    <option value="goedgekeurd">Goedkeuren</option>
                    <option value="afgekeurd">Afkeuren</option>
                </select>
            </div>
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p>Jeroen van Ark</p>
                <select name="status-geven" id="status-geven">
                    <option value="afwachting">In afwacthing</option>
                    <option value="goedgekeurd">Goedkeuren</option>
                    <option value="afgekeurd">Afkeuren</option>
                </select>
            </div>
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p>Patrick van Dijk</p>
                <select name="status-geven" id="status-geven">
                    <option value="afwachting">In afwacthing</option>
                    <option value="goedgekeurd">Goedkeuren</option>
                    <option value="afgekeurd">Afkeuren</option>
                </select>
            </div>
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p>Efe Bakir</p>
                <select name="status-geven" id="status-geven">
                    <option value="afwachting">In afwacthing</option>
                    <option value="goedgekeurd">Goedkeuren</option>
                    <option value="afgekeurd">Afkeuren</option>
                </select>
            </div>
        </div> <br>
        
    </div>

    <div class="form overzicht-weetjes" id="overzicht-weetjes-form">
        <i class="fa-solid fa-x" onclick="closeLogin(7)"></i>
        <h1>Overzicht van alle weetjes!</h1>
        <div class="overzicht">
            
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p>Julian Berle</p>
                <div class="buttons">
                    <button class="orange">Bewerken</button>
                    <button class="red">Verwijder</button>
                </div>
            </div>
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p>Jeroen van Ark</p>
                <div class="buttons">
                    <button class="orange">Bewerken</button>
                    <button class="red">Verwijder</button>
                </div>
            </div>
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p>Patrick van Dijk</p>
                <div class="buttons">
                    <button class="orange">Bewerken</button>
                    <button class="red">Verwijder</button>
                </div>
            </div>
            <div class="status">
                <p>Koningsdag</p>
                <p>20-02-2023</p>
                <p>Efe Bakir</p>
                <div class="buttons">
                    <button class="orange">Bewerken</button>
                    <button class="red">Verwijder</button>
                </div>
            </div>
        </div> <br>
        
    </div>

    <div class="form gebruikers" id="gebruikers-form">
        <i class="fa-solid fa-x" onclick="closeLogin(8)"></i>
        <h1>Overzicht van alle weetjes!</h1>
        <div class="overzicht">

        <?php
            $stmn = $conn->prepare($credentialsUser);
            $stmn->execute();
            while ($row = $stmn->fetch()) {
        echo "<div class='gebruiker'>";
        echo "<p>Name: " . $row["username"]. "</p>";
        echo "<p>Permission: " .$row["permission"]. "</p>";
        echo "<p>Email: " . $row["email"]. "</p>";
        echo "<div class='buttons'>";
        echo"<button class='red'>Verbannen</button>";
        echo "</div>";
        echo "</div>";
      }
      ?>
           
        </div> <br>
        
    </div>
    </div>

    <div class="footer">
        <p class="italic">© 2023 Team zonder GPT</p>
    </div>
    <script src="https://kit.fontawesome.com/e6d99cb95a.js" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>