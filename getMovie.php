
<?php
    session_start();

    $mtitle= $_REQUEST["movieTitle"];
    $genre = $_REQUEST["movieGenre"];
    $summary = $_REQUEST["movieSummary"];
    $year = $_REQUEST["movieYear"];
    $rating = $_REQUEST["movieRating"];
    $runningtime = $_REQUEST["movieRuntime"];
    $poster = $_REQUEST["moviePoster"];
    
    
    $_SESSION['title'] = $mtitle;
    $_SESSION['poster'] = $poster;
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css" />
    <script src="http://code.jquery.com/jquery-1.7.min.js"></script>
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
    p{
        color:gray;
    }
    #wrapper{
        position: absolute;
        width:100%;
        height:100%;
        background-color:#131313;
        display:flex;
        justify-content: center;
        align-items: center;
        color:white;
    }
    img{
        position: relative;
        width:40%;

    }
    #mTitle{
        font-size:2rem;
    }
    #movieInfo{
        position:relative;
        /* background-color:red; */
        width:45%;
        padding : 2rem;
        display:flex;
        flex-direction : column;
        justify-content: flex-start;
        align-items: left;
    }
    #ReservationBtn{
        width: 50%;
        height: 50px;
        color: white;
        background-color: #131313;
        border: 1px solid white;
        border-radius: 5px;
        font-size: 20px;
        cursor: pointer;
    }
    #ReservationBtn:hover{
        background-color: black;
    }
</style>

<script>
    reservation = () =>{
    let reservForm = document.reservForm;
    let phNum = reservForm.ph.value;
    if(phNum){
        reservForm.submit();
    }else{
        alert("휴대전화는 필수항목");
    }
}
</script>
</head>
<body>
    <div id="wrapper">
        <img src="<?=$poster?>" alt="moviePoster"/>
        <div id="movieInfo">
            <div><strong id="mTitle"><?=$mtitle?></strong></div>
            <p> 장르 : <?=$genre?> </p><br>
            <p> 러닝타임  : <?= round($runningtime / 60) ?>시간 <?= $runningtime % 60 ?>분 </p>
            <p> 평점 : <?=$rating?></p><br><br>
            <p><?=$summary?> </p> <br><br>
            <form name="reservForm" mothod="post" action="/CGBee/setSeat.php"> 
                <span> 상영관 </span>
                <select id="theater" name="theater">
                    <option value="1">강남</option>
                    <option value="2">서초</option>
                    <option value="3">용산</option>
                    <option value="4">송파</option>
                    <option value="5">성남</option>
                </select><br><br>
                <span> 상영일자 </span><input id="movieDate" name="date" type="date"><br>
                   
                <!-- <?php

                    for($i = 1; $i<= 30; $i++) { 
                        echo "<label><input type=checkbox name=seat[] value='A{$i}'> </label>";
                        if($i%5==0 && $i%10!=0) echo "&nbsp";
                        if($i%10==0 && $i%21!=0) echo "<br>";
                    }
                    echo "<br>";
                ?> -->

                <br>
                <span>휴대전화* </span>
                <input type="text" name="ph" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> <br><br>
                <input id="ReservationBtn" type="button" onclick="reservation()" value="좌석 선택">
            </form>
        </div>
    </div>

    <script>
        document.getElementById('movieDate').value=new Date().toISOString().slice(0, 10);

    </script>
</body>
</html>