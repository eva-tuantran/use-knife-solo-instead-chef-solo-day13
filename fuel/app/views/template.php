<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo $title; ?></title>
<?php echo Asset::css('bootstrap.min.css');?>
<?php echo Asset::css('navbar-static-top.css');?>
<?php echo Asset::css('style.css');?>
<?php echo Asset::render('add_css');?>
<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]>
  <script src="../../assets/js/ie8-responsive-file-warning.js"></script>
<![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<?php echo Asset::render('add_js');?>
</head>

<body>

<!-- Static navbar -->
<div class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">楽市楽座V2</a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">開催日程</a></li>
        <li><a href="#about">会場一覧</a></li>
        <li><a href="#contact">出店予約</a></li>
        <li><a href="#contact">出店予約</a></li>
        <li><a href="#contact">新着情報</a></li>
        <li><a href="#contact">初めての方へ</a></li>
        <li><a href="#contact">ブログ</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="./login">ログイン</a></li>
        <li><a href="../navbar-fixed-top/">ログアウト</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>


<!-- Container -->
<div class="container">
  <!-- Contents -->
  <div class="contents">
    <?php if (Session::get_flash('notice')): ?>
    <div class="notice"><p><?php echo implode('</p><p>', (array) Session::get_flash('notice')); ?></div></p>
    <?php endif; ?>
    <?php echo $content; ?>
  </div>
</div> <!-- /container -->


</body>
</html>
