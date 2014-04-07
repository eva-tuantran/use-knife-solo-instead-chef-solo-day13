$(function() {
  $('img[usemap]').rwdImageMaps();
  Calendar.init();
  Carousel.start();

  Map.init();
  Search.init();
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
      $(tipDiv).show();
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
          pauseDuration: 5000,
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

var Search = {
  init: function() {
    $("#select_region").on("change", function(evt) {
      Search.changeRegion();
    });
  },
  changeRegion: function() {
    $("#select_prefecture").prop("selectedIndex", 0);
    var region_id = $("#select_region").val();
    $.ajax({
      type: "get",
      url: '/search/prefecture',
      dataType: "json",
      data: {region_id: region_id}
    }).done(function(json, textStatus, jqXHR) {
      if (json) {
        $("#select_prefecture").empty();
        $("#select_prefecture").append('<option value="">都道府県</option>');
        $.each(json, function(key, value) {
          $("#select_prefecture").append('<option value="' + key + '">' + value + '</option>');
        });
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
    });
  }
};
