<?php
    $num = $_REQUEST["num"];
    $page = empty($_REQUEST["page"]) ? 1 : $_REQUEST["page"];    
    
    try {
        require("db_connect.php");

        $db->exec("delete from board where num=$num");
        
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    
    header("Location:list.php?page=$page");
    exit();
?>