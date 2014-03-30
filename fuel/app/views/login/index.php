<div id="contentLogin" class="row">
  <!-- ad -->
  <div id="ad" class="col-sm-7">
    <a href="#"><img src="http://dummyimage.com/535x250/ccc/fff.jpg"  class="img-responsive"></a>
  </div>
  <!-- /ad -->
  <!-- loginForm -->
  <div id="loginForm" class="col-sm-5">
    <div class="box clearfix">
      <?php if($error_message): ?>
      <h3><?php echo $error_message ?></h3>
      <?php endif ?>
      <?php if($info_message): ?>
      <h3><?php echo $info_message ?></h3>
      <?php endif ?>
      <form id="login" action="/login/auth?rurl=<?php echo $return_url; ?>" accept-charset="utf-8" method="post">
        <?php echo \Form::csrf(); ?>
        <div class="form-group">
          <input type="text" class="form-control" id="mail" placeholder="メールアドレス(ログインID)" name="email">
          <input type="password" class="form-control" id="password" placeholder="パスワード" name="password">
          <button type="submit" class="btn btn-default">ログイン</button>
        </div>
      </form>
      <ul>
        <li><a href="#" target="_blank">パスワードを忘れた方はこちら</a></li>
        <li><a href="#" target="_blank">よくあるご質問はこちら</a></li>
      </ul>
    </div>
  </div>
  <!-- /loginForm -->
</div>
