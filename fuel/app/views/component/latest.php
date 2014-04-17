<?php
    if ($fleamarket_list):
        foreach ($fleamarket_list as $fleamarket):
            $fleamarket_id = $fleamarket['fleamarket_id'];
            $prefecture = '';
            if ($fleamarket['prefecture_id'] > 0):
                $prefecture = $prefectures[$fleamarket['prefecture_id']];
            endif;
?>
<!-- market -->
<div class="market clearfix">
  <p class="state"><?php echo $prefecture;?></p>
  <p class="case"><?php echo e($event_statuses[$fleamarket['event_status']])?></p>
  <div class="marketPhoto"><a href="/detail/<?php echo e($fleamarket_id);?>"><img src="http://dummyimage.com/180x110/ccc/fff.jpg" class="img-rounded"></a></div>
  <p class="date"><?php echo e(date('n月j日', strtotime($fleamarket['event_date'])));?>(<?php echo $week_list[date('w', strtotime($fleamarket['event_date']))];?>)</p>
  <h3><a href="/detail/<?php echo e($fleamarket_id);?>"><?php echo e($fleamarket['name']);?></a></h3>
  <p class="place"><?php echo e($fleamarket['location_name']);?></p>
</div>
<!-- /market -->
<?php
        endforeach;
    endif;
?>