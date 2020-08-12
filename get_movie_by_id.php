<?php

require('./config/db.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Extract required info
    // $id = $_GET['id'];

    // Validate the required info
    if (!isset($_GET['id'])) {
        echo json_encode(["status" => false, "message" => "Movie id is required."]);
        return;
    }

    // Search for movie in database
    $stmt = $connection->prepare('SELECT * FROM movies WHERE id = ?');
    $stmt->execute(array($_GET['id']));
    $movie = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

    if (!$movie) {
        echo json_encode(["status" => false, "message" => "Invalid movie id provided."]);
        return;
    }

    // Get producer of the movie
    $stmt = $connection->prepare('SELECT * FROM producers WHERE id = ?');
    $stmt->execute(array($movie['producer_id']));
    $producer = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

    // get cinema of the movie
    $stmt = $connection->prepare('SELECT * FROM cinemas WHERE id = ?');
    $stmt->execute(array($movie['cinema_id']));
    $cinema = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

    // get resolution of the movie
    $stmt = $connection->prepare('SELECT * FROM resolutions WHERE id = ?');
    $stmt->execute(array($movie['resolution_id']));
    $resolution = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];


    // Add producer and cinema to the result

    $movie['producer'] = $producer;
    $movie['cinema'] = $cinema;
    $movie['resolutions'] = $resolution;

    unset($movie['cinema_id']);
    unset($movie['producer_id']);

    // Return the result
    echo json_encode(["status" => true, "movie" => $movie]);
    return;
}
