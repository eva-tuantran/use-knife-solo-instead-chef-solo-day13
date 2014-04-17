<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <?php echo Asset::render('add_css');?>
    <?php echo Asset::render('add_js');?>
  </head>
  <body>
    <a href="/admin/user/list">ユーザー</a>
    <a href="/admin/fleamarket/list">開催</a>
    <a href="/admin/logout">ログアウト</a>
    <hr>
    <?php echo $content; ?>
  </body>
</html>
