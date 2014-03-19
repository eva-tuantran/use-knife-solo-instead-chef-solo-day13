<style type="text/css">
.find_box {margin-bottom: 10px; border: 1px solid #ccc;}
.find_title {text-align: center; border-bottom: 1px solid #ccc;}
.find_condtion {list-style: none; padding: 10px;}
table {margin-bottom: 10px; width: 800px; border: 1px solid #ccc;}
table td {padding: 10px;}
.first-td {border-bottom: 1px solid #ccc;}
.left-td {border-left: 1px solid #ccc;}
.right-td {border-right: 1px solid #ccc;}
.last-td {}
.event_info li {margin-left: 10px;padding: 5px; border: 1px solid #ccc; float: left;}
.event_info .invalid {background-color: #666}
.action_buttons li {margin-left: 10px; float: left;}
.action_buttons .reservation {background-color: #ffa500}
</style>
<script type="text/javascript">
$(function() {
  $(".pagination li").on("click", function(evt) {
      evt.preventDefault();
      var href = $(this).find("a").attr("href");
      $("#form_search").attr("action", href).submit();
  });

  $("#do_filter").on("click", function(evt) {
      evt.preventDefault();
      $("#form_search").submit();
  });
});
</script>
<form id="form_search" action="/search/index" method="post">
<?php
    if (is_array($base_conditions) && count($base_conditions) > 0):
        foreach ($base_conditions as $field => $value):
            echo Form::hidden('conditions[' . $field . ']', $value);
        endforeach;
    endif;
?>

<h2><?php echo $title;?></h2>
<div class="row">
  <div class="col-md-2">
    <div class="find_box">
      <p class="find_title">ステータス</p>
      <ul class="find_condtion">
        <li><?php
            $is_checked = isset($filters['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_SCHEDULE, $filters['event_status']);
            echo Form::checkbox('filters[event_status][]', \Model_Fleamarket::EVENT_STATUS_SCHEDULE, $is_checked, array('id' => 'form_event_schedule'));
            echo Form::label('開催予定', null, array('for' => 'form_event_schedule'));
        ?></li>
        <li><?php
            $is_checked = isset($filters['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT, $filters['event_status']);
            echo Form::checkbox('filters[event_status][]', \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT, $is_checked, array('id' => 'form_event_reservation_receipt'));
            echo Form::label('予約受付中', null, array('for' => 'form_event_reservation_receipt'));
        ?></li>
        <li><?php
            $is_checked = isset($filters['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_RECEIPT_END, $filters['event_status']);
            echo Form::checkbox('filters[event_status][]', \Model_Fleamarket::EVENT_STATUS_RECEIPT_END, $is_checked, array('id' => 'form_event_receipt_end'));
            echo Form::label('受付終了', null, array('for' => 'form_event_receipt_end'));
        ?></li>
        <li><?php
            $is_checked = isset($filters['event_status']) && in_array(\Model_Fleamarket::EVENT_STATUS_CLOSE, $filters['event_status']);
            echo Form::checkbox('filters[event_status][]', \Model_Fleamarket::EVENT_STATUS_CLOSE, $is_checked, array('id' => 'form_event_close'));
            echo Form::label('開催終了', null, array('for' => 'form_event_close'));
        ?></li>
      </ul>
    </div>
    <div class="find_box">
      <p class="find_title">出店形態</p>
      <ul class="find_condtion">
      <?php
          foreach ($entry_styles as $entry_style_id => $entry_style_name):
              $id = 'form_entry_style_' . $entry_style_id;
              $is_checked = isset($filters['entry_style']) && in_array($entry_style_id, $filters['entry_style']);
      ?>
      <li><?php
          echo Form::checkbox('filters[entry_style][]', $entry_style_id, $is_checked, array('id' => $id));
          echo Form::label($entry_style_name, null, array('for' => $id));
      ?></li>
      <?php
          endforeach;
      ?>
      </ul>
    </div>
    <div class="find_box">
      <p class="find_title">出店料金</p>
      <ul class="find_condtion">
        <li><?php
            $is_checked = isset($filters['shop_fee']) && in_array(\Model_Fleamarket::SHOP_FEE_FLAG_FREE, $filters['shop_fee']);
            echo Form::checkbox('filters[shop_fee][]', \Model_Fleamarket::SHOP_FEE_FLAG_FREE, $is_checked, array('id' => 'form_shop_fee_free'));
            echo Form::label('無料出店', null, array('for' => 'form_shop_fee_free'));
        ?></li>
        <li><?php
            $is_checked = isset($filters['shop_fee']) && in_array(\Model_Fleamarket::SHOP_FEE_FLAG_CHARGE, $filters['shop_fee']);
            echo Form::checkbox('filters[shop_fee][]', \Model_Fleamarket::SHOP_FEE_FLAG_CHARGE, $is_checked, array('id' => 'form_shop_fee_charge'));
            echo Form::label('有料出店', null, array('for' => 'form_shop_fee_charge'));
        ?></li>
      </ul>
    </div>
    <div>
      <input id="do_filter" type="button" name="do_filter" value="検索">
    </div>
  </div>
  <div class="col-md-10">
<?php
    if (! $fleamarket_list):
?>
    <table>
      <tbody>
        <tr>
          <td colspan="5">条件に一致するフリーマーケットはありませんでした</td>
        </tr>
      </tbody>
    </table>
<?php
    else:
        echo $pagination->render();
        foreach ($fleamarket_list as $fleamarket):
            $fleamarket_id = $fleamarket['fleamarket_id'];
?>
    <table>
      <tbody>
        <tr>
          <td colspan="5" class="first-td"><?php echo e($fleamarket['name']);?></td>
        </tr>
        <tr>
          <td rowspan="6" class="left-td"><img src="path/to/aaa.jpg"></td>
          <td>開催日</td>
          <td><?php echo e($fleamarket['event_date']);?></td>
          <td>出店形態</td>
          <td class="right-td"><?php echo e($fleamarket['style_string']);?></td>
        </tr>
        <tr>
          <td>開催時間</td>
          <td><?php
              echo e($fleamarket['event_time_start']);
              if ($fleamarket['event_time_end'] != ''):
                  echo '～' . $fleamarket['event_time_end'];
              endif;
          ?></td>
          <td>出店料金</td>
          <td class="right-td"><?php echo e($fleamarket['fee_string']); ?></td>
        </tr>
        <tr>
          <td>交通</td>
          <td colspan="3"><?php echo e(@$fleamarket['about_access']);?></td>
        </tr>
        <tr>
          <td colspan="4" class="right-td">
            <ul class="event_info">
              <li class="<?php echo $fleamarket['car_shop_flag'] == 0 ? 'invalid': '';?>">車出店可能</li>
              <li class="<?php echo $fleamarket['charge_parking_flag'] == 0 ? 'invalid': '';?>">有料駐車場</li>
              <li class="<?php echo $fleamarket['free_parking_flag'] == 0 ? 'invalid': '';?>">無料駐車場</li>
              <li class="<?php echo $fleamarket['rainy_location_flag'] == 0 ? 'invalid': '';?>">雨天開催会場</li>
            </ul>
          </td>
        </tr>
        <tr>
          <td colspan="4"><?php echo e($fleamarket['booth_string']);?></td>
        </tr>
        <tr>
          <td colspan="4" class="last-td">
            <ul class="action_buttons">
              <li><a id="do_mylist" href="/mypage/listadd/<?php echo $fleamarket['fleamarket_id'];?>">マイリストに追加</li>
              <li><a id="do_detail" href="/search/detail/<?php echo $fleamarket['fleamarket_id'];?>">詳細情報を見る</a></li>
              <li class="reservation"><a id="do_reservation" href="/reservation/index/<?php echo $fleamarket['fleamarket_id'];?>">出店予約をする</a></li>
            </ul>
          </td>
        </tr>
      </tbody>
    </table>
<?php
        endforeach;
        echo $pagination->render();
    endif;
?>
  </div>
</div>
</form>