<dl>
<?php
    if ($fleamarket_list):
        foreach ($fleamarket_list as $fleamarket):
            $prefecture = '';
            if ($fleamarket['prefecture_id'] > 0):
                $prefecture = $prefectures[$fleamarket['prefecture_id']];
            endif;
?>
  <dt><?php echo e(date('Y年n月j日', strtotime($fleamarket['event_date'])));?>(<?php echo $week_list[date('w', strtotime($fleamarket['event_date']))];?>)</dt>
  <dd>
      <a href="/detail/<?php echo e($fleamarket['fleamarket_id']);?>">
          <?php
            if ($fleamarket['register_type'] === \Model_Fleamarket::REGISTER_TYPE_ADMIN):
                echo '楽市楽座主催&nbsp;';
            endif;
            echo e($fleamarket['name']) . '&nbsp;';
            echo $prefecture . '&nbsp;';
            switch ($fleamarket['event_status']):
                case \Model_Fleamarket::EVENT_STATUS_SCHEDULE:
                    echo '開催予定';
                    break;
                case \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT:
                    echo '予約受付中';
                    break;
                case \Model_Fleamarket::EVENT_STATUS_RECEIPT_END:
                    echo '受付終了';
                    break;
                default:
                    echo '';
                    break;
            endswitch;
          ?>
      </a>
  </dd>
</dl>
<?php
        endforeach;
    endif;
?>
<ul>
  <li><a href="/all?ac%5Bevent_status%5D%5B%5D=1&ac%5Bevent_status%5D%5B%5D=2&ac%5Bevent_status%5D%5B%5D=3">一覧</a></li>
</ul>
