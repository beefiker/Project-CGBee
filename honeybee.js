const beeYellow = "#f9c901";
const beeDark = "#242424";

$.ajax({
  method: "GET",
  url: "https://yts-proxy.now.sh/list_movies.json",
  data: { limit: 15, sort_by: "like_count" },
}).done(function (event) {
  console.log(event.data);
  const movies = event.data.movies;

  for (i = 0; i < movies.length; i++) {
    const summary = movies[i].summary.slice(0, 140) + "...";
    $("#sortByLike").append("<div class=sortLikePartition id=LikePartition" + i + "></div>");
    $("#LikePartition" + i).append("<img src='" + movies[i].medium_cover_image + "'/>");
    $("#LikePartition" + i).append("<p class=movietitle>" + movies[i].title + "</p>");
    $("#LikePartition" + i).append("<p class=movieGenre>" + movies[i].genres[0] + ", " + movies[i].genres[1] + "</p>");
    $("#LikePartition" + i).append("<p class=movieSummary>" + summary + "</p>");

    var newForm = $("<form></form>");

    newForm.attr("name", "newForm");
    newForm.attr("method", "post");
    newForm.attr("action", "/getMovie.php");
    newForm.attr("target", "_blank");
    newForm.append($("<input/>", { type: "hidden", name: "movieTitle", value: movies[i].title_long }));
    newForm.append($("<input/>", { type: "hidden", name: "movieGenre", value: movies[i].genres }));
    newForm.append($("<input/>", { type: "hidden", name: "movieSummary", value: movies[i].summary }));
    newForm.append($("<input/>", { type: "hidden", name: "movieYear", value: movies[i].year }));
    newForm.append($("<input/>", { type: "hidden", name: "movieRating", value: movies[i].rating }));
    newForm.append($("<input/>", { type: "hidden", name: "movieRuntime", value: movies[i].runtime }));
    newForm.append($("<input/>", { type: "hidden", name: "moviePoster", value: movies[i].medium_cover_image }));

    newForm.append($("<input/>", { type: "submit", name: "data2", value: "예매하기", id: "ReservationBtn" }));

    newForm.appendTo("#LikePartition" + i);

    // $("#sortByLike").append("<div id=scrollHorizon>ㅁ</div>");
  }

  $("#LikePartition0").hover(
    () => {
      $("#LikePartition0 > .movietitle").css({ visibility: "visible" });
      $("#LikePartition0 > .movieGenre").css({ visibility: "visible" });
      $("#LikePartition0 > .movieSummary").css({ visibility: "visible" });
      $("#LikePartition0 > form > input").css({ visibility: "visible" });
      $("#LikePartition0 > img").animate({ opacity: "0.5" }, 300);
    },
    () => {
      $("#LikePartition0 > img").animate({ opacity: "1" }, 300);
      $("#LikePartition0 > .movietitle").css({ visibility: "hidden" });
      $("#LikePartition0 > .movieGenre").css({ visibility: "hidden" });
      $("#LikePartition0 > .movieSummary").css({ visibility: "hidden" });
      $("#LikePartition0 > form > input").css({ visibility: "hidden" });
      $("#LikePartition0 > .gogo").css({ visibility: "hidden" });
    }
  );
});

let count = 0;
$("#scrollLeftHorizon").click(() => {
  count++;
  let val = -300;
  let i = count * val;
  $("#sortByLike").animate({
    left: i,
  });
  if (i == -3600) alert("Done");
});

// * 크기를 되돌렸을 때 생기는 오류 대비
$(window).resize(function () {
  if (CurrentMenuValue == 1) {
    if ($(window).width() >= 800) {
      $("#navi").animate({ left: "-300px" }, 200);
      $("#Topmenu, #container").animate({ left: 0 }, 200);
      $(".Btncontainer").removeClass("change");
      CurrentMenuValue = 0;
    }
  }
});

// * Click animating code starts from here.

const page = $("html, body");

const logo = document.querySelector("#logoImg");
logo.addEventListener("click", () => {
  window.scrollTo({ top: document.querySelector("#box1").offsetTop, behavior: "smooth" });
});

$("#gotoA, #naviA").click(() => {
  const CurrentBoxTop = $("#box1").offset().top;
  page.stop().animate({ scrollTop: CurrentBoxTop }, 800, "easeInExpo");
});
$("#gotoB, #naviB").click(() => {
  const CurrentBoxTop = $("#box2").offset().top;
  page.stop().animate({ scrollTop: CurrentBoxTop }, 800, "easeInExpo");
});
$("#gotoC, #naviC").click(() => {
  const CurrentBoxTop = $("#box3").offset().top;
  page.stop().animate({ scrollTop: CurrentBoxTop }, 800, "easeInExpo");
});
$("#gotoD, #naviD").click(() => {
  const CurrentBoxTop = $("#box4").offset().top;
  page.stop().animate({ scrollTop: CurrentBoxTop }, 800, "easeInExpo");
});
$("#gotoE, #naviE").click(() => {
  const CurrentBoxTop = $("#box5").offset().top;
  page.stop().animate({ scrollTop: CurrentBoxTop }, 800, "easeInExpo");
});
$("#gotoF, #naviF").click(() => {
  const CurrentBoxTop = $("#box6").offset().top;
  page.stop().animate({ scrollTop: CurrentBoxTop }, 800, "easeInExpo");
});
$("#gotoG, #naviG").click(() => {
  const CurrentBoxTop = $("#box7").offset().top;
  page.stop().animate({ scrollTop: CurrentBoxTop }, 800, "easeInExpo");
});

const CurrentColor = "#636e72";
$("#gotoA").css({ color: CurrentColor });
$("#naviA").css({ color: CurrentColor });

// ! 셋인터벌로 브라우저 속도 조절
setInterval(() => {
  $(window).scroll(() => {
    let browserY = $(document).scrollTop() + 350;
    let CurrentPageNum = 0;
    const page1Y = $("#box1").offset();
    const page2Y = $("#box2").offset();
    const page3Y = $("#box3").offset();
    const page4Y = $("#box4").offset();
    const page5Y = $("#box5").offset();
    const page6Y = $("#box6").offset();
    const page7Y = $("#box7").offset();

    if (browserY < page2Y.top) {
      CurrentPageNum = 0;
      $(".menuList").css({ color: "white" });
      $("#gotoA").css({ color: CurrentColor });
      $(".navimenu").css({ color: "white" });
      $("#naviA").css({ color: CurrentColor });
    } else if (browserY == page1Y.top && browserY < page2Y.top) {
      CurrentPageNum = 1;
      $(".menuList").css({ color: "white" });
      $("#gotoA").css({ color: CurrentColor });
      $(".navimenu").css({ color: "white" });
      $("#naviB").css({ color: CurrentColor });
    } else if ((browserY >= page2Y.top && browserY <= page3Y.top) || browserY == page2Y.top) {
      CurrentPageNum = 2;
      $(".menuList").css({ color: "white" });
      $("#gotoB").css({ color: CurrentColor });
      $(".navimenu").css({ color: "white" });
      $("#naviB").css({ color: CurrentColor });
    } else if ((browserY >= page3Y.top && browserY <= page4Y.top) || browserY == page3Y.top) {
      CurrentPageNum = 3;
      $(".menuList").css({ color: "white" });
      $("#gotoC").css({ color: CurrentColor });
      $(".navimenu").css({ color: "white" });
      $("#naviC").css({ color: CurrentColor });
    } else if ((browserY >= page4Y.top && browserY <= page5Y.top) || browserY == page4Y.top) {
      CurrentPageNum = 4;
      $(".menuList").css({ color: "white" });
      $("#gotoD").css({ color: CurrentColor });
      $(".navimenu").css({ color: "white" });
      $("#naviD").css({ color: CurrentColor });
    } else if ((browserY >= page5Y.top && browserY <= page6Y.top) || browserY == page5Y.top) {
      CurrentPageNum = 5;
      $(".menuList").css({ color: "white" });
      $("#gotoE").css({ color: CurrentColor });
      $(".navimenu").css({ color: "white" });
      $("#naviE").css({ color: CurrentColor });
    } else if ((browserY >= page6Y.top && browserY <= page7Y.top) || browserY == page6Y.top) {
      CurrentPageNum = 6;
      $(".menuList").css({ color: "white" });
      $("#gotoF").css({ color: CurrentColor });
      $(".navimenu").css({ color: "white" });
      $("#naviF").css({ color: CurrentColor });
    } else if (browserY >= page7Y.top) {
      CurrentPageNum = 7;
      $(".menuList").css({ color: "white" });
      $("#gotoG").css({ color: CurrentColor });
      $(".navimenu").css({ color: "white" });
      $("#naviG").css({ color: CurrentColor });
    }
  });
}, 200);

let CurrentMenuValue = 0; // * 메뉴 숨겨있을 때 0, 클릭해서 나타냈을 때 1
$("#menuBtn").click(() => {
  switch (CurrentMenuValue) {
    case 0:
      $(".Btncontainer").addClass("change");
      $("#navi").animate({ left: 0 }, 200);
      $("#Topmenu, #container").animate({ left: "300px" }, 200);
      CurrentMenuValue = 1;
      break;
    case 1:
      $(".Btncontainer").removeClass("change");
      $("#navi").animate({ left: "-300px" }, 200);
      $("#Topmenu, #container").animate({ left: 0 }, 200);
      CurrentMenuValue = 0;
      break;
  }
  if (CurrentMenuValue == 1) {
    $(".box").click(() => {
      $(".Btncontainer").removeClass("change");
      $("#navi").animate({ left: "-300px" }, 200);
      $("#Topmenu, #container").animate({ left: 0 }, 200);
      CurrentMenuValue = 0;
    });
  }
});
