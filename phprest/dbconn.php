<?php

$host         = "localhost";
$username     = "root";
$password     = "root";
$dbname       = "bank";

try {
    $dbconn = new PDO('mysql:host=localhost;dbname=bank', $username, $password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
