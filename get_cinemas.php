<?php

require('./config/db.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Search for movies in database
    $stmt = $connection->prepare('SELECT * FROM cinemas ORDER BY id DESC LIMIT 20');
    $stmt->execute(array());
    $cinemas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the result
    echo json_encode(["status" => true, "cinemas" => $cinemas]);
    return;
}
