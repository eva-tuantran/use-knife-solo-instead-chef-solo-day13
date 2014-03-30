<?php
    if ($fleamarket_list):
        foreach ($fleamarket_list as $key => $fleamarket):
?>
<!-- rank1 -->
<div class="rank<?php echo ($key + 1);?> clearfix"><i class="rankicon"></i>
  <div class="rankPhoto">
      <a href="/detail/<?php echo e($fleamarket['fleamarket_id']);?>"><img src="assets/img/noimage.jpg" class="img-rounded"></a>
  </div>
  <h3><a href="/detail/<?php echo e($fleamarket['fleamarket_id']);?>"><?php echo e($fleamarket['name']);?></a></h3>
  <dl class="col-md-4">
    <dt>開催日</dt>
    <dd><?php echo e($fleamarket['event_date']);?></dd>
  </dl>
  <dl class="col-md-4">
    <dt>出店形態</dt>
    <dd><?php echo e($fleamarket['style_string']);?></dd>
  </dl>
  <dl class="col-md-4">
    <dt>開催時間</dt>
    <dd><?php
            if ($fleamarket['event_time_start']):
                echo e($fleamarket['event_time_start']);
            else:
                echo '-';
            endif;
            if ($fleamarket['event_time_end']):
                echo '～' . $fleamarket['event_time_end'];
            endif;
    ?></dd>
  </dl>
  <dl class="col-md-4">
    <dt>出店料金</dt>
    <dd><?php
            if ($fleamarket['fee_string']):
                echo e($fleamarket['fee_string']);
            else:
                echo '-';
            endif;
    ?></dd>
  </dl>
  <dl class="col-md-9">
    <dt>交通</dt>
    <dd><?php echo e(@$fleamarket['about_access']);?></dd>
  </dl>
  <ul>
    <li><a href="/detail/<?php echo e($fleamarket['fleamarket_id']);?>">詳細情報を見る<i></i></a></li>
  </ul>
</div>
<!-- /rank1 -->
<?php
        endforeach;
    endif;
?>