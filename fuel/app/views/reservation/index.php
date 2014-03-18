<h2>reservation</h2>

<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>

<form action="/inquiry/confirm" method="POST">
  <table>
    <tr>
      <td>出店方法</td>
      <td>
      </td>
    </tr>
    <tr>
    </tr>
  </table>
  
  <input type="submit" value="確認">
</form>
