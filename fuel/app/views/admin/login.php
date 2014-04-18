<?php if(isset($failed) && $failed){ ?>
ログインできませんでした
<?php } ?>

<form action="/admin/login" method="POST">
  <table>
    <tr>
      <td>email</td>
      <td><input type="text" name="email" size="40"></td>
    </tr>
    <tr>
      <td>password</td>
      <td><input type="password" name="password" size="40"></td>
    </tr>
  </table>
  <input type="submit" value="login">
</form>
