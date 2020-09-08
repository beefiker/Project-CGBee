const beeYellow = "#f9c901";
const beeDark = "#242424";

$.ajax({
  method: "GET",
  url: "https://yts-proxy.now.sh/list_movies.json",
  data: { limit: 15, sort_by: "like_count" },
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
          'px; z-index:-1; margin:auto; padding:0; "><img src="flask.gif" style="width:100%; height:100%;"></div>'
      );
    }
  },
  success: function () {
    $.ajax({
      method: "GET",
      url: "https://yts-proxy.now.sh/list_movies.json",
      data: { limit: 15, sort_by: "rating" },
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
              'px; z-index:-1; margin:auto; padding:0;"><img src="flask.gif" style="width:100%; height:100%;"></div>'
          );
        }
      },
      complete: () => {
        $("#load_image").fadeOut(500);
        $(".needsLoad").show();
        $("#load_image").remove();
      },
    }).done((event) => {
      console.log(event.data);
      const movies = event.data.movies;

      for (i = 0; i < movies.length; i++) {
        const summary = movies[i].summary.slice(0, 140) + "...";
        $("#sortByRating").append("<div class=sortPartition id=RatingPartition" + i + "></div>");
        $("#RatingPartition" + i).append("<img src='" + movies[i].medium_cover_image + "'/>");
        $("#RatingPartition" + i).append("<p class=movietitle>" + movies[i].title + "</p>");
        $("#RatingPartition" + i).append(
          "<p class=movieGenre>" + movies[i].genres[0] + ", " + movies[i].genres[1] + "</p>"
        );
        $("#RatingPartition" + i).append("<p class=movieSummary>" + summary + "</p>");

        var newForm = $("<form></form>");

        newForm.attr("name", "newForm");
        newForm.attr("method", "post");
        newForm.attr("action", "/CGBee/getMovie.php");
        newForm.attr("target", "_blank");
        newForm.append($("<input/>", { type: "hidden", name: "movieTitle", value: movies[i].title_long }));
        newForm.append($("<input/>", { type: "hidden", name: "movieGenre", value: movies[i].genres }));
        newForm.append($("<input/>", { type: "hidden", name: "movieSummary", value: movies[i].summary }));
        newForm.append($("<input/>", { type: "hidden", name: "movieYear", value: movies[i].year }));
        newForm.append($("<input/>", { type: "hidden", name: "movieRating", value: movies[i].rating }));
        newForm.append($("<input/>", { type: "hidden", name: "movieRuntime", value: movies[i].runtime }));
        newForm.append($("<input/>", { type: "hidden", name: "moviePoster", value: movies[i].medium_cover_image }));

        newForm.append($("<input/>", { type: "submit", name: "data2", value: "예매하기", id: "ReservationBtn" }));

        newForm.appendTo("#RatingPartition" + i);

        let thisPartition = $("#RatingPartition" + i);
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
    });
  },
}).done((event) => {
  console.log(event.data);
  const movies = event.data.movies;

  for (i = 0; i < movies.length; i++) {
    const summary = movies[i].summary.slice(0, 140) + "...";
    $("#sortByLike").append("<div class=sortPartition id=LikePartition" + i + "></div>");
    $("#LikePartition" + i).append("<img src='" + movies[i].medium_cover_image + "'/>");
    $("#LikePartition" + i).append("<p class=movietitle>" + movies[i].title + "</p>");
    $("#LikePartition" + i).append("<p class=movieGenre>" + movies[i].genres[0] + ", " + movies[i].genres[1] + "</p>");
    $("#LikePartition" + i).append("<p class=movieSummary>" + summary + "</p>");

    var newForm = $("<form></form>");

    newForm.attr("name", "newForm");
    newForm.attr("method", "post");
    newForm.attr("action", "/CGBee/getMovie.php");
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

    let thisPartition = $("#LikePartition" + i);
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
});

$("#LikeRight").click(() => {
  let currentX = $("#sortByLike").scrollLeft();
  let val = 500;
  let i = currentX + val;
  $("#sortByLike").animate({
    scrollLeft: i,
  });
});
$("#RatingRight").click(() => {
  let currentX = $("#sortByRating").scrollLeft();
  let val = 500;
  let i = currentX + val;
  $("#sortByRating").animate({
    scrollLeft: i,
  });
});

$("#LikeLeft").click(() => {
  let currentX = $("#sortByLike").scrollLeft();
  let val = -500;
  let i = currentX + val;
  $("#sortByLike").animate({
    scrollLeft: i,
  });
});
$("#RatingLeft").click(() => {
  let currentX = $("#sortByRating").scrollLeft();
  let val = -500;
  let i = currentX + val;
  $("#sortByRating").animate({
    scrollLeft: i,
  });
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
