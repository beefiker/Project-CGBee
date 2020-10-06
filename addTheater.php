<?php
    $name = $_REQUEST["theaterName"];
    $img =  isset($_REQUEST['theaterImg']) ? $_REQUEST['theaterImg'] : "https://placeimg.com/100/100/any";
    $amount = $_REQUEST["theaterSeats"];
    
    try {
        require("db_connect.php");
            
        $db->exec("insert into theater (theater_name, seat_amount, img)
        values ('$name','$amount','$img')");


    } catch (PDOException $e) {
        echo "값을 제대로 입력해주세요", "<br>";
        exit($e->getMessage());
    }
    header("Location:admin.php");
    exit();
?>