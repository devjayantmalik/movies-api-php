<?php

$host = 'localhost';
$port = '3600';
$database = "movies";
$user = 'acer';
$pass = 'password';

$connection = new PDO("mysql:host=$host;port=$port;dbname=$database;", $user, $pass);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: X-Requested-With");
