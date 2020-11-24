<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/7637a8f104.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<?php
    $title = $_REQUEST["title"];
    try {
        require("db_connect.php");
        $query = $db->query("select * from movie where title like '%$title%'");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) { 
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
        }
        
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>
</body>
</html>