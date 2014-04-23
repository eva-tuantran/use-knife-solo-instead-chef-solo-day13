<?php
    if ($fleamarket_list):
        foreach ($fleamarket_list as $key => $fleamarket):
            $rank = $key + 1;
            $entry_style_string = '';
            $shop_fee_string = '';
            if ($fleamarket['entry_styles']):
                foreach ($fleamarket['entry_styles'] as $entry_style):
                    $entry_type_id = $entry_style['entry_style_id'];
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
<!-- rank<?php echo $rank;?> -->
<div class="rank<?php echo $rank;?> clearfix"><i class="rankicon"></i>
  <div class="rankPhoto">
    <?php
        $image_path = '/assets/img/noimage.jpg';
        if (isset($fleamarket['file_name']) && $fleamarket['file_name'] != ''):
            $image_path = '/files/fleamarket/img/m_' . $fleamarket['file_name'];

            if (! file_exists('.' . $image_path)):
                $image_path ='/assets/img/noimage.jpg';
            endif;
        endif;
    ?>
    <a href="/detail/<?php echo e($fleamarket['fleamarket_id']);?>">
      <img src="<?php echo $image_path;?>" class="img-rounded" style="width: 200px; height: 150px;">
    </a>
  </div>
  <h3><a href="/detail/<?php echo e($fleamarket['fleamarket_id']);?>"><?php echo e($fleamarket['name']);?></a></h3>
  <dl class="col-md-4">
    <dt>開催日</dt>
    <dd><?php echo e(date('n月j日', strtotime($fleamarket['event_date'])));?>(<?php echo $week_list[date('w', strtotime($fleamarket['event_date']))];?>)&nbsp;</dd>
  </dl>
  <dl class="col-md-4">
    <dt>出店形態</dt>
    <dd><?php
        if ($entry_style_string != ''):
            echo $entry_style_string;
        endif;
    ?></dd>
  </dl>
  <dl class="col-md-4">
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
  <dl class="col-md-4">
    <dt>出店料金</dt>
    <dd><?php
        if ($shop_fee_string != ''):
            echo $shop_fee_string;
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
<!-- /rank<?php echo $rank;?> -->
<?php
        endforeach;
    endif;
?>
