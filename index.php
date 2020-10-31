<!--
php
//db에 영화정보 넣기
$url_rating = "https://yts-proxy.now.sh/list_movies.json?sort_by=rating&limit=15";
$url_like = "https://yts-proxy.now.sh/list_movies.json?sort_by=like_count&limit=15";
//  Initiate curl session
$handle = curl_init();
// Will return the response, if false it prints the response
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($handle, CURLOPT_URL,$url_rating);
// Execute the session and store the contents in $result
$result_rating=curl_exec($handle);
// Closing the session
$result_rating = file_get_contents($url_rating);

curl_setopt($handle, CURLOPT_URL,$url_like);
// Execute the session and store the contents in $result
$result_like=curl_exec($handle);
// Closing the session
$result_like = file_get_contents($url_like);

$data_rating = json_decode($result_rating);
// var_dump($data);
$list_rating = $data_rating->data->movies;
$data_like = json_decode($result_like);
// var_dump($data);
$list_like = $data_like->data->movies;

for($i=0; $i<count($list_rating); $i++){

    $id = $list_rating[$i]->id;
    $title = $list_rating[$i]->title_english;
    $replace_title = str_replace("'"," ", $title);
    $year = $list_rating[$i]->year;
    $rating = $list_rating[$i]->rating;
    $runningtime = $list_rating[$i]->runtime;
    if(!$list_rating[$i]->genres[1]){
      $genres = $list_rating[$i]->genres[0];
    }else{
      $genres = $list_rating[$i]->genres[0].", ".$list_rating[$i]->genres[1];
    }
    $summary = substr($list_like[$i]->summary,0,140) . "...";
    $cut_summary = str_replace("'","",$summary);
    $language = $list_rating[$i]->language;
    $imgsrc = $list_rating[$i]->medium_cover_image;
    $uploaded_date = $list_rating[$i]->date_uploaded;
    
    try {
      require("db_connect.php");

      $query = $db->query("select * from movie where id=$id");

      if (!($row = $query->fetch(PDO::FETCH_ASSOC))) {    
        $db->exec("insert into movie(id, title, year, rating, runningtime, genres, country, summary, imgsrc, uploaded_date)
      values ($id, '$replace_title', '$year', '$rating',$runningtime,'$genres','$language','$cut_summary','$imgsrc','$uploaded_date')");
      }
    } catch (PDOException $e) {
      exit($e->getMessage());
    }
}

for($i=0; $i<count($list_like); $i++){

  $id = $list_like[$i]->id;
  $title = $list_like[$i]->title_english;
  $replace_title = str_replace("'"," ", $title);
  $year = $list_like[$i]->year;
  $rating = $list_like[$i]->rating;
  $runningtime = $list_like[$i]->runtime;
  if(!$list_like[$i]->genres[1]){
    $genres = $list_like[$i]->genres[0];
  }else{
    $genres = $list_like[$i]->genres[0].", ".$list_like[$i]->genres[1];
  }
  $summary = substr($list_like[$i]->summary,0,140) . "...";
  $cut_summary = str_replace("'","",$summary);
  $language = $list_like[$i]->language;
  $imgsrc = $list_like[$i]->medium_cover_image;
  $uploaded_date = $list_like[$i]->date_uploaded;
  
  try {
    require("db_connect.php");

    $query = $db->query("select * from movie where id=$id");

    if (!($row = $query->fetch(PDO::FETCH_ASSOC))) {    
      $db->exec("insert into movie(id, title, year, rating, runningtime, genres, country, summary, imgsrc, uploaded_date)
      values ($id, '$replace_title', '$year', '$rating',$runningtime,'$genres','$language','$cut_summary','$imgsrc','$uploaded_date')");
    }
  } catch (PDOException $e) {
    exit($e->getMessage());
  }
}

curl_close($handle); -->

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CGBee</title>
    <meta name="author" content="Jaeyoung2" />
    <script src="http://code.jquery.com/jquery-1.7.min.js"></script>
    <script
      src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
      integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
      crossorigin="anonymous"
    ></script>

    <link href="honeybee.css" rel="stylesheet" />
    <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css" />

    <script src="https://kit.fontawesome.com/7637a8f104.js" crossorigin="anonymous"></script>
   
  </head>
  <body>
    <div id="container">
      <nav>
        <div id="navi">
          <div id="menuBtn">
            <div class="Btncontainer">
              <div class="bar1"></div>
              <div class="bar2"></div>
              <div class="bar3"></div>
            </div>
          </div>
          <ul>
            <li id="logoTag" class="navilogo">
              <a id="logoText" href="#">CGBee</a>
            </li>
            <li id="naviA" class="navimenu"><span>Now Playing</span></li>
            <li id="naviB" class="navimenu"><span>Top Rank</span></li>
            <li id="naviC" class="navimenu"><span>Free Movie</span></li>
            <li id="naviD" class="navimenu"><span>Theater</span></li>
            <li id="naviE" class="navimenu"><span>Notice</span></li>

            <li id="naviG" class="navimenu"><span>My Ticket</span></li>
            
          </ul>
        </div>
      </nav>

      <div id="Topmenu">
        <div id="logoImg">
          <img id="bee" src="images/bee.png" alt="bee" />
          <a id="logoText" href="#">CGBee</a>
        </div>
        <ul id="menuWrapper">
          <li id="gotoA" class="menuList">Now Playing</li>
          <li id="gotoB" class="menuList">Top Rank</li>
          <li id="gotoC" class="menuList">Free Movie</li>
          <li id="gotoD" class="menuList">Theater</li>
          <li id="gotoE" class="menuList">Notice</li>

          <li id="ReservationDetails" class="menuList">My Ticket</li>
        </ul>
      </div>

      <div id="box1" class="box">
        <div id="sort-like-wrap" class="sortWrapper needsLoad">
          <p class="sortName needsLoad">Now Playing</p>
          <div class="flexRowContainer">
            <div class="scrollLeft needsLoad" id="LikeLeft"><strong class="scrollText"><</strong></div>
            <div id="sortByLike" class="movieDiv">
            <?php
                try {
                  require("db_connect.php");    
      
                  $query = $db->query("select * from movie order by year desc");
                  $i = 0;
                  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                       $partition = "LikePartition". "$i";
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
                       if($i > 14) break;
                  }
                  
                } catch (PDOException $e) {
                  exit($e->getMessage());
                }
          
              ?>
            </div>
            <div class="scrollRight needsLoad" id="LikeRight"><strong class="scrollText">></strong></div>
          </div>
        </div>
      </div>

      <hr color="#495464" size="2px" class="needsLoad">

      <div id="box2" class="box">
        <div id="sort-rating-wrap" class="sortWrapper needsLoad">
          <p class="sortName needsLoad">Top Rank</p>
          <div class="flexRowContainer">
            <div class="scrollLeft" id="RatingLeft"><strong class="scrollText"><</strong></div>
            <div id="sortByRating" class="movieDiv">
            <?php
                try {
                  require("db_connect.php");    
      
                  $query = $db->query("select * from movie order by rating desc");
                  $i = 0;
                  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                       $partition = "RatingPartition". "$i";
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
                       if($i > 14) break;
                  }
                  
                } catch (PDOException $e) {
                  exit($e->getMessage());
                }
          
              ?>
            </div>
            <div class="scrollRight" id="RatingRight"><strong class="scrollText">></strong></div>
          </div>
        </div>
      </div>

      <hr color="#495464" size="2px" class="needsLoad">

      <div id="box3" class="box">
      <p class="subtext_align_middle needsLoad">Free Movie<span><i class="fas fa-coins"></i></span></p>
      <div id="sort-rating-wrap" class="randomWrapper needsLoad">
      
          
            <div id="randomMovie" class="movieDiv">

              <?php
              // TODO 랜덤으로 안바뀌고 있음. 수정 필요
                  try {
                    require("db_connect.php");    
        
                    $query = $db->query("select * from movie");
                    
                    $rand = 3;
                    while ($row[$rand] = $query->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row[$rand][id];
                        $title =$row[$rand][title];
                        $year = $row[$rand][year];
                        $rating = $row[$rand][rating];
                        $runningtime = $row[$rand][runningtime];
                        $country = $row[$rand][country];
                        $genres = $row[$rand][genres];
                        $summary = $row[$rand][summary];
                        $img = $row[$rand][imgsrc];
                        $uploaded_date = $row[$rand][uploaded_date];
                    
                        ?>
                        <div class="sortPartition" id="randomPartition">
                          <img class="movieImg" src="<?=$img?>" alt="">
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
                            <input type="submit" value="무료예매" name="data2" id="ReservationBtn">
                          </form>
                        </div>

                        <?php
                    break;
                    }
                    
                  } catch (PDOException $e) {
                    exit($e->getMessage());
                  }
            
                ?>

                
            </div>

        </div>
      </div>

      <hr color="#495464" size="2px" class="needsLoad">

      <div id="box4" class="box">
        <p class="subtext_align_middle needsLoad" id="toggleTheater">Theater <i class='fas fa-caret-down fa-1x'></i></p>
          <div class="theaterLists needsLoad">
   
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
          </div>
        
      </div>

      <hr color="#495464" size="2px" class="needsLoad">

      <div id="box5" class="box">
      <p class="subtext_align_middle needsLoad" id="toggleNotice">Notice <i class='fas fa-caret-down fa-1x'></i></p>
        <ul id="boardlist" class="needsLoad noticeLists_ul">
          <script>
            showboardList = () => {
                $.ajax({
                    url:'board.php', 
                    type:'post', 
                    data:{}, 
                    success: function(prop) {
                      $('#boardlist').html(prop);
                    },
                    error: function() {
                    }
                });

            }
            // setInterval('showboardList()', 3000);
            showboardList();
          </script>
        </ul>

      </div>

    </div>

  </body>
  <script type="text/javascript" src="honeybee.js"></script>
  <script>
          
      togglingNotice = () => {
        let notices = $(".noticeLists_ul");
        if(notices.css("display") == "none"){
          $("#toggleNotice").html("<p class='subtext_align_middle needsLoad' id='toggleNotice'>Notice <i class='fas fa-caret-down fa-1x'></i></p>");
            notices.fadeIn(500);
        }else{
            $("#toggleNotice").html("<p class='subtext_align_middle needsLoad' id='toggleNotice'>Notice <i class='fas fa-caret-up fa-1x'></i></p>");
            notices.fadeOut(500);
        }
      }
      togglingTheater = () =>{
        let theaters = $(".theaterLists_ul");
        if(theaters.css("display") == "none"){
          $("#toggleTheater").html("<p class='subtext_align_middle needsLoad' id='toggleTheater'>Theater <i class='fas fa-caret-down fa-1x'></i></p>");
            theaters.fadeIn(500);
        }else{
            $("#toggleTheater").html("<p class='subtext_align_middle needsLoad' id='toggleTheater'>Theater <i class='fas fa-caret-up fa-1x'></i></p>");
            theaters.fadeOut(500);
        }
      }
      


      $("#toggleTheater").click(()=>{
          togglingTheater();
      });
      $("#toggleNotice").click(()=>{
          togglingNotice();
      });
  </script>

</html>
