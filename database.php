<?php
$server = 'hbc353.encs.concordia.ca';
$username = 'hbc353_4';
$password = 'sqldb353';
$database = 'hbc353_4';

try{
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e){
    die('Connection Failed: ' . $e->getMessage());
}

?>