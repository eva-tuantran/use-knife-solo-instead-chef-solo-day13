<div id="contentLogin" class="row">
  <!-- ad -->
  <div id="ad" class="col-sm-2">
    <!-- <a href="#"><img src="http://dummyimage.com/535x250/ccc/fff.jpg"  class="img-responsive"></a> -->
  </div>
  <!-- /ad -->
  <!-- loginForm -->
  <div id="loginForm" class="col-sm-7">
    <div class="box clearfix">
      <h3>パスワード再設定</h3>
      <form id="login" action="/mypage/passwordchange" accept-charset="utf-8" method="post">
        <?php echo \Form::csrf(); ?>
        <div class="form-group">
          <input type="password" class="form-control" id="password" placeholder="現在のパスワード" name="password">
          <?php if (!empty($error['password'])) {echo '<span class="errorMessage">' .$error['password']. '</span>';} ?>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="new_password" placeholder="新パスワード" name="new_password">
          <?php if (!empty($error['new_password'])) {echo '<span class="errorMessage">' .$error['new_password']. '</span>';} ?>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="new_password2" placeholder="新パスワード(確認用)" name="new_password2">
          <?php if (!empty($error['new_password2'])) {echo '<span class="errorMessage">' .$error['new_password2']. '</span>';} ?>
        </div>
        <button type="submit" class="btn btn-default" style="margin-top: 10px;">変更する</button>
      </form>
    </div>
  </div>
  <!-- /loginForm -->
</div>
