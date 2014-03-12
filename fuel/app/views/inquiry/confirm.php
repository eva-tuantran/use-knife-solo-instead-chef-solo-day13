<h2>inquiry</h2>

<?php $form = $fieldset->form(); ?>
<?php $fields = $fieldset->field(); ?>

<?php echo $form->open('inquiry/thanks') ?>

<table>
  <tr>
    <td>
    <?php echo $fields['inquiry_type']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo e(Model_Contact::inquiry_type_label($input['inquiry_type'])); ?>
    </td>
  </tr>

  <tr>
    <td>
    <?php echo $fields['subject']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo e($input['subject']); ?>
    </td>
  </tr>

  <tr>
    <td>
    <?php echo $fields['email']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo e($input['email']); ?>
    </td>
  </tr>

  <tr>
    <td>
    <?php echo $fields['tel']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo e($input['tel']); ?>
    </td>
  </tr>

  <tr>
    <td>
    <?php echo $fields['contents']->set_template('{label}'); ?>
    </td>
    <td>
    <?php echo nl2br(e($input['contents'])); ?>
    </td>
  </tr>

</table>

<input type="submit" value="確認">
<?php echo $form->close(); ?>
