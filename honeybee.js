const beeYellow = "#f9c901";
const beeDark = "#242424";

$.ajax({
  method: "GET",
  url: "https://yts-proxy.now.sh/list_movies.json",
  data: { limit: 50 },
  beforeSend: () => {
    $(".needsLoad").hide();

    let width = 450;
    let height = 350;
    let top = ($(window).height() - height) / 2 + $(window).scrollTop();
    let left = ($(window).width() - width) / 2 + $(window).scrollLeft();

    if ($("#load_image").length != 0) {
      $("#load_image").css({
        top: top + "px",
        left: left + "px",
      });
      $("#load_image").show();
    } else {
      $("body").append(
        '<div id="load_image" style="position:absolute; top:' +
          top +
          "px; left:" +
          left +
          "px; width:" +
          width +
          "px; height:" +
          height +
          'px; z-index:-1; margin:auto; padding:0; "><img src="images/flask.gif" style="width:100%; height:100%;"></div>'
      );
    }
  },
  success: function () {
    $.ajax({
      method: "GET",
      url: "https://yts-proxy.now.sh/list_movies.json",
      data: { limit: 15 },
      complete: () => {
        $("#load_image").fadeOut(500);
        $(".needsLoad").show();
        $("#load_image").remove();
      },
    });
  },
});

hoverMovies = (prop, count) => {
  for (let i = 0; i < count; i++) {
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
};
hoverMovies("#trendingPartition", 15);
hoverMovies("#dramaPartition", 15);
hoverMovies("#actionPartition", 15);
hoverMovies("#musicPartition", 15);
hoverMovies("#adventurePartition", 15);

sliderLeft = (prop) => {
  let currentX = $(prop).scrollLeft();
  let val = -500;
  let i = currentX + val;
  $(prop).animate({
    scrollLeft: i,
  });
};

sliderRight = (prop) => {
  let currentX = $(prop).scrollLeft();
  let val = 500;
  let i = currentX + val;
  $(prop).animate({
    scrollLeft: i,
  });
};

$("#movieList_slideRight").click(() => {
  sliderRight("#movieListWrapper");
});

$("#movieList_slideLeft").click(() => {
  sliderLeft("#movieListWrapper");
});

togglingNotice = () => {
  let notices = $(".noticeLists_ul");
  if (notices.css("display") == "none") {
    $("#toggleNotice").html(
      "<p class='subtext_align_middle needsLoad' id='toggleNotice'>Notice <i class='fas fa-caret-down fa-1x'></i></p>"
    );
    notices.fadeIn(500);
  } else {
    $("#toggleNotice").html(
      "<p class='subtext_align_middle needsLoad' id='toggleNotice'>Notice <i class='fas fa-caret-up fa-1x'></i></p>"
    );
    notices.fadeOut(500);
  }
};
togglingTheater = () => {
  let theaters = $(".theaterLists_ul");
  if (theaters.css("display") == "none") {
    $("#toggleTheater").html(
      "<p class='subtext_align_middle needsLoad' id='toggleTheater'>Theater <i class='fas fa-caret-down fa-1x'></i></p>"
    );
    theaters.fadeIn(500);
  } else {
    $("#toggleTheater").html(
      "<p class='subtext_align_middle needsLoad' id='toggleTheater'>Theater <i class='fas fa-caret-up fa-1x'></i></p>"
    );
    theaters.fadeOut(500);
  }
};

$("#toggleTheater").click(() => {
  togglingTheater();
});
$("#toggleNotice").click(() => {
  togglingNotice();
});

// * 크기를 되돌렸을 때 생기는 오류 대비
$(window).resize(() => {
  if (CurrentMenuValue == 1) {
    if ($(window).width() >= 800) {
      $("#navi").animate({ left: "-300px" }, 200);
      $("#Topmenu, #container").animate({ left: 0 }, 200);
      $(".Btncontainer").removeClass("change");
      CurrentMenuValue = 0;
    }
  }
});

const page = $("html, body");
const logo = document.querySelector("#logoImg");

logo.addEventListener("click", () => {
  window.scrollTo({ top: document.querySelector("#box1").offsetTop, behavior: "smooth" });
});
animateToBox = (box) => {
  const CurrentBoxTop = $(box).offset().top - 100;
  page.stop().animate({ scrollTop: CurrentBoxTop }, 800, "easeInExpo");
};

$("#gotoA, #naviA").click(() => {
  animateToBox("#box1");
});
$("#gotoB, #naviB").click(() => {
  animateToBox("#box2");
});
$("#gotoC, #naviC").click(() => {
  animateToBox("#box3");
});
$("#gotoD, #naviD").click(() => {
  animateToBox("#box4");
});
$("#gotoE, #naviE").click(() => {
  animateToBox("#box5");
});
$("#gotoF, #naviF").click(() => {
  animateToBox("#NoticeBox");
});

let CurrentMenuValue = 0; // * 메뉴 숨겨있을 때 0, 클릭해서 나타냈을 때 1
animateToBefore = () => {
  $(".Btncontainer").removeClass("change");
  $("#navi").animate({ left: "-300px" }, 200);
  $("#Topmenu, #container").animate({ left: 0 }, 200);
  CurrentMenuValue = 0;
};

$("#menuBtn").click(() => {
  switch (CurrentMenuValue) {
    case 0:
      $(".Btncontainer").addClass("change");
      $("#navi").animate({ left: 0 }, 200);
      $("#Topmenu, #container").animate({ left: "300px" }, 200);
      CurrentMenuValue = 1;
      break;
    case 1:
      animateToBefore();
      break;
  }
  if (CurrentMenuValue == 1) {
    $(".box").click(() => {
      animateToBefore();
    });
  }
});

openHistory = () => {
  let details = window.open("/CGBee/history.php", "PopupWin", "width=1100,height=600");
};
$("#ReservationDetails, #naviG").click(() => {
  openHistory();
});

$("#searchBtn").on("click", function () {
  window.open("", "popup_window", "width=800, height=365 scrollbars=yes");
  $("#searchForm").submit();
});
