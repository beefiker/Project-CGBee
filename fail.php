<?php
    session_start();
    $date = $_SESSION['date'];
    $theater = $_SESSION['theater'];
?>
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
                align-items: center;
        }

        th        { background-color:#ecae01; color:black}
        
        .date  { width:180px; }

    </style>
</head>
<body>
    <script>
        let a = "<?=$date?>";
        let b = a.slice(0,7);
    </script>
    <div class="alignCenter">
    <h1>실패사유 : 이미 예약된 날짜</h1><br>
    <h2><?=$theater?> 상영관</h2>
    <table>
    <tr>
        <th class="date"> 예약 불가능한 날짜 </th>
    </tr>
    
    <?php
        try {
            require("db_connect.php");        
            $query = $db->query("select title, reservation_date from reservation where reservation_date like '$date%' and theater = '$theater' order by reservation_date");
            // $query = $db->query("select title, reservation_date from reservation where theater = $theater");
    
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                ?>
                <tr>
                    <td><?=$row["reservation_date"]?></td>
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