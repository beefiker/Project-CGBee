
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
    input{
        width:150px;
        height:22px;
        background:#131313;
        padding:0 0 0 .5em;
        color: white;
        border: 1px solid #999;
    }
    select { 
        width:100px;
        padding: .2em .5em; /* 여백으로 높이 설정 */ 
        font-family: inherit; 
        background: url(images/selectIcon.png) no-repeat 100% 50%; /* 네이티브 화살표 대체 */ 
        border: 1px solid #999; 
        color:white;
        border-radius: 0px; 
        -webkit-appearance: none; 
        -moz-appearance: none; appearance: none; 
        appearance: none;
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
       border-right: 0;
}

.progress > li.li_info {
       background-color: #ecae01;
}

.progress > li.li_seat {
       background-color: #242424;
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
     border-left-color: #ecae01;
}
.li_seat .diagonal {
     border-left-color: #242424;
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
        justify-content: center;
        align-items: center;
        color:white;
    }
    img{
        position: relative;
        width:300px;
    }
    #mTitle{
        font-size:2rem;
    }
    #movieInfo{
        position:relative;
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
            <p> 장르 : <?=$genre?> </p><br>
            <p> 러닝타임  : <?= round($runningtime / 60) ?>시간 <?= $runningtime % 60 ?>분 </p>
            <p> 평점 : <?=$rating?></p><br><br>
            <p><?=$summary?> </p> <br><br>
            <form name="reservForm" mothod="post" action="/CGBee/setSeat.php"> 
                <span> 상&nbsp;영&nbsp;관&nbsp; </span>
                <select id="theater" name="theater">
                    <?php
                    try {
                        require("db_connect.php");
                  
                        $query = $db->query("select * from theater");
                  
                        while($row = $query->fetch(PDO::FETCH_ASSOC)) {    
                            echo "<option value=$row[theater_sn]>",$row[theater_name],"</option>";
                        }
                      } catch (PDOException $e) {
                        exit($e->getMessage());
                      }
                    ?>
                </select><br><br>
                <span> 상영일자 </span><input id="movieDate" name="date" type="date">
                <select id="movieHour" name="hour">
                    <?php
                    try {
                        require("db_connect.php");
                  
                        $query = $db->query("select * from schedule");
                  
                        while($row = $query->fetch(PDO::FETCH_ASSOC)) {    
                            echo "<option value=$row[timezone]>",$row[timezone],"</option>";
                        }
                      } catch (PDOException $e) {
                        exit($e->getMessage());
                      }
                    ?>
                </select>
                <br>

                <br>
                <span>휴대전화 </span>
                <input type="text" name="ph" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Enter Your Mobile"> <br><br>
                <input id="ReservationBtn" type="button" onclick="reservation()" value="좌석 선택">
            </form>
        </div>
    </div>
</div>
    <script>
        document.getElementById('movieDate').value=new Date().toISOString().slice(0, 10);

    </script>
</body>
</html>