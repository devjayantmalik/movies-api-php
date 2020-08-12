<?php


require('./db.php');

$create_cinemas_table_query = <<<EOT
    
CREATE TABLE IF NOT EXISTS cinemas(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL UNIQUE
);
EOT;

$stmt = $connection->prepare($create_cinemas_table_query);
$stmt->execute(array());


$create_producers_table_query = <<<EOT
    
CREATE TABLE IF NOT EXISTS producers(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL UNIQUE
);
EOT;

$stmt = $connection->prepare($create_producers_table_query);
$stmt->execute(array());



$create_resolutions_table_query = <<<EOT
    
CREATE TABLE IF NOT EXISTS resolutions(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    resolution_1080 TEXT,
    resolution_720 TEXT,
    resolution_480 TEXT,
    resolution_320 TEXT,
    resolution_240 TEXT
);

EOT;


$stmt = $connection->prepare($create_resolutions_table_query);
$stmt->execute(array());



$create_movie_table_query = <<<EOT
    
CREATE TABLE IF NOT EXISTS movies(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    poster TEXT DEFAULT NULL,
    title VARCHAR(200) NOT NULL UNIQUE,
    `description` TEXT DEFAULT NULL,
    length VARCHAR(20) NOT NULL DEFAULT "00:00:00",
    filesize VARCHAR(20) NOT NULL DEFAULT "0 B",
    resolution_id INTEGER NOT NULL,
    cinema_id INTEGER NOT NULL,
    producer_id INTEGER NOT NULL,
    FOREIGN KEY (cinema_id) REFERENCES cinemas(id),
    FOREIGN KEY (producer_id) REFERENCES producers(id),
    FOREIGN KEY (resolution_id) REFERENCES resolutions(id)
);

EOT;


$stmt = $connection->prepare($create_movie_table_query);
$stmt->execute(array());


$insert_sample_data_query = <<<EOT
    
INSERT INTO cinemas(title) VALUES ('Hollywood'), ('Bollywood'), ('Adult');
INSERT INTO producers (title) VALUES ('Brazzers'), ('Digital Sin'), ('Pure Taboo');

INSERT INTO resolutions (resolution_1080, resolution_720, resolution_480, resolution_320, resolution_240) VALUES
	('/movies/1080p.mp4', '/movies/720p.mp4', '/movies/480p.mp4', '/movies/320p.mp4','/movies/240p.mp4' );
    

INSERT INTO `movies` (poster, title, `description`, length, filesize, resolution_id, cinema_id, producer_id) VALUES
			('/images/movie.jpg', 'Movie 1', 'No description available right now', '2:40:00', '2 GB', 1, 3, 1),
            ('/images/movie.jpg', 'Movie 2', 'No description available right now', '2:40:00', '2 GB', 1, 3, 1),
            ('/images/movie.jpg', 'Movie 3', 'No description available right now', '2:40:00', '2 GB', 1, 3, 1),
            ('/images/movie.jpg', 'Movie 4', 'No description available right now', '2:40:00', '2 GB', 1, 3, 2),
            ('/images/movie.jpg', 'Movie 5', 'No description available right now', '2:40:00', '2 GB', 1, 3, 2),
            ('/images/movie.jpg', 'Movie 6', 'No description available right now', '2:40:00', '2 GB', 1, 3, 2),
            ('/images/movie.jpg', 'Movie 7', 'No description available right now', '2:40:00', '2 GB', 1, 3, 3),
            ('/images/movie.jpg', 'Movie 8', 'No description available right now', '2:40:00', '2 GB', 1, 3, 3),
            ('/images/movie.jpg', 'Movie 9', 'No description available right now', '2:40:00', '2 GB', 1, 3, 3);
            

EOT;


// $stmt = $connection->prepare($insert_sample_data_query);
// $stmt->execute(array());
