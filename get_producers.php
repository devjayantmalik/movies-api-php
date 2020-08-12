<?php

require('./config/db.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Search for movies in database
    $stmt = $connection->prepare('SELECT * FROM producers ORDER BY id DESC LIMIT 20');
    $stmt->execute(array());
    $producers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the result
    echo json_encode(["status" => true, "producers" => $producers]);
    return;
}
