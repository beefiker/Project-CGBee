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
// echo $list[0]->id;

for($i=0; $i<count($list_rating); $i++){

    $id = $list_rating[$i]->id;
    $title = $list_rating[$i]->title_english;
    $replace_title = str_replace("'"," ", $title);
    $year = $list_rating[$i]->year;
    $rating = $list_rating[$i]->rating;
    $runningtime = $list_rating[$i]->runtime;
    // $genres = $list[$i]->genres;
    // $genreArray = "";
    // for($i = 0; $i < count($genres); $i++) $genreArray .= $genres[$i]+", ";
    $summary = substr($list_rating[$i]->summary,0,140);
    $cut_summary = str_replace("'","",$summary);
    $language = $list_rating[$i]->language;
    $imgsrc = $list_rating[$i]->background_image;
    $uploaded_date = $list_rating[$i]->date_uploaded;
    
    try {
      require("db_connect.php");

      $query = $db->query("select * from movie where id=$id");

      if (!($row = $query->fetch(PDO::FETCH_ASSOC))) {    
        $db->exec("insert into movie(id, title, year, rating, runningtime, country, imgsrc, uploaded_date)
        values ($id, '$replace_title', '$year', '$rating',$runningtime,'$language','$imgsrc','$uploaded_date')");
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
  // $genres = $list[$i]->genres;
  // $genreArray;
  // for($i = 0; $i < count($genres); $i++) $genreArray .= $genres[$i]+", ";
  $summary = substr($list_like[$i]->summary,0,140);
  $cut_summary = str_replace("'","",$summary);
  $language = $list_like[$i]->language;
  $imgsrc = $list_like[$i]->background_image;
  $uploaded_date = $list_like[$i]->date_uploaded;
  
  try {
    require("db_connect.php");

    $query = $db->query("select * from movie where id=$id");

    if (!($row = $query->fetch(PDO::FETCH_ASSOC))) {    
      $db->exec("insert into movie(id, title, year, rating, runningtime, country, imgsrc, uploaded_date)
      values ($id, '$replace_title', '$year', '$rating',$runningtime,'$language','$imgsrc','$uploaded_date')");
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
            <li id="naviA" class="navimenu"><span>인기순</span></li>
            <li id="naviB" class="navimenu"><span>평점순</span></li>
            <li id="naviC" class="navimenu"><span>추천영화</span></li>
            <li id="naviD" class="navimenu"><span>극장</span></li>
            <li id="naviE" class="navimenu"><span>공지사항</span></li>

            <li id="naviG" class="navimenu"><span>예매내역</span></li>
            
          </ul>
        </div>
      </nav>

      <div id="Topmenu">
        <div id="logoImg">
          <img id="bee" src="images/bee.png" alt="bee" />
          <a id="logoText" href="#">CGBee</a>
        </div>
        <ul id="menuWrapper">
          <li id="gotoA" class="menuList">인기순</li>
          <li id="gotoB" class="menuList">평점순</li>
          <li id="gotoC" class="menuList">추천영화</li>
          <li id="gotoD" class="menuList">극장</li>
          <li id="gotoE" class="menuList">공지사항</li>

          <li id="ReservationDetails" class="menuList">예매내역</li>
        </ul>
      </div>

      <div id="box1" class="box">
        <div id="sort-like-wrap" class="sortWrapper needsLoad">
          <p class="sortName needsLoad">인기 순</p>
          <div class="flexRowContainer">
            <div class="scrollLeft needsLoad" id="LikeLeft"><strong class="scrollText"><</strong></div>
            <div id="sortByLike" class="movieDiv"></div>
            <div class="scrollRight needsLoad" id="LikeRight"><strong class="scrollText">></strong></div>
          </div>
        </div>
      </div>


      <div id="box2" class="box">
        <div id="sort-rating-wrap" class="sortWrapper needsLoad">
          <p class="sortName needsLoad">평점 순</p>
          <div class="flexRowContainer">
            <div class="scrollLeft" id="RatingLeft"><strong class="scrollText"><</strong></div>
            <div id="sortByRating" class="movieDiv"></div>
            <div class="scrollRight" id="RatingRight"><strong class="scrollText">></strong></div>
          </div>
        </div>
      </div>


      <div id="box3" class="box">
      <div id="sort-rating-wrap" class="randomWrapper needsLoad">
          <p class="randomName needsLoad">오늘만 무료</p>
            <div id="randomMovie" class="movieDiv"></div>

        </div>
      </div>


      <div id="box4" class="box">
        <ul id="theaterUL">
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
        <ul>
      </div>


      <div id="box5" class="box">
        <ul id="boardlist">
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
            // setInterval('showboardList()', 1000);
            showboardList();
          </script>
        </ul>

      </div>

    </div>

  </body>
  <script type="text/javascript" src="honeybee.js"></script>


</html>
