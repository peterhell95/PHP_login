<?php

$db_host = "mysql.rackhost.hu";
$db_user = "c12500peterhell9";
$db_pass = "";
$db_name = "";

try {    
    //create PDO connection 
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch(PDOException $e) {
    //show error
    die("Hiba történt: " . $e->getMessage());
}
