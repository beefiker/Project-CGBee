<?php
    $date = $_REQUEST["date"];
    $title = $_REQUEST["title"];
    $img =  isset($_REQUEST['img']) ? $_REQUEST['img'] : "";
    $contents = $_REQUEST["contents"];
    
    try {
        require("db_connect.php");
            
        $db->exec("insert into board (title, contents, write_date, eventImg)
        values ('$title','$contents','$date','$img')");


    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    header("Location:admin.php");
    exit();
?>