<h2>ログインページ</h2>

<div class="container">
  <div class="row">
    <div class="col-md-9">
      <div class="thumbnail">
        <img data-src="holder.js/815x503" alt="thumbnail">
      </div>
    </div>
    <div class="col-md-3">
      <div class="panel panel-default panel-primary">
        <div class="panel-body">

          <?php if($error_message): ?>
            <div class="col-xs-12 alert-danger"><?php echo $error_message ?></div>
          <?php endif ?>

          <?php if($info_message): ?>
            <div class="col-xs-12 alert-info"><?php echo $info_message ?></div>
          <?php endif ?>

          <form id="login" action="/login/auth?rurl=<?php echo $return_url; ?>" accept-charset="utf-8" method="post">
            <?php echo \Form::csrf(); ?>
            <label id="label_email" for="form_email">メールアドレス</label>
            <input id="form_email" name="email" type="text" value="">
            <label id="label_password" for="form_password">パスワード</label>
            <input id="form_password" name="password" type="password" value="">
            <input type="submit" name="submit" class="btn btn-primary" value="ログイン">
          </form>

          <ul style="padding-left: 0px; margin-top: 10px;">
            <li>パスワードを忘れた方は<a href="#" target="_blank">コチラ</a></li>
            <li>よくある質問は<a href="#" target="_blank">コチラ</a></li>
          </ul>
        </div>

      </div>
    </div>
  </div>
</div>
