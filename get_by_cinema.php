<?php

require('./config/db.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Validate the required info
    if (!isset($_GET['id'])) {
        echo json_encode(["status" => false, "message" => "cinema id is required."]);
        return;
    }

    // Search for movie in database
    $stmt = $connection->prepare('SELECT * FROM movies WHERE cinema_id = ? LIMIT 20');
    $stmt->execute(array($_GET['id']));
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$movies) {
        echo json_encode(["status" => false, "message" => "no movies found."]);
        return;
    }

    $result = [];

    foreach ($movies as $movie) {
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

        // Add the movie to the result
        array_push($result, $movie);
    }


    // Return the result
    echo json_encode(["status" => true, "movies" => $result]);
    return;
}
