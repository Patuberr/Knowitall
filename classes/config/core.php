<?php 
class core 
{ 
    public static $home_url="http://jouwwebsite.nl/save_login/"; 
    public static function init() { 
        // show error reporting 
        error_reporting(E_ALL); 
        
        // start php 
        session_start(); 
        
        // set your default time-zone 
        date_default_timezone_set('Europe/Amsterdam'); 
    } 
}