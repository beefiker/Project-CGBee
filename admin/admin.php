<?php
    session_start();
    $today = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://code.jquery.com/jquery-1.7.min.js"></script>
    <script
      src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
      integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
      crossorigin="anonymous"
    ></script>

    <script src="https://kit.fontawesome.com/7637a8f104.js" crossorigin="anonymous"></script>
    <title>Admin</title>
    <style>
        
        @import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);
        :root {
            --beeDark: #242424;
            --beeYellow: #ecae01;
            --littleBlack: #131313;
        }   
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
            background-color:black;
        }
        h1{
            font-size: 3rem;
            color : var(--beeYellow);
        }
        h2{
            font-size: 2rem;
            color : var(--beeYellow);
        }
        
        span{
            color:#f9c901;
        }
        .bk{
            color:#131313;
        }

        #container{
            width:1200px;
            margin: 0 auto;
            background:#131313;
            display:block;
            
        }
        #helloDiv{
            width:100%;
            height:100px;
            display:flex;
            justify-content:center;
            align-items:center;
            background:#214252;
        }
        #theaters{
            display:block;
            width:60%;
            float:left;            
        }
        #theaters > ul {
            border-radius: 10px 10px 10px 10px;
            background:#f05454;
            width:100%;
            float:left;
            text-align:center;
        }
        #theaters > ul > li {
            width:160px;
            padding:10px;
            text-align:center;
        }
        .theaterimg{
            width:140px;
            height:110px;
        }
        .theaterItems {
            color: #636e71;
            float: left;
            width: 20%;
            text-align: center;
            padding-bottom: 2rem;
        }
        .modifyTheater{
            border-radius: 10px 10px 10px 10px;
            background:#af2d2d;
            width:100%;
            display:flex;
            justify-content:center;
            align-items:center;
            
            
        }
        .addTheater{
            width:60%;
            height:160px;
            padding:30px;
            /* background:red; */
            display:flex;
            /* justify-content:center; */
            align-items:center;
        }
        .delTheater{
            display:flex;
            /* justify-content:center; 
            align-items:center; */
            width:40%;
            height:160px;
            padding:10px;
            /* background:blue; */
        }
        .modifyEvent{
            width:40%;
            height:400px;
            display:block;
            float:right;
            background:#ce6262;
            border-radius: 10px 10px 10px 10px;
            
        }
        .addEvent{
            position:relative;
            width:90%;
            height:400px;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        #addMovieList{
            width:40%;
            height:150px;
            float:right;
            background:#db6400;
            border-radius: 10px 10px 10px 10px;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        .modifyNotice{
            display:block;
            float:left;
            width:100%;
            padding-top:50px;
            background:#92817a;
            border-radius: 10px 10px 10px 10px;
        }
        .noticeLists{

        }
        #submitBtn{
            all:unset;
            width:80%;
            height:60px;
            background-color:white;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        
        .eventItems {
            width:50%;
            min-height: 100px;
            float:left;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
        }
        #boardlist {
            width: 100%;
        }
        .eventImg{
            width:75px;
            height:75px;
            margin-right:30px;
        }
        
        .a{
            background-color:none;
            border:2px solid white;
            border-radius:0px 10px 0 0;
            color:white;
            width:300px;
            height:75px;
            display:flex;
            align-items:center;
        }

        .contents{
            position:relative;
            width:280px;
            min-height:10px;
            border:2px solid white;
            background-color:white;
            word-break:break-all;
            padding:10px;
            margin-bottom:50px;
            color:black;
            text-align:left;
        }
        /* 여기부터 셀렉트박스 */
        .multiselect {
            display:flex;
        }

        .selectBox {
            position: relative;
            width:100px;
        }

        .selectBox select {
            width: 100%;
            font-weight: bold;
        }

        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        #checkboxes {
            width:200px;
            height:200px;
            overflow:scroll;
            display: none;
            border: 1px #dadada solid;
            color:white;
        }
        #checkboxes label {
            display: block;
        }
        #checkboxes label:hover {
            color:white;
            background-color: #1e90ff;
        }
        
    </style>

</head>
<body>

    <script>
    let expanded = false;

    function showCheckboxes() {
    let checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
    }

    </script>

    <div id="container">
        <div id="helloDiv"><h1>Hello, Admin</h1></div>

        <p id="toggleTheater">Hide Theaters</p>
        <div id="theaters">
            <ul class="theaterLists_ul">
                <?php
                    try {
                        require("db_connect.php");

                        $query = $db->query("select * from theater");
                        
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {    
                        $theaterName = $row["theater_name"];
                        $seatAmount = $row["seat_amount"];
                        $src = $row["img"];

                        echo "<li class='theaterItems'>","<img class='theaterimg' src=$src>","<br>","<span>" ,$theaterName,"점","</span>","<br><br>", "</li>";

                        }
                    } catch (PDOException $e) {
                        exit($e->getMessage());
                    }
                ?>
            </ul>
            
            <div class="modifyTheater">
                <div class="addTheater">
                    <form mothod="post" action="/CGBee/admin/addTheater.php" class="forms">
                        <span> 극장 이름 : </span><input type="text" name="theaterName"> <br><br>
                        <span> 극장 이미지 : </span> <input type="file" name="theaterImg"> <br><br>
                        <span> 좌석 수 : </span> <input type="text" name="theaterSeats"> <br><br>
                        <input type="submit" value="추가" id="submitBtn">
                    </form>
                </div>
                <div class="delTheater">
                    <form mothod="post" action="/CGBee/admin/delTheater.php">
                        <span> 삭제할 극장 </span>
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
                        </select><br>
                        
                        
                        <br>
                        <input type="submit" value="삭제" id="submitBtn">
                    </form>
                </div>
            </div>
        </div>
        <div id="addMovieList">
            
                <form mothod="post" action="/CGBee/admin/addMovieList.php">
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
                    </select>

                    <span> 극장에 영화 추가 </span><br>
                    
                    <div class="multiselect">

                        <div class="selectBox" onclick="showCheckboxes()">
                            <select>
                                <option>영화선택</option>
                            </select>
                            <div class="overSelect"></div>
                        </div>

                        <div id="checkboxes">
                                <?php
                                    try {
                                        require("db_connect.php");
                                    
                                        $query = $db->query("select * from movie");
                                    
                                        while($row = $query->fetch(PDO::FETCH_ASSOC)) {    
                                            echo "<label><input type='checkbox' id='movieList' name='movie[]' value='$row[id]'/> $row[title]</label>";
                                        }
                                    } catch (PDOException $e) {
                                        exit($e->getMessage());
                                    }
                                ?>
                        </div>

                        <input type="submit" value="추가">
                    </div>
                </form>


        </div>

        <div class="modifyEvent">
            <div class="addEvent">
                <form mothod="post" action="/CGBee/admin/addEvent.php" class="forms">
                    <input type="hidden" name="date" value="<?=$today?>">
                    <span> 제목 </span>
                    <input type="text" name="title"><br><br>
                    
                    <p> 내용 </p>
                    <textarea id="textarea" name="contents" rows="5" cols="50">
                    </textarea>
                    <br><br>
                    <span> <img src="../images/addPhoto.png" alt=""> </span><input type="file" name="img"><br><br>
                        <input type="submit" value="추가" id="submitBtn">
                </form>
            </div>
        </div>
        <div class="modifyNotice">
            <ul class="noticeLists">
            <?php
                try {
                    require("db_connect.php");

                    $query = $db->query("select * from board");
                    
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {    
                    $id = $row["id"];
                    $title = $row["title"];
                    $contents = $row["contents"];
                    $write_date = $row["write_date"];
                    $eventImg = $row["eventImg"];

                    echo    "<li class='eventItems'>",
                                "<div class='a'>",
                                    "<img class='eventImg' src='$eventImg'>","<p>$title</p>",
                                    "<form mothod='post' action='/CGBee/admin/delEvent.php'>",
                                        "<input type='hidden' name='eventId' value='$id'>",
                                        "<input type='submit' style='all:unset;cursor:pointer;' value='❌'>", 
                                    "</form>",
                                "</div>",
                                "<p class='contents'>", $contents ,"</p>",
                                
                            "</li>";

                    }
                } catch (PDOException $e) {
                    exit($e->getMessage());
                }
            ?>
            </ul>
        </div>
    </div>
    <script> // TODO 집가서 이 부분 손 보기
    function togglingTheater(){
        let theaters = $("#theaters");
        if(theaters.css("display") == "none"){
            theaters.css('display','block');
            $("#toggleTheater").text("Hide Theaters");
        }else{
            $("#toggleTheater").text("Show Theaters");
            theaters.css('display','none');
        }
        
    }

    $("#toggleTheater").click(function(){
        togglingTheater();
    });
    </script>
</body>
</html>
    
