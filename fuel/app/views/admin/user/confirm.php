<?php $prefectures = Config::get('master.prefectures'); ?>

<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $fields = $fieldset->field(); ?>

<h3>ユーザー登録</h3>
<form action="/admin/user/thanks" method="POST" class="form-horizontal">
  <table>
    <tr>
      <td>ニックネーム</td>
      <td>
	<?php echo e($input['nick_name']); ?>
      </td>
    </tr>
    <tr>
      <td>氏名</td>
      <td>
	<?php echo e($input['last_name']); ?>
	<?php echo e($input['first_name']); ?>
      </td>
    </tr>
    <tr>
      <td>氏名(かな)</td>
      <td>
	<?php echo e($input['last_name_kana']); ?>
	<?php echo e($input['first_name_kana']); ?>
      </td>
    </tr>
    <tr>
      <td>誕生日</td>
      <td>
	<?php echo e($input['birthday']); ?>
      </td>
    </tr>
    <tr>
      <td>性別</td>
      <td>
	<?php if ($input['gender'] == 1) { echo '男性'; }
	      else if ($input['gender'] == 2 ){ echo '女性'; }
	      ?>
      </td>
    </tr>
    <tr>
      <td>都道府県</td>
      <td>
	<?php echo e($prefectures[$input['prefecture_id']]); ?>
      </td>
    </tr>
    <tr>
      <td>住所</td>
      <td>
	<?php echo e($input['address']); ?>
      </td>
    </tr>
    <tr>
      <td>電話番号</td>
      <td>
	<?php echo e($input['tel']); ?>
      </td>
    </tr>
    <tr>
      <td>携帯電話</td>
      <td>
	<?php echo e($input['mobile_tel']); ?>
      </td>
    </tr>
    <tr>
      <td>メールアドレス</td>
      <td>
	<?php echo e($input['email']); ?>
      </td>
    </tr>
    <tr>
      <td>携帯メールアドレス</td>
      <td>
	<?php echo e($input['mobile_email']); ?>
      </td>
    </tr>
    <tr>
      <td>デバイス</td>
      <td>
	<?php echo e($input['device']); ?>
      </td>
    </tr>
    <tr>
      <td>mm_flag</td>
      <td>
	<?php echo e($input['mm_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>mm_device</td>
      <td>
	<?php echo e($input['mm_device']); ?>
      </td>
    </tr>
    <tr>
      <td>mm_error_flag</td>
      <td>
	<?php echo e($input['mm_error_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>mobile_carrier</td>
      <td>
	<?php echo e($input['mobile_carrier']); ?>
      </td>
    </tr>
    <tr>
      <td>mobile_uid</td>
      <td>
	<?php echo e($input['mobile_uid']); ?>
      </td>
    </tr>
    <tr>
      <td>password</td>
      <td>
	<?php echo e($input['password']); ?>
      </td>
    </tr>
    <tr>
      <td>admin_memo</td>
      <td>
	<?php echo e($input['admin_memo']); ?>
      </td>
    </tr>
    <tr>
      <td>organization_flag</td>
      <td>
	<?php echo e($input['organization_flag']); ?>
      </td>
    </tr>
    <tr>
      <td>register_status</td>
      <td>
	<?php echo e($input['register_status']); ?>
      </td>
    </tr>
    <tr>
      <td>last_login</td>
      <td>
	<?php echo e($input['last_login']); ?>
      </td>
    </tr>

  </table>
  <input type="submit" value="登録">
  <input type="hidden" name="user_id" value="<?php echo e(Input::param('user_id')); ?>">
  <?php echo Form::csrf(); ?>
</form>
