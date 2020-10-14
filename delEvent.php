<?php
    $id = $_REQUEST["eventId"];
    try {
        require("db_connect.php");
            
        $db->exec("delete from board where id = $id");


    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    header("Location:admin.php");
    exit();
?>