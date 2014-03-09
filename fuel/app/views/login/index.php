<h2>ログイン</h2>

<?php if($error_message): ?>
    <div class="col-xs-12 alert-danger"><?php echo $error_message ?></div>
<?php endif ?>

<?php if($info_message): ?>
    <div class="col-xs-12 alert-info"><?php echo $info_message ?></div>
<?php endif ?>

<form id="logintest" action="/login/auth?rurl=<?php echo $return_url; ?>" accept-charset="utf-8" method="post">
  <label id="label_email" for="form_email">メールアドレス</label>
  <input id="email" name="email" type="text" value="">
  <label id="label_password" for="label_password">パスワード</label>
  <input id="password" name="password" type="password" value="">
  <input type="submit" name="submit">
</form>
