<div id="contentMypage" class="row">
  <!-- mypageProfile -->
  <div id="mypageProfile" class="col-sm-3">
    <div class="box clearfix">
      <h3>2014年3月</h3>
      <img src="http://dummyimage.com/170x170/ccc/fff.jpg" class="img-responsive">
      <?php echo Auth::get_screen_name(); ?> さん
      <ul>
        <li>フリマ登録情報</li>
        <li><a href="/mypage/account">アカウント設定</a></li>
        <li><a href="/login/out">ログアウト</a></li>
      </ul>
    </div>
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
                <select class="form-control" name="conditions[prefecture]">
                  <option value="">都道府県</option>
                  <?php foreach ($prefectures as $prefecture_id => $name): ?>
                  <option value="<?php echo $prefecture_id;?>"><?php echo $name;?></option>
                  <?php endforeach; ?>
                </select>

              </div>
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
      <li><a href="#check" data-toggle="tab">最近チェックしたフリマ</a></li>
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
              <!-- market -->
              <div class="market clearfix">
                <div class="marketPhoto"><a href="#"><img src="http://dummyimage.com/180x110/ccc/fff.jpg" class="img-rounded"></a></div>
                <p class="date">12月24日(土)</p>
                <h3><a href="#">○○フリーマーケット</a></h3>
                <p class="place">大井競馬場</p>
              </div>
              <!-- /market -->
              <div class="market clearfix">
                <div class="marketPhoto"><a href="#"><img src="http://dummyimage.com/180x110/ccc/fff.jpg" class="img-rounded"></a></div>
                <p class="date">12月24日(土)</p>
                <h3><a href="#">○○フリーマーケット</a></h3>
                <p class="place">大井競馬場</p>
              </div>
              <!-- /market -->
              <div class="market clearfix">
                <div class="marketPhoto"><a href="#"><img src="http://dummyimage.com/180x110/ccc/fff.jpg" class="img-rounded"></a></div>
                <p class="date">12月24日(土)</p>
                <h3><a href="#">○○フリーマーケット</a></h3>
                <p class="place">大井競馬場</p>
              </div>
              <!-- /market -->
              <div class="market clearfix">
                <div class="marketPhoto"><a href="#"><img src="http://dummyimage.com/180x110/ccc/fff.jpg" class="img-rounded"></a></div>
                <p class="date">12月24日(土)</p>
                <h3><a href="#">○○フリーマーケット</a></h3>
                <p class="place">大井競馬場</p>
              </div>
              <!-- /market -->
              <div class="market clearfix">
                <div class="marketPhoto"><a href="#"><img src="http://dummyimage.com/180x110/ccc/fff.jpg" class="img-rounded"></a></div>
                <p class="date">12月24日(土)</p>
                <h3><a href="#">○○フリーマーケット</a></h3>
                <p class="place">大井競馬場</p>
              </div>
              <!-- /market -->
            </div>
          </div>
          <!-- /latest -->
          <!-- ranking -->
          <div class="tab-pane" id="ranking"> <!-- rank1 -->
            <div class="rank1 clearfix"><i class="rankicon"></i>
              <div class="rankPhoto"><a href="#"><img src="http://dummyimage.com/150x110/ccc/fff.jpg" class="img-rounded"></a></div>
              <h3><a href="#">タイトルタイトルタイトルタイトルタイトルタイトル</a></h3>
              <dl class="col-md-2">
                <dt>開催日</dt>
                <dd>12月24日(土)</dd>
              </dl>
              <dl class="col-md-2">
                <dt>出店形態</dt>
                <dd>車出店</dd>
              </dl>
              <dl class="col-md-2">
                <dt>開催時間</dt>
                <dd>9時〜14時</dd>
              </dl>
              <dl class="col-md-2">
                <dt>出店料金</dt>
                <dd>無料</dd>
              </dl>
              <dl class="col-md-9">
                <dt>交通</dt>
                <dd>国分寺駅から京王バス（府中駅行き）藤塚バス停下車</dd>
              </dl>
              <ul>
                <li><a href="#">詳細情報を見る<i></i></a></li>
              </ul>
            </div>
            <!-- /rank1 -->
            <!-- rank2 -->
            <div class="rank2 clearfix"><i class="rankicon"></i>
              <div class="rankPhoto"><a href="#"><img src="http://dummyimage.com/150x110/ccc/fff.jpg" class="img-rounded"></a></div>
              <h3><a href="#">タイトルタイトルタイトルタイトルタイトルタイトル</a></h3>
              <dl class="col-md-2">
                <dt>開催日</dt>
                <dd>12月24日(土)</dd>
              </dl>
              <dl class="col-md-2">
                <dt>出店形態</dt>
                <dd>車出店</dd>
              </dl>
              <dl class="col-md-2">
                <dt>開催時間</dt>
                <dd>9時〜14時</dd>
              </dl>
              <dl class="col-md-2">
                <dt>出店料金</dt>
                <dd>無料</dd>
              </dl>
              <dl class="col-md-9">
                <dt>交通</dt>
                <dd>国分寺駅から京王バス（府中駅行き）藤塚バス停下車</dd>
              </dl>
              <ul>
                <li><a href="#">詳細情報を見る<i></i></a></li>
              </ul>
            </div>
            <!-- /rank2 -->
            <!-- rank3 -->
            <div class="rank3 clearfix"><i class="rankicon"></i>
              <div class="rankPhoto"><a href="#"><img src="http://dummyimage.com/150x110/ccc/fff.jpg" class="img-rounded"></a></div>
              <h3><a href="#">タイトルタイトルタイトルタイトルタイトルタイトル</a></h3>
              <dl class="col-md-2">
                <dt>開催日</dt>
                <dd>12月24日(土)</dd>
              </dl>
              <dl class="col-md-2">
                <dt>出店形態</dt>
                <dd>車出店</dd>
              </dl>
              <dl class="col-md-2">
                <dt>開催時間</dt>
                <dd>9時〜14時</dd>
              </dl>
              <dl class="col-md-2">
                <dt>出店料金</dt>
                <dd>無料</dd>
              </dl>
              <dl class="col-md-9">
                <dt>交通</dt>
                <dd>国分寺駅から京王バス（府中駅行き）藤塚バス停下車</dd>
              </dl>
              <ul>
                <li><a href="#">詳細情報を見る<i></i></a></li>
              </ul>
            </div>
            <!-- /rank3 -->
          </div>
          <!-- /ranking -->
          <!-- check -->
          <div class="tab-pane" id="check">
            <!-- result -->
            <div class="result clearfix">
              <h3><a href="#">2014年3年8日(土)　東京都　★無料フリマ★チャリティフリーマーケットin太田</a></h3>
              <div class="resultPhoto"><a href="#"><img src="http://dummyimage.com/200x150/ccc/fff.jpg" class="img-rounded"></a></div>
              <div class="resultDetail">
                <dl class="col-md-3">
                  <dt>出店数</dt>
                  <dd>60店</dd>
                </dl>
                <dl class="col-md-3">
                  <dt>開催時間</dt>
                  <dd>9時〜14時</dd>
                </dl>
                <dl class="col-md-3">
                  <dt>出店形態</dt>
                  <dd>車出店</dd>
                </dl>
                <dl class="col-md-3">
                  <dt>出店料金</dt>
                  <dd>無料</dd>
                </dl>
                <dl class="col-md-11">
                  <dt>交通</dt>
                  <dd>国分寺駅から京王バス（府中駅行き）藤塚バス停下車</dd>
                </dl>
                <ul class="facilitys">
                  <li class="facility1">車出店可能</li>
                  <li class="facility2">有料駐車場</li>
                  <li class="facility3">無料駐車場</li>
                  <li class="facility4">雨天開催会場</li>
                </ul>
                <ul class="detailLink">
                  <li><a href="#">詳細情報を見る<i></i></a></li>
                </ul>
                <ul class="rightbutton">
                  <li class="button makeReservation"><a href="#"><i></i>出店予約をする</a></li>
                </ul>
              </div>
            </div>
            <!-- /result -->
            <!-- result -->
            <div class="result clearfix">
              <h3><a href="#">2014年3年8日(土)　東京都　★無料フリマ★チャリティフリーマーケットin太田</a></h3>
              <div class="resultPhoto"><a href="#"><img src="http://dummyimage.com/200x150/ccc/fff.jpg" class="img-rounded"></a></div>
              <div class="resultDetail">
                <dl class="col-md-3">
                  <dt>出店数</dt>
                  <dd>60店</dd>
                </dl>
                <dl class="col-md-3">
                  <dt>開催時間</dt>
                  <dd>9時〜14時</dd>
                </dl>
                <dl class="col-md-3">
                  <dt>出店形態</dt>
                  <dd>車出店</dd>
                </dl>
                <dl class="col-md-3">
                  <dt>出店料金</dt>
                  <dd>無料</dd>
                </dl>
                <dl class="col-md-11">
                  <dt>交通</dt>
                  <dd>国分寺駅から京王バス（府中駅行き）藤塚バス停下車</dd>
                </dl>
                <ul class="facilitys">
                  <li class="facility1">車出店可能</li>
                  <li class="facility2">有料駐車場</li>
                  <li class="facility3">無料駐車場</li>
                  <li class="facility4">雨天開催会場</li>
                </ul>
                <ul class="detailLink">
                  <li><a href="#">詳細情報を見る<i></i></a></li>
                </ul>
                <ul class="rightbutton">
                  <li class="button makeReservation"><a href="#"><i></i>出店予約をする</a></li>
                </ul>
              </div>
            </div>
            <!-- /result -->
          </div>
          <!-- /check -->
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
                  <li class="facility1 <?php echo $entry['car_shop_flag'] == \Model_Fleamarket::CAR_SHOP_FLAG_NG ? 'off': '';?>">車出店可能</li>
                  <li class="facility2 <?php echo $entry['charge_parking_flag'] == \Model_Fleamarket::CHARGE_PARKING_FLAG_NONE ? 'off': '';?>">有料駐車場</li>
                  <li class="facility3 <?php echo $entry['free_parking_flag'] == \Model_Fleamarket::FREE_PARKING_FLAG_NONE ? 'off': '';?>">無料駐車場</li>
                  <li class="facility4 <?php echo $entry['rainy_location_flag'] == \Model_Fleamarket::RAINY_LOCATION_FLAG_NONE ? 'off': '';?>">雨天開催会場</li>
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
        </div>

          <!-- mylist -->
          <div class="tab-pane" id="mylist">
            <?php if(empty($mylists)): ?>
            <p>マイリストはありません</p>
            <?php else: ?>
            <?php foreach($mylists as $mylist): ?>
            <!-- result -->
            <div class="result clearfix">
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
                  <li class="facility1 <?php echo $mylist['car_shop_flag'] == \Model_Fleamarket::CAR_SHOP_FLAG_NG ? 'off': '';?>">車出店可能</li>
                  <li class="facility2 <?php echo $mylist['charge_parking_flag'] == \Model_Fleamarket::CHARGE_PARKING_FLAG_NONE ? 'off': '';?>">有料駐車場</li>
                  <li class="facility3 <?php echo $mylist['free_parking_flag'] == \Model_Fleamarket::FREE_PARKING_FLAG_NONE ? 'off': '';?>">無料駐車場</li>
                  <li class="facility4 <?php echo $mylist['rainy_location_flag'] == \Model_Fleamarket::RAINY_LOCATION_FLAG_NONE ? 'off': '';?>">雨天開催会場</li>
                </ul>
                <ul class="detailLink">
                  <li><a href="/detail/<?php echo $mylist['fleamarket_id'] ?>">詳細情報を見る<i></i></a></li>
                </ul>
                <ul class="rightbutton">
                  <li class="button makeReservation"><a href="/reservation?fleamarket_id=<?php echo $mylist['fleamarket_id'] ?>">出店予約をする</a></li>
                  <li class="button cancel"><a href="#" class="fleamarket_cancel"><i></i>マイリスト解除(未実装)</a></li>
                </form>
              </ul>
            </div>
          </div>
          <?php endforeach; ?>
          <?php endif ?>
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
$(function() {
    $(window).resize(function() {
      $("#newMarket").carouFredSel({
prev:{button:"#prev",key:"left"},
next:{button:"#next",key:"right"}
});});
    $(window).resize();
    });



$('.fleamarket_cancel').click(function() {
    if (!confirm('フリーマーケットをキャンセルします\nよろしいですか？')) {
    return false;
    }
    });



$(function() {
    Carousel.get();
    });
var Carousel = {
get: function() {
       $.ajax({
type: "get",
url: "/fleamarket/latest/",
dataType: "html"
}).done(function(html, textStatus, jqXHR) {
  $("#newMarket").empty();
  $("#newMarket").html(html);
  Carousel.start();
  }).fail(function(jqXHR, textStatus, errorThrown) {
    }).always(function() {
      });
},
start: function () {
         $("#newMarket").carouFredSel({
align: true,
scroll:{
items: 1,
duration: 300,
pauseDuration: 5000,
easing: 'linear',
pauseOnHover: 'immediate'
},
prev:{button: "#prev", key: "left"},
next:{button: "#next", key:"right"}
});
}
};
</script>

