<style type="text/css">
table td {padding: 10px;}
.highlight {background-color: #c00;}
</style>
<script type="text/javascript">
var event_date = ['2014/3/8', '2014/3/16', '2014/3/21', '2014/3/22', '2014/3/30'];
$(function() {
  $("#calendar").datepicker({
    onSelect: function(selected_date) {
      var $form = $("#form_search_calendar");
      $form.append('<input type="hidden" name="conditions[event_date]" value="' + selected_date + '">');
      $form.submit();
      }
  });
});
</script>
<?php
    echo Form::open(array(
        'action' => 'search/',
        'method' => 'post',
        'id' => 'form_search_calendar',
    ));
?>
<h2><?php echo $title;?></h2>
<table>
  <tbody>
    <tr>
      <td><?php
        echo Form::label('カレンダー');
      ?></td>
      <td>
        <div id="calendar"></div>
      </td>
    </tr>
  </tbody>
</table>
<?php
    echo Form::close();
?>
<hr style="border: 2px dotted #ccc;">
<?php
    echo Form::open(array(
        'action' => 'search/',
        'method' => 'post',
        'id' => 'form_search_condition',
    ));
?>
<table>
  <tbody>
    <tr>
      <td><?php echo Form::label('キーワード');?></td>
      <td><?php
          echo Form::input('conditions[keyword]');
      ?></td>
    </tr>
    <tr>
      <td><?php echo Form::label('エリアを選択');?></td>
      <td>
        <div><?php
            $prefectures = array_merge(array('' => ''), $prefectures);
            echo Form::select('conditions[prefecture]', null, $prefectures);
        ?></div>
      </td>
    </tr>
    <tr>
      <td><?php echo Form::label('条件を選択');?></td>
      <td>
        <div><?php
            echo Form::checkbox('conditions[shop_fee][]', FLEAMARKET_SHOP_FEE_FLAG_FREE, null, array('id' => 'form_shop_fee'));
            echo Form::label('出店無料', null, array('for' => 'form_shop_fee'));
            echo Form::checkbox('conditions[car_shop]', FLEAMARKET_CAR_SHOP_FLAG_OK, null, array('id' => 'form_car_shop'));
            echo Form::label('車出店可', null, array('for' => 'form_car_shop'));
            echo Form::checkbox('conditions[pro_shop]', FLEAMARKET_PRO_SHOP_FLAG_OK, null, array('id' => 'form_pro_shop'));
            echo Form::label('プロ出店可', null, array('for' => 'form_pro_shop'));
        ?></div>
        <div><?php
            echo Form::checkbox('conditions[rainy_location]', FLEAMARKET_RAINY_LOCATION_FLAG_EXIST, null, array('id' => 'form_rainy_location'));
            echo Form::label('雨天開催会場]', null, array('for' => 'form_rainy_location'));
            echo Form::checkbox('conditions[charge_parking', FLEAMARKET_CHARGE_PARKING_FLAG_EXIST, null, array('id' => 'form_charge_parking'));
            echo Form::label('有料駐車場あり', null, array('for' => 'form_charge_parking'));
            echo Form::checkbox('conditions[free_parking]', FLEAMARKET_FREE_PARKING_FLAG_EXIST, null, array('id' => 'form_free_parking'));
            echo Form::label('無料駐車場あり', null, array('for' => 'form_free_parking'));
        ?></div>
      </td>
    </tr>
  </tbody>
</table>
<div class="action-section">
<?php
    echo Form::input('confirm', '検索', array('type' => 'submit', 'id' => 'do_search'));
?>
</div>
<?php
    echo Form::close();
?>
