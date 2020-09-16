
<?php
    session_start();

    $poster = isset($_SESSION['poster']) ? $_SESSION['poster'] : "";
    $title = isset($_SESSION['title']) ? $_SESSION['title'] : "";

    $ph = $_REQUEST["ph"];
    $_SESSION['ph'] = $ph;
    
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
        justify-content: center;
        align-items: center;
    }

    #ReservationBtn{
        width: 100%;
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
</head>
<body>
    <?php

    try {
        require("db_connect.php");

    // ! 날짜와 상영관이 겹칠 때 오류 발생하는 코드
    // $query = $db->query("select * from ");

    // if ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
    //         header("Location:/CGBee/fail.php");
    //         exit();
    // }
        

    // $last_insert_id_reservation = $db->lastInsertId();
    //     echo $last_insert_id_reservation;
    // ! 좌석 선택완료 후 데이터 입력
    // foreach($seat as $value){
    //     $db->exec("insert into seat(reservation_num, seat_sn, reservation_date)
    //     values ('$last_insert_id','$value','$movieDate') ");
    // }
    

    } catch (PDOException $e) {
        exit($e->getMessage());
    }

    ?>
    <div id="wrapper">
        <img src="<?=$poster?>" alt="moviePoster"/>
        <div id="movieInfo">
            <div><strong id="mTitle"><?=$mtitle?></strong></div>
            <p>좌석 선택</p>
            <form name="reservForm" mothod="post" action="/CGBee/reservation.php"> 
            <?php

    try {
        require("db_connect.php");
        // $query = $db->query("select * from seat where theater_sn = $theater");

        // $last_insert_id_screening = $db->lastInsertId();
        // echo $last_insert_id_reservation;
        // echo $last_insert_id_screening;
        // echo "<br>";
        echo "<br>";

    } catch (PDOException $e) {
        exit($e->getMessage());
    }

?>
    <?php

        for($i = 1; $i<= 30; $i++) { 
            echo "<label><input id=seats type=checkbox name=seat[] value='A{$i}'> </label>";
            if($i%5==0 && $i%10!=0) echo "&nbsp";
            if($i%10==0 && $i%21!=0) echo "<br>";
        }
    ?>
                <br><input id="ReservationBtn" type="submit" onclick="reservation()" value="좌석선택">
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

    <script>
    reservation = () =>{
        // ! 동작하지않음.  수정필요
    let checkArray = new Array();
    $('input:checkbox[name='seat[]']:checked').each(function() { // 체크된 체크박스의 value 값을 가지고 온다.
            checkArray.push(this.value);
    });
    if(checkArray.length()){
        reservForm.submit();
    }else{
        alert("좌석 필수선택");
        
    }
}
</script>
</body>
</html>