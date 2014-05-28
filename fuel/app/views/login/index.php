<div id="contentLogin" class="row">
  <!-- ad -->
  <div id="ad" class="col-sm-7">
    <div id="login_left">
  	  <img src="/assets/img/regist_bg02.png" alt="フリーマーケット参加者募集" width="100%">
	  <a href="/signup"><img src="/assets/img/regist_btn_off.png" id="login_left_btn02" alt="登録する" width="66%"></a>
	</div>
<!--    <a href="#"><img src="http://dummyimage.com/535x250/ccc/fff.jpg"  class="img-responsive"></a> -->
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
        <div class="form-group text-left">
          <label for="mail" class="text-left">メールアドレス(ログインID)</label>
          <input type="text" class="form-control" id="mail" name="email">
          <label for="password">パスワード</label>
          <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-default">ログイン</button>
      </form>
      <ul>
        <li><a href="/reminder" target="_blank">パスワードを忘れた方はこちら</a></li>
        <li><a href="/info/question" target="_blank">よくあるご質問はこちら</a></li>
      </ul>
    </div>
  </div>
  <!-- /loginForm -->
</div>
