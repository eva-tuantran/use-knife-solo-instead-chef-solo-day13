<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $fields = $fieldset->field(); ?>

<h3>フリマ登録</h3>
<form action="/admin/fleamarket/confirm" method="POST" class="form-horizontal" enctype="multipart/form-data">
  <table>
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
	<input type="text" name="event_date" value="<?php echo e($fields['event_date']->value); ?>">
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
	<input type="text" name="event_time_start" value="<?php echo e($fields['event_time_start']->value); ?>">
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
	<input type="text" name="event_time_end" value="<?php echo e($fields['event_time_end']->value); ?>">
	<?php
	   if (isset($errors['event_time_end'])) {
   	       echo $errors['event_time_end'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>event_status</td>
      <td>
	<input type="text" name="event_status" value="<?php echo e($fields['event_status']->value); ?>">
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
      <td>pickup_flag</td>
      <td>
	<input type="text" name="pickup_flag" value="<?php echo e($fields['pickup_flag']->value); ?>">
	<?php
	   if (isset($errors['pickup_flag'])) {
   	       echo $errors['pickup_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>shop_fee_flag</td>
      <td>
	<input type="text" name="shop_fee_flag" value="<?php echo e($fields['shop_fee_flag']->value); ?>">
	<?php
	   if (isset($errors['shop_fee_flag'])) {
   	       echo $errors['shop_fee_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>car_shop_flag</td>
      <td>
	<input type="text" name="car_shop_flag" value="<?php echo e($fields['car_shop_flag']->value); ?>">
	<?php
	   if (isset($errors['car_shop_flag'])) {
   	       echo $errors['car_shop_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>pro_shop_flag</td>
      <td>
	<input type="text" name="pro_shop_flag" value="<?php echo e($fields['pro_shop_flag']->value); ?>">
	<?php
	   if (isset($errors['pro_shop_flag'])) {
   	       echo $errors['pro_shop_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>rainy_location_flag</td>
      <td>
	<input type="text" name="rainy_location_flag" value="<?php echo e($fields['rainy_location_flag']->value); ?>">
	<?php
	   if (isset($errors['rainy_location_flag'])) {
   	       echo $errors['rainy_location_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>charge_parking_flag</td>
      <td>
	<input type="text" name="charge_parking_flag" value="<?php echo e($fields['charge_parking_flag']->value); ?>">
	<?php
	   if (isset($errors['charge_parking_flag'])) {
   	       echo $errors['charge_parking_flag'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>free_parking_flag</td>
      <td>
	<input type="text" name="free_parking_flag" value="<?php echo e($fields['free_parking_flag']->value); ?>">
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
	<input type="text" name="register_type" value="<?php echo e($fields['register_type']->value); ?>">
	<?php
	   if (isset($errors['register_type'])) {
   	       echo $errors['register_type'];
           }
	?>
      </td>
    </tr>
    <tr>
      <td>display_flag</td>
      <td>
	<input type="text" name="display_flag" value="<?php echo e($fields['display_flag']->value); ?>">
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
	<input type="checkbox" name=""fleamarket_image_id value="1<?php echo $fleamarket_image->fleamarket_image_id; ?>">削除する
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
  </table>
  <input type="submit" value="登録">
  <input type="hidden" name="fleamarket_id" value="<?php echo e(Input::param('fleamarket_id')); ?>">
</form>

    
