<?php
$theater = $_REQUEST["theater"];
$movie = $_REQUEST["movie"];


    try {
        require("db_connect.php");


        for($i=0; $i<count($movie); $i++){
            $db->exec("insert into movieList(theater_sn, movie_id) 
            values($theater,$movie[$i])");
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    header("Location:admin.php");
    exit();
?>