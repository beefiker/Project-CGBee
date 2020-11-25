<?php
        $title = $_REQUEST["title"];
        $titleCount = 0;
        $genreCount = 0;
        $resultCount=0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://code.jquery.com/jquery-1.7.min.js"></script>
    <script src="https://kit.fontawesome.com/7637a8f104.js" crossorigin="anonymous"></script>
    <title>Document</title>
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

        body{
            background-color:#131313;
            color:white;
        }

        .movieDiv {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: row;
        }
        .sortPartition {
            position: relative;
            width: 230px;
            height: 345px;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: row;
            margin-right: 30px;
        }

        #ReservationBtn {
            position: absolute;
            bottom: 0.5rem;
            left: 10px;
            width: 210px;
            height: 50px;
            color: black;
            background-color: white;
            border: 1px solid white;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            visibility:hidden;
        }

        .movietitle {
            position: absolute;
            top: 1rem;
            width: 210px;
            color: white;
            font-size: 20px;
            font-weight: bold;
            visibility:hidden;
        }
        .movieGenre {
            position: absolute;
            top: 5.5rem;
            width: 200px;
            color: white;
            font-size: 15px;
            display: flex;
            justify-content: flex-start;
            font-weight: 100;
            visibility:hidden;
        }
        .movieSummary {
            position: absolute;
            bottom: 5rem;
            width: 210px;
            color: white;
            font-size: 15px;
            display: flex;
            justify-content: center;
            visibility:hidden;
        }

        .menuList {
            cursor: pointer;
            width: 33.3%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .result{
            z-index:1;
            position:fixed;
            display:flex;
            width:100%;
            height:40px;
            text-align:center;
            justify-content: center;
            align-items:center;
            font-size:20px;
            font-weight:bold;
            color:#ecae01;
            text-shadow: 2px 2px 2px black;
        }
    </style>
</head>
<body>
<?php
    try {
        require("db_connect.php");
        $query = $db->query("select * from movie where title like '%$title%'");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                $titleCount++;
        }
        $resultCount = $titleCount;

        if(!$titleCount){
            $query = $db->query("select * from movie where genres like '%$title%'");
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                $genreCount++;
            } 
        $resultCount = $genreCount;  
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>

<p class="result"> <?=$resultCount?> 개의 검색 결과 </p>

    <div id="movieListWrapper" class="movieDiv">
    <?php
        $title = $_REQUEST["title"];
        try {
            require("db_connect.php");
            $query = $db->query("select * from movie where title like '%$title%'");
            $i = 0;
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                $partition = "searchPartition". "$i";
                $id = "$row[id]";
                $title = $row[title];
                $year = $row[year];
                $rating = $row[rating];
                $runningtime = $row[runningtime];
                $country = $row[country];
                $genres = $row[genres];
                $summary = $row[summary];
                $img = $row[imgsrc];
                $uploaded_date = $row[uploaded_date];
    ?>
                <div class="sortPartition" id="<?=$partition?>">
                    <img src="<?=$img?>" alt="">
                    <p class=movietitle><?=$title?></p>
                    <p class=movieGenre><?=$genres?></p>
                    <p class=movieSummary><?=$summary?></p>
                    <form method="post" action="/CGBee/getMovie.php" name="newForm" target="_blank">
                        <input type="hidden" name="movieId" value="<?=$id?>">
                        <input type="hidden" name="movieTitle" value="<?=$title?>">
                        <input type="hidden" name="movieGenre" value="<?=$genres?>">
                        <input type="hidden" name="movieSummary" value="<?=$summary?>">
                        <input type="hidden" name="movieYear" value="<?=$year?>">
                        <input type="hidden" name="movieRating" value="<?=$rating?>">
                        <input type="hidden" name="movieRuntime" value="<?=$runningtime?>">
                        <input type="hidden" name="moviePoster" value="<?=$img?>">
                        <input type="submit" value="예매하기" name="data2" id="ReservationBtn">
                    </form>
                </div>

    <?php
                $i++;
            }
            
            if(!$i){
                $query = $db->query("select * from movie where genres like '%$title%'");
                $i = 0;
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                    $partition = "searchPartition". "$i";
                    $id = "$row[id]";
                    $title = $row[title];
                    $year = $row[year];
                    $rating = $row[rating];
                    $runningtime = $row[runningtime];
                    $country = $row[country];
                    $genres = $row[genres];
                    $summary = $row[summary];
                    $img = $row[imgsrc];
                    $uploaded_date = $row[uploaded_date];
        ?>
                    <div class="sortPartition" id="<?=$partition?>">
                        <img src="<?=$img?>" alt="">
                        <p class=movietitle><?=$title?></p>
                        <p class=movieGenre><?=$genres?></p>
                        <p class=movieSummary><?=$summary?></p>
                        <form method="post" action="/CGBee/getMovie.php" name="newForm" target="_blank">
                            <input type="hidden" name="movieId" value="<?=$id?>">
                            <input type="hidden" name="movieTitle" value="<?=$title?>">
                            <input type="hidden" name="movieGenre" value="<?=$genres?>">
                            <input type="hidden" name="movieSummary" value="<?=$summary?>">
                            <input type="hidden" name="movieYear" value="<?=$year?>">
                            <input type="hidden" name="movieRating" value="<?=$rating?>">
                            <input type="hidden" name="movieRuntime" value="<?=$runningtime?>">
                            <input type="hidden" name="moviePoster" value="<?=$img?>">
                            <input type="submit" value="예매하기" name="data2" id="ReservationBtn">
                        </form>
                    </div>

        <?php
                    $i++;
                }
                
            }
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    ?>
    </div>

    <script>
        hoverMovies = (prop, count) => {
        for (let i = 0; i < <?=$resultCount?>; i++) {
            let thisPartition = $(prop + i);
            thisPartition.hover(
            () => {
                thisPartition.children(".movietitle").css({ visibility: "visible" });
                thisPartition.children(".movieGenre").css({ visibility: "visible" });
                thisPartition.children(".movieSummary").css({ visibility: "visible" });
                thisPartition.children("form").find("input").css({ visibility: "visible" });
                thisPartition.children("img").animate({ opacity: "0.5" }, 100);
            },
            () => {
                thisPartition.children("img").animate({ opacity: "1" }, 100);
                thisPartition.children(".movietitle").css({ visibility: "hidden" });
                thisPartition.children(".movieGenre").css({ visibility: "hidden" });
                thisPartition.children(".movieSummary").css({ visibility: "hidden" });
                thisPartition.children("form").find("input").css({ visibility: "hidden" });
            }
            );
        }
    }
    
        hoverMovies("#searchPartition", 15);
    </script>
</body>
</html>