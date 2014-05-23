<!-- result -->
<?php
    $fleamarket_id = $fleamarket['fleamarket_id'];

    $box = '';
    $status = '';
    $official = '';
    if (empty($no_box)):
        $box = 'box';
        if ($is_official):
            $status = $render_status;
            $official = 'resultPush';
        endif;
    endif;

    $box_style = $box . ' ' . $status . ' ' . $official;
?>
  <div class="<?php echo $box_style;?> result clearfix">
    <h3>
      <?php if ($is_official): ?>
        <strong><img src="/assets/img/resultPush.png" alt="楽市楽座主催" width="78" height="14"></strong>
      <?php endif; ?>
      <a href="/detail/<?php echo e($fleamarket_id);?>">
        <?php echo e(date('Y年n月j日', strtotime($fleamarket['event_date'])));?>(<?php echo $week_list[date('w', strtotime($fleamarket['event_date']))];?>)&nbsp;
        <?php echo e($fleamarket['name']);?>
      </a>
  </h3>
  <div class="resultPhoto">
    <?php
        $image_path = '/assets/img/noimage.jpg';
        if (isset($fleamarket['file_name']) && $fleamarket['file_name'] != ''):
            $image_path = '/files/fleamarket/img/m_' . $fleamarket['file_name'];

            if (! file_exists('.' . $image_path)):
                $image_path ='/assets/img/noimage.jpg';
            endif;
        endif;
    ?>
    <a href="/detail/<?php echo e($fleamarket_id);?>">
      <img src="<?php echo $image_path;?>" class="img-rounded" style="width: 200px; height: 150px;">
    </a>
  </div>
  <div class="resultDetail">
    <?php if ($type === 'reserved' && ! empty($fleamarket['reservation_number'])):?>
    <dl class="col-md-11 reservationNumber clearfix">
      <dt>予約番号</dt>
      <dd><?php echo e($fleamarket['reservation_number']);?></dd>
    </dl>
    <?php endif;?>
    <?php if ($is_official): ?>
    <dl class="col-md-6">
      <dt>出店ブース数</dt>
      <dd><?php echo $fleamarket['total_booth'] ? $fleamarket['total_booth'] .'ブース' : '-'; ?></dd>
    </dl>
    <?php endif; ?>
    <dl class="col-md-6">
      <dt>開催時間</dt>
      <dd><?php
          if ($fleamarket['event_time_start']):
              echo e(date('G:i', strtotime($fleamarket['event_time_start'])));
          else:
              echo '-';
          endif;
          if ($fleamarket['event_time_end']):
              echo '～' . e(date('G:i', strtotime($fleamarket['event_time_end'])));
          endif;
      ?></dd>
    </dl>
    <?php if ($is_official): ?>
    <dl class="col-md-6">
      <dt>出店形態</dt>
      <dd><?php
          if (isset($fleamarket['entry_style_name_list'])):
              echo e(implode('/', $fleamarket['entry_style_name_list']));
          else:
              echo '-';
          endif;
      ?></dd>
    </dl>
    <dl class="col-md-6">
      <dt>出店料金</dt>
      <dd><?php
          if (isset($fleamarket['booth_fee_list'])):
              echo e(implode('/', $fleamarket['booth_fee_list']));
          else:
              echo '-';
          endif;
      ?></dd>
    </dl>
    <?php endif; ?>
    <dl class="col-md-11">
      <dt>交通</dt>
      <dd><?php echo e($fleamarket['about_access']);?></dd>
    </dl>
    <?php if ($is_official): ?>
    <ul class="facilitys">
      <li class="facility1 <?php echo $fleamarket['car_shop_flag']       ? 'on' : 'off'; ?>">車出店可能</li>
      <li class="facility2 <?php echo $fleamarket['charge_parking_flag'] ? 'on' : 'off'; ?>">有料駐車場</li>
      <li class="facility3 <?php echo $fleamarket['free_parking_flag']   ? 'on' : 'off'; ?>">無料駐車場</li>
      <li class="facility4 <?php echo $fleamarket['rainy_location_flag'] ? 'on' : 'off'; ?>">雨天開催会場</li>
    </ul>
    <?php endif;?>
    <ul class="detailLink">
      <li><a href="/detail/<?php echo $fleamarket_id ?>">詳細情報を見る<i></i></a></li>
    </ul>
    <ul class="rightbutton">
<?php if ($type == 'finished'):?>
<?php elseif ($type == 'reserved'):?>
    <?php if ($is_official):?>
      <!-- <li class="button change makeReservation"><a href="/mypage/change?fleamarket_id=<?php echo $fleamarket_id;?>"><i></i>予約変更</a></li> -->
        <?php if ($fleamarket['event_status'] == \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT):?>
      <li class="button cancel"><a href="/mypage/cancel?entry_id=<?php echo $fleamarket['entry_id'];?>" class="fleamarket_cancel"><i></i>予約解除</a></li>
        <?php endif;?>
    <?php endif;?>
<?php elseif ($type == 'waiting'):?>
      <li class="button reserved">キャンセル待ち中</li>
<?php elseif ($type == 'mylist'):?>
    <?php if ($user && $user->hasEntry($fleamarket_id)):?>
      <li class="button reserved">出店予約中</li>
    <?php elseif ($user && $user->hasWaiting($fleamarket_id)):?>
      <li class="button reserved">キャンセル待ち中</li>
    <?php elseif ($fleamarket['event_status'] == \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT):?>
        <?php if ($fleamarket['event_reservation_status'] == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL):?>
      <li class="button makeReservation"><a href="/reservation?fleamarket_id=<?php echo $fleamarket_id;?>">キャンセル待ちをする</a></li>
        <?php else:?>
      <li class="button makeReservation"><a href="/reservation?fleamarket_id=<?php echo $fleamarket_id;?>">出店予約をする</a></li>
        <?php endif;?>
    <?php endif;?>
      <li class="button cancel"><a href="#" class="mylist_remove" id="fleamarket_id_<?php echo $fleamarket_id;?>"><i></i>マイリスト解除</a></li>
<?php elseif ($type == 'myfleamarket'):?>
      <li class="button makeReservation change"><a href="/fleamarket/<?php echo $fleamarket_id;?>"><i></i>内容変更</a></li>
<?php endif;?>
    </ul>
  </div>
</div>
<!-- /result -->
