
<?php
    session_start();

    $poster = isset($_SESSION['poster']) ? $_SESSION['poster'] : "";
    $title = isset($_SESSION['title']) ? $_SESSION['title'] : "";

    $ph = $_REQUEST["ph"];
    $_SESSION['ph'] = $ph;

    $pw = $_REQUEST["pw"];
    $_SESSION['pw'] = $pw;
    
    $theater = $_REQUEST["theater"];
    $_SESSION['theater'] = $theater;

    $movieDate = $_REQUEST["date"];
    $movieHour = $_REQUEST["hour"];
    // $_SESSION['date'] = substr($movieDate,0,7);
    $_SESSION['date'] = $movieDate;
    $_SESSION['hour'] = $movieHour;

    $headcount = $_REQUEST["headcount"];
    $_SESSION['headcount'] = $headcount;

    $_SESSION['poster'] = $poster;
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css" />
    <script src="http://code.jquery.com/jquery-1.7.min.js"></script>
    <script src="https://kit.fontawesome.com/7637a8f104.js" crossorigin="anonymous"></script>
    <script
      src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
      integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
      crossorigin="anonymous"
    ></script>
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
       color: #131313;
       list-style: none;
       background-color: #bbb;
       position: relative;
}

.progress > li:last-child {
       border-right: 10px;
}

.progress > li.li_info {
       background-color: #242424;
}

.progress > li.li_seat {
       background-color: #ecae01;
}

.progress > li.li_receipt {
       background-color: #242424;
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
     border-left-color: #ecae01;
}
.li_receipt .diagonal {
     border-left-color: #242424;
}
    #wrapper{
        position: relative;
        width:100%;
        height:70%;
        background-color:#131313;
        display:flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        color:white;
        z-index:1;
    }
    
    img{
        position: relative;
        width:300px;
        left:5%;
    }

    #movieInfo{
        position:relative;
        width:45%;
        padding : 2rem;
        display:flex;
        flex-direction : column;
        justify-content: center;
        align-items: center;
    }

    #ReservationBtn{
        position:relative;
        width: 100%;
        height: 50px;
        color: #242424;
        background-color: #f9c901;
        border: 1px solid #f9c901;
        border-radius: 5px;
        font-size: 20px;
        cursor: pointer;
    }
    #ReservationBtn:hover{
        background-color: #f9c901;
        color:#131313;
        border: 1px solid #131313;
    }

    .screen{
     color: white;
     padding: 10px 25px 10px 25px;
     border: 1px solid white;
     letter-spacing:5px;
    }
    input[type="checkbox"]{
        width:15px;
        height:25px;
        cursor:pointer;
    }
</style>
</head>
<body>

<script>
    let checkedCnt = 0;
    reservation = () =>{
        let reservForm = document.reservForm;
        if(checkedCnt>=1){
            reservForm.submit();
            checkedCnt = 0;
        }else{
            alert("좌석을 선택해주세요");
        }

    }

    ischecked = () =>{    checkedCnt++;    }
</script>
<div id="container">
    <ul class="progress">
       <li class="li_info">
           <span>
           <p><i class="fas fa-keyboard fa-2x"></i></p>
            <p>정보입력</p>
           </span>
           <div class="diagonal"></div>
       </li>
       <li class="li_seat">
           <span>
           <p><i class="fas fa-couch fa-2x"></i></p>
            <p>좌석선택</p>
           </span>
           <div class="diagonal"></div>
       </li>
       <li class="li_receipt">
           <span>
           <p>&nbsp;<i class="fas fa-receipt fa-2x"></i></p>
           <p>예매완료</p>
           </span>
       </li>
    </ul>
    <div id="wrapper">
        <img src="<?=$poster?>" alt="moviePoster"/>
        <div id="movieInfo">
            <div><strong id="mTitle"><?=$mtitle?></strong></div>
            <p class="screen">Screen</p>
            <form name="reservForm" mothod="post" action="/CGBee/reservation.php"> 
            <br>
            <?php
                try {
                    require("db_connect.php");
                    $query = $db->query("select * from theater where theater_sn = $theater");
                
                    if($row = $query->fetch(PDO::FETCH_ASSOC)) {    
                        $seatCount = $row[seat_amount];
                    }
                    
                    for($i = 1; $i<= $seatCount; $i++) { 
                        echo "<label><input type=checkbox name=seat[] onclick=ischecked() value='A{$i}'> </label>";
                        if($i%10==3 || $i%10==7 ) echo "&nbsp&nbsp&nbsp";
                        if($i%10==0) echo "<br>";
                        if($i%60==0) echo "<br>";
                    }

                } catch (PDOException $e) {
                    exit($e->getMessage());
                }
                
            ?> 
            
            
                <input id="ReservationBtn" type="button" onclick="reservation()" value="좌석선택">
            </form>
            <?php
                try {
                    require("db_connect.php");        
                    $query = $db->query("select * from reservation r, screening sc, seat s where sc.screening_sn = s.screening_sn and r.reservation_sn = s.reservation_sn and sc.screening_date = '$movieDate' and sc.reservation_hour ='$movieHour' and s.theater_sn = '$theater' and s.title = '$title'");

                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                        
                        ?>
                        <script>
                        $("input:checkbox[name ='seat[]']:input[value='<?=$row[seat_sn]?>']").attr("disabled", true);
                        </script>

                        <?php
                    }

                    
                } catch (PDOException $e) {
                    exit($e->getMessage());
                }
?>
        </div>
    </div>
    </div>
</body>
</html>