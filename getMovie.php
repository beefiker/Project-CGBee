
<?php

    $mtitle= $_REQUEST["movieTitle"];
    $genre = $_REQUEST["movieGenre"];
    $summary = $_REQUEST["movieSummary"];
    $year = $_REQUEST["movieYear"];
    $rating = $_REQUEST["movieRating"];
    $runningtime = $_REQUEST["movieRuntime"];
    $poster = $_REQUEST["moviePoster"];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css" />
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
        alert("휴대전화는 필수항목입니다.");
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
            <p> 러닝타임  : <?= round($runningtime / 60, 1) ?>시간 <?= $runningtime % 60 ?>분 </p>
            <p> 평점 : <?=$rating?></p><br><br>
            <p><?=$summary?> </p> <br><br>
            <form name="reservForm" mothod="post" action="/asd/reservation.php"> 

            <input type="hidden" name="movieName" value= <?="$mtitle"?>>
                <span> 상영관 </span>
                <select id="theater" name="theater">
                    <option value="Gangnam">강남</option>
                    <option value="Seocho">서초</option>
                    <option value="Yongsan">용산</option>
                    <option value="Songpa">송파</option>
                    <option value="Seongnam">성남</option>
                </select><br><br>
                <span> 상영일자 </span><input id="movieDate" name="date" type="date"><br><br>
                <span> 인원 수 </span>
                <select id="headcount" name="headcount">
                    <option value="1">1명</option>
                    <option value="2">2명</option>
                    <option value="3">3명</option>
                    <option value="4">4명</option>
                    <option value="5">5명</option>
                    <option value="6">6명</option>
                </select><br><br>
                <span>휴대전화* </span>
                <input type="text" name="ph" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> <br><br>
                <input id="ReservationBtn" type="button" onclick="reservation()" value="예매하기">
            </form>
        </div>
    </div>

    <script>
        document.getElementById('movieDate').value=new Date().toISOString().slice(0, 10);
    </script>
</body>
</html>