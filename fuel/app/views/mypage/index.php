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

    <!-- ad -->
    <div class="ad clearfix"> <a href="#"><img src="http://dummyimage.com/220x150/ccc/fff.jpg" class="img-responsive"></a></div>
    <!-- /ad -->
  </div>
  <!-- /mypageProfile -->



  <!-- searchResult -->
  <div id="searchResult" class="col-sm-9">
    <!-- pills -->
    <ul class="nav nav-pills">
      <li><a href="#">これまで参加したフリマ <span class="badge"><?php echo e(Auth::getFinishedEntryCount()); ?>件</span></a></li>
      <li><a href="#">出店予約中のフリマ <span class="badge"><?php echo e(Auth::getReservedEntryCount()); ?>件</span></a></li>
      <li><a href="#">マイリスト <span class="badge"><?php echo e(Auth::getFavoriteCount()); ?>件</span></a></li>
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
                <select class="form-control">
                  <option>エリア</option>
                  <option label="北海道・東北" value="1">北海道・東北</option>
                  <option label="関東" value="2">関東</option>
                  <option label="中部" value="3">中部</option>
                  <option label="近畿" value="4">近畿</option>
                  <option label="中国・四国" value="5">中国・四国</option>
                  <option label="九州・沖縄" value="6">九州・沖縄</option>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control" name="conditions[prefecture]">
                  <option value="">都道府県</option>
                  <?php foreach ($prefectures as $prefecture_id => $name): ?>
                  <option value="<?php echo $prefecture_id;?>"><?php echo $name;?></option>
                  <?php endforeach; ?>
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
      <li><a href="#mylist" data-toggle="tab">マイリスト</a></li>
    </ul>
    <!-- /nav-tabs -->

    <!-- tabGroup -->
    <div class="tabGroup">
      <div class="box clearfix">
        <div id="my-tab-content" class="tab-content">

          <!-- reservation -->
          <div class="tab-pane active" id="reservation">
            <?php if(empty($entries)): ?>
            <p>現在予約しているフリーマーケットがありません。</p>
            <?php else: ?>
            <?php foreach($entries as $entry): ?>
            <!-- result -->
            <div class="result clearfix">
              <h3><a href="/detail/<?php echo $entry['fleamarket_id'] ?>"><?php echo $entry['name'] ?></a></h3>
              <div class="resultPhoto"><a href="#"><img src="http://dummyimage.com/200x150/ccc/fff.jpg" class="img-rounded"></a></div>
              <div class="resultDetail">
                <dl class="col-md-3">
                  <dt>出店数</dt>
                  <dd><?php echo e(@$entry['booth_string']);?></dd>
                </dl>
                <dl class="col-md-3">
                  <dt>開催時間</dt>
                  <dd><?php echo e($entry['event_date']); ?></dd>
                </dl>
                <dl class="col-md-3">
                  <dt>出店形態</dt>
                  <dd><?php echo e($entry['fleamarket_entry_style_name']); ?></dd>
                </dl>
                <dl class="col-md-3">
                  <dt>出店料金</dt>
                  <dd><?php echo e(@$entry['booth_fee_string']); ?></dd>
                </dl>
                <dl class="col-md-11">
                  <dt>交通</dt>
                  <dd><?php echo e($entry['about_access']);?></dd>
                </dl>
                <ul class="facilitys">
                  <li class="facility1 <?php $flagcheck($entry['car_shop_flag']) ?>"      >車出店可能</li>
                  <li class="facility2 <?php $flagcheck($entry['charge_parking_flag']) ?>">有料駐車場</li>
                  <li class="facility3 <?php $flagcheck($entry['free_parking_flag']) ?>"  >無料駐車場</li>
                  <li class="facility4 <?php $flagcheck($entry['rainy_location_flag']) ?>">雨天開催会場</li>
                </ul>
                <ul class="detailLink">
                  <li><a href="/detail/<?php echo $entry['fleamarket_id'] ?>">詳細情報を見る<i></i></a></li>
                </ul>
                <ul class="rightbutton">
                  <li class="button change makeReservation"><a href="/mypage/change?fleamarket_id=<?php echo $entry['fleamarket_id'] ?>"><i></i>予約変更</a></li>
                  <li class="button cancel"><a href="/mypage/cancel?fleamarket_id=<?php echo $entry['fleamarket_id'] ?>" class="fleamarket_cancel"><i></i>予約解除</a></li>
                </form>
              </ul>
            </div>
          </div>
          <?php endforeach; ?>
          <?php endif ?>
        <ul class="more">
          <li><a href="#">続きを見る</a></li>
        </ul>
        </div>

        <!-- mylist -->
        <div class="tab-pane" id="mylist">
          <?php if(empty($mylists)): ?>
          <p>マイリストはありません</p>
          <?php else: ?>
          <?php foreach($mylists as $mylist): ?>
          <!-- result -->
          <div class="result clearfix" id="mylist_<?php echo $mylist['fleamarket_id']; ?>">
            <h3><a href="/detail/<?php echo $mylist['fleamarket_id'] ?>"><?php echo $mylist['name'] ?></a></h3>
            <div class="resultPhoto"><a href="#"><img src="http://dummyimage.com/200x150/ccc/fff.jpg" class="img-rounded"></a></div>
            <div class="resultDetail">
              <dl class="col-md-3">
                <dt>出店数</dt>
                <dd><?php echo e(@$mylist['booth_string']);?></dd>
              </dl>
              <dl class="col-md-3">
                <dt>開催時間</dt>
                <dd><?php echo e($mylist['event_date']); ?></dd>
              </dl>
              <dl class="col-md-3">
                <dt>出店形態</dt>
                <dd><?php echo e($mylist['fleamarket_entry_style_name']); ?></dd>
              </dl>
              <dl class="col-md-3">
                <dt>出店料金</dt>
                <dd><?php echo e(@$mylist['booth_fee_string']); ?></dd>
              </dl>
              <dl class="col-md-11">
                <dt>交通</dt>
                <dd><?php echo e($mylist['about_access']);?></dd>
              </dl>
              <ul class="facilitys">
                <li class="facility1 <?php $flagcheck($mylist['car_shop_flag'])?>"      >車出店可能</li>
                <li class="facility2 <?php $flagcheck($mylist['charge_parking_flag'])?>">有料駐車場</li>
                <li class="facility3 <?php $flagcheck($mylist['free_parking_flag'])?>"  >無料駐車場</li>
                <li class="facility4 <?php $flagcheck($mylist['rainy_location_flag'])?>">雨天開催会場</li>
              </ul>
              <ul class="detailLink">
                <li><a href="/detail/<?php echo $mylist['fleamarket_id'] ?>">詳細情報を見る<i></i></a></li>
              </ul>
              <ul class="rightbutton">
                <li class="button makeReservation"><a href="/reservation?fleamarket_id=<?php echo $mylist['fleamarket_id'] ?>">出店予約をする</a></li>
                <li class="button cancel"><a href="#" class="mylist_remove" id="fleamarket_id_<?php echo $mylist['fleamarket_id']; ?>"><i></i>マイリスト解除</a></li>
              </form>
            </ul>
          </div>
        </div>
        <?php endforeach; ?>
        <?php endif ?>
      <!-- /result -->
      <ul class="more">
        <li><a href="#">続きを見る</a></li>
      </ul>
      </div>


    </div>
  </div>

  <div id="contribution" class="box clearfix">
    <h3>開催投稿したフリマ</h3>

    <?php if(empty($myfleamarkets)): ?>
    <p>開催投稿したフリマはありません</p>
    <?php else: ?>
    <?php foreach($myfleamarkets as $myfleamarket): ?>

    <!-- result -->
    <div class="result clearfix">
      <h3><a href="/detail/<?php echo $myfleamarket['fleamarket_id'] ?>"><?php echo $myfleamarket['name'] ?></a></h3>
      <div class="resultPhoto"><a href="#"><img src="http://dummyimage.com/200x150/ccc/fff.jpg" class="img-rounded"></a></div>
        <div class="resultDetail">
          <dl class="col-md-3">
            <dt>出店数</dt>
            <dd><?php echo e(@$myfleamarket['booth_string']);?></dd>
          </dl>
          <dl class="col-md-3">
            <dt>開催時間</dt>
            <dd><?php echo e($myfleamarket['event_date']); ?></dd>
          </dl>
          <dl class="col-md-3">
            <dt>出店形態</dt>
            <dd><?php echo e($myfleamarket['fleamarket_entry_style_name']); ?></dd>
          </dl>
          <dl class="col-md-3">
            <dt>出店料金</dt>
            <dd><?php echo e(@$myfleamarket['booth_fee_string']); ?></dd>
          </dl>
          <dl class="col-md-11">
            <dt>交通</dt>
            <dd><?php echo e($myfleamarket['about_access']);?></dd>
          </dl>
          <ul class="facilitys">
            <li class="facility1 <?php $flagcheck($myfleamarket['car_shop_flag'])?>"      >車出店可能</li>
            <li class="facility2 <?php $flagcheck($myfleamarket['charge_parking_flag'])?>">有料駐車場</li>
            <li class="facility3 <?php $flagcheck($myfleamarket['free_parking_flag'])?>"  >無料駐車場</li>
            <li class="facility4 <?php $flagcheck($myfleamarket['rainy_location_flag'])?>">雨天開催会場</li>
          </ul>
          <ul class="detailLink">
            <li><a href="/detail/<?php echo $myfleamarket['fleamarket_id'] ?>">詳細情報を見る<i></i></a></li>
          </ul>
        <ul class="rightbutton">
          <li class="button makeReservation change"><a href="/fleamarket/<?php echo $myfleamarket['fleamarket_id'] ?>"><i></i>内容変更</a></li>
        </ul>
      </div>
    </div>
    <!-- /result -->

    <?php endforeach; ?>
    <?php endif ?>

    <ul class="more">
      <li><a href="#">続きを見る</a></li>
    </ul>
  </div>




  <!-- /result -->

  <!-- /contribution -->
</div>
<!-- /searchResult -->
  </div>
</div>
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
