<?php $prefectures = Config::get('master.prefectures'); ?>

<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $fields = $fieldset->field(); ?>

<h3></h3>

<form action="/admin/user/confirm" method="POST" class="form-horizontal" enctype="multipart/form-data">
  <table>
    <tr>
      <td>ニックネーム</td>
      <td>
	<input type="text" name="nick_name" value="<?php echo e($fields['nick_name']->value); ?>">
	<?php
	   if (isset($errors['nick_name'])) {
	       echo $errors['nick_name'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>氏名</td>
      <td>
	<input type="text" name="last_name" value="<?php echo e($fields['last_name']->value); ?>">
	<input type="text" name="first_name" value="<?php echo e($fields['first_name']->value); ?>">
	<?php
	   if (isset($errors['last_name'])) {
	       echo $errors['last_name'];
    	   }
	   if (isset($errors['first_name'])) {
	       echo $errors['first_name'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>氏名（かな）</td>
      <td>
	<input type="text" name="last_name_kana" value="<?php echo e($fields['last_name_kana']->value); ?>">
	<input type="text" name="first_name_kana" value="<?php echo e($fields['first_name_kana']->value); ?>">
	<?php
	   if (isset($errors['last_name_kana'])) {
	       echo $errors['last_name_kana'];
    	   }
	   if (isset($errors['first_name_kana'])) {
	       echo $errors['first_name_kana'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>誕生日</td>
      <td>
	<input type="text" name="birthday" value="<?php echo e($fields['birthday']->value); ?>">
	<?php
	   if (isset($errors['birthday'])) {
	       echo $errors['birthday'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>性別</td>
      <td>
	<input type="radio" name="gender" value="1"<?php if ($fields['gender']->value == 1) { echo ' checked'; } ?>>男性
	<input type="radio" name="gender" value="2"<?php if ($fields['gender']->value == 2) { echo ' checked'; } ?>>女性
	<?php
	   if (isset($errors['gender'])) {
	       echo $errors['gender'];
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
      <td>電話番号</td>
      <td>
	<input type="text" name="tel" value="<?php echo e($fields['tel']->value); ?>">
	<?php
	   if (isset($errors['tel'])) {
	       echo $errors['tel'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>携帯電話</td>
      <td>
	<input type="text" name="mobile_tel" value="<?php echo e($fields['mobile_tel']->value); ?>">
	<?php
	   if (isset($errors['mobile_tel'])) {
	       echo $errors['mobile_tel'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>メールアドレス</td>
      <td>
	<input type="text" name="email" value="<?php echo e($fields['email']->value); ?>">
	<?php
	   if (isset($errors['email'])) {
	       echo $errors['email'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>携帯メールアドレス</td>
      <td>
	<input type="text" name="mobile_email" value="<?php echo e($fields['mobile_email']->value); ?>">
	<?php
	   if (isset($errors['mobile_email'])) {
	       echo $errors['mobile_email'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>デバイス</td>
      <td>
	<input type="text" name="device" value="<?php echo e($fields['device']->value); ?>">
	<?php
	   if (isset($errors['device'])) {
	       echo $errors['device'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>mm_flag</td>
      <td>
	<input type="text" name="mm_flag" value="<?php echo e($fields['mm_flag']->value); ?>">
	<?php
	   if (isset($errors['mm_flag'])) {
	       echo $errors['mm_flag'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>mm_device</td>
      <td>
	<input type="text" name="mm_device" value="<?php echo e($fields['mm_device']->value); ?>">
	<?php
	   if (isset($errors['mm_device'])) {
	       echo $errors['mm_device'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>mm_error_flag</td>
      <td>
	<input type="text" name="mm_error_flag" value="<?php echo e($fields['mm_error_flag']->value); ?>">
	<?php
	   if (isset($errors['mm_error_flag'])) {
	       echo $errors['mm_error_flag'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>mobile_carrier</td>
      <td>
	<input type="text" name="mobile_carrier" value="<?php echo e($fields['mobile_carrier']->value); ?>">
	<?php
	   if (isset($errors['mobile_carrier'])) {
	       echo $errors['mobile_carrier'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>mobile_uid</td>
      <td>
	<input type="text" name="mobile_uid" value="<?php echo e($fields['mobile_uid']->value); ?>">
	<?php
	   if (isset($errors['mobile_uid'])) {
	       echo $errors['mobile_uid'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>password</td>
      <td>
	<input type="text" name="password" value="<?php echo e($fields['password']->value); ?>">
	<?php
	   if (isset($errors['password'])) {
	       echo $errors['password'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>admin_memo</td>
      <td>
	<input type="text" name="admin_memo" value="<?php echo e($fields['admin_memo']->value); ?>">
	<?php
	   if (isset($errors['admin_memo'])) {
	       echo $errors['admin_memo'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>organization_flag</td>
      <td>
	<input type="text" name="organization_flag" value="<?php echo e($fields['organization_flag']->value); ?>">
	<?php
	   if (isset($errors['organization_flag'])) {
	       echo $errors['organization_flag'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>register_status</td>
      <td>
	<input type="text" name="register_status" value="<?php echo e($fields['register_status']->value); ?>">
	<?php
	   if (isset($errors['register_status'])) {
	       echo $errors['register_status'];
    	   }
	?>
      </td>
    </tr>
    <tr>
      <td>last_login</td>
      <td>
	<input type="text" name="last_login" value="<?php echo e($fields['last_login']->value); ?>">
	<?php
	   if (isset($errors['last_login'])) {
	       echo $errors['last_login'];
    	   }
	?>
      </td>
    </tr>
  </table>
  <input type="submit" value="add">
  <input type="hidden" name="user_id" value="<?php echo e(Input::param('user_id')); ?>">
</form>
