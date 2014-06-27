<div id="contentMypage" class="row">
  <!-- mypageProfile -->
  <div id="calendar" class="col-sm-3">
    <div class="box clearfix" id="calendar-search">
      <?php echo $calendar; ?>
    </div>
    <div class="box clearfix">
      <h3 style="float: none; margin-bottom:5px;">オプション変更</h3>
      <ul style="float: none">
        <li style="margin-right: 10px;"><a href="/mypage/account">アカウント設定</a></li>
        <li><a href="/mypage/password">パスワード変更</a></li>
      </ul>
    </div>
    <!-- ad -->
    <!-- <div class="ad clearfix"> <a href="#"><img src="http://dummyimage.com/220x150/ccc/fff.jpg" class="img-responsive"></a></div> -->
    <!-- /ad -->
  </div>
  <!-- /mypageProfile -->
  <!-- searchResult -->
  <div id="searchResult" class="col-sm-9">
    <!-- pills -->
    <ul class="nav nav-pills">
      <li><a href="/mypage/list?type=finished">これまで参加したフリマ <span class="badge"><?php echo e(Auth::getFinishedEntryCount()); ?>件</span></a></li>
      <li><a href="/mypage/list?type=reserved">出店予約中のフリマ <span class="badge"><?php echo e(Auth::getReservedEntryCount()); ?>件</span></a></li>
      <li><a href="/mypage/list?type=waiting">キャンセル待ちのフリマ <span class="badge"><?php echo e(Auth::getWaitingEntryCount()); ?>件</span></a></li>
      <li><a href="/mypage/list?type=mylist">マイリスト <span class="badge"><?php echo e(Auth::getFavoriteCount()); ?>件</span></a></li>
    </ul>
    <!-- /pills -->
    <!-- search -->
    <div id="search" class="box clearfix">
      <?php echo $search;?>
    </div>
    <!-- /search -->
    <!-- newArrivals -->
    <div id="newArrivals" class="box clearfix">
      <h3>新着情報</h3>
      <dl class="dl-horizontal">
        <?php foreach ($news_headlines as $headline): ?>
        <dt><?php echo $headline['date'] ?></dt>
        <dd><a href="<?php echo $headline['url'] ?>"><?php echo $headline['title'] ?></a></dd>
        <?php endforeach; ?>
      </dl>
    </div>
    <!-- /newArrivals -->
    <!-- nav-tabs -->
    <ul class="nav nav-tabs hidden-xs">
      <li class="active"><a href="#latest" data-toggle="tab">最新の開催</a></li>
      <li><a href="#ranking" data-toggle="tab">人気開催ランキング</a></li>
    </ul>
    <ul class="nav nav-tabs visible-xs">
      <li class="active"><a href="#latest" data-toggle="tab">最新</a></li>
      <li><a href="#ranking" data-toggle="tab">人気</a></li>
      <li><a href="#check" data-toggle="tab">履歴</a></li>
    </ul>
    <!-- /nav-tabs -->
    <!-- tabGroup -->
    <div class="tabGroup">
      <div class="box clearfix">
        <div id="my-tab-content" class="tab-content">
          <!-- latest -->
          <div class="tab-pane active" id="latest">
            <ul id="scrollControl">
              <li id="prev">Prev</li>
              <li id="next">Next</li>
            </ul>
            <div id="newMarket">
              <?php echo $fleamarket_latest; ?>
            </div>
          </div>
          <!-- /latest -->
          <!-- ranking -->
          <div class="tab-pane" id="ranking">
            <?php echo $popular_ranking; ?>
          </div>
          <!-- /ranking -->

        </div>
      </div>
    </div>
    <!-- /tabGroup -->
    <!-- nav-tabs -->
    <ul id="list" class="nav nav-tabs">
      <li class="active"><a href="#reservation" data-toggle="tab">出店予約中のフリマ</a></li>
      <li><a href="#waiting" data-toggle="tab">キャンセル待ちのフリマ</a></li>
      <li><a href="#mylist" data-toggle="tab">マイリスト</a></li>
    </ul>
    <!-- /nav-tabs -->
    <!-- tabGroup -->
    <div class="tabGroup">
      <div class="box clearfix">
        <div id="my-tab-content" class="tab-content">
          <!-- reservation -->
          <div class="tab-pane active" id="reservation">
            <?php if (empty($fleamarkets_view['reserved'])): ?>
                <p>予約済みフリマはありません。</p>
            <?php else: ?>
                <?php foreach ($fleamarkets_view['reserved'] as $fleamarket_view) { echo $fleamarket_view; }; ?>
            <?php endif; ?>
            <ul class="more">
              <li><a href="/mypage/list?type=reserved">続きを見る</a></li>
            </ul>
          </div>
          <!-- waiting -->
          <div class="tab-pane" id="waiting">
            <?php if (empty($fleamarkets_view['waiting'])): ?>
                <p>キャンセル待ちをしているフリマはありません</p>
            <?php else: ?>
                <?php foreach ($fleamarkets_view['waiting'] as $fleamarket_view) { echo $fleamarket_view; }; ?>
            <?php endif; ?>
            <ul class="more">
              <li><a href="/mypage/list?type=waiting">続きを見る</a></li>
            </ul>
          </div>
          <!-- mylist -->
          <div class="tab-pane" id="mylist">
            <?php if (empty($fleamarkets_view['mylist'])): ?>
                <p>マイリストはありません</p>
            <?php else: ?>
                <?php foreach ($fleamarkets_view['mylist'] as $fleamarket_view) { echo $fleamarket_view; }; ?>
            <?php endif; ?>
            <ul class="more">
              <li><a href="/mypage/list?type=mylist">続きを見る</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div id="contribution" class="box clearfix">
        <h3>開催投稿したフリマ</h3>
        <?php if (empty($fleamarkets_view['myfleamarket'])): ?>
        <p>開催投稿したフリマはありません</p>
        <?php else: ?>
          <?php foreach ($fleamarkets_view['myfleamarket'] as $fleamarket_view) { echo $fleamarket_view; }; ?>
        <?php endif; ?>
        <ul class="more">
          <li><a href="/mypage/list?type=myfleamarket">続きを見る</a></li>
        </ul>
      </div>
      <!-- /contribution -->
    </div>
    <!-- /searchResult -->
  </div>
</div>
<div id="information-dialog" class="afDialog">
  <p id="message" class="message"></p>
</div>
<div id="dialog_confirm" class="afDialog" title="解除">
  <p id="message" class="message">解除してもよろしいですか？</p>
</div>
<script type="text/javascript">
$(function() {
  $('.cancel_reservation, .cancel_waiting').click(function(evt) {
    evt.preventDefault();

    var cancel = $(this).attr("class").replace("cancel_", "");
    var href = $(this).attr("href");
    $("#dialog_confirm").dialog({
      buttons: {
        "はい": function(event){
          location.href = href + "&cancel=" + cancel;
        },
        "いいえ": function(event){
          $(this).dialog("close");
        }
      }
    });

    return false;
  });

  $(".mylist_remove").click(function(evt) {
    evt.preventDefault();
    var id = $(this).attr("id");
    id = id.match(/^fleamarket_id_(\d+)/)[1];

    $.ajax({
      type: "post",
      url: "/favorite/delete",
      dataType: "json",
      data: {fleamarket_id: id}
    }).done(function(json, textStatus, jqXHR) {
      if (json == 'nologin' || json == 'nodata') {
        openDialog("マイリストを解除するためにはログインが必要です");
      }else if(json){
        openDialog("マイリストを解除しました", true);
      }else{
        openDialog("マイリストを解除できませんでした");
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      openDialog("マイリストを解除できませんでした");
    });
  });

  Calendar.init();
  Carousel.start();
  Search.init();
});

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
        url: "/search/prefecture",
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

var openDialog = function(message, reload) {
  if (typeof reload == "undefined") {
    reload = false;
  }
  $("#information-dialog #message").text(message);
  $("#information-dialog").dialog({
    modal: true,
    buttons: {
      Ok: function() {
        if (reload) {
          location.reload();
        }
        $(this).dialog("close");
      }
    }
  });
};
</script>
