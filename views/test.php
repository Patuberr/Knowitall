<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require 'vendor/autoload.php';
    $phpmailer = new PHPMailer(true);
    try {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '1d9c33c3499beb';
        $phpmailer->Password = '80e4a07165d43f';
        $phpmailer->SMTPSecure = "tls";
	    $phpmailer->setFrom('vanEmail@example.com', 'Mailer');
	    $phpmailer->addAddress('naarEmail@example.com', 'Joe User');
        $phpmailer->isHTML(true);
	    $phpmailer->Subject = 'Test Email Subject';
        $phpmailer->Body = "test";
	    $phpmailer->send();
        var_dump($phpmailer);
    } catch (Exception $e) {
        echo "Bericht kon niet verzonden worden. Mailer Error: {$phpmailer->ErrorInfo}";
    }




?>
<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>test</p>
</body>
</html> -->
