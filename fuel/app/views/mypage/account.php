<h2>マイページ</h2>

<div class="container">
  <div class="row">
    <div class="col-md-2">
      <div class="panel panel-info">
        <img data-src="holder.js/158x158" alt="thumbnail">
        ようこそ <?php echo Auth::get_screen_name(); ?> さん
        <ul>
          <li><a href="/mypage">フリマ登録情報</a></li>
          <li>アカウント設定</a></li>
          <li><a href="/login/out">ログアウト</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-10">
      <div class="panel panel-default panel-primary">
        <div class="panel-heading">ユーザ情報変更</div>
          <?php if(isset($error_message)): ?>
            <div class="col-xs-12 alert-danger"><?php echo $error_message ?></div>
          <?php endif ?>

          <?php if(isset($info_message)): ?>
            <div class="col-xs-12 alert-info"><?php echo $info_message ?></div>
          <?php endif ?>
        <div class="panel-body">
            <?php echo $user_account_form ?>
        </div>
      </div>
    </div>
  </div>
</div>




