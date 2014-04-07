<div id="contentLogin" class="row">
  <!-- ad -->
  <div id="ad" class="col-sm-2">
    <!-- <a href="#"><img src="http://dummyimage.com/535x250/ccc/fff.jpg"  class="img-responsive"></a> -->
  </div>
  <!-- /ad -->
  <!-- loginForm -->
  <div id="loginForm" class="col-sm-7">
    <div class="box clearfix">
      <h3>パスワードを忘れた方</h3>
      <p style="margin-bottom: 20px;">認証済みのメールアドレスに再設定用URLを通知いたします。<br />
        認証されていないメールアドレスには通知できません。<br />
      </p>
      <form id="login" action="/reminder/submit" accept-charset="utf-8" method="post">
        <?php echo \Form::csrf(); ?>
        <div class="form-group">
          <input type="text" class="form-control" id="mail" placeholder="メールアドレス(ログインID)" name="email">
          <button type="submit" class="btn btn-default">送信する</button>
        </div>
      </form>
      <ul>
      </ul>
    </div>
  </div>
  <!-- /loginForm -->
</div>
