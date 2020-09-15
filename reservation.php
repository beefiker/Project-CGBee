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
        color : #faf3dd;
    }
    h2{
        font-size: 1.8rem;
    }
    p, span{
        font-size: 1.5rem;
    }
    h2, p{
        color:white;
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

    $ph = $_SESSION['ph'];
    $theater = $_SESSION["theater"];

    $date = $_SESSION['date'];

    $seat = $_REQUEST['seat'];
    $headcount = count($seat);

    $r_sn = $_SESSION['r_sn'];
    $sc_sn = $_SESSION['sc_sn'];
    
    $poster = isset($_SESSION['poster']) ? $_SESSION['poster'] : "";
    $title = isset($_SESSION['title']) ? $_SESSION['title'] : "";

    try {
        require("db_connect.php");
            

        // TODO :: 밑에 주석 코드들 구현하기 
            
            // ! 겹치지않으면 예매 테이블에 데이터 추가
            $db->exec("insert into reservation (phone, title, theater, reservation_date)
            values ('$ph','$title', '$theater', '$date')");

            // ? 가장 최근에 추가된 예매 테이블의 auto_increment 값 가져오기
            $_SESSION['r_sn'] = $db->lastInsertId();

            // ! 겹치지않으면 상영일자 테이블에 데이터 추가
            $db->exec("insert into screening (theater_sn, screening_date)
            values ('$theater', '$date')");

            // ? 가장 최근에 추가된 상영일자 테이블의 auto_increment 값 가져오기
            $_SESSION['sc_sn'] = $db->lastInsertId();
            // $query = $db->query("select * from reservation where reservation_date = '$movieDate' and theater = '$theater'");
            
        // if ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                 ?>
                 <!-- <script>
                    window.open("/CGBee/fail.php", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=400,height=550");
                    history.back();
                </script> -->

                 <?php
        //         // exit();
        //         // header("Location:/CGBee/getMovie.php");
        //         // exit();
        //         header("Location:/CGBee/fail.php");
        //         exit();
                
            
        // }

        // ! 일시적으로 주석처리
        // $query = $db->query("select * from seat s, reservation r, screening sc where s.screening_sn = sc.screening_sn and r.reservation_sn = s.reservation_sn");

        // if ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
        //         header("Location:/CGBee/fail.php");
        //         exit();
        // }

        foreach($seat as $value){
            // $db->exec("insert into seat(reservation_sn, theater_sn, seat_sn) values('$last_insert_id','$theater','$value') ");
            $db->exec("insert into seat (screening_sn, seat_sn, reservation_sn, theater_sn, title)
            values ('$_SESSION[sc_sn]', '$value', '$_SESSION[r_sn]','$theater', '$title')");
    
        }
        

    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    


?>

        <div id="wrapper">
        <h1> 예매가 완료되었따</h1> <br>

        <h2> <span><?=$ph?></span>님의 예매내역</h2><br>
        <img src="<?=$poster?>" alt=""> <br>
        <p><?=$title?></p><br>
        <p> <span><?=$date?></span> 일 <span>
        <?php
        switch($theater){
            case 1:
                echo "강남"; break;
            case 2:
                echo "서초"; break;
            case 3:
                echo "용산"; break;
            case 4:
                echo "송파"; break;
            case 5:
                echo "성남"; break;
        }
        ?></span> 상영관 </p> <br>
        <p> 인원 <span> <?=$headcount?></span>명 </p> <br>
        <p> 좌석 : 
        
        <?php 
            foreach($seat as $val){
                echo "$val ";
            }
        ?> </p>

        </div>
</body>
</html>