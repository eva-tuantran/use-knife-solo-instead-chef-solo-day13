<h2>inquiry</h2>

<?php $form = $fieldset->form(); ?>
<?php $fields = $fieldset->field(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>

<?php echo $form->open('inquiry/confirm') ?>

<table>
  <tr>
    <td>
    <?php echo $fields['inquiry_type']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo $fields['inquiry_type']->set_template('{field}'); ?>
    <?php if( isset($errors['inquiry_type']) ){ ?>
    <?php echo $errors['inquiry_type']; ?>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td>
    <?php echo $fields['subject']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo $fields['subject']->set_template('{field}'); ?>
    <?php if( isset($errors['subject']) ){ ?>
    <?php echo $errors['subject']; ?>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td>
    <?php echo $fields['email']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo $fields['email']->set_template('{field}'); ?>
    <?php if( isset($errors['email']) ){ ?>
    <?php echo $errors['email']; ?>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td>
    <?php echo $fields['email2']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo $fields['email2']->set_template('{field}'); ?>
    <?php if( isset($errors['email2']) ){ ?>
    <?php echo $errors['email2']; ?>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td>
    <?php echo $fields['tel']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo $fields['tel']->set_template('{field}'); ?>
    <?php if( isset($errors['tel']) ){ ?>
    <?php echo $errors['tel']; ?>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td>
    <?php echo $fields['contents']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo $fields['contents']->set_template('{field}'); ?>
    <?php if( isset($errors['contents']) ){ ?>
    <?php echo $errors['contents']; ?>
    <?php } ?>
    </td>
  </tr>
    
</table>

<input type="submit" value="確認">
<?php echo $form->close(); ?>
