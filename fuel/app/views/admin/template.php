<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/admin.css" rel="stylesheet">
    <?php echo Asset::render('add_css');?>
    <?php echo Asset::render('add_js');?>
  </head>
  <body>
    <nav role="navigation" class="navbar navbar-default navbar-fixed-top">
      <!-- We use the fluid option here to avoid overriding the fixed width of a normal container within the narrow content columns. -->
      <div class="container-fluid">
        <div class="navbar-header">
          <button data-target="#bs-example-navbar-collapse-6" data-toggle="collapse" class="navbar-toggle" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="/admin/index" class="navbar-brand">楽市楽座</a>
        </div>
        <?php if ($is_login):?>
        <div id="bs-example-navbar-collapse-6" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/admin/fleamarket/list">フリマ</a></li>
            <li><a href="/admin/entry/list">予約</a></li>
            <li><a href="/admin/location/list">会場</a></li>
            <li><a href="/admin/user/list">ユーザ</a></li>
            <li><a href="/admin/mailmagazine/list">メルマガ</a></li>
            <li><a href="/admin/index/logout">ログアウト</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
        <?php endif;?>
      </div>
    </nav>
    <div id="container-wrap">
      <div class="container-fluid">
        <?php echo $content; ?>
      </div>
    </div>
    <div id="dialog" style="text-align: left; padding: 20px; display: none;">
      <p id="message"></p>
    </div>
  </body>
</html>
