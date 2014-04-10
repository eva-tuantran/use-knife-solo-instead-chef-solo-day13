<?php
?>
<script type="text/javascript">
$(function() {
  $("#inputEventDate").datepicker({
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

<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $fields = $fieldset->field(); ?>

<h3>フリマ登録</h3>
<form action="/admin/fleamarket/confirm" method="POST" class="form-horizontal" enctype="multipart/form-data">
  <table>
    <tr>
      <td>location_id</td>
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
      <td>event_number</td>
      <td>
	<input type="text" name="event_number" value="<?php echo e($fields['event_number']->value); ?>">
	<?php
	   if (isset($errors['event_number'])) {
   	       echo $errors['event_number'];
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
      <td>headline</td>
      <td>
	<input type="text" name="headline" value="<?php echo e($fields['headline']->value); ?>">
	<?php
	   if (isset($errors['headline'])) {
   	       echo $errors['headline'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>information</td>
      <td>
	<input type="text" name="information" value="<?php echo e($fields['information']->value); ?>">
	<?php
	   if (isset($errors['information'])) {
   	       echo $errors['information'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>内容</td>
      <td>
	<input type="text" name="description" value="<?php echo e($fields['description']->value); ?>">
	<?php
	   if (isset($errors['description'])) {
   	       echo $errors['description'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>reservation_serial</td>
      <td>
	<input type="text" name="reservation_serial" value="<?php echo e($fields['reservation_serial']->value); ?>">
	<?php
	   if (isset($errors['reservation_serial'])) {
   	       echo $errors['reservation_serial'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>予約受付開始日</td>
      <td>
	<input type="text" name="reservation_start" value="<?php echo e($fields['reservation_start']->value); ?>">
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
	<input type="text" name="reservation_end" value="<?php echo e($fields['reservation_end']->value); ?>">
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
      <td>link_from_list</td>
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
      <td>寄付金</td>
      <td>
	<input type="text" name="donation_fee" value="<?php echo e($fields['donation_fee']->value); ?>">
	<?php
	   if (isset($errors['donation_fee'])) {
   	       echo $errors['donation_fee'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>寄付先</td>
      <td>
	<input type="text" name="donation_point" value="<?php echo e($fields['donation_point']->value); ?>">
	<?php
	   if (isset($errors['donation_point'])) {
   	       echo $errors['donation_point'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>register_type</td>
      <td>
	<input type="radio" name="register_type" value="1"<?php if ($fields['display_flag']->value == 1) { echo ' checked'; } ?>>運営者
	<input type="radio" name="register_type" value="2"<?php if ($fields['display_flag']->value == 2) { echo ' checked'; } ?>>ユーザー投稿
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
      <td>event_reservation_status</td>
      <td>
	<input type="text" name="event_reservation_status" value="<?php echo e($fields['event_reservation_status']->value); ?>">
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
    <tr>
      <td>deleted_at</td>
      <td>
      <?php
	 if (isset($fleamarket)) {
             echo e($fleamarket->deleted_at);
         }
      ?> 
      </td>
    </tr>
    <?php if ($fleamarket) { ?>
    <?php foreach ($fleamarket->fleamarket_images as $fleamarket_image) { ?>
    <tr>
      <td>ファイル</td>
      <td>
	<img src="<?php echo $fleamarket_image->Url(); ?>">
	<input type="checkbox" name="fleamarket_image_id[]" value="<?php echo $fleamarket_image->fleamarket_image_id; ?>">削除する
      </td>
    </tr>
    <?php } ?>
    <?php } ?>
    <tr>
      <td>ファイル</td>
      <td>
	<input type="file" name="upload1">
      </td>
    </tr>
    <tr>
      <td>ファイル</td>
      <td>
	<input type="file" name="upload2">
      </td>
    </tr>
    <tr>
      <td>ファイル</td>
      <td>
	<input type="file" name="upload3">
      </td>
    </tr>
    <tr>
      <td>ファイル</td>
      <td>
	<input type="file" name="upload4">
      </td>
    </tr>
    <?php foreach (Model_Fleamarket_About::getAboutTitles() as $id => $title) { ?>
    <tr>
      <td>
	<?php echo e($title); ?>
      </td>
      <td>
	<input type="text" name="fleamarket_about_<?php echo $id ?>" value="<?php echo e($fields["fleamarket_about_${id}"]->value); ?>">
      </td>
    </tr>
    <?php } ?>
    <?php if ($fleamarket) {
	  foreach ($fleamarket->fleamarket_entry_styles as $fleamarket_entry_style) { ?>
    <tr>
    <td><?php echo e($entry_styles[$fleamarket_entry_style->entry_style_id]); ?></td>
    <td>
    </td>
    </tr>
    <?php }} ?>
  </table>
<input type="submit" value="登録">
  <input type="hidden" name="fleamarket_id" value="<?php echo e(Input::param('fleamarket_id')); ?>">
</form>
