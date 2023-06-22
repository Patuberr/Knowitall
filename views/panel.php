<?php
session_start();
include_once("./classes/config/database.php");

if ($_SESSION['logedin'] == 0) {
    header("Location: /");

} else {
}

if(isset($_GET['delete-message'])) {
    $id = ((int)$_GET["delete-message"]);

    $sql = "DELETE FROM message WHERE message_id=?";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$id]);
}

if(isset($_GET['delete-user'])) {
    $id = ((int)$_GET["delete-user"]);
    $sql = "SELECT * FROM account WHERE account_id=? AND permission = 1";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$id]);
    $rowCount = $stmt->rowCount();

    if($rowCount > 0) {
        $sql = "UPDATE account SET ban = 1 WHERE account_id=? AND permission = 1";
        $stmt= $conn->prepare($sql);
        $stmt->execute([$id]);
    } else {
        echo "De permissie van deze gebruiker is te hoog om te verbannen";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /");
}

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
        'account_account_id' => $_SESSION['account_id'],
        'image' => $new_img_name
    ];

    $insert = "INSERT INTO message (post_date, title, approval, description, fact_date, image, account_account_id)
    values(:post_date, :title, :approval, :description, :fact_date, :image, :account_account_id)";

    $statement = $conn->prepare($insert);

    $statement->execute($messageData);

    try {
	    $mail->isSMTP();
	    $mail->Host = 'sandbox.smtp.mailtrap.io';
	    $mail->SMTPAuth = true;
        $mail->Username = '22966c4970ed6b';
        $mail->Password = '4b80655fb3c310';
	    $mail->Port = 2525;
	    $mail->SMTPSecure = 'tls';
	    $mail->setFrom($_SESSION['email'], $_SESSION['username']);
	    $mail->addAddress('admin@knowitall.nl', 'Admin');
	    $mail->isHTML(true);
	    $mail->Subject =    'Nieuw weetje!';
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
        <p>' . $_SESSION['username'] . ' heeft een weetje achtergelaten!<br> <br>
        Bekijk de website om het weetje te beoordelen.</p>
        <a href="http://knowitall.local/panel" target="_blank">Website</a> <br> <br> <br>
        <footer>&copy 2023 Team zonder GPT</footer>
        </div>';
	    $mail->send();
	    echo "<script>console.log('Bericht is verzonden')</script>";
	} catch (Exception $e) {
	    echo "<script>console.log('Bericht kon niet verzonden worden. Mailer Error: ' . {$mail->ErrorInfo} . ')</script>";
    }
} else {
    // echo "Ging iets fout";
}

if(isset($_POST['approvalSubmit'])){
    $message_id = $_GET["status"];
    $approval = $_POST["status-geven"];
    $reason = $_POST['reason'];
    $username = $_GET['username'];
    $email = $_GET['email'];
    
    switch($approval) {
        case "goedgekeurd":
            $approvalnummer = 2;
            break;
        case "afgekeurd":
            $approvalnummer = 1;
            break;
        case "afwachting":
            $approvalnummer = 0;
            break;
    }

    $sql = "UPDATE message SET approval=$approvalnummer WHERE message_id = $message_id";
    $sth = $conn->prepare($sql);
    $sth->execute();

    try {
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '22966c4970ed6b';
        $mail->Password = '4b80655fb3c310';
        $mail->Port = 2525;
        $mail->SMTPSecure = 'tls';
        $mail->setFrom('admin@knowitall.nl', 'Admin');
        $mail->addAddress($email, $username);
        $mail->isHTML(true);
        $mail->Subject =    'Weetje ' . $approval . '!';
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
        <p>Beste test,<br> <br>
        Je weetje is ' . $approval . ' met de reden: ' . $reason . ' <script>akeurReden</script></p>
        <a href="http://knowitall.local/panel" target="_blank">Website</a> <br> <br>
        <p>KnowItAll team</p> <br>
        <footer>&copy 2023 Team zonder GPT</footer>
        </div>';
        sleep(5);
        $mail->send();
        echo "<script>console.log('Bericht is verzonden')</script>";
    } catch (Exception $e) {
        echo "<script>console.log('Bericht kon niet verzonden worden. Mailer Error: ' . {$mail->ErrorInfo} . ')</script>";
    }
    
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
                <li class="nav-item">
                    <a href="/panel?logout" class="nav-link"><i class="fa-solid fa-right-from-bracket"></i></a>
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
            <?php 
                $sessionAccountId = $_SESSION['account_id'];
                $query = $conn->query("SELECT * FROM message WHERE account_account_id = $sessionAccountId");
            
                while($row = $query->fetch()) {
                    // echo $row['message_id'] ." " . $row['post_date'] . " " . $row['approval'] . " " . $row['description'] . " " . $row['fact_date'] . " " . $row['image'] . " " . $row['account_account_id'];
                    switch ($row['approval']) {
                        case 0:
                            $styleColor = "orange";
                            $approvalName = "In afwachting";
                            break;
                        case 1:
                            $styleColor = "red";
                            $approvalName = "Afgekeurd";
                            break;
                        case 2:
                            $styleColor = "green";
                            $approvalName = "Goedgekeurd";
                            break;
                        default:
                            echo "<script>console.log('Er ging iets fout met de kleuren')";
                    }
                    echo "
                    <div class='status'>
                        <p>" . $row['title'] . "</p>
                        <p>" . $row['post_date'] . "</p>
                        <p style='color:" . $styleColor . "';>" . $approvalName . "</p>
                    </div>";
                };
            ?>
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
            <input type="submit" name="itemSubmit" class="submitButton" value="Toevoegen"> <br> <br>
        </form>
    </div>

    <div class="form ingestuurde-weetjes" id="ingestuurde-weetjes-form">
        <i class="fa-solid fa-x" onclick="closeLogin(6)"></i>
        <h1>Ingestuurde weetjes!</h1>
        <div class="overzicht">
        <?php 
                $sessionAccountId = $_SESSION['account_id'];
                $query = $conn->query("SELECT * FROM message INNER JOIN account on message.account_account_id = account.account_id WHERE approval = 0 ORDER BY message_id DESC");

                while($row = $query->fetch()) {
                    echo "
                    <div class='status'>
                        <p>" . $row['title'] . "</p>
                        <p id = 'descriptionText'>" . $row['description'] . "</p>
                        <p>" . $row['post_date'] . "</p>
                        <p>" . $row['username'] . "</p>
                        <div class='selectButtons'>
                        <form class='form-ingestuurde-weetjes' method='post' action='?status=" . $row['message_id'] ."&username=" . $row['username'] . "&email=" . $row['email'] . "'>
                        <select name='status-geven' id='status-geven' required=true>
                            <option name='afwachting' value='afwachting'>In afwacthing</option>
                            <option name='goedgekeurd' value='goedgekeurd'>Goedkeuren</option>
                            <option name='afgekeurd' value='afgekeurd'>Afkeuren</option>
                        </select>
                        <input type='text' name='reason' placeholder='Reden' class='reason' required=true>
                        <input  type='submit' name='approvalSubmit' value='Bevestig' class='submitButtonStatus'>
                        </form>
                        </div>
                    </div>";
                };
            ?>
        </div> <br>
        
    </div>

    <div class="form overzicht-weetjes" id="overzicht-weetjes-form">
        <i class="fa-solid fa-x" onclick="closeLogin(7)"></i>
        <h1>Overzicht van alle goedgekeurde weetjes weetjes!</h1>

        <div class="overzicht">
        <?php 
                $query = $conn->query("SELECT * FROM message INNER JOIN account on message.account_account_id = account.account_id WHERE approval = 2 ORDER BY message_id DESC");
                while($row = $query->fetch()) {
                    echo "
                    <div class='status'>
                        <p>" . $row['title'] . "</p>
                        <p>" . $row['post_date'] . "</p>
                        <p>" . $row['username'] . "</p>
                        <div class='buttons'>
                            <button onclick='location.href= `?delete-message=" . $row['message_id'] . "`' class='red'>Verwijder</button>
                        </div>
                    </div>";
                };
            ?>
        </div> <br>
        
    </div>

    <div class="form gebruikers" id="gebruikers-form">
        <i class="fa-solid fa-x" onclick="closeLogin(8)"></i>
        <h1>Gebruikers!</h1>
        <div class="overzicht">

        <?php
            $credentialsUser= "SELECT * FROM account";
            $stmn = $conn->prepare($credentialsUser);
            $stmn->execute();
            while ($row = $stmn->fetch()) {
                switch ($row['permission']) {
                    case 1:
                        $permissionName = "Gebruiker";
                        break;
                    case 2:
                        $permissionName = "Admin";
                        break;
                    case 3:
                        $permissionName = "Beheerder";
                        break;
                    default:
                        $permissionName = "Er is een fout opgetreden";
                        break;

                }

                switch ($row['ban']) {
                    case 0: 
                        $banName = "nee";
                        break;
                    case 1:
                        $banName = "Ja";
                        break;
                    default:
                        $banName = "Er is een fout opgetreden";
                        break;
                }

                echo "
                <div class='gebruiker'>
                    <p>" . $row['username'] . "</p>
                    <p>" . $permissionName . "</p>
                    <p>" . $row['email'] . "</p>
                    <p>Verbannen: " . $banName . "</p>
                    <div class='buttons'>
                        <button class='red' onclick='location.href = `?delete-user=" . $row['account_id'] . "`'>Verbannen</button>
                    </div>
                </div>";
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
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", "http://knowitall.local/panel");
        }
    </script>
</body>
</html>