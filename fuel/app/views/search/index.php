<div id="contentSearch" class="row">
  <!-- searchResult -->
  <div id="searchResult" class="col-sm-9 col-sm-push-3">
    <div id="resultTitle"><?php echo 'なにを表示？';?>◯◯◯◯◯◯のフリマ情報一覧</div>
    <!-- result -->
<?php
    if (! $fleamarket_list):
?>
    <div class="box result clearfix">
      <h3><strong>条件に一致するフリーマーケットはありませんでした</strong></h3>
    </div>
<?php
    else:
        foreach ($fleamarket_list as $fleamarket):
            $fleamarket_id = $fleamarket['fleamarket_id'];
?>
    <div class="box result clearfix">
      <h3><?php if ($fleamarket['register_type'] == \Model_Fleamarket::REGISTER_TYPE_ADMIN):?><strong>楽市楽座主催</strong>&nbsp;<?php endif;?><a href="#"><?php echo e($fleamarket['event_date']);?>&nbsp;<?php echo e($fleamarket['name']);?></a></h3>
      <div class="resultPhoto"><a href="#"><img src="http://dummyimage.com/200x150/ccc/fff.jpg" class="img-rounded"></a></div>
      <div class="resultDetail">
        <dl class="col-md-3">
          <dt>出店数</dt>
          <dd><?php echo e($fleamarket['booth_string']);?></dd>
        </dl>
        <dl class="col-md-3">
          <dt>開催時間</dt>
          <dd><?php
            echo e($fleamarket['event_time_start']);
            if ($fleamarket['event_time_end'] != ''):
                echo '～' . $fleamarket['event_time_end'];
            endif;
          ?></dd>
        </dl>
        <dl class="col-md-3">
          <dt>出店形態</dt>
          <dd><?php echo e($fleamarket['style_string']);?></dd>
        </dl>
        <dl class="col-md-3">
          <dt>出店料金</dt>
          <dd><?php echo e($fleamarket['fee_string']); ?></dd>
        </dl>
        <dl class="col-md-11">
          <dt>交通</dt>
          <dd><?php echo e(@$fleamarket['about_access']);?></dd>
        </dl>
        <ul class="facilitys">
          <li class="<?php echo $fleamarket['car_shop_flag'] == \Model_Fleamarket::CAR_SHOP_FLAG_NG ?: 'facility1';?>">車出店可能</li>
          <li class="<?php echo $fleamarket['charge_parking_flag'] == \Model_Fleamarket::CHARGE_PARKING_FLAG_NONE ?: 'facility2';?>">有料駐車場</li>
          <li class="<?php echo $fleamarket['free_parking_flag'] == \Model_Fleamarket::FREE_PARKING_FLAG_NONE ?: 'facility3';?>">無料駐車場</li>
          <li class="<?php echo $fleamarket['rainy_location_flag'] == \Model_Fleamarket::RAINY_LOCATION_FLAG_NONE ?: 'facility4';?>">雨天開催会場</li>
        </ul>
        <ul class="detailLink">
          <li><a href="/detail/<?php echo $fleamarket['fleamarket_id'];?>">詳細情報を見る</a></li>
        </ul>
        <ul class="rightbutton">
          <li class="button makeReservation"><a href="#">出店予約をする</a></li>
          <li class="button addMylist"><a href="#">マイリストに追加</a></li>
        </ul>
      </div>
    </div>
    <!-- /result -->
<?php
        endforeach;
    endif;
?>
  </div>
  <!-- /searchResult -->
  <!-- searchSelecter -->
  <form id="form_search" action="/search/index/1/" method="post">
    <div id="searchSelecter" class="col-sm-3 col-sm-pull-9">
      <div class="box clearfix">
      <?php
          if (is_array($base_conditions) && count($base_conditions) > 0):
              foreach ($base_conditions as $field => $value):
                  echo Form::hidden('conditions[' . $field . ']', $value);
              endforeach;
          endif;
      ?>
        <fieldset>
          <h3>ステータス</h3>
          <?php
              $is_checked = isset($add_conditions['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_SCHEDULE, $add_conditions['event_status']);
          ?>
          <label>
            <input type="checkbox" name="add_conditions[event_status][]" value="<?php echo \Model_Fleamarket::EVENT_STATUS_SCHEDULE;?>" <?php echo $is_checked ? 'checked': '';?>>開催予定
          </label>
          <?php
              $is_checked = isset($add_conditions['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT, $add_conditions['event_status']);
          ?>
          <label>
            <input type="checkbox" name="add_conditions[event_status][]" value="<?php echo \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT;?>" <?php echo $is_checked ? 'checked': '';?>>予約受付中
          </label>
          <?php
              $is_checked = isset($add_conditions['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_RECEIPT_END, $add_conditions['event_status']);
          ?>
          <label>
            <input type="checkbox" name="add_conditions[event_status][]" value="<?php echo \Model_Fleamarket::EVENT_STATUS_RECEIPT_END;?>" <?php echo $is_checked ? 'checked': '';?>>受付終了
          </label>
          <?php
              $is_checked = isset($add_conditions['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_CLOSE, $add_conditions['event_status']);
          ?>
          <label>
            <input type="checkbox" name="add_conditions[event_status][]" value="<?php echo \Model_Fleamarket::EVENT_STATUS_CLOSE;?>" <?php echo $is_checked ? 'checked': '';?>>開催終了
          </label>
          <h3>出店形態</h3>
          <?php
              foreach ($entry_styles as $entry_style_id => $entry_style_name):
                  $is_checked = isset($add_conditions['entry_style']) && in_array($entry_style_id, $add_conditions['entry_style']);
          ?>
          <label>
            <input type="checkbox" name="add_conditions[entry_style][]" value="<?php echo $entry_style_id;?>" <?php echo $is_checked ? 'checked': '';?>><?php echo e($entry_style_name);?>
          </label>
          <?php
              endforeach;
          ?>
          <h3>出店料金</h3>
          <?php
              $is_checked = isset($add_conditions['shop_fee']) && in_array(\Model_Fleamarket::SHOP_FEE_FLAG_FREE, $add_conditions['shop_fee']);
          ?>
          <label>
            <input type="checkbox" name="add_conditions[shop_fee][]" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_FREE;?>" <?php echo $is_checked ? 'checked': '';?>>無料出店
          </label>
          <?php
              $is_checked = isset($add_conditions['shop_fee']) && in_array(\Model_Fleamarket::SHOP_FEE_FLAG_CHARGE, $add_conditions['shop_fee']);
          ?>
          <label>
            <input type="checkbox" name="add_conditions[shop_fee][]" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_CHARGE;?>" <?php echo $is_checked ? 'checked': '';?>>有料出店
          </label>
          <div id="searchButton">
            <button id="do_search" type="button" class="btn btn-default">検索</button>
          </div>
        </fieldset>
      </div>
      <div class="box clearfix">
        <dl>
          <dt>期間から選択</dt>
          <dd><a href="#">7日以内</a></dd>
          <dd><a href="#">15日以内</a></dd>
          <dd><a href="#">1ヶ月以内</a></dd>
          <dd><a href="#">3ヶ月以内</a></dd>
        </dl>
        <dl>
          <dt>月別から絞り込み</dt>
          <dd><a href="#">当月</a></dd>
          <dd><a href="#">翌月</a></dd>
          <dd><a href="#">翌々月</a></dd>
        </dl>
        <dl>
          <dt>出店料金から絞り込み</dt>
          <dd><a href="#">当月</a></dd>
          <dd><a href="#">翌月</a></dd>
          <dd><a href="#">翌々月</a></dd>
        </dl>
        <dl>
          <dt>都道府県から絞り込み</dt>
          <dd><a href="#">全国</a></dd>
          <dd><a href="#">北海道・東北</a></dd>
          <dd><a href="#">関東</a></dd>
          <dd><a href="#">中部</a></dd>
          <dd><a href="#">近畿</a></dd>
          <dd><a href="#">中国・四国</a></dd>
          <dd><a href="#">九州・沖縄</a></dd>
        </dl>
        <dl>
          <dt>主催者から絞り込み</dt>
          <dd><a href="#">楽市楽座主催</a></dd>
          <dd><a href="#">その他主催</a></dd>
        </dl>
      </div>
    </div>
  </form>
</div>
<!-- /searchSelecter -->
<!-- ad -->
<div class="ad"><img src="/assets/img/ad/test.jpg" alt="test" width="970" height="150" class="img-responsive"></div>
<!-- /ad -->
<!-- pagination -->
<?php echo $pagination->render();?>
<!-- /pagination -->
<script type="text/javascript">
$(function() {
  $(".pagination li").on("click", function(evt) {
      evt.preventDefault();
      var href = $(this).find("a").attr("href");
      $("#form_search").attr("action", href).submit();
  });

  $("#do_search").on("click", function(evt) {
      evt.preventDefault();
      $("#form_search").submit();
  });

  $(".addMylist a").click(function(){
      $.ajax({
          type: "post",
          url: '/favorite/add',
          dataType: "json"
      }).done(function(json, textStatus, jqXHR) {
          alert(json);
      }).fail(function(jqXHR, textStatus, errorThrown) {
      }).always(function() {
      });
  });
});
</script>
