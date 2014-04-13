<!-- result -->
<div class="<?php if (empty($no_box)) { echo 'box'; }; ?> result <?php $render_status($fleamarket); ?> <?php echo $is_official($fleamarket) ? 'resultPush' : ''; ?>  clearfix">
  <h3>
    <?php if ($is_official($fleamarket)): ?>
    <strong>楽市楽座主催</strong>
    <?php endif; ?>
    <a href="/detail/<?php echo $fleamarket['fleamarket_id'] ?>"><?php echo $fleamarket['name'] ?></a>
  </h3>
  <div class="resultPhoto"><a href="#"><img src="http://dummyimage.com/200x150/ccc/fff.jpg" class="img-rounded"></a></div>
  <div class="resultDetail">
      <dl class="col-md-6">
        <dt>出店数</dt>
        <dd><?php echo $fleamarket['total_booth'] ? "${fleamarket['total_booth']}店" : "お問い合わせ"; ?></dd>
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
        <li class="facility1 <?php echo $fleamarket['car_shop_flag']       ? 'on' : 'off'; ?>">車出店可能</li>
        <li class="facility2 <?php echo $fleamarket['charge_parking_flag'] ? 'on' : 'off'; ?>">有料駐車場</li>
        <li class="facility3 <?php echo $fleamarket['free_parking_flag']   ? 'on' : 'off'; ?>">無料駐車場</li>
        <li class="facility4 <?php echo $fleamarket['rainy_location_flag'] ? 'on' : 'off'; ?>">雨天開催会場</li>
      </ul>
    <ul class="detailLink">
      <li><a href="/detail/<?php echo $fleamarket['fleamarket_id'] ?>">詳細情報を見る<i></i></a></li>
    </ul>
    <ul class="rightbutton">
    <?php if($type == 'mylist'): ?>
          <li class="button makeReservation"><a href="/reservation?fleamarket_id=<?php echo $fleamarket['fleamarket_id'] ?>">出店予約をする</a></li>
          <li class="button cancel"><a href="#" class="mylist_remove" id="fleamarket_id_<?php echo $fleamarket['fleamarket_id']; ?>"><i></i>マイリスト解除</a></li>
    <?php elseif($type == 'entry'): ?>
        <?php if ($is_official($fleamarket)): ?>
          <!-- <li class="button change makeReservation"><a href="/mypage/change?fleamarket_id=<?php echo $fleamarket['fleamarket_id'] ?>"><i></i>予約変更</a></li> -->
          <li class="button cancel"><a href="/mypage/cancel?fleamarket_id=<?php echo $fleamarket['fleamarket_id'] ?>" class="fleamarket_cancel"><i></i>予約解除</a></li>
        <?php endif; ?>
    <?php elseif($type == 'myfleamarket'): ?>
          <li class="button makeReservation change"><a href="/fleamarket/<?php echo $fleamarket['fleamarket_id'] ?>"><i></i>内容変更</a></li>
    <?php elseif($type == 'reserved'): ?>
        <?php if ($is_official($fleamarket)): ?>
          <!-- <li class="button change makeReservation"><a href="/mypage/change?fleamarket_id=<?php echo $fleamarket['fleamarket_id'] ?>"><i></i>予約変更</a></li> -->
          <li class="button cancel"><a href="/mypage/cancel?fleamarket_id=<?php echo $fleamarket['fleamarket_id'] ?>" class="fleamarket_cancel"><i></i>予約解除</a></li>
        <?php endif; ?>
    <?php endif; ?>
    </ul>
  </div>
</div>
<!-- /result -->
