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
      <li><a href="/mypage/list?type=entry">これまで参加したフリマ <span class="badge"><?php echo e(Auth::getFinishedEntryCount()); ?>件</span></a></li>
      <li><a href="/mypage/list?type=reserved">出店予約中のフリマ <span class="badge"><?php echo e(Auth::getReservedEntryCount()); ?>件</span></a></li>
      <li><a href="/mypage/list?type=reserved">キャンセル待ちのフリマ <span class="badge"><?php echo e(Auth::getWaitingEntryCount()); ?>件</span></a></li>
      <li><a href="/mypage/list?type=mylist">マイリスト <span class="badge"><?php echo e(Auth::getFavoriteCount()); ?>件</span></a></li>
    </ul>
    <!-- /pills -->
    <!-- search -->
    <div id="search" class="box clearfix">
      <div class="row">
        <form id="form_search" action="/search/1/" method="get">
          <fieldset>
            <div id="searchInput" class="col-md-7">
              <div class="form-group">
                <input type="text" class="form-control" id="keywordInput" placeholder="キーワードを入力" name="conditions[keyword]">
              </div>
              <div id="searchCheckbox">

                <label for="form_shop_fee">
                  <input id="form_shop_fee" type="checkbox" name="conditions[shop_fee]" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_FREE;?>">出店無料
                </label>
                <label for="form_car_shop">
                  <input id="form_car_shop" type="checkbox" name="conditions[car_shop]" value="<?php echo \Model_Fleamarket::CAR_SHOP_FLAG_OK;?>">車出店可
                </label>
                <label for="form_rainy_location">
                  <input id="form_rainy_location" type="checkbox" name="conditions[rainy_location]" value="<?php echo \Model_Fleamarket::RAINY_LOCATION_FLAG_EXIST;?>">雨天開催会場
                </label>
                <label for="form_pro_shop">
                  <input id="form_pro_shop" type="checkbox" name="conditions[form_pro_shop]" value="<?php echo \Model_Fleamarket::PRO_SHOP_FLAG_OK;?>">プロ出店可
                </label>
                <label for="form_charge_parking">
                  <input id="form_charge_parking" type="checkbox" name="conditions[charge_parking]" value="<?php echo \Model_Fleamarket::CHARGE_PARKING_FLAG_EXIST;?>">有料駐車場あり
                </label>
                <label for="form_free_parking">
                  <input id="form_free_parking" type="checkbox" name="conditions[free_parking]" value="<?php echo \Model_Fleamarket::FREE_PARKING_FLAG_EXIST;?>">無料駐車場あり
                </label>

              </div>
            </div>
            <div id="searchSelect" class="col-md-3">
              <div class="form-group">
                <select id="select_region" class="form-control" name="conditions[region]">
                  <option value="">エリア</option>
                  <?php
                  foreach ($regions as $region_id => $name):
                  ?>
                  <option value="<?php echo $region_id;?>"><?php echo $name;?></option>
                  <?php
                  endforeach;
                  ?>
                </select>
              </div>
              <div class="form-group">
                <select id="select_prefecture" class="form-control" name="conditions[prefecture]">
                  <option value="">都道府県</option>
                  <?php
                  foreach ($prefectures as $prefecture_id => $name):
                  ?>
                  <option value="<?php echo $prefecture_id;?>"><?php echo $name;?></option>
                  <?php
                  endforeach;
                  ?>
                </select>
              </div>
            </div>
            <div id="searchButton" class="col-md-2">
              <button type="submit" class="btn btn-default">検索</button>
            </div>
          </fieldset>
        </form>
      </div>
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
    <ul class="nav nav-tabs">
      <li class="active"><a href="#reservation" data-toggle="tab">出店予約したフリマ</a></li>
      <li><a href="#waiting" data-toggle="tab">キャンセル待ち中のフリマ</a></li>
      <li><a href="#mylist" data-toggle="tab">マイリスト</a></li>
    </ul>
    <!-- /nav-tabs -->

    <!-- tabGroup -->
    <div class="tabGroup">
      <div class="box clearfix">
        <div id="my-tab-content" class="tab-content">

          <!-- reservation -->
          <div class="tab-pane active" id="reservation">
            <?php if (empty($fleamarkets_view['entry'])): ?>
                <p>予約済みフリマはありません。</p>
            <?php else: ?>
                <?php foreach ($fleamarkets_view['entry'] as $fleamarket_view) { echo $fleamarket_view; }; ?>
            <?php endif; ?>
            <ul class="more">
              <li><a href="/mypage/list?type=entry">続きを見る</a></li>
            </ul>
          </div>

          <!-- waiting -->
          <div class="tab-pane" id="waiting">
            <?php if (empty($fleamarkets_view['waiting'])): ?>
                <p>キャンセル待ち中のフリマはありません</p>
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
</div>
</div>


<script>

$('.fleamarket_cancel').click(function() {
  var href = $(this).attr('href');
  $('#dialog_confirm').dialog({
    buttons: {
      "はい": function(event){
         location.href = href;
       },
      "いいえ": function(event){
        $(this).dialog("close");
       }
    }
  });
  return false;
});


$(function() {
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
      // $("#calendar").empty();
      // $("#calendar").html(html);
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

$(function () {
  $(".mylist_remove").click(function(){
    var id = $(this).attr('id');
    id = id.match(/^fleamarket_id_(\d+)/)[1];

    $.ajax({
      type: "post",
      url: '/favorite/delete',
      dataType: "json",
      data: {fleamarket_id: id}
    }).done(function(json, textStatus, jqXHR) {
      if (json == 'nologin' || json == 'nodata') {
        $('#dialog_need_login').dialog();
      } else if (json) {
        $('#dialog_success').dialog({close: function(event){ location.reload(); }});
      } else {
        $('#dialog_fail').dialog();
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      $('#dialog_fail').dialog();
    });
  });
});
</script>

<div id="dialog_success" style="display: none;">
マイリストを解除しました
</div>
<div id="dialog_fail" style="display: none;">
マイリストを解除できませんでした
</div>
<div id="dialog_need_login" style="display: none;">
マイリストを解除するためにはログインが必要です
</div>

<div id="dialog_confirm" style="display: none;">
フリーマーケットをキャンセルします。よろしいですか？
</div>
