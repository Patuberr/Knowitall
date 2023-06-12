<?php
    // Importeer de PHPMailer klassen in de globale namespace
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	 
	require 'vendor/autoload.php'; // pad naar de autoload.php die door Composer is gecreëerd
	 
    $mail = new PHPMailer(true);

?>