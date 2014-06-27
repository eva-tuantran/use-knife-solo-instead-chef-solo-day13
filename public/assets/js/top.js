$(function() {
  $('img[usemap]').rwdImageMaps();
  Calendar.init();
  Carousel.start();

  Map.init();

  var $mapimage = $("#map img");
  $('#map area').hover(function(){
    $($mapimage).attr('src', $($mapimage).attr('src').replace('map_normal', $(this).attr("id")));
  }, function(){
    $($mapimage).attr('src', $($mapimage).attr('src').replace($(this).attr("id"), 'map_normal'));
  });
});

var Map = {
  previous_region: 0,
  current_region: null,
  init: function() {
    $('#map map area').on("click", function(evt) {
      evt.preventDefault();
      Map.current_region = $(this).index() + 1;
      Map.click();

      return false;
    });

    $("#map").on("mouseleave", function(evt) {
      $('div.region').hide();
      Map.previous_region= null;
    });
  },
  click: function() {
    $('div.region').hide();
    if (Map.isShow()) {
      var tipDiv = '#region_0' + Map.current_region;
      var parent_width = $("#map").width();
      var tip_width = $(tipDiv).width();
      var padding = (parent_width - tip_width + 20) / 2;
      $(tipDiv).css("left", padding).show();
    }
  },
  isShow: function() {
    var is_show = Map.previous_region != Map.current_region;
    if (is_show) {
      Map.previous_region = Map.current_region;
    } else {
      Map.previous_region= null;
    }

    return is_show;
  }
};

var Calendar = {
  init: function() {
    $(document).on("click", ".calendar_nav a", function(evt) {
      evt.preventDefault();

      var url = $(this).attr("href");
      Calendar.get(url);

      return false;
    });
  },
  get: function(url) {
    if (url == "" || typeof url === "undefined") {
      url = "/calendar/";
    }

    $.ajax({
      type: "get",
      url: url,
      dataType: "html"
    }).done(function(html, textStatus, jqXHR) {
      $("#calendar-search").empty();
      $("#calendar-search").html(html);
    }).fail(function(jqXHR, textStatus, errorThrown) {
    }).always(function() {
    });
  }
};

var Carousel = {
  start: function () {
    $(window).resize(function() {
      $("#newMarket").carouFredSel({
        align: true,
        scroll:{
          items: 1,
          duration: 300,
          pauseDuration: 2000,
          easing: "linear",
          pauseOnHover: "immediate"
        },
        prev:{button: "#prev", key: "left"},
        next:{button: "#next", key: "right"}
      });
    });
    $(window).resize();
  }
};
