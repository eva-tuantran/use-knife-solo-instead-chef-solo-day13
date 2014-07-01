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
      <?php
          if (! empty($error)):
      ?>
      <ul>
        <?php
            foreach ($error as $mesage):
        ?>
          <li class="errorMessage"><?php echo e($mesage);?></li>
        <?php
            endforeach;
        ?>
      </ul>
      <?php
          endif;
      ?>
      <form id="login" action="/reminder/resetpassword?token=<?php echo $hash; ?>" accept-charset="utf-8" method="post">
        <?php echo \Form::csrf(); ?>
        <div class="form-group text-left">
          <label for="mail" class="text-left">パスワード</label>
          <input type="password" class="form-control" id="password" name="password">
          <label for="mail" class="text-left">パスワード(確認用)</label>
          <input type="password" class="form-control" id="password2" name="password2">
        </div>
        <button type="submit" class="btn btn-default">送信する</button>
      </form>
    </div>
  </div>
  <!-- /loginForm -->
</div>
