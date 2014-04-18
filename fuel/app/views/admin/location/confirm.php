<?php $prefectures = Config::get('master.prefectures'); ?>

<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $fields = $fieldset->field(); ?>

<h3>開催地登録</h3>
<form action="/admin/location/thanks" method="POST" class="form-horizontal">
  <table>
    <tr>
      <td>会場名</td>
      <td>
	<?php echo e($input['name']); ?>
      </td>
    </tr>
    <tr>
      <td>郵便番号</td>
      <td>
	<?php echo e($input['zip']); ?>
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
      <td>googlemap用住所</td>
      <td>
	<?php echo e($input['googlemap_address']); ?>
      </td>
    </tr>
  </table>
  <input type="submit" value="登録">
  <input type="hidden" name="location_id" value="<?php echo e(Input::param('location_id')); ?>">
  <?php echo Form::csrf(); ?>
</form>
