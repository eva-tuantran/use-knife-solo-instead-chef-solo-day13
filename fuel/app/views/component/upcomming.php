<dl>
<?php
    if ($fleamarket_list):
        foreach ($fleamarket_list as $fleamarket):
?>
  <dt><?php echo e(date('Y年n月j日', strtotime($fleamarket['event_date'])));?></dt>
  <dd>
      <a href="/detail/<?php echo e($fleamarket['fleamarket_id']);?>">
          <?php
            if ($fleamarket['register_type'] === \Model_Fleamarket::REGISTER_TYPE_ADMIN):
                echo '楽市楽座主催&nbsp;';
            endif;
            echo e($fleamarket['name']) . '&nbsp;';
            echo $prefectures[$fleamarket['prefecture_id']] . '&nbsp;';
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
  <li><a href="/search/1?upcomming=1">一覧</a></li>
</ul>
