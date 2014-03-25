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
      <li><a href="#">これまで参加したフリマ <span class="badge">42件</span></a></li>
      <li><a href="#">出店予約中のフリマ <span class="badge">5件</span></a></li>
      <li><a href="#">マイリスト <span class="badge">5件</span></a></li>
    </ul>
    <!-- /pills -->
    <!-- search -->
    <div id="search" class="box clearfix">
      <div class="row">
        <form>
          <fieldset>
            <div id="searchInput" class="col-md-7">
              <div class="form-group">
                <input type="text" class="form-control" id="keywordInput" placeholder="キーワードを入力">
              </div>
              <div id="searchCheckbox">
                <label>
                  <input type="checkbox">
                  出店者無料 </label>
                <label>
                  <input type="checkbox">
                  車出店無料 </label>
                <label>
                  <input type="checkbox">
                  雨天開催会場 </label>
                <label>
                  <input type="checkbox">
                  プロ出店可 </label>
                <label>
                  <input type="checkbox">
                  有料駐車場あり </label>
                <label>
                  <input type="checkbox">
                  無料駐車場あり </label>
              </div>
            </div>
            <div id="searchSelect" class="col-md-3">
              <div class="form-group">
                <select class="form-control">
                  <option>都道府県</option>
                  <option label="北海道" value="1">北海道</option>
                  <option label="青森県" value="2">青森県</option>
                  <option label="岩手県" value="3">岩手県</option>
                  <option label="宮城県" value="4">宮城県</option>
                  <option label="秋田県" value="5">秋田県</option>
                  <option label="山形県" value="6">山形県</option>
                  <option label="福島県" value="7">福島県</option>
                  <option label="茨城県" value="8">茨城県</option>
                  <option label="栃木県" value="9">栃木県</option>
                  <option label="群馬県" value="10">群馬県</option>
                  <option label="埼玉県" value="11">埼玉県</option>
                  <option label="千葉県" value="12">千葉県</option>
                  <option label="東京都" value="13">東京都</option>
                  <option label="神奈川県" value="14">神奈川県</option>
                  <option label="新潟県" value="15">新潟県</option>
                  <option label="富山県" value="16">富山県</option>
                  <option label="石川県" value="17">石川県</option>
                  <option label="福井県" value="18">福井県</option>
                  <option label="山梨県" value="19">山梨県</option>
                  <option label="長野県" value="20">長野県</option>
                  <option label="岐阜県" value="21">岐阜県</option>
                  <option label="静岡県" value="22">静岡県</option>
                  <option label="愛知県" value="23">愛知県</option>
                  <option label="三重県" value="24">三重県</option>
                  <option label="滋賀県" value="25">滋賀県</option>
                  <option label="京都府" value="26">京都府</option>
                  <option label="大阪府" value="27">大阪府</option>
                  <option label="兵庫県" value="28">兵庫県</option>
                  <option label="奈良県" value="29">奈良県</option>
                  <option label="和歌山県" value="30">和歌山県</option>
                  <option label="鳥取県" value="31">鳥取県</option>
                  <option label="島根県" value="32">島根県</option>
                  <option label="岡山県" value="33">岡山県</option>
                  <option label="広島県" value="34">広島県</option>
                  <option label="山口県" value="35">山口県</option>
                  <option label="徳島県" value="36">徳島県</option>
                  <option label="香川県" value="37">香川県</option>
                  <option label="愛媛県" value="38">愛媛県</option>
                  <option label="高知県" value="39">高知県</option>
                  <option label="福岡県" value="40">福岡県</option>
                  <option label="佐賀県" value="41">佐賀県</option>
                  <option label="長崎県" value="42">長崎県</option>
                  <option label="熊本県" value="43">熊本県</option>
                  <option label="大分県" value="44">大分県</option>
                  <option label="宮崎県" value="45">宮崎県</option>
                  <option label="鹿児島県" value="46">鹿児島県</option>
                  <option label="沖縄県" value="47">沖縄県</option>
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
                          <dd><?php echo e(@$entry['fee_string']); ?></dd>
                        </dl>
                        <dl class="col-md-11">
                          <dt>交通</dt>
                          <dd><?php echo e($entry['about_access']);?></dd>
                        </dl>
                        <ul class="facilitys">
                          <li class="facility1 <?php echo $entry['car_shop_flag'] == \Model_Fleamarket::CAR_SHOP_FLAG_NG ? 'invalid': '';?>">車出店可能</li>
                          <li class="facility2 <?php echo $entry['charge_parking_flag'] == \Model_Fleamarket::CHARGE_PARKING_FLAG_NONE ? 'invalid': '';?>">有料駐車場</li>
                          <li class="facility3 <?php echo $entry['free_parking_flag'] == \Model_Fleamarket::FREE_PARKING_FLAG_NONE ? 'invalid': '';?>">無料駐車場</li>
                          <li class="facility4 <?php echo $entry['rainy_location_flag'] == \Model_Fleamarket::RAINY_LOCATION_FLAG_NONE ? 'invalid': '';?>">雨天開催会場</li>
                        </ul>
                        <ul class="detailLink">
                          <li><a href="/detail/<?php echo $entry['fleamarket_id'] ?>">詳細情報を見る<i></i></a></li>
                        </ul>
                        <ul class="rightbutton">
                          <li class="button change makeReservation"><a href="#"><i></i>予約変更</a></li>
                          <form action="/mypage/cancel" accept-charset="utf8" method="post">
                            <input type="hidden" name="fleamarket_id" value="<?php echo $entry['fleamarket_id'] ?>" />
                            <li class="button cancel"><input type="submit" name="submit"><a href="#"><i></i>予約解除</a></li>
                          </form>
                        </ul>
                      </div>
                    </div>
                    <!-- /result -->
                <?php endforeach; ?>
            <?php endif ?>

          </div>
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
</script>
