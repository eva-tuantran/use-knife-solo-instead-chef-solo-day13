<script type="text/javascript">
$(function() {
  $("#inputEventDate").datepicker({
    numberOfMonths: 3,
    showButtonPanel: true
  });
  $("#inputReservationStart").datepicker({
    numberOfMonths: 3,
    showButtonPanel: true
  });
  $("#inputReservationEnd").datepicker({
    numberOfMonths: 3,
    showButtonPanel: true
  });
  $("#inputEventTimeStart").timepicker({
    showButtonPanel: true,
    stepMinute: 5
  });
  $("#inputEventTimeEnd").timepicker({
    showButtonPanel: true,
    stepMinute: 5
  });
});
</script>

<?php $entry_styles = Config::get('master.entry_styles'); ?>

<?php $input  = $fieldsets['fleamarket']->input(); ?>
<?php $errors = $fieldsets['fleamarket']->validation()->error_message(); ?>
<?php $fields = $fieldsets['fleamarket']->field(); ?>

<h3>フリマ登録</h3>
<form action="/admin/fleamarket/confirm" method="POST" class="form-horizontal" enctype="multipart/form-data">
  <table>
    <tr>
      <td>開催地</td>
      <td>
	<select name="location_id">
	<?php foreach ($locations as $location) { ?>
	<option value="<?php echo $location->location_id; ?>"<?php if ($location->location_id == $fields['location_id']->value) { echo ' selected=selected'; } ?>><?php echo e($location->name); ?></option>
	<?php } ?>
	</select>
      </td>
    </tr>
    <tr>
      <td>フリマ名</td>
      <td>
	<input type="text" name="name" value="<?php echo e($fields['name']->value); ?>">
	<?php
	   if (isset($errors['name'])) {
   	       echo $errors['name'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>主催者名</td>
      <td>
	<input type="text" name="promoter_name" value="<?php echo e($fields['promoter_name']->value); ?>">
	<?php
	   if (isset($errors['promoter_name'])) {
   	       echo $errors['promoter_name'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>開催日</td>
      <td>
	<input type="text" name="event_date" value="<?php echo e($fields['event_date']->value); ?>" id="inputEventDate">
	<?php
	   if (isset($errors['event_date'])) {
   	       echo $errors['event_date'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>開催時間</td>
      <td>
	<input type="text" name="event_time_start" value="<?php echo e($fields['event_time_start']->value); ?>" id="inputEventTimeStart">
	<?php
	   if (isset($errors['event_time_start'])) {
   	       echo $errors['event_time_start'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>終了時間</td>
      <td>
	<input type="text" name="event_time_end" value="<?php echo e($fields['event_time_end']->value); ?>" id="inputEventTimeEnd">
	<?php
	   if (isset($errors['event_time_end'])) {
   	       echo $errors['event_time_end'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>開催状況</td>
      <td>
	<input type="radio" name="event_status" value="1"<?php if ($fields['event_status']->value == 1) { echo ' checked'; } ?>>開催予定
	<input type="radio" name="event_status" value="2"<?php if ($fields['event_status']->value == 2) { echo ' checked'; } ?>>予約受付中
	<input type="radio" name="event_status" value="3"<?php if ($fields['event_status']->value == 3) { echo ' checked'; } ?>>受付終了
	<input type="radio" name="event_status" value="4"<?php if ($fields['event_status']->value == 4) { echo ' checked'; } ?>>開催終了
	<input type="radio" name="event_status" value="5"<?php if ($fields['event_status']->value == 5) { echo ' checked'; } ?>>中止
	<?php
	   if (isset($errors['event_status'])) {
   	       echo $errors['event_status'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>内容</td>
      <td>
	
	<textarea name="description" cols=50 rows=10><?php echo e($fields['description']->value); ?></textarea>
	<?php
	   if (isset($errors['description'])) {
   	       echo $errors['description'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>予約受付開始日</td>
      <td>
	<input type="text" name="reservation_start" value="<?php echo e($fields['reservation_start']->value); ?>" id="inputReservationStart">
	<?php
	   if (isset($errors['reservation_start'])) {
   	       echo $errors['reservation_start'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>予約受付終了日</td>
      <td>
	<input type="text" name="reservation_end" value="<?php echo e($fields['reservation_end']->value); ?>" id="inputReservationEnd">
	<?php
	   if (isset($errors['reservation_end'])) {
   	       echo $errors['reservation_end'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>予約受付電話番号</td>
      <td>
	<input type="text" name="reservation_tel" value="<?php echo e($fields['reservation_tel']->value); ?>">
	<?php
	   if (isset($errors['reservation_tel'])) {
   	       echo $errors['reservation_tel'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>予約受付E-mailアドレス</td>
      <td>
	<input type="text" name="reservation_email" value="<?php echo e($fields['reservation_email']->value); ?>">
	<?php
	   if (isset($errors['reservation_email'])) {
   	       echo $errors['reservation_email'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>主催者ホームページ</td>
      <td>
	<input type="text" name="website" value="<?php echo e($fields['website']->value); ?>">
	<?php
	   if (isset($errors['website'])) {
   	       echo $errors['website'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>出品物の種類</td>
      <td>
	<input type="text" name="item_categories" value="<?php echo e($fields['item_categories']->value); ?>">
	<?php
	   if (isset($errors['item_categories'])) {
   	       echo $errors['item_categories'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>導線</td>
      <td>
	<input type="text" name="link_from_list" value="<?php echo e($fields['link_from_list']->value); ?>">
	<?php
	   if (isset($errors['link_from_list'])) {
   	       echo $errors['link_from_list'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>ピックアップ</td>
      <td>
	<input type="radio" name="pickup_flag" value="1"<?php if ($fields['pickup_flag']->value == 1) { echo ' checked'; } ?>>対象
	<input type="radio" name="pickup_flag" value="0"<?php if ($fields['pickup_flag']->value == 0) { echo ' checked'; } ?>>対象外
	<?php
	   if (isset($errors['pickup_flag'])) {
   	       echo $errors['pickup_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>出店料</td>
      <td>
	<input type="radio" name="shop_fee_flag" value="1"<?php if ($fields['shop_fee_flag']->value == 1) { echo ' checked'; } ?>>無料
	<input type="radio" name="shop_fee_flag" value="0"<?php if ($fields['shop_fee_flag']->value == 0) { echo ' checked'; } ?>>有料
	<?php
	   if (isset($errors['shop_fee_flag'])) {
   	       echo $errors['shop_fee_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>車出店</td>
      <td>
	<input type="radio" name="car_shop_flag" value="1"<?php if ($fields['car_shop_flag']->value == 1) { echo ' checked'; } ?>>OK
	<input type="radio" name="car_shop_flag" value="0"<?php if ($fields['car_shop_flag']->value == 0) { echo ' checked'; } ?>>NG
	<?php
	   if (isset($errors['car_shop_flag'])) {
   	       echo $errors['car_shop_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>プロ出店</td>
      <td>
	<input type="radio" name="pro_shop_flag" value="1"<?php if ($fields['pro_shop_flag']->value == 1) { echo ' checked'; } ?>>OK
	<input type="radio" name="pro_shop_flag" value="0"<?php if ($fields['pro_shop_flag']->value == 0) { echo ' checked'; } ?>>NG
	<?php
	   if (isset($errors['pro_shop_flag'])) {
   	       echo $errors['pro_shop_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>雨天開催会場</td>
      <td>
	<input type="radio" name="rainy_location_flag" value="1"<?php if ($fields['rainy_location_flag']->value == 1) { echo ' checked'; } ?>>OK
	<input type="radio" name="rainy_location_flag" value="0"<?php if ($fields['rainy_location_flag']->value == 0) { echo ' checked'; } ?>>NG
	<?php
	   if (isset($errors['rainy_location_flag'])) {
   	       echo $errors['rainy_location_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>有料駐車場</td>
      <td>
	<input type="radio" name="charge_parking_flag" value="1"<?php if ($fields['charge_parking_flag']->value == 1) { echo ' checked'; } ?>>あり
	<input type="radio" name="charge_parking_flag" value="0"<?php if ($fields['charge_parking_flag']->value == 0) { echo ' checked'; } ?>>なし
	<?php
	   if (isset($errors['charge_parking_flag'])) {
   	       echo $errors['charge_parking_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>無料駐車場</td>
      <td>
	<input type="radio" name="free_parking_flag" value="1"<?php if ($fields['free_parking_flag']->value == 1) { echo ' checked'; } ?>>あり
	<input type="radio" name="free_parking_flag" value="0"<?php if ($fields['free_parking_flag']->value == 0) { echo ' checked'; } ?>>なし
	<?php
	   if (isset($errors['free_parking_flag'])) {
   	       echo $errors['free_parking_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>register_type</td>
      <td>
	<input type="radio" name="register_type" value="1"<?php if ($fields['register_type']->value == 1) { echo ' checked'; } ?>>運営者
	<input type="radio" name="register_type" value="2"<?php if ($fields['register_type']->value == 2) { echo ' checked'; } ?>>ユーザー投稿
	<?php
	   if (isset($errors['register_type'])) {
   	       echo $errors['register_type'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>表示</td>
      <td>
	<input type="radio" name="display_flag" value="1"<?php if ($fields['display_flag']->value == 1) { echo ' checked'; } ?>>表示
	<input type="radio" name="display_flag" value="0"<?php if ($fields['display_flag']->value == 0) { echo ' checked'; } ?>>非表示
	<?php
	   if (isset($errors['display_flag'])) {
   	       echo $errors['display_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>予約状況</td>
      <td>
	<input type="radio" name="event_reservation_status" value="1"<?php if ($fields['event_reservation_status']->value == 1) { echo ' checked'; } ?>>まだまだあります
	<input type="radio" name="event_reservation_status" value="2"<?php if ($fields['event_reservation_status']->value == 2) { echo ' checked'; } ?>>残り僅か！
	<input type="radio" name="event_reservation_status" value="3"<?php if ($fields['event_reservation_status']->value == 3) { echo ' checked'; } ?>>満員
	<?php
	   if (isset($errors['event_reservation_status'])) {
   	       echo $errors['event_reservation_status'];
           }
	?>
      </td>
    </tr>
<tr>
      <td>created_at</td>
      <td>
      <?php
	 if (isset($fleamarket)) {
             echo e($fleamarket->created_at);
         }
      ?> 
      </td>
    </tr>
    <tr>
      <td>updated_at</td>
      <td>
      <?php
	 if (isset($fleamarket)) {
             echo e($fleamarket->updated_at);
         }
      ?> 
      </td>
    </tr>
    <?php foreach (range(1,4) as $priority) { ?>
    <tr>
      <td>ファイル<?php echo $priority; ?></td>
      <td>
	<?php if ($fleamarket && $fleamarket->fleamarket_image($priority)) { ?>
	<img src="<?php echo $fleamarket->fleamarket_image($priority)->Url(); ?>">
	<input type="checkbox" name="delete_priorities[]" value="<?php echo $priority; ?>">削除する
	<?php } ?>
	<input type="file" name="upload<?php echo $priority; ?>">
      </td>
    </tr>
    <?php } ?>
    <?php foreach (Model_Fleamarket_About::getAboutTitles() as $id => $title) { ?>
    <tr>
      <td>
	<?php echo e($title); ?>
      </td>
      <td>
	<textarea name="fleamarket_about_<?php echo $id; ?>_description" cols=50 rows=10><?php echo e($fieldsets['fleamarket_abouts'][$id]->field('description')->value); ?></textarea>
	<?php $errors = $fieldsets['fleamarket_abouts'][$id]->validation()->error_message(); ?>
	<?php 
	   if (isset($errors['description'])) {
   	       echo $errors['description'];
           }
	?>
      </td>
    </tr>
    <?php } ?>
    <?php foreach ($entry_styles as $id => $entry_style) { ?>
    <tr>
      <td>
	<?php echo e($entry_style); ?>
      </td>
      <td>
	<?php $errors = $fieldsets['fleamarket_entry_styles'][$id]->validation()->error_message(); ?>
	<table>
	  <tr>
	    <td>出店料</td><td><input type="text" name="fleamarket_entry_style_<?php echo $id; ?>_booth_fee" value="<?php echo e($fieldsets['fleamarket_entry_styles'][$id]->field('booth_fee')->value); ?>">
	  </tr>
	<?php 
	   if (isset($errors['booth_fee'])) {
   	       echo $errors['booth_fee'];
           }
	?></td>
	<tr>
	  <td>最大ブース数</td><td><input type="text" name="fleamarket_entry_style_<?php echo $id; ?>_max_booth" value="<?php echo e($fieldsets['fleamarket_entry_styles'][$id]->field('max_booth')->value); ?>">
	<?php 
	   if (isset($errors['max_booth'])) {
   	       echo $errors['max_booth'];
           }
	?></td>
	</tr>
	<tr>
	  <td>ユーザー毎ブース数上限</td><td><input type="text" name="fleamarket_entry_style_<?php echo $id; ?>_reservation_booth_limit" value="<?php echo e($fieldsets['fleamarket_entry_styles'][$id]->field('reservation_booth_limit')->value); ?>">
	<?php 
	   if (isset($errors['reservation_booth_limit'])) {
   	       echo $errors['reservation_booth_limit'];
           }
	?>
	  </td>
	</tr>
	</table>
      </td>
    </tr>
    <?php } ?>
</table>
<input type="submit" value="登録">
<input type="hidden" name="fleamarket_id" value="<?php echo e(Input::param('fleamarket_id')); ?>">
</form>

