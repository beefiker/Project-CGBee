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
        display:flex;
        flex-direction:column;
        justify-content: center;
        align-items: center;
    }
    ul > li {
        float: left;
        padding:10px;
        text-align:center;
    }
    img{
        width:150px;
        height:100px;
    }
    .modifyTheater{
        width:100%;
        display:flex;
        justify-content:center;
        align-items:center;
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
    form{
        width:40%;
        padding:5%;
    }
</style>

</head>
<body>
<div id="container">
    <div class="menu-box">
        <ul>
        <?php
                try {
                    require("db_connect.php");

                    $query = $db->query("select * from theater");
                    
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {    
                    $theaterName = $row["theater_name"];
                    $seatAmount = $row["seat_amount"];
                    $src = $row["img"];

                    echo "<li>","<img class='theaterimg' src=$src>","<br>","<span>" ,$theaterName,"점","</span>","<br><br>", "</li>";

                    }
                } catch (PDOException $e) {
                    exit($e->getMessage());
                }
            ?>
        </ul>
    </div>
    
    <div class="modifyTheater">
            <form mothod="post" action="/CGBee/addTheater.php">
               <span> 극장 이름 : </span><input type="text" name="theaterName"> <br><br>
               <span> 극장 이미지 : </span> <input type="file" name="theaterImg"> <br><br>
               <span> 좌석 수 : </span> <input type="text" name="theaterSeats"> <br><br>
                <input type="submit" value="추가" id="submitBtn">
            </form>

            <form mothod="post" action="/CGBee/delTheater.php">
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
    <div class="modifyEvent">
                <?php
                    try {
                        require("db_connect.php");
                  
                        $query = $db->query("select * from board");
                  
                        while($row = $query->fetch(PDO::FETCH_ASSOC)) {   
                            $title = $row[title];
                            $contents = $row[contents];
                            echo "<p> $title, $contents</p>";
                        }
                      } catch (PDOException $e) {
                        exit($e->getMessage());
                      }
                ?>
    </div>
</div>
</body>
</html>
    
