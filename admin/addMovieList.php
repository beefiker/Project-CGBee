<?php
$theater = $_REQUEST["theater"];
$movie = $_REQUEST["movie"];

    try {

        require("db_connect.php");

        for($i=0; $i<count($movie); $i++){

            $query = $db->query("select * from movieList where theater_sn = $theater and movie_id = $movie[$i]");

            if (!($row = $query->fetch(PDO::FETCH_ASSOC))) {
                $db->exec("insert into movieList(theater_sn, movie_id) 
                values($theater,$movie[$i])");
            }
        }
        
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    header("Location:admin.php");
    exit();
?>