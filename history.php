<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            width:1000px;
            height:600px;
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

        th        { background-color:#ecae01; color:black; height:30px;}
        tr { height: 20px;}
        .serialNumber { width: 100px;}
        .title { width: 350px; }
        .date  { width:200px; }
        .seat { width: 150px;}
        .theater { width: 90px;}

    </style>


    <script>
        search = () => {

            <?php
                // try {
                //     require("db_connect.php");        

                //     $query = $db->query("select * from reservation");
                //     // $query = $db->query("select title, reservation_date from reservation where theater = $theater");
                    
                //     while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                //         echo $row["title"];
                //     }
            
                    
                // } catch (PDOException $e) {
                //     exit($e->getMessage());
                // }
            ?>
            alert(ph);
        }
    </script>
</head>
<body>
    <div class="alignCenter">
    <h1>예매내역 조회</h1><br>

    
    <form method="GET">
    <input type="text" name="phone" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> <input type="submit" value="확인">
    </form>
    <table>
        <tr>
            <th class="serialNumber">예매번호</th>
            <th class="title">영화</th>
            <th class="theater">상영관</th>
            <th class="date">상영일자</th>
            <th class="seat">좌석</th>
        </tr>
    <?php
        $ph = $_REQUEST["phone"];
        try {
            require("db_connect.php");    

            $query = $db->query("select * from reservation where phone = '$ph'");
            
            // $query = $db->query("select title, reservation_date from reservation where theater = $theater");
            
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                // ?>
                 <tr>
                     <td><?=$row["reservation_sn"]?></td>
                     <td><?=$row["title"]?></td>
                     <td><?php
                        switch($row["theater"]){
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
                     
                     ?></td>
                     <td><?=$row["reservation_date"]," ",$row["reservation_hour"]?></td>
                    <td><?php
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