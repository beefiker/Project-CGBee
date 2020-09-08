<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<style>
    @import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);
    *{
        font-family: "Monsterrat","Jeju Gothic", serif;
        margin: 0;
        padding: 0;
        list-style: none;
        font-weight: Medium;
        font-size: 15px;
        text-decoration: none;
    }

    body{
        background-color:#131313;
    }
    h1{
        font-size: 3rem;
    }
    h2{
        font-size: 1.8rem;
    }
    p, span{
        font-size: 1.5rem;
    }
    h2, p{
        color:gray;
    }
    span{
        color:#f9c901;
    }
    #wrapper{
        position: absolute;
        width:100%;
        height:100%;
        display:flex;
        flex-direction:column;
        justify-content: center;
        align-items: center;
        color:white;
    }
    img{
        position: relative;
        width:30%;

    }
</style>

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

    $poster = isset($_SESSION['poster']) ? $_SESSION['poster'] : "";

    try {
        require("db_connect.php");
        $query = $db->query("select * from reservation where reservation_date = '$movieDate' and theater = '$theater'");

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
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

        ?>

        <div id="wrapper">
        <h1> 예매가 완료되었따</h1> <br>

        <h2> <span><?=$ph?></span>님의 예매내역</h2><br>
        <img src="<?=$poster?>" alt=""> <br>
        
        <p> <span><?=$movieDate?></span>일 <span><?=$theater?></span> 상영관 </p> <br>
        <p> 인원 <span> <?=$headcount?></span>명 </p> <br>
        </div>
        <?php

        
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    
?>
</body>
</html>