<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="http://code.jquery.com/jquery-1.7.min.js"></script>
    <script
      src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
      integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
      crossorigin="anonymous"
    ></script>
    <script src="https://kit.fontawesome.com/7637a8f104.js" crossorigin="anonymous"></script>
    
    <style>
        @import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);
        * {
        margin: 0;
        padding: 0;
        list-style: none;
        font-family: "Monsterrat", "Jeju Gothic", serif;
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
            width:1000px;
            padding-top:50px;
            height:400px;
        }

        th { background-color:#ecae01; color:black; height:30px;}
        tr { height: 20px;}
        .serialNumber { width: 100px;}
        .title { width: 350px; }
        .date  { width:200px; }
        .seat { width: 140px; }
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
        #delPw{
            all:unset;
            width:70px;
            height:20px;
            font-size:12px;
            border-bottom: 1px solid grey;
        }
        #delBtn{
            all:unset;
            width:25px;
            height:25px;
            cursor:pointer;
            color:red;
            font-size:11px;
        }
        #delBtn:hover{
            background:blue;
            border-radius:5px;
        }
        .seats{
            font-size:13px;
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
            <th class="serialNumber">Serial No.</th>
            <th class="title">Title</th>
            <th class="theater">Theater</th>
            <th class="date">Date</th>
            <th class="seat">Seats</th>
            <th class="cancel">Cancel</th>
        </tr>
    <?php
        $ph = $_REQUEST["phone"];
        try {
            require("db_connect.php");    

            $query = $db->query("select * from reservation r, theater t where r.theater = t.theater_sn and r.phone = '$ph' order by r.reservation_date, r.reservation_hour");
            
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                $sn = $row["reservation_sn"];
                ?> 
                 <tr>
                     <td><?=$row["reservation_sn"]?></td>
                     <td><?=$row["title"]?></td>
                     <td><?=$row["theater_name"]?></td>
                     <td><?=$row["reservation_date"]," ",$row["reservation_hour"]?></td>
                     
                    <td class="seats">
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
                     <td class="formTD">
                        <form name="delReservationForm" mothod="post" action="/CGBee/delhistory.php">
                        <input type="hidden" name="sn" value="<?=$sn?>">
                        <input type="hidden" name="phone" value="<?=$ph?>">
                        <input class="hided_inputs" id="delPw" type="text" name="enterPw" placeholder="PASSWORD">
                        <input class="hided_inputs" id="delBtn" type="submit" value="❌">
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