<div id="contentHome" class="row">
  <!-- soon -->
  <div id="soon" class="container">
    <div class="box clearfix">
      <h2><i></i>近日開催のフリーマーケット</h2>
      <?php echo $upcomming;?>
    </div>
  </div>
  <!-- /soon -->
  <!-- map -->
  <div id="map" class="col-sm-7">
    <div class="box">
      <h2><i></i>地図から探す</h2>
      <div class="map">
        <img src="assets/img/map_normal.jpg" alt="地図" width="397" height="255" border="0" usemap="#mapSearch">
        <map name="mapSearch">
          <area shape="rect" coords="299,1,397,65" href="#" id="map_1">
          <area shape="poly" coords="375,76,299,76,299,124,322,124,322,169,375,168" href="#" id="map_2">
          <area shape="poly" coords="376,175,298,175,298,200,314,200,315,238,356,239,357,251,376,251" href="#" id="map_3">
          <area shape="poly" coords="316,131,300,131,300,139,219,139,220,169,240,170,241,211,219,211,218,250,240,250,241,239,308,239,307,208,292,206,292,170,316,169" href="#" id="map_4">
          <area shape="poly" coords="212,139,160,139,160,195,175,195,175,251,212,251,213,205,236,204,236,176,211,176" href="#" id="map_5">
          <area shape="rect" coords="81,138,155,195" href="#" id="map_6">
          <area shape="rect" coords="82,205,166,253" href="#" id="map_7">
          <area shape="poly" coords="71,139,2,139,2,195,19,195,19,251,71,252" href="#" id="map_8">
          <area shape="rect" coords="46,60,102,92" href="#" id="map_9">
        </map>
        <div id="regions">
          <div class="region" id="region_01">
            <div class="inner">
              <h2>北海道地方</h2>
              <ul>
                <li><a href="/search/1?prefecture=hokkaido">北海道</a></li>
              </ul>
            </div>
          </div>
          <div class="region" id="region_02">
            <div class="inner">
              <h2>東北地方</h2>
              <ul>
                <li><a href="/search/1?prefecture=aomori">青森県</a></li>
                <li><a href="/search/1?prefecture=iwate">岩手県</a></li>
                <li><a href="/search/1?prefecture=miyagi">宮城県</a></li>
                <li><a href="/search/1?prefecture=akita">秋田県</a></li>
                <li><a href="/search/1?prefecture=yamagata">山形県</a></li>
                <li><a href="/search/1?prefecture=fukushima">福島県</a></li>
              </ul>
            </div>
          </div>
          <div class="region" id="region_03">
            <div class="inner">
              <h2>関東地方</h2>
              <ul>
                <li><a href="/search/1?prefecture=ibaraki">茨城県</a></li>
                <li><a href="/search/1?prefecture=tochigi">栃木県</a></li>
                <li><a href="/search/1?prefecture=gunma">群馬県</a></li>
                <li><a href="/search/1?prefecture=saitama">埼玉県</a></li>
                <li><a href="/search/1?prefecture=chiba">千葉県</a></li>
                <li><a href="/search/1?prefecture=tokyo">東京都</a></li>
                <li><a href="/search/1?prefecture=kanagawa">神奈川県</a></li>
              </ul>
            </div>
          </div>
          <div class="region" id="region_04">
            <div class="inner">
              <h2>中部地方</h2>
              <ul>
                <li><a href="/search/1?prefecture=niigata">新潟県</a></li>
                <li><a href="/search/1?prefecture=toyama">富山県</a></li>
                <li><a href="/search/1?prefecture=ishikawa">石川県</a></li>
                <li><a href="/search/1?prefecture=fukui">福井県</a></li>
                <li><a href="/search/1?prefecture=yamanashi">山梨県</a></li>
                <li><a href="/search/1?prefecture=nagano">長野県</a></li>
                <li><a href="/search/1?prefecture=gifu">岐阜県</a></li>
                <li><a href="/search/1?prefecture=shizuoka">静岡県</a></li>
                <li><a href="/search/1?prefecture=aichi">愛知県</a></li>
              </ul>
            </div>
          </div>
          <div class="region" id="region_05">
            <div class="inner">
              <h2>関西地方</h2>
              <ul>
                <li><a href="/search/1?prefecture=mie">三重県</a></li>
                <li><a href="/search/1?prefecture=shiga">滋賀県</a></li>
                <li><a href="/search/1?prefecture=kyoto">京都府</a></li>
                <li><a href="/search/1?prefecture=osaka">大阪府</a></li>
                <li><a href="/search/1?prefecture=hyogo">兵庫県</a></li>
                <li><a href="/search/1?prefecture=nara">奈良県</a></li>
                <li><a href="/search/1?prefecture=wakayama">和歌山県</a></li>
              </ul>
            </div>
          </div>
          <div class="region" id="region_06">
            <div class="inner">
              <h2>中国地方</h2>
              <ul>
                <li><a href="/search/1?prefecture=tottori">鳥取県</a></li>
                <li><a href="/search/1?prefecture=shimane">島根県</a></li>
                <li><a href="/search/1?prefecture=okayama">岡山県</a></li>
                <li><a href="/search/1?prefecture=hiroshima">広島県</a></li>
                <li><a href="/search/1?prefecture=yamaguchi">山口県</a></li>
              </ul>
            </div>
          </div>
          <div class="region" id="region_07">
            <div class="inner">
              <h2>四国地方</h2>
              <ul>
                <li><a href="/search/1?prefecture=tokushima">徳島県</a></li>
                <li><a href="/search/1?prefecture=kagawa">香川県</a></li>
                <li><a href="/search/1?prefecture=ehime">愛媛県</a></li>
                <li><a href="/search/1?prefecture=kochi">高知県</a></li>
              </ul>
            </div>
          </div>
          <div class="region" id="region_08">
            <div class="inner">
              <h2>九州地方</h2>
              <ul>
                <li><a href="/search/1?prefecture=fukuoka">福岡県</a></li>
                <li><a href="/search/1?prefecture=saga">佐賀県</a></li>
                <li><a href="/search/1?prefecture=nagasaki">長崎県</a></li>
                <li><a href="/search/1?prefecture=kumamoto">熊本県</a></li>
                <li><a href="/search/1?prefecture=oita">大分県</a></li>
                <li><a href="/search/1?prefecture=miyazaki">宮崎県</a></li>
                <li><a href="/search/1?prefecture=kagoshima">鹿児島県</a></li>
              </ul>
            </div>
          </div>
          <div class="region" id="region_09">
            <div class="inner">
              <h2>沖縄地方</h2>
              <ul>
                <li><a href="/search/1?prefecture=okinawa">沖縄県</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /map -->
  <!-- calendar -->
  <div id="calendar" class="col-sm-5">
    <div class="box">
      <h2><i></i>カレンダーで探す</h2>
      <div id="calendar-search"><?php echo $calendar;?></div>
    </div>
  </div>
  <!-- /calendar -->
  <!-- search -->
  <div id="search" class="container">
    <div class="box">
      <div class="row">
        <form id="form_search_calendar" action="/search/1" method="get">
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
      <div id="newMarket" class="container">
        <?php echo $latest;?>
      </div>
    </div>
  </div>
  <!-- /new -->
  <!-- ranking -->
  <div id="ranking" class="container">
    <div class="box clearfix">
      <h2><i></i>人気開催ランキング</h2>
      <?php echo $popular_ranking;?>
    </div>
  </div>
  <!-- /ranking -->
  <!-- blog -->
  <div id="blog" class="container">
    <div class="box">
      <h2><a href="#" target="_blank"><i></i>楽市楽座ブログ</a></h2>
      <dl class="dl-horizontal">
      <?php foreach ($news_headlines as $headline): ?>
          <dt><?php echo $headline['date'] ?></dt>
          <dd><a href="<?php echo $headline['url'] ?>"><?php echo $headline['title'] ?></a></dd>
      <?php endforeach; ?>
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
</div>
