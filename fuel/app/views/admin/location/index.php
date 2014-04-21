<?php $prefectures = Config::get('master.prefectures'); ?>

<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $fields = $fieldset->field(); ?>

<h3>開催地登録</h3>

<form action="/admin/location/confirm" method="POST" class="form-horizontal" enctype="multipart/form-data">
  <table>
    <tr>
      <td>名前</td>
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
      <td>郵便番号</td>
      <td>
	<input type="text" name="zip" value="<?php echo e($fields['zip']->value); ?>">
	<?php
	   if (isset($errors['zip'])) {
	       echo $errors['zip'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>都道府県</td>
      <td>
	<select name="prefecture_id">
	  <option value=""></option>
	  <?php foreach ($prefectures as $id => $prefecture) { ?>
	  <option value="<?php echo $id; ?>"<?php if ($id == $fields['prefecture_id']->value) echo ' selected=selected';?>><?php echo e($prefecture); ?></option>
	  <?php } ?>
	</select>
      </td>
    </tr>
    <tr>
      <td>住所</td>
      <td>
	<input type="text" name="address" value="<?php echo e($fields['address']->value); ?>">
	<?php
	   if (isset($errors['address'])) {
	       echo $errors['address'];
    	   }
	?>
      </td>

    </tr>
    <tr>
      <td>googleマップ用住所</td>
      <td>
	<input type="text" name="googlemap_address" value="<?php echo e($fields['googlemap_address']->value); ?>">
	<?php
	   if (isset($errors['googlemap_address'])) {
	       echo $errors['googlemap_address'];
    	   }
	?>
      </td>
    </tr>
  </table>
  <input type="submit" value="add">
  <input type="hidden" name="location_id" value="<?php echo e(Input::param('location_id')); ?>">
</form>
