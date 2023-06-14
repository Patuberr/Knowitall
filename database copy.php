<?php 
class database {
    private $servername = "localhost";
    private $dbUsername = "root"; // Changed variable name to $dbUsername
    private $dbPassword = "";
    private $dbname = "knowitall";
    
    public $conn;

    public function __construct() {

        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->dbUsername, $this->dbPassword);

    }

    

    

}



