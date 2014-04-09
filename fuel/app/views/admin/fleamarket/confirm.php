<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $fields = $fieldset->field(); ?>

<h3>フリマ登録</h3>
<form action="/admin/fleamarket/thanks" method="POST" class="form-horizontal">
  <table>
    <tr>
      <td>フリマ名</td>
      <td>
	<?php echo e($input['name']); ?>
      </td>
    </tr>
    <tr>
      <td>主催者名</td>
      <td>
	<?php echo e($input['promoter_name']); ?>
      </td>
    </tr>
    <tr>
      <td>event_number</td>
      <td>
	<?php echo e($input['event_number']); ?>
      </td>
    </tr>
    <tr>
      <td>開催日</td>
      <td>
	<?php echo e($input['event_date']); ?>
      </td>
    </tr>
    <tr>
      <td>開催時間</td>
      <td>
	<?php echo e($input['event_time_start']); ?>
      </td>
    </tr>
    <tr>
      <td>終了時間</td>
      <td>
	<?php echo e($input['event_time_end']); ?>
      </td>
    </tr>
    <tr>
      <td>event_status</td>
      <td>
	<?php echo e($input['event_status']); ?>
      </td>
    </tr>
    <tr>
      <td>headline</td>
      <td>
	<?php echo e($input['headline']); ?>
      </td>
    </tr>
    <tr>
      <td>information</td>
      <td>
	<?php echo e($input['information']); ?>
      </td>
    </tr>
    <tr>
      <td>内容</td>
      <td>
	<?php echo e($input['description']); ?>
      </td>
    </tr>
    <tr>
      <td>reservation_serial</td>
      <td>
   	<?php echo e($input['reservation_serial']); ?>
      </td>
    </tr>
    <tr>
      <td>予約受付開始日</td>
      <td>
	<?php echo e($input['reservation_start']); ?>
      </td>
    </tr>
    <tr>
      <td>予約受付終了日</td>
      <td>
	<?php echo e($input['reservation_end']); ?>
      </td>
    </tr>
    <tr>
      <td>予約受付電話番号</td>
      <td>
	<?php echo e($input['reservation_tel']); ?>
      </td>
    </tr>
    <tr>
      <td>予約受付E-mailアドレス</td>
      <td>
	<?php echo e($input['reservation_email']); ?>
      </td>
    </tr>
    <tr>
      <td>主催者ホームページ</td>
      <td>
	<?php echo e($input['website']); ?>
      </td>
    </tr>
    <tr>
      <td>出品物の種類</td>
      <td>
	<?php echo e($input['item_categories']); ?>
      </td>
    </tr>
    <tr>
      <td>link_from_list</td>
      <td>
	<?php echo e($input['link_from_list']); ?>
      </td>
    </tr>
    <tr>
      <td>pickup_flag</td>
      <td>
	<?php echo e($input['pickup_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>shop_fee_flag</td>
      <td>
	<?php echo e($input['shop_fee_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>car_shop_flag</td>
      <td>
	<?php echo e($input['car_shop_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>pro_shop_flag</td>
      <td>
	<?php echo e($input['pro_shop_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>rainy_location_flag</td>
      <td>
	<?php echo e($input['rainy_location_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>charge_parking_flag</td>
      <td>
	<?php echo e($input['charge_parking_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>free_parking_flag</td>
      <td>
   	<?php echo e($input['free_parking_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>寄付金</td>
      <td>
	<?php echo e($input['donation_fee']); ?>
      </td>
    </tr>
    <tr>
      <td>寄付先</td>
      <td>
	<?php echo e($input['donation_point']); ?>
      </td>
    </tr>
    <tr>
      <td>register_type</td>
      <td>
	<?php echo e($input['register_type']); ?>
      </td>
    </tr>
    <tr>
      <td>display_flag</td>
      <td>
	<?php echo e($input['display_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>event_reservation_status</td>
      <td>
	<?php echo e($input['event_reservation_status']); ?>
      </td>
    </tr>
    <?php if ($fleamarket && $input['fleamarket_image_id']) { ?>
    <?php foreach ($fleamarket->fleamarket_images as $fleamarket_image) { ?>
    <?php foreach ($input['fleamarket_image_id'] as $fleamarket_image_id) { ?>
    <?php if ($fleamarket_image->fleamarket_image_id == $fleamarket_image_id) { ?>
    <tr>
      <td>ファイル</td>
      <td><img src="<?php echo $fleamarket_image->Url(); ?>">を削除</td>
    </tr>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    <?php foreach ($files as $file) { ?>
    <tr>
      <td>ファイル</td>
      <td>
	<img src="/files/admin/fleamarket/img/<?php echo $file['saved_as']; ?>">
      </td>
    </tr>
    <?php } ?>
  </table>
  <input type="submit" value="登録">
  <input type="hidden" name="fleamarket_id" value="<?php echo e(Input::param('fleamarket_id')); ?>">
  <?php echo Form::csrf(); ?>
</form>
