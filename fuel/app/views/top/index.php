<div id="contentHome" class="row">
<!-- soon -->
<div id="soon" class="container">
  <div class="box clearfix">
    <h2>近日開催</h2>
    <dl class="dl-horizontal">
      <dt>2014年04月05日(水)</dt>
      <dd><a href="#">テキストテキストテキストテキストテキストテキストテキストテキスト</a></dd>
    </dl>
    <ul>
      <li><a href="#">一覧</a></li>
    </ul>
  </div>
</div>
<!-- /soon -->
<!-- map -->
<div id="map" class="col-sm-7">
  <div class="box">
    <h2>地図から探す</h2>
    <div class="map"> <img src="assets/img/map.jpg" alt="地図" width="397" height="255" border="0" class="img-responsive"> </div>
  </div>
</div>
<!-- /map -->
<!-- calendar -->
<div id="calendar" class="col-sm-5">
  <div class="box">
    <h2>カレンダーで探す</h2>
    <div id="calendar-search"></div>
  </div>
</div>
<!-- /calendar -->
<!-- search -->
<div id="search" class="container">
  <div class="box">
    <div class="row">
      <form id="form_search_calendar" action="/search/1/" method="get">
        <fieldset>
          <div id="searchTitle" class="col-md-2">
            <h2><i></i>条件で探す</h2>
          </div>
          <div id="searchInput" class="col-md-5">
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
                <input id="form_pro_shop" type="checkbox" name="conditions[pro_shop]" value="<?php echo \Model_Fleamarket::PRO_SHOP_FLAG_OK;?>">プロ出店可
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
                <?php
                  foreach ($prefectures as $prefecture_id => $name):
                ?>
                  <option value="<?php echo $prefecture_id;?>"><?php echo $name;?></option>
                <?php
                  endforeach;
                ?>
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
</div>
<!-- /search -->
<!-- new -->
<div id="new" class="container">
  <div class="box clearfix">
    <h2><i></i>最新のフリマ</h2>
    <ul id="scrollControl">
      <li id="prev">Prev</li>
      <li id="next">Next</li>
    </ul>
    <div id="newMarket" class="container"></div>
  </div>
</div>
<!-- /new -->
<!-- ranking -->
<div id="ranking" class="container">
  <div class="box clearfix">
    <h2><i></i>人気開催ランキング</h2>
    <!-- rank1 -->
    <div class="rank1 clearfix"><i class="rankicon"></i>
      <div class="rankPhoto"><a href="#"><img src="http://dummyimage.com/150x110/ccc/fff.jpg"></a></div>
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
      <div class="rankPhoto"><a href="#"><img src="http://dummyimage.com/150x110/ccc/fff.jpg"></a></div>
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
      <div class="rankPhoto"><a href="#"><img src="http://dummyimage.com/150x110/ccc/fff.jpg"></a></div>
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
</div>
<!-- /ranking -->
<!-- blog -->
<div id="blog" class="container">
  <div class="box">
    <h2><a href="#" target="_blank"><i></i>楽市楽座ブログ</a></h2>
    <dl class="dl-horizontal">
      <dt>2014年04月05日(水)</dt>
      <dd><a href="#">テキストテキストテキストテキストテキスト</a></dd>
      <dt>2014年04月05日(水)</dt>
      <dd><a href="#">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</a></dd>
      <dt>2014年04月05日(水)</dt>
      <dd><a href="#">テキストテキストテキストテキストテキスト</a></dd>
      <dt>2014年04月05日(水)</dt>
      <dd><a href="#">テキストテキストテキストテキストテキスト</a></dd>
      <dt>2014年04月05日(水)</dt>
      <dd><a href="#">テキストテキストテキストテキストテキスト</a></dd>
    </dl>
  </div>
</div>
<!-- /blog -->
<!-- twitter -->
<div id="twitter" class="col-sm-6">
  <div class="box">
    <h2><a href="https://twitter.com/rakuichirakuza_" target="_blank">Twitter</a></h2>
    <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/rakuichirakuza_" data-widget-id="446250651970842624" data-chrome="noheader nofooter noborders noscrollbar transparent">@rakuichirakuza_</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
  </div>
</div>
<!-- twitter -->
<!-- facebook -->
<div id="facebook" class="col-sm-6">
  <div class="box">
    <h2><a href="https://www.facebook.com/rakuichirakuza" target="_blank">Facebook</a></h2>
    <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Frakuichirakuza&amp;width&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden;width:100%; height:300px;" allowTransparency="true"></iframe>
  </div>
</div>
<!-- /facebook -->

<hr>
<script type="text/javascript">
$(function() {
  Calendar.get();
  Carousel.get();
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
      Calendar.init();
    }).fail(function(jqXHR, textStatus, errorThrown) {
    }).always(function() {
    });
  }
};

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
</div>