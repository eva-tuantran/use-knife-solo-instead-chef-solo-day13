<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $fields = $fieldset->field(); ?>

<h3></h3>
<form action="/admin/entry/confirm" method="POST" class="form-horizontal" enctype="multipart/form-data">
  <table>
    <tr>
      <td></td>
      <td>
      </td>
    </tr>
  </table>
  <input type="submit" value="">
  <input type="hidden" name="entry_id" value="<?php echo e(Input::param('entry_id')); ?>">
</form>
