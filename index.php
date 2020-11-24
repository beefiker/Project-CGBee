<!--php
//db에 영화정보 넣기
$url_rating = "https://yts-proxy.now.sh/list_movies.json?sort_by=rating&limit=50";
$url_like = "https://yts-proxy.now.sh/list_movies.json?sort_by=like_count&limit=50";
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
            <li id="naviA" class="navimenu"><span>Trending</span></li>
            <li id="naviB" class="navimenu"><span>Action</span></li>
            <li id="naviC" class="navimenu"><span>Adventure</span></li>
            <li id="naviD" class="navimenu"><span>Drama</span></li>
            <li id="naviE" class="navimenu"><span>Musical</span></li>
            <li id="naviF" class="navimenu"><span>Notice</span></li>
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
          <li id="gotoA" class="menuList">Trending</li>
          <li id="gotoB" class="menuList">Action</li>
          <li id="gotoC" class="menuList">Adventure</li>
          <li id="gotoD" class="menuList">Drama</li>
          <li id="gotoE" class="menuList">Musical</li>
          <li id="gotoF" class="menuList">Notice</li>

          <li id="ReservationDetails" class="menuList">My Ticket</li>
        </ul>
      </div>
      <div class="search">
        <form action="/CGBee/search.php" target="_blank">
          <input type="text" name="title" placeholder="S e a r c h"> <input type="submit" id="searchBtn" value=" ">
        </form>
      </div>

      <div id="box1" class="box">
        <div class="sortWrapper needsLoad">
          <p class="sortName needsLoad">Trending now</p>
          <div class="flexRowContainer">
            <div class="scrollLeft needsLoad" id="movieList_slideLeft"><strong class="scrollText"><</strong></div>
            <div id="movieListWrapper" class="movieDiv">
            <?php
                try {
                  require("db_connect.php");    
      
                  $query = $db->query("select * from movie order by rating desc, year desc limit 15");
                  $i = 0;
                  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                       $partition = "trendingPartition". "$i";
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
                  
                } catch (PDOException $e) {
                  exit($e->getMessage());
                }
          
              ?>
            </div>
            <div class="scrollRight needsLoad" id="movieList_slideRight"><strong class="scrollText">></strong></div>
          </div>
        </div>
      </div>

      <!-- <hr color="#131313" size="3px" class="needsLoad"> -->

      <div id="box2" class="box">
        <div class="sortWrapper needsLoad">
          <p class="sortName needsLoad">Action</p>
          <div class="flexRowContainer">
          <div class="scrollLeft needsLoad" id="movieList_slideLeft"><strong class="scrollText"><</strong></div>
            <div id="movieListWrapper" class="movieDiv">
            <?php
                try {
                  require("db_connect.php");    
      
                  $query = $db->query("select * from movie where genres like '%action%' order by year desc,rating desc limit 15");
                  $i = 0;
                  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                       $partition = "actionPartition". "$i";
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
                  
                } catch (PDOException $e) {
                  exit($e->getMessage());
                }
          
              ?>
            </div>
            <div class="scrollRight needsLoad" id="movieList_slideRight"><strong class="scrollText">></strong></div>
          </div>
        </div>
      </div>

      <!-- <hr color="#131313" size="3px" class="needsLoad"> -->

      <div id="box3" class="box">
        <div class="sortWrapper needsLoad">
          <p class="sortName needsLoad">Adventure</p>
          <div class="flexRowContainer">
          <div class="scrollLeft needsLoad" id="movieList_slideLeft"><strong class="scrollText"><</strong></div>
            <div id="movieListWrapper" class="movieDiv">
            <?php
                try {
                  require("db_connect.php");    
      
                  $query = $db->query("select * from movie where genres like '%adven%' order by year desc,rating desc limit 15");
                  $i = 0;
                  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                       $partition = "adventurePartition". "$i";
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
                  
                } catch (PDOException $e) {
                  exit($e->getMessage());
                }
          
              ?>
            </div>
            <div class="scrollRight needsLoad" id="movieList_slideRight"><strong class="scrollText">></strong></div>
          </div>
        </div>
      </div>

      <!-- <hr color="#131313" size="3px" class="needsLoad"> -->

      <div id="box4" class="box">
        <div class="sortWrapper needsLoad">
          <p class="sortName needsLoad">Drama</p>
          <div class="flexRowContainer">
          <div class="scrollLeft needsLoad" id="movieList_slideLeft"><strong class="scrollText"><</strong></div>
            <div id="movieListWrapper" class="movieDiv">
            <?php
                try {
                  require("db_connect.php");    
      
                  $query = $db->query("select * from movie where genres like '%drama%' order by year desc,rating desc limit 15");
                  $i = 0;
                  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                       $partition = "dramaPartition". "$i";
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
                } catch (PDOException $e) {
                  exit($e->getMessage());
                }
              ?>
            </div>
            <div class="scrollRight needsLoad" id="movieList_slideRight"><strong class="scrollText">></strong></div>
          </div>
        </div>
      </div>

      <!-- <hr color="#131313" size="3px" class="needsLoad"> -->

      <div id="box5" class="box">
        <div class="sortWrapper needsLoad">
          <p class="sortName needsLoad">Musical</p>
          <div class="flexRowContainer">
          <div class="scrollLeft needsLoad" id="movieList_slideLeft"><strong class="scrollText"><</strong></div>
            <div id="movieListWrapper" class="movieDiv">
            <?php
                try {
                  require("db_connect.php");    
      
                  $query = $db->query("select * from movie where genres like '%music%' order by year,rating desc limit 15");
                  $i = 0;
                  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                       $partition = "musicPartition". "$i";
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
                } catch (PDOException $e) {
                  exit($e->getMessage());
                }
              ?>
            </div>
            <div class="scrollRight needsLoad" id="movieList_slideRight"><strong class="scrollText">></strong></div>
          </div>
        </div>
      </div>

      <hr color="#131313" size="3px" class="needsLoad">

      <div id="NoticeBox" class="box">
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

</html>
