<?php 

$servername = "localhost";
$dbUsername = "root"; // Changed variable name to $dbUsername
$dbPassword = "";
$dbname = "knowitall";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);

