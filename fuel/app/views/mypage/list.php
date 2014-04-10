<div id="contentMypage" class="row">

  <!-- mypageProfile -->
  <div id="calendar" class="col-sm-3">
    <div class="box clearfix" id="calendar-search">
      <?php echo $calendar; ?>
    </div>

    <!-- <div class="box clearfix"> -->
    <!-- <li><a href="/mypage/account">アカウント設定</a></li> -->
    <!-- </ul> -->
    <!-- </div> -->
  </div>
  <!-- /mypageProfile -->

  <!-- searchResult -->
  <div id="searchResult" class="col-sm-9">
    <!-- pills -->
    <ul class="nav nav-pills">
      <li><a href="/mypage/list?type=entry">これまで参加したフリマ <span class="badge"><?php echo e(Auth::getFinishedEntryCount()); ?>件</span></a></li>
      <li><a href="/mypage/list?type=reserved">出店予約中のフリマ <span class="badge"><?php echo e(Auth::getReservedEntryCount()); ?>件</span></a></li>
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

    <div id="resultTitle">
    <?php
        switch (Input::get('type')) {
            case 'mylist':
                echo "マイリスト";
                break;
            case 'entry':
                echo "出店したフリマ";
                break;
            case 'myfleamarket':
                echo "投稿したフリマ";
                break;
            default:
                echo "フリマ一覧";
                break;
        }
    ?>
    </div>


    <?php if(empty($fleamarkets)): ?>
    <p>フリマ情報はありません</p>
    <?php else: ?>
    <?php foreach ($fleamarkets as $fleamarket): ?>
    <!-- result -->
    <div class="box result <?php $render_status($fleamarket); ?> <?php echo $is_official($fleamarket) ? 'resultPush' : ''; ?>  clearfix">
      <h3>
        <?php if ($is_official($fleamarket)): ?>
        <strong>楽市楽座主催</strong>
        <?php endif ?>
        <a href="/detail/<?php echo $fleamarket['fleamarket_id'] ?>"><?php echo $fleamarket['name'] ?></a>
      </h3>
      <div class="resultPhoto"><a href="#"><img src="http://dummyimage.com/200x150/ccc/fff.jpg" class="img-rounded"></a></div>
      <div class="resultDetail">
          <dl class="col-md-6">
            <dt>出店数</dt>
            <dd><?php echo e(@$fleamarket['total_booth']);?>店</dd>
          </dl>
          <dl class="col-md-6">
            <dt>開催時間</dt>
            <dd><?php echo e($fleamarket['event_date']); ?></dd>
          </dl>
          <dl class="col-md-6">
            <dt>出店形態</dt>
            <dd><?php echo e(@$fleamarket['fleamarket_entry_style_name']); ?></dd>
          </dl>
          <dl class="col-md-6">
            <dt>出店料金</dt>
            <dd><?php echo e(@$fleamarket['booth_fee_string']); ?></dd>
          </dl>
          <dl class="col-md-11">
            <dt>交通</dt>
            <dd><?php echo e($fleamarket['about_access']);?></dd>
          </dl>
          <ul class="facilitys">
            <li class="facility1 <?php echo e($fleamarket['car_shop_flag'])       ? 'on' : 'off'; ?>">車出店可能</li>
            <li class="facility2 <?php echo e($fleamarket['charge_parking_flag']) ? 'on' : 'off'; ?>">有料駐車場</li>
            <li class="facility3 <?php echo e($fleamarket['free_parking_flag'])   ? 'on' : 'off'; ?>">無料駐車場</li>
            <li class="facility4 <?php echo e($fleamarket['rainy_location_flag']) ? 'on' : 'off'; ?>">雨天開催会場</li>
          </ul>
        <ul class="detailLink">
          <li><a href="/detail/<?php echo $fleamarket['fleamarket_id'] ?>">詳細情報を見る<i></i></a></li>
        </ul>
        <ul class="rightbutton">
        <?php if($type == 'mylist'): ?>
              <li class="button makeReservation"><a href="/reservation?fleamarket_id=<?php echo $fleamarket['fleamarket_id'] ?>">出店予約をする</a></li>
              <li class="button cancel"><a href="#" class="mylist_remove" id="fleamarket_id_<?php echo $fleamarket['fleamarket_id']; ?>"><i></i>マイリスト解除</a></li>
        <?php elseif($type == 'entry'): ?>
              <li class="button change makeReservation"><a href="/mypage/change?fleamarket_id=<?php echo $fleamarket['fleamarket_id'] ?>"><i></i>予約変更</a></li>
              <li class="button cancel"><a href="/mypage/cancel?fleamarket_id=<?php echo $fleamarket['fleamarket_id'] ?>" class="fleamarket_cancel"><i></i>予約解除</a></li>
        <?php elseif($type == 'myfleamarket'): ?>
              <li class="button makeReservation change"><a href="/fleamarket/<?php echo $fleamarket['fleamarket_id'] ?>"><i></i>内容変更</a></li>
        <?php elseif($type == 'reserved'): ?>
              <li class="button change makeReservation"><a href="/mypage/change?fleamarket_id=<?php echo $fleamarket['fleamarket_id'] ?>"><i></i>予約変更</a></li>
              <li class="button cancel"><a href="/mypage/cancel?fleamarket_id=<?php echo $fleamarket['fleamarket_id'] ?>" class="fleamarket_cancel"><i></i>予約解除</a></li>
        <?php endif; ?>
        </ul>
      </div>
    </div>
    <!-- /result -->
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- result -->
    <div class="box result status2 resultPush clearfix">
      <h3><strong>楽市楽座主催</strong><a href="#">2014年3年8日(土)　東京都　★無料フリマ★チャリティフリーマーケットin太田</a></h3>
      <div class="resultPhoto"><a href="#"><img src="http://dummyimage.com/200x150/ccc/fff.jpg" class="img-rounded"></a></div>
      <div class="resultDetail">
        <dl class="col-md-6">
          <dt>出店数</dt>
          <dd>60店</dd>
        </dl>
        <dl class="col-md-6">
          <dt>開催時間</dt>
          <dd>9時〜14時</dd>
        </dl>
        <dl class="col-md-6">
          <dt>出店形態</dt>
          <dd>車出店車出店車出店車出店車出店車出店車出店</dd>
        </dl>
        <dl class="col-md-6">
          <dt>出店料金</dt>
          <dd>無料無料無料無料無料無料無料無料無料無料</dd>
        </dl>
        <dl class="col-md-11">
          <dt>交通</dt>
          <dd>国分寺駅から京王バス（府中駅行き）藤塚バス停下車</dd>
        </dl>
        <ul class="facilitys">
          <li class="facility1">車出店可能</li>
          <li class="facility2 off">有料駐車場</li>
          <li class="facility3 off">無料駐車場</li>
          <li class="facility4 off">雨天開催会場</li>
        </ul>
        <ul class="detailLink">
          <li><a href="#">詳細情報を見る<i></i></a></li>
        </ul>
        <ul class="rightbutton">
          <li class="button change makeReservation"><a href="#"><i></i>予約変更</a></li>
          <li class="button cancel"><a href="#"><i></i>予約解除</a></li>
        </ul>
      </div>
    </div>
    <!-- /result -->

    <!-- pagination -->
    <?php if ('' != ($pagnation =  $pagination->render())): ?> 
    <?php echo $pagnation; ?>
    <?php else: ?>
    <ul class="pagination">
        <li class="disabled"><a href="javascript:void(0);" rel="prev">«</a></li>
        <li class="active"><a href="javascript:void(0);">1<span class="sr-only"></span></a></li>
        <li class="disabled"><a href="javascript:void(0);" rel="next">»</a></li>
    </ul>
    <?php endif; ?>
    <!-- /pagination -->

  </div>
  <!-- /searchResult -->
</div>
</div>





<script>

$('.fleamarket_cancel').click(function() {
    if (!confirm('フリーマーケットをキャンセルします\nよろしいですか？')) {
    return false;
    }
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
          if(json == 'nologin' || json == 'nodata'){
              alert(json);
          }else if(json){
              alert('削除しました' + id);
              $('#mylist_' + id).remove();
              if ($('#mylist').children('div').length == 0) {
                  $('#mylist').append('<p>マイリストはありません</p>');
              }
          }else{
              alert('失敗しました');
          }
      }).fail(function(jqXHR, textStatus, errorThrown) {
          alert('失敗しました');
      });
  });
});
</script>
