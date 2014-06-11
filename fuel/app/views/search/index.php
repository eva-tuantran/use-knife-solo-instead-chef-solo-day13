<script type='text/javascript'>
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
</script>

<script type='text/javascript'>
googletag.cmd.push(function() {
googletag.defineSlot('/64745063/(楽市楽座)検索結果_フッターバナー_728x90', [auto, 90], 'div-gpt-ad-1397113960029-0').addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>
<div id="contentSearch" class="row">
  <!-- searchResult -->
  <div id="searchResult" class="col-sm-9 col-sm-push-3">
    <?php
        $title = '';
        $titles = array();

        if ($conditions):
            foreach ($conditions as $field => $condition):
                if ($condition == '') {
                    continue;
                }

                switch ($field):
                    case 'prefecture':
                        $titles[0] = $prefectures[$condition];
                        break;
                    case 'region':
                        if (! isset($conditions['prefecture'])):
                            $titles[1] = $regions[$condition];
                        endif;
                        break;
                    case 'calendar':
                        $titles[2] = date('Y年m月d日', strtotime($condition));
                        break;
                    case 'upcomming':
                        $titles[3] = '近日開催';
                        break;
                    case 'reservation':
                        $titles[4] = '出店予約可能';
                        break;
                    case 'keyword':
                        $titles[5] = e($condition);
                        break;
                    case 'shop_fee':
                        $titles[6] = '出店無料';
                        break;
                    case 'car_shop':
                        $titles[7] = '車出店可';
                        break;
                    case 'rainy_location':
                        $titles[8] = '雨天開催会場';
                        break;
                    case 'pro_shop':
                        $titles[9] = 'プロ出店可';
                        break;
                    case 'charge_parking':
                        $titles[10] = '有料駐車場あり';
                        break;
                    case 'free_parking':
                        $titles[11] = '無料駐車場あり';
                        break;
                    default:
                        break;
                endswitch;
            endforeach;
        endif;

        if ($titles):
            ksort($titles);
            $title = implode('/', $titles);
            $title .= 'の';
        endif;
    ?>
    <div id="resultTitle"><?php echo $title;?>フリマ会場一覧</div>
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

            $is_official = false;
            if ($fleamarket['register_type'] == \Model_Fleamarket::REGISTER_TYPE_ADMIN):
                $is_official = true;
            endif;

            $status_class = '';
            $resultPush = '';
            if ($is_official):
                $status_class = 'status' . $fleamarket['event_status'];
                $resultPush = 'resultPush';
            endif;

            $total_booth = 0;
            $entry_style_string = '';
            $shop_fee_string = '';
            if ($fleamarket['entry_styles']):
                foreach ($fleamarket['entry_styles'] as $entry_style):
                    $entry_type_id = $entry_style['entry_style_id'];

                    $total_booth += $entry_style['max_booth'];

                    $entry_style_string .= $entry_style_string != '' ? '/' : '';
                    $entry_style_string .= $entry_styles[$entry_type_id];

                    $shop_fee_string .= $shop_fee_string != '' ? '/' : '';
                    $booth_fee = $entry_style['booth_fee'];
                    if ($booth_fee > 0):
                        $booth_fee = number_format($booth_fee) . '円';
                    else:
                        $booth_fee = '無料';
                    endif;
                    $shop_fee_string .= $booth_fee;
                endforeach;
            endif;
?>
    <div class="box result <?php echo $status_class;?> <?php echo $resultPush;?> clearfix">
      <h3>
        <?php if ($is_official):?>
        <strong><img src="/assets/img/resultPush.png" alt="楽市楽座主催" width="78" height="14"></strong>
        <?php endif;?>
        <a href="/detail/<?php echo e($fleamarket_id);?>">
          <?php echo e(date('Y年n月j日', strtotime($fleamarket['event_date'])));?>(<?php echo $week_list[date('w', strtotime($fleamarket['event_date']))];?>)&nbsp;
          <?php echo e($fleamarket['name']);?>
        </a>
      </h3>
      <div class="resultPhoto">
        <?php
            $full_path = '/assets/img/noimage.jpg';
            if (! empty($fleamarket['file_name'])):
                $full_path = $image_path . $fleamarket_id .'/m_' . $fleamarket['file_name'];

                if (! file_exists('.' . $full_path)):
                    $full_path ='/assets/img/noimage.jpg';
                endif;
            endif;
        ?>
        <a href="/detail/<?php echo e($fleamarket_id);?>">
          <img src="<?php echo $full_path;?>" class="img-rounded" style="width: 200px; height: 150px;">
        </a>
      </div>
      <div class="resultDetail">
        <dl class="col-md-6">
          <dt>出店ブース数</dt>
          <dd><?php
            if ($total_booth > 0):
                echo e($total_booth . 'ブース');
            else:
                echo '-';
            endif;
          ?></dd>
        </dl>
        <dl class="col-md-6">
          <dt>開催時間</dt>
          <dd><?php
            if ($fleamarket['event_time_start'] && $fleamarket['event_time_start'] != '00:00:00'
                && $fleamarket['event_time_end'] && $fleamarket['event_time_end'] != '00:00:00'):
                echo e(substr($fleamarket['event_time_start'], 0, 5)) . '～' . e(substr($fleamarket['event_time_end'], 0, 5));
            else:
                echo '-';
            endif;
          ?></dd>
        </dl>
        <dl class="col-md-6">
          <dt>出店形態</dt>
          <dd><?php
            if ($entry_style_string):
                echo e($entry_style_string);
            else:
                echo '-';
            endif;
          ?></dd>
        </dl>
        <dl class="col-md-6">
          <dt>出店料金</dt>
          <dd><?php
            if ($shop_fee_string):
                echo e($shop_fee_string);
            else:
                echo '-';
            endif;
          ?></dd>
        </dl>
        <dl class="col-md-11">
          <dt>交通</dt>
          <dd><?php
            if (isset($fleamarket['about_access']) && $fleamarket['about_access'] != ''):
                echo nl2br(e($fleamarket['about_access']));
            else:
                echo '-';
            endif;
          ?></dd>
        </dl>
        <ul class="facilitys">
          <li class="facility1 <?php echo $fleamarket['car_shop_flag'] != \Model_Fleamarket::CAR_SHOP_FLAG_NG ? 'on' : 'off';?>">車出店可能</li>
          <li class="facility2 <?php echo $fleamarket['charge_parking_flag'] != \Model_Fleamarket::CHARGE_PARKING_FLAG_NONE ? 'on' : 'off';?>">有料駐車場</li>
          <li class="facility3 <?php echo $fleamarket['free_parking_flag'] != \Model_Fleamarket::FREE_PARKING_FLAG_NONE ? 'on' : 'off';?>">無料駐車場</li>
          <li class="facility4 <?php echo $fleamarket['rainy_location_flag'] != \Model_Fleamarket::RAINY_LOCATION_FLAG_NONE ? 'on' : 'off';?>">雨天開催会場</li>
        </ul>
        <ul class="detailLink">
          <li><a href="/detail/<?php echo $fleamarket_id;?>">詳細情報を見る<i></i></a></li>
        </ul>
        <ul class="rightbutton">
    <?php if ($user && $user->hasReserved($fleamarket_id)):?>
          <li class="button reserved">出店予約中</li>
    <?php elseif ($user && $user->hasWaiting($fleamarket_id, true)):?>
        <?php if (\Model_Fleamarket::isBoothEmpty($fleamarket_id)):?>
          <li class="button makeReservation"><a href="/reservation?fleamarket_id=<?php echo $fleamarket_id;?>">出店予約をする</a></li>
        <?php else:?>
          <li class="button reserved">キャンセル待ち中</li>
        <?php endif;?>
    <?php elseif ($is_official):?>
        <?php if ($fleamarket['event_status'] == \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT):?>
            <?php if ($fleamarket['event_reservation_status'] == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL):?>
          <li class="button makeReservation"><a href="/reservation?fleamarket_id=<?php echo $fleamarket_id;?>">キャンセル待ちをする</a></li>
            <?php else:?>
          <li class="button makeReservation"><a href="/reservation?fleamarket_id=<?php echo $fleamarket_id;?>">出店予約をする</a></li>
            <?php endif;?>
        <?php endif;?>
    <?php endif;?>
          <li class="button addMylist"><a id="fleamarket_id_<?php echo $fleamarket_id; ?>" href="#">マイリストに追加</a></li>
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
  <form id="form_search" action="/search/1" method="get">
    <div id="searchSelecter" class="col-sm-3 col-sm-pull-9">
      <div class="box clearfix">
      <?php
          if ($conditions):
              foreach ($conditions as $field => $value):
                  echo '<input type="hidden" name="c[' . $field . ']" value="' . $value . '">';
              endforeach;
          endif;
      ?>
        <fieldset>
          <h3>ステータス</h3>
          <?php
              $is_checked = isset($add_conditions['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_SCHEDULE, $add_conditions['event_status']);
          ?>
          <label>
            <input type="checkbox" name="ac[event_status][]" value="<?php echo \Model_Fleamarket::EVENT_STATUS_SCHEDULE;?>" <?php echo $is_checked ? 'checked': '';?>>開催予定
          </label>
          <?php
              $is_checked = isset($add_conditions['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT, $add_conditions['event_status']);
          ?>
          <label>
            <input type="checkbox" name="ac[event_status][]" value="<?php echo \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT;?>" <?php echo $is_checked ? 'checked': '';?>>予約受付中
          </label>
          <?php
              $is_checked = isset($add_conditions['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_RECEIPT_END, $add_conditions['event_status']);
          ?>
          <label>
            <input type="checkbox" name="ac[event_status][]" value="<?php echo \Model_Fleamarket::EVENT_STATUS_RECEIPT_END;?>" <?php echo $is_checked ? 'checked': '';?>>受付終了
          </label>
          <?php
              $is_checked = isset($add_conditions['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_CLOSE, $add_conditions['event_status']);
          ?>
          <label>
            <input type="checkbox" name="ac[event_status][]" value="<?php echo \Model_Fleamarket::EVENT_STATUS_CLOSE;?>" <?php echo $is_checked ? 'checked': '';?>>開催終了
          </label>
          <h3>出店形態</h3>
          <?php
              foreach ($entry_styles as $entry_style_id => $entry_style_name):
                  $is_checked = isset($add_conditions['entry_style']) && in_array($entry_style_id, $add_conditions['entry_style']);
          ?>
          <label>
            <input type="checkbox" name="ac[entry_style][]" value="<?php echo $entry_style_id;?>" <?php echo $is_checked ? 'checked': '';?>><?php echo e($entry_style_name);?>
          </label>
          <?php
              endforeach;
          ?>
          <h3>出店料金</h3>
          <?php
              $is_checked = isset($add_conditions['shop_fee']) && in_array(\Model_Fleamarket::SHOP_FEE_FLAG_FREE, $add_conditions['shop_fee']);
          ?>
          <label>
            <input type="checkbox" name="ac[shop_fee][]" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_FREE;?>" <?php echo $is_checked ? 'checked': '';?>>出店無料
          </label>
          <?php
              $is_checked = isset($add_conditions['shop_fee']) && in_array(\Model_Fleamarket::SHOP_FEE_FLAG_CHARGE, $add_conditions['shop_fee']);
          ?>
          <label>
            <input type="checkbox" name="ac[shop_fee][]" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_CHARGE;?>" <?php echo $is_checked ? 'checked': '';?>>出店有料
          </label>
          <div id="searchButton">
            <button id="do_search" type="button" class="btn btn-default">検索</button>
          </div>
        </fieldset>
      </div>
<!--
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
-->
    </div>
  </form>
</div>
<!-- /searchSelecter -->
<!-- ad -->
<div class="ad">
  <!-- (楽市楽座)検索結果_フッターバナー_728x90 -->
  <div id="div-gpt-ad-1397113960029-0" class="ad" style="width: auto; height: 90px;">
  <script type="text/javascript">
  googletag.cmd.push(function() { googletag.display("div-gpt-ad-1397113960029-0"); });
  </script>
  </div>
</div>
<!-- /ad -->
<!-- pagination -->
<?php
    if ('' != ($pagnation =  $pagination->render())):
        echo $pagnation;
    elseif ($fleamarket_list):
?>
<ul class="pagination">
    <li class="disabled"><a href="javascript:void(0);" rel="prev">«</a></li>
    <li class="active"><a href="javascript:void(0);">1<span class="sr-only"></span></a></li>
    <li class="disabled"><a href="javascript:void(0);" rel="next">»</a></li>
</ul>
<?php
    endif;
?>
<!-- /pagination -->
<div id="information-dialog" class="afDialog">
  <p id="message" class="message"></p>
</div>
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

  $(".addMylist a").click(function(evt){
    evt.preventDefault();
    var id = $(this).attr('id');
    id = id.match(/^fleamarket_id_(\d+)/)[1];

    $.ajax({
      type: "post",
      url: '/favorite/add',
      dataType: "json",
      data: {fleamarket_id: id}
    }).done(function(json, textStatus, jqXHR) {
      var message = '';
      if (json == 'nologin' || json == 'nodata') {
        message = 'マイリストに登録するためにはログインが必要です';
      } else if (json) {
        message = 'マイリストに登録しました';
      } else {
        message = 'マイリストに登録できませんでした';
      }
      openDialog(message);
    }).fail(function(jqXHR, textStatus, errorThrown) {
      openDialog('マイリストに登録できませんでした');
    });
  });

  var openDialog = function(message) {
    $("#information-dialog #message").text(message);
    $("#information-dialog").dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $(this).dialog( "close" );
        }
      }
    });
  };
});
</script>
