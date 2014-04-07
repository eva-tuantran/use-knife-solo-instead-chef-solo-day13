<div id="contentLogin" class="row">
  <!-- ad -->
  <div id="ad" class="col-sm-2">
    <!-- <a href="#"><img src="http://dummyimage.com/535x250/ccc/fff.jpg"  class="img-responsive"></a> -->
  </div>
  <!-- /ad -->
  <!-- loginForm -->
  <div id="loginForm" class="col-sm-7">
    <?php if(!empty($error)){ var_dump($error); }; ?>
    <div class="box clearfix">
      <h3>パスワード再設定</h3>
      <form id="login" action="/reminder/resetpassword?token=<?php echo $hash; ?>" accept-charset="utf-8" method="post">
        <?php echo \Form::csrf(); ?>
        <div class="form-group">
          <input type="password" class="form-control" id="password" placeholder="パスワード" name="password">
          <input type="password" class="form-control" id="password2" placeholder="パスワード(確認用)" name="password2">
          <button type="submit" class="btn btn-default">送信する</button>
        </div>
      </form>
      <ul>
      </ul>
    </div>
  </div>
  <!-- /loginForm -->
</div>
