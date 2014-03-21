<h2>inquiry</h2>

<?php $input = $fieldset->input(); ?>

<form action="/inquiry/thanks" method="POST">
<table>
  <tr>
    <td>
      お問い合わせの種類
    </td>
    <td>
    <?php echo e(\Model_Contact::inquiry_type_to_label($input['inquiry_type'])); ?>
    </td>
  </tr>

  <tr>
    <td>
      名前
    </td>
    <td>
    <?php echo e($input['last_name']); ?><?php echo e($input['first_name']); ?>
    </td>
  </tr>

  <tr>
    <td>
      件名
    </td>
    <td>
    <?php echo e($input['subject']); ?>
    </td>
  </tr>

  <tr>
    <td>
      メールアドレス
    </td>
    <td>
    <?php echo e($input['email']); ?>
    </td>
  </tr>

  <tr>
    <td>
      電話番号
    </td>
    <td>
    <?php echo e($input['tel']); ?>
    </td>
  </tr>

  <tr>
    <td>
      内容
    </td>
    <td>
    <?php echo nl2br(e($input['contents'])); ?>
    </td>
  </tr>

</table>

<?php echo \Form::csrf(); ?>

<input type="submit" value="確認">
</form>
