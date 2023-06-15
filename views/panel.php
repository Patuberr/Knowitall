<?php
session_start();
include_once("./classes/config/database.php");

$credentialsUser= "SELECT username, email, permission FROM account";

echo $_SESSION['account_id'] . $_SESSION['username'] . $_SESSION['permission'] . $_SESSION['email'] . $_SESSION['logedin'];

if (isset($_POST['itemSubmit'])) {
    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $error = $_FILES['my_image']['error'];

    if ( $error === 0) {
        if ($img_size > 9999999999999999999999) {
            echo "Sorry, your file is too large";
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = ['jpg', 'jpeg', 'png'];
            if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true). '.' . $img_ex_lc;
                    $img_upload_path = './assets/images/weetjes/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
            } else {
                echo "You can't upload files of this type";
            }
        } 
    } else {
        echo "Unknow error occured. Try again later";
    }

    $messageData = [
        'post_date' => date("Y/m/d"),
        'title' => htmlspecialchars($_POST['titel']),
        'approval' => 0,
        'description' => htmlspecialchars($_POST['weetje']),
        'fact_date' => htmlspecialchars($_POST['weetje-datum']),
        'account_account_id' => 70,
        'image' => $new_img_name
    ];

    $insert = "INSERT INTO message (post_date, title, approval, description, fact_date, image, account_account_id)
    values(:post_date, :title, :approval, :description, :fact_date, :image, :account_account_id)";

    $statement = $conn->prepare($insert);

    $statement->execute($messageData);
} else {
    echo "Ging iets fout";
}

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
            </ul>
            <div class="hamburger" id="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>

    <?php 

        if ($_SESSION['permission'] == 1) {
            echo "
                <ul class='bar-panel'>
                    <li onclick='openStatusWeetjes()'>Status Weetjes</li>
                    <li onclick='OpenWeetjesAanmaken()'>Weetje aanmaken</li>
                </ul>
        ";
        } elseif ($_SESSION['permission'] == 2) {
            echo "
                <ul class='bar-panel'>
                    <li onclick='openStatusWeetjes()'>Status Weetjes</li>
                    <li onclick='OpenWeetjesAanmaken()'>Weetje aanmaken</li>
                    <li onclick='openIngestuurdeWeetjes()'>Ingestuurde weetjes</li>
                    <li onclick='openOverzichtWeetjes()'>Overzicht weetjes</li>
                    <li onclick='openGebruikers()'>Gebruikers</li>
                </ul>        
        ";
        } elseif ($_SESSION['permission'] == 3) {
            echo "
                <ul class='bar-panel'>
                    <li onclick='openStatusWeetjes()'>Status Weetjes</li>
                    <li onclick='OpenWeetjesAanmaken()'>Weetje aanmaken</li>
                    <li onclick='openIngestuurdeWeetjes()'>Ingestuurde weetjes</li>
                    <li onclick='openOverzichtWeetjes()'>Overzicht weetjes</li>
                    <li onclick='openGebruikers()'>Gebruikers</li>
                </ul>        
        ";
        }
    ?>
    <div class="page">

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
            <div class="fact_date">
                <label for="weetje-datum">Datum weetje</label> <br>
                <ion-icon name="calendar-outline"></ion-icon>
                <input type="date" name="weetje-datum" id="weetje-datum" required=true> 
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