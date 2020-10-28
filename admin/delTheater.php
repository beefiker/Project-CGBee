<?php
$theater = $_REQUEST["theater"];
    try {
        require("db_connect.php");
            
        $db->exec("delete from theater where theater_sn = $theater");
        $db->exec("delete from movieList where theater_sn = $theater");
        
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    header("Location:admin.php");
    exit();
?>