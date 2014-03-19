<style type="text/css">
table td {padding: 10px;}
.highlight {background-color: #c00;}
</style>
<script type="text/javascript">
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
<form id="form_search_calendar" action="/search/" method="post">
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
</form>
<hr style="border: 2px dotted #ccc;">
<form id="form_search_condition" action="/search/" method="post">
<table>
  <tbody>
    <tr>
      <td>キーワード</td>
      <td><input type="text" name="conditions[keyword]">
      </td>
    </tr>
    <tr>
      <td>エリアを選択</td>
      <td>
        <div>
            <select name="conditions[prefecture]">
                <option value=""></option>
            <?php
                foreach ($prefectures as $prefecture_id => $name):
            ?>
                <option value="<?php echo $prefecture_id;?>"><?php echo $name;?></option>
            <?php
                endforeach;
            ?>
            </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>条件を選択</td>
      <td>
        <div>
            <input id="form_shop_fee" type="checkbox" name="conditions[shop_fee]" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_FREE;?>">
            <label for="form_shop_fee">出店無料</label>
            <input id="form_car_shop" type="checkbox" name="conditions[car_shop]" value="<?php echo \Model_Fleamarket::CAR_SHOP_FLAG_OK;?>">
            <label for="form_car_shop">車出店可</label>
            <input id="form_pro_shop" type="checkbox" name="conditions[form_pro_shop]" value="<?php echo \Model_Fleamarket::PRO_SHOP_FLAG_OK;?>">
            <label for="form_pro_shop">車出店可</label>
        </div>
        <div>
            <input id="form_rainy_location" type="checkbox" name="conditions[rainy_location]" value="<?php echo \Model_Fleamarket::RAINY_LOCATION_FLAG_EXIST;?>">
            <label for="form_rainy_location">雨天開催会場</label>
            <input id="form_charge_parking" type="checkbox" name="conditions[charge_parking]" value="<?php echo \Model_Fleamarket::CHARGE_PARKING_FLAG_EXIST;?>">
            <label for="form_charge_parking">有料駐車場あり</label>
            <input id="form_free_parking" type="checkbox" name="conditions[free_parking]" value="<?php echo \Model_Fleamarket::FREE_PARKING_FLAG_EXIST;?>">
            <label for="form_free_parking">無料駐車場あり</label>
        </div>
      </td>
    </tr>
  </tbody>
</table>
<div class="action-section">
    <input id="form_search_condition" type="submit" value="検索">
</div>
</form>
