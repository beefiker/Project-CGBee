<?php
    session_start();
    $today = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="http://code.jquery.com/jquery-1.7.min.js"></script>
    <script
      src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
      integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
      crossorigin="anonymous"
    ></script>
    <link href="admin.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/7637a8f104.js" crossorigin="anonymous"></script>
    <title>CGBee :: Admin</title>
  </head>
  <body>
    <!-- <script>
    let expanded = false;

    function showCheckboxes() {
    let checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
    }

    </script> -->

    <div id="container">
      <div id="helloDiv" class="blocks"><h2>Welcome, Admin.</h2></div>

      <div id="theaters" class="blocks">
        <ul class="theaterLists_ul">
          <?php
                    try {
                        require("db_connect.php");

                        $query = $db->query("select * from theater");
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        $theaterName = $row["theater_name"];
                        $seatAmount = $row["seat_amount"];
                        $src = $row["img"];
                        echo "<li>","<img class='theaterimg' src='$src'/>",
                        "<br />","<span>" ,$theaterName,"점","</span>","<br /><br />", "</li>"; }
                    } catch (PDOException $e) {
                      exit($e->getMessage());
                    } ?>
        </ul>

        <div class="modifyTheater">
          <div class="modTitle"> 
            <div class="addTitle">극장 추가</div>
            <div class="delTitle">극장 삭제</div>
          </div>
          <div class="modTheaterWrapper">
            <div class="addTheater">
                <div class="textWrapper">
                    <form mothod="post" action="/CGBee/admin/addTheater.php">
                    <span> 극장 명 : </span><input type="text" name="theaterName" /><br /><br />
                    <span> 좌석 수 : </span> <input type="text" name="theaterSeats" /> <br /><br />
                    <p> <img src="../images/addPhoto.png" alt="" /> </p><input type="file" name="theaterImg" /> <br /><br />
                    
                </div>
                <div class="btnWrapper">
                    <input type="submit" value="추가" id="submitBtn_addTheater" />
                    </form>
                </div>
            </div>
            <div class="delTheater">
                <div class="textWrapper">
                <form mothod="post" action="/CGBee/admin/delTheater.php">
                  <p style="text-align: center;"> <i class="fas fa-theater-masks fa-3x"></i></p><br><br>
                  <select id="theater" name="theater">
                    <?php
                        try {
                          require("db_connect.php");
                      
                          $query = $db->query("select * from theater");
                          while($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                            echo "<option value='$row[theater_sn]'>",$row[theater_name],"</option>"; } 
                        } catch (PDOException $e) { 
                          exit($e->getMessage()); 
                        } ?>
                  </select><br />

                  <br />
                    </div>
                  <div class="btnWrapper">
                    <input type="submit" value="삭제" id="submitBtn_delTheater" />
                    </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modifyEvent blocks">
        
        <div class="addEvent">
            <div class="eventTitle"> 
                    공지사항 등록
              </div>
            <div class="textWrapper">
          <form mothod="post" action="/CGBee/admin/addEvent.php" class="forms">
            <input type="hidden" name="date" value="<?=$today?>" />
            <span> 제목 </span>
            <input type="text" name="title" /><br /><br />
            <p>내용</p>
            <textarea id="textarea" name="contents" rows="5" cols="50"></textarea>
            <br />
            <p> <img class="addImg" src="../images/addPhoto.png" alt="" /> </p><input type="file" name="img" /><br /><br />
        </div>
            <div class="btnWrapper">
                <input type="submit" value="추가" id="submitBtn_addEvent" />
                </form>
            </div>
        </div>
      </div>
      <div id="addMovieList" class="blocks">
        <form mothod="post" action="/CGBee/admin/addMovieList.php">
          <div class="selectTheater">
            <span> <i class="fas fa-theater-masks fa-3x"></i><br /><br /> </span>
            <select id="theater" name="theater">
              <?php
                                try {
                                    require("db_connect.php");
                                
                                    $query = $db->query("select * from theater");
                                    while($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                                      echo "<option value='$row[theater_sn]'>",$row[theater_name],
                                      "</option>"; }
                                } catch (PDOException $e) { 
                                  exit($e->getMessage()); 
                                } ?>
            </select>
          </div>
          <div class="selectMovie">
            <div class="multiselect">
              <div class="boxWrapper">
                <div class="selectBox" onclick="showCheckboxes()">
                  <p>
                    <select disabled>
                      <option>Select Movie</option>
                    </select>
                  </p>
                  <div class="overSelect"></div>
                </div>

                <div id="checkboxes">
                  <?php
                                            try {
                                                require("db_connect.php");
                                            
                                                $query = $db->query("select * from movie"); 
                                                while($row = $query->fetch(PDO::FETCH_ASSOC)) { echo "<label
                    ><input type='checkbox' id='movieList' name='movie[]' value='$row[id]' /> $row[title]</label
                  >"; } } catch (PDOException $e) { exit($e->getMessage()); } ?>
                </div>
              </div>
              <input type="submit" value="추가" />
            </div>
          </div>
        </form>
      </div>
      <div class="modifyNotice blocks">
        <ul class="noticeLists">
          <?php
                try {
                    require("db_connect.php");

                    $query = $db->query("select * from board"); while ($row = $query->fetch(PDO::FETCH_ASSOC)) { $id =
          $row["id"]; $title = $row["title"]; $contents = $row["contents"]; $write_date = $row["write_date"]; $eventImg
          = $row["eventImg"]; echo "
          <li class='eventItems'>
            ", "
            <div class='itemWrapper'>
              ", "<img class='eventImg' src='$eventImg' />","
              <p>$title</p>
              ", "
              <form mothod='post' action='/CGBee/admin/delEvent.php'>
                ", "<input type='hidden' name='eventId' value='$id' />", "<input
                type='submit'
                  style='all: unset; cursor: pointer; font-size: 30px;'
                  value='❌'
                />", "
              </form>
              ", "
            </div>
            ", "
            <p class='contents'>", $contents ,"</p>
            ", "
          </li>
          "; } } catch (PDOException $e) { exit($e->getMessage()); } ?>
        </ul>
      </div>
    </div>
    <script>
      // TODO 집가서 이 부분 손 보기
      function togglingTheater() {
        let theaters = $("#theaters");
        if (theaters.css("display") == "none") {
          theaters.css("display", "block");
          $("#toggleTheater").text("Hide Theaters");
        } else {
          $("#toggleTheater").text("Show Theaters");
          theaters.css("display", "none");
        }
      }

      $("#toggleTheater").click(function () {
        togglingTheater();
      });
    </script>
  </body>
</html>
