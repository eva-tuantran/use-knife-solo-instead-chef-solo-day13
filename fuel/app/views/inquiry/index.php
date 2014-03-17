<h2>inquiry</h2>

<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>

<form action="/inquiry/confirm" method="POST">

<table>
  <tr>
    <td>
     お問い合わせの種類
    </td>
    <td>
      <select name="inquiry_type">
       <option value="1"<?php if ($input['inquiry_type'] == 1){ echo ' selected=selected'; }?>>
         楽市楽座について
       </option>
       <option value="2"<?php if ($input['inquiry_type'] == 2){ echo ' selected=selected'; }?>>
         フリーマーケットについて
       </option>
       <option value="3"<?php if ($input['inquiry_type'] == 3){ echo ' selected=selected'; }?>>
         楽市楽座のウェブサイトについて
       </option>
       <option value="4"<?php if ($input['inquiry_type'] == 4){ echo ' selected=selected'; }?>>
         そのほかのお問い合わせについて
       </option>
      </select>
    </td>
    <?php if (isset($errors['inquiry_type'])) { ?>
    <?php echo $errors['inquiry_type']; ?>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td>
      件名
    </td>
    <td>
      <input type="text" name="subject" value="<?php echo e($input['subject']); ?>">
      <?php if (isset($errors['subject'])) { ?>
      <?php echo $errors['subject']; ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td>
      メールアドレス
    </td>
    <td>
      <input type="text" name="email" value="<?php echo e($input['email']); ?>">
      <?php if (isset($errors['email'])) { ?>
      <?php echo $errors['email']; ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td>
      メールアドレス確認用
    </td>
    <td>
      <input type="text" name="email2" value="<?php echo e($input['email2']); ?>">
      <?php if (isset($errors['email2'])) { ?>
      <?php echo $errors['email2']; ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td>
      電話番号
    </td>
    <td>
      <input type="text" name="tel" value="<?php echo e($input['tel']); ?>">
      <?php if (isset($errors['tel'])) { ?>
      <?php echo $errors['tel']; ?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td>
      内容
    </td>
    <td>
    <textarea name="contents" cols=80 rows=10><?php echo e($input['contents']); ?></textarea>
    <?php if (isset($errors['contents'])) { ?>
    <?php echo $errors['contents']; ?>
    <?php } ?>
    </td>
  </tr>
    
</table>

<input type="submit" value="確認">
</form>

