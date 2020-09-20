<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/7637a8f104.js" crossorigin="anonymous"></script>
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
    h2, p{
        color:white;
    }
    span{
        color:#f9c901;
    }
    .bk{
        color:#131313;
    }
    #container{
        position:absolute;
        width:100%;
        height:100%;
        display:flex;
        flex-direction:column;
        justify-content: center;
        align-items: center;
    }
    .progress{
        position: relative;
        width:100%;
        height:120px;
        background:#f9c901;
        display:flex;
        flex-direction:row;
        justify-content: center;
        align-items: center;
    }
    li{
        float:left;
        width:33.4%;
        height:100%;
        display:flex;
        flex-direction:column;
        justify-content: center;
        align-items: center;
    }
    i{
        margin:10px;
    }

    
.progress > li {
       width: 100%;
       height: 100%;
       border-radius: 0;
       color: #131313 !important;
       list-style: none;
       font-size: 2rem;
       background-color: #bbb;
       position: relative;
}

.progress > li:last-child {
       border-right: 0;
}

.progress > li.li_info {
       background-color: #242424;
}

.progress > li.li_seat {
       background-color: #242424;
}

.progress > li.li_receipt {
       background-color: #ecae01;
}

.progress > li:not(.completed) {
     padding-left: 20px;
}

.progress > li span {
       position: relative;
       top: 5px;
    }

.diagonal {
     width: 0; 
     height: 0; 
     border-top: 60px solid transparent;
     border-bottom: 60px solid transparent;
     border-left: 20px solid #bbb;
     top: 0; right: 0;
     position: absolute;
     transform: translateX(100%);
     z-index: 1;
}
.li_info .diagonal {
     border-left-color: #242424;
}
.li_seat .diagonal {
     border-left-color: #242424;
}
.li_receipt .diagonal {
     border-left-color: #ecae01;
}
    #wrapper{
        position: relative;
        width:100%;
        height:70%;
        display:flex;
        flex-direction:column;
        justify-content: center;
        align-items: center;
    }
    img{
        position: relative;
        width:200px;
        height:300px;

    }
</style>

</head>
<body>
<?php

    $ph = $_SESSION['ph'];
    $theater = $_SESSION["theater"];

    $date = $_SESSION['date'];
    $hour = $_SESSION['hour'];

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
        $db->exec("insert into reservation (phone, title, theater, reservation_date, reservation_hour, seats)
        values ('$ph','$title', '$theater', '$date','$hour','$seat')");

        // ? 가장 최근에 추가된 예매 테이블의 auto_increment 값 가져오기
        $_SESSION['r_sn'] = $db->lastInsertId();

        // ! 겹치지않으면 상영일자 테이블에 데이터 추가
        $db->exec("insert into screening (theater_sn, screening_date, reservation_hour)
        values ('$theater', '$date','$hour')");

        // ? 가장 최근에 추가된 상영일자 테이블의 auto_increment 값 가져오기
        $_SESSION['sc_sn'] = $db->lastInsertId();

        foreach($seat as $value){
            // $db->exec("insert into seat(reservation_sn, theater_sn, seat_sn) values('$last_insert_id','$theater','$value') ");
            $db->exec("insert into seat (screening_sn, seat_sn, reservation_sn, theater_sn, title)
            values ('$_SESSION[sc_sn]', '$value', '$_SESSION[r_sn]','$theater', '$title')");
        }  

    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    


?>
<div id="container">
<ul class="progress">
       <li class="li_info">
           <span>
           <p class="bk"><i class="fas fa-keyboard fa-2x"></i></p>
            <p class="bk">정보입력</p>
           </span>
           <div class="diagonal"></div>
       </li>
       <li class="li_seat">
           <span>
           <p class="bk"><i class="fas fa-couch fa-2x"></i></p>
            <p class="bk">좌석선택</p>
           </span>
           <div class="diagonal"></div>
       </li>
       <li class="li_receipt">
           <span>
           <p class="bk">&nbsp;<i class="fas fa-receipt fa-2x"></i></p>
           <p class="bk">예매완료</p>
           </span>
       </li>
    </ul>
        <div id="wrapper">
        <h2> <span><?=$ph?></span>님의 예매내역</h2><br>
        <h2><?=$title?></h2><br>
        <img src="<?=$poster?>" alt=""> <br>
        
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
        <p>
        <?php 
            foreach($seat as $val){
                echo "$val ";
            }
        ?>/
        <span> <?=$headcount?>명</span> 
        </p>
        </div>
        </div>
</body>
</html>