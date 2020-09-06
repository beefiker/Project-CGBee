<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

    $ph = $_REQUEST["ph"];
    $movieName = $_REQUEST["movieName"];
    $theater = $_REQUEST["theater"];
    $movieDate = $_REQUEST["date"];
    $headcount = $_REQUEST["headcount"];

    $_SESSION['date'] = substr($movieDate,0,7);
    $_SESSION['theater'] = $theater;

    try {
        require("db_connect.php");        
        $query = $db->query("select * from reservation where reservation_date = '$movieDate' and theater = '$theater'");

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                // header("Location:fail.php");
                // exit();
                ?>
                <script>
                    let win = window.open("/CGBee/fail.php", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=400,height=550");
                    history.back();
                </script>
                <?php
                    exit();
            
        }
        $db->exec("insert into reservation (phone, title, theater, reservation_date, headcount)
        values ('$ph','$movieName', '$theater', '$movieDate','$headcount')");

        // header("Location:done.php");
        // exit();
        ?>
        <p> 예매내역 </p>
        <p> 휴대전화 : <?=$ph?></p>
        <p> 상영관 : <?=$theater?></p>
        <p> 영화이름 : <?=$movieName?></p>
        <p> 상영일자 : <?=$movieDate?></p>
        <p> 인원 수 : <?=$headcount?> </p>
        <?php

        
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    
?>
</body>
</html>