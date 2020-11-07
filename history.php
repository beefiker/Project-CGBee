<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/7637a8f104.js" crossorigin="anonymous"></script>
    <style>
        @import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);
        * {
        margin: 0;
        padding: 0;
        list-style: none;
        font-family: "Monsterrat", "Jeju Gothic", serif;
        font-weight: Medium;
        font-size: 15px;
        text-decoration: none;
        }

        .alignCenter{
            position:absolute;
            width:100%;
            height:100%;
            display:flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
        }
        h1{
            font-size:25px;
        }
        body{
            background-color:#131313;
            color:white;
        }
        table, h1, h2{  position:relative;
                text-align:center;
                display:flex;
                justify-content: center;
                align-items: flex-start;
        }
        table{
            width:900px;
            padding-top:50px;
            height:400px;
        }

        th { background-color:#ecae01; color:black; height:30px;}
        tr { height: 20px;}
        .serialNumber { width: 100px;}
        .title { width: 350px; }
        .date  { width:200px; }
        .seat { width: 150px;}
        .theater { width: 90px;}
        .cancel {width:120px;}
        input[type=text]{
            width:175px;
            height:25px;
            background:#131313;
            padding: 0 0 0 1em;
            color: white;
            border: 1px solid #999;
            border-radius:3px;
        }
        #searchBtn{
            width:25px;
            height:25px;
            background:url(images/search.png) no-repeat 50% 50%;
            background-size:25px;
            color: white;
            border: 1px solid #999;
            border-radius:3px;
        }
        #delBtn{
            all:unset;
            width:25px;
            height:25px;
            background:black;
            cursor:pointer;
        }
        #delBtn:hover{
            background:blue;
            border-radius:5px;
        }
    </style>
</head>
<body>
    <div class="alignCenter">
    <h1>예매내역 조회</h1><br>
    
    <form method="GET">
    <input type="text" name="phone" placeholder="010-0000-0000"> <input type="submit" id="searchBtn" value=" ">
    </form>
    <table>
        <tr>
            <th class="serialNumber">예매번호</th>
            <th class="title">영화</th>
            <th class="theater">상영관</th>
            <th class="date">상영일자</th>
            <th class="seat">좌석</th>
            <th class="cancel">취소</th>
        </tr>
    <?php
        $ph = $_REQUEST["phone"];
        try {
            require("db_connect.php");    

            $query = $db->query("select * from reservation r, theater t where r.theater = t.theater_sn and r.phone = '$ph' order by r.reservation_date, r.reservation_hour");
            
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                $sn = $row["reservation_sn"];
                ?> 
                <script>
                    deleteReservation = () =>{
                        let delReservationForm = document.delReservationForm;
                        let getPwFromUser = prompt('비밀번호를 입력해주세요');
                        if(getPwFromUser == <?=$row["reservation_pw"]?>){
                            delReservationForm.submit();
                        }else{
                            alert("비밀번호가 틀렸습니다.");
                        }
                    }
                </script>
                 <tr>
                     <td><?=$row["reservation_sn"]?></td>
                     <td><?=$row["title"]?></td>
                     <td><?=$row["theater_name"]?></td>
                     <td><?=$row["reservation_date"]," ",$row["reservation_hour"]?></td>
                     
                    <td>
                        <?php
                            try {
                                $query1 = $db->query("select * from reservation r, screening sc, seat s where sc.screening_sn = s.screening_sn and r.reservation_sn = s.reservation_sn and 
                                sc.screening_date = '$row[reservation_date]' and 
                                sc.reservation_hour ='$row[reservation_hour]' and 
                                s.theater_sn = '$row[theater]' and 
                                s.reservation_sn = '$row[reservation_sn]' and
                                s.title = '$row[title]'");
            
                                while ($row = $query1->fetch(PDO::FETCH_ASSOC)) { 
                                    echo $row[seat_sn], " ";
                                }
            
                                
                            } catch (PDOException $e) {
                                exit($e->getMessage());
                            }
                        ?>
                     </td>
                     <td>
                        <form name="delReservationForm" mothod="post" action="/CGBee/delhistory.php">
                        <input type="hidden" name="sn" value='<?=$sn?>'>
                        <input type="button" value="❌" name="deleteBtn" id="delBtn" onclick="deleteReservation()">
                        </form>
                     </td>
                     
                 </tr>
                 <?php
            }
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    ?>
    </table>
    </div>
</body>
</html>