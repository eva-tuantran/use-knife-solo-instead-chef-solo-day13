<?php $entry_styles = Config::get('master.entry_styles'); ?>

<?php $input  = $fieldsets['fleamarket']->input(); ?>
<?php $errors = $fieldsets['fleamarket']->validation()->error_message(); ?>
<?php $fields = $fieldsets['fleamarket']->field(); ?>
<?php 
   $is_delete = array();

   if(isset($input['delete_priorities'])){
       foreach ($input['delete_priorities'] as $priority){
           $is_delete[$priority] = 1;
       } 
   }
?>

<h3>フリマ登録</h3>
<form action="/admin/fleamarket/thanks" method="POST" class="form-horizontal">
  <table>
    <tr>
      <td>location_id</td>
      <td>
	<?php 
	   foreach ($locations as $location) {
	     if( $location->location_id == $input['location_id'] ){
	       echo e($location->name);
             }
           }
	?>
      </td>
    </tr>
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
<!--
    <tr>
      <td>event_number</td>
      <td>
	<?php echo e($input['event_number']); ?>
      </td>
    </tr>
-->
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
      <td>開催状況</td>
      <td>
	<?php 
	   $statuses = Model_Fleamarket::getEventStatuses();
	   echo $statuses[$input['event_status']];
        ?>
      </td>
    </tr>
<!--
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
-->
    <tr>
      <td>内容</td>
      <td>
	<?php echo e($input['description']); ?>
      </td>
    </tr>
<!--
    <tr>
      <td>reservation_serial</td>
      <td>
   	<?php echo e($input['reservation_serial']); ?>
      </td>
    </tr>
-->
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
      <td>導線</td>
      <td>
	<?php echo e($input['link_from_list']); ?>
      </td>
    </tr>
    <tr>
      <td>ピックアップ</td>
      <td>
	<?php echo $input['pickup_flag'] ? '対象' : '対象外'; ?>
      </td>
    </tr>
    <tr>
      <td>出店料</td>
      <td>
        <?php echo $input['shop_fee_flag'] ? '無料' : '有料'; ?>
      </td>
    </tr>
    <tr>
      <td>車出店</td>
      <td>
        <?php echo $input['car_shop_flag'] ? 'OK' : 'NG'; ?>
      </td>
    </tr>
    <tr>
      <td>プロ出店</td>
      <td>
        <?php echo $input['pro_shop_flag'] ? 'OK' : 'NG'; ?>
      </td>
    </tr>
    <tr>
      <td>雨天開催会場</td>
      <td>
        <?php echo $input['rainy_location_flag'] ? 'OK' : 'NG'; ?>
      </td>
    </tr>
    <tr>
      <td>有料駐車場</td>
      <td>
        <?php echo $input['charge_parking_flag'] ? 'あり' : 'なし'; ?>
      </td>
    </tr>
    <tr>
      <td>無料駐車場</td>
      <td>
        <?php echo $input['free_parking_flag'] ? 'あり' : 'なし'; ?>
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
	<?php if ($input['register_type'] == Model_Fleamarket::REGISTER_TYPE_ADMIN) { echo '運営者'; }
	      else if($input['register_type'] == Model_Fleamarket::REGISTER_TYPE_USER) { echo 'ユーザー投稿'; }
	      ?>
      </td>
    </tr>
    <tr>
      <td>display_flag</td>
      <td>
        <?php echo $input['display_flag'] ? 'YES' : 'NO'; ?>
      </td>
    </tr>
    <tr>
      <td>予約状況</td>
      <td>
	<?php      if($input['event_reservation_status'] == Model_Fleamarket::EVENT_RESERVATION_STATUS_ENOUGH)  { echo 'まだまだあります'; }
	      else if($input['event_reservation_status'] == Model_Fleamarket::EVENT_RESERVATION_STATUS_FEW) { echo '残り僅か！'; }
	      else if($input['event_reservation_status'] == Model_Fleamarket::EVENT_RESERVATION_STATUS_FEW) { echo '満員'; }
	      ?>
      </td>
    </tr>
    <?php foreach (range(1,4) as $priority) { ?>
    <tr>
      <td>ファイル<?php echo($priority); ?></td>
      <td>
	<?php if(isset($is_delete[$priority])){ ?>
	<img src="<?php echo $fleamarket->fleamarket_image($priority)->Url(); ?>">(削除)
	<?php }elseif(isset($files["upload${priority}"])) { ?>
	<img src="/files/admin/fleamarket/img/<?php echo $files["upload${priority}"]['saved_as']; ?>">(更新)
	<?php }elseif( $fleamarket && $fleamarket->fleamarket_image($priority) ){ ?>
	<img src="<?php echo $fleamarket->fleamarket_image($priority)->Url(); ?>">
	<?php } ?>
      </td>
    </tr>
    <?php } ?>

    <?php foreach (Model_Fleamarket_About::getAboutTitles() as $id => $title) { ?>
    <tr>
      <td><?php echo e($title); ?></td>
      <td>
	<?php 
	   $input = $fieldsets['fleamarket_abouts'][$id]->input();
	   echo e($input['description']);
	?>
      </td>
    </tr>
    <?php } ?>
    <?php foreach ($entry_styles as $id => $entry_style) { ?>
    <tr>
      <td><?php echo e($entry_style); ?></td>
      <td>
	出店料
	<?php 
	   $input = $fieldsets['fleamarket_entry_styles'][$id]->input();
	   echo e($input['booth_fee']);
	?>
	<br />
	最大ブース数
	<?php 
	   $input = $fieldsets['fleamarket_entry_styles'][$id]->input();
	   echo e($input['max_booth']);
	?>
	<br />
	ユーザー毎ブース数上限
	<?php 
	   $input = $fieldsets['fleamarket_entry_styles'][$id]->input();
	   echo e($input['reservation_booth_limit']);
	?>
	<br />
      </td>
    </tr>
    <?php } ?>
  </table>
  <input type="submit" value="登録">
  <input type="hidden" name="fleamarket_id" value="<?php echo e(Input::param('fleamarket_id')); ?>">
  <?php echo Form::csrf(); ?>
</form>
