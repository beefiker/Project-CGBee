<?php
    $sn = $_REQUEST["sn"];
        try {
            require("db_connect.php");
                
            $db->exec("delete from reservation where reservation_sn  = $sn");
            $db->exec("delete from screening where reservation_sn = $sn");
            $db->exec("delete from seat where reservation_sn = $sn");
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        header("Location:history.php");
        exit();
?>