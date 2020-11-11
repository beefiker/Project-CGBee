<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $name = $_REQUEST["theaterName"];
    $img =  isset($_REQUEST['theaterImg']) ? $_REQUEST['theaterImg'] : "https://placeimg.com/100/100/any";
    $amount = $_REQUEST["theaterSeats"];
    
    try {
        require("db_connect.php");
        $query = $db->query("select * from theater where theater_name = '$name'");
            
        if (!($row = $query->fetch(PDO::FETCH_ASSOC))) {
            $db->exec("insert into theater (theater_name, seat_amount, img)
            values ('$name','$amount','$img')");
        }

    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    header("Location:admin.php");
    exit();
?>
</body>
</html>
