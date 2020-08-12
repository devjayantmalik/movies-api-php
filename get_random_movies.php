<?php

require('./config/db.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Search for movies in database
    $stmt = $connection->prepare('SELECT COUNT(*) as count FROM movies;');
    $stmt->execute(array());
    $count = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['count'];

    // Check if no movies exists
    if (!$count) {
        echo json_encode(["status" => false, "message" => "no movies found."]);
        return;
    }

    // Generate 20 random numbers between 1 and count
    $nums = [];
    $iter = $count;
    for ($i = 1; $i <= $iter; $i++) {
        $num = random_int(1, $count);
        if (array_search($num, $nums) === false) {
            $nums[] = $num;
        } else {
            $iter = $iter + 1;
        }
    }

    // Get the movies generated as random numbers
    $results = [];
    foreach ($nums as $num) {

        // Search for movie in database
        $stmt = $connection->prepare('SELECT * FROM movies WHERE id = ?');
        $stmt->execute(array($num));
        $movie = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

        if (!$movie) {
            continue;
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

        // add to result
        $results[] = $movie;
    }



    // Return the result
    echo json_encode(["status" => true, "movies" => $results]);
    return;
}
