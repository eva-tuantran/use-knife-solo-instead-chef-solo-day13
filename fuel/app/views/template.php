<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリマ・フリーマーケットの全国開催情報 - フリーマーケット楽市楽座 - <?php echo $title; ?></title>
<meta name="keywords" content="フリーマーケット,フリマ,楽市楽座,オークファン">
<meta name="author" content="フリーマーケット楽市楽座">
<meta property="og:title" content="フリーマーケット楽市楽座">
<meta property="og:description" content="フリーマーケット・フリマの全国開催情報、出店参加者受付中!週末や休日は楽市フリーマーケットへ行こう!開催エリア日本一!出店無料イベントや大型イベントも多数実施中。">
<meta property="og:url" content="http://www.rakuichi-rakuza.jp/">
<meta property="og:image" content="http://www.rakuichi-rakuza.jp/assets/img/ogimage.png">
<link rel="apple-touch-icon" href="http://www.rakuichi-rakuza.jp/assets/img/ogimage.png">
<meta property="og:site_name" content="フリーマーケット楽市楽座">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/reset.css" rel="stylesheet">
<link href="/assets/css/base.css" rel="stylesheet">
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/jquery.carouFredSel.js"></script>
<?php echo Asset::css('style.css');?>
<?php echo Asset::render('add_css');?>
<?php echo Asset::render('add_js');?>
</head>
<body>
<!-- header -->
<div id="header">
  <!-- headerBar -->
  <div id="headerBarWrap">
    <div id="headerBar" class="container">
      <div id="headerDescription" class="hidden-xs">
        <p>フリーマーケット楽市楽座の情報サイト</p>
      </div>
      <ul>
        <?php if(Auth::check()): ?>
            <li class="user">ようこそ、<?php echo Auth::get_screen_name(); ?> さん</li>
            <li><a href="/mypage">マイページ</a></li>
            <li><a href="/login/out">ログアウト</a></li>
        <?php else: ?>
            <li class="user">ようこそ、ゲストさん</li>
            <li><a href="/login">ログイン</a></li>
            <li><a href="/signup">会員登録</a></li>
        <?php endif; ?>
        <li class="guide hidden-xs"><a href="/guide"><i></i>初めての方へ</a></li>
        <li class="inquiry hidden-xs"><a href="/inquiry"><i></i>お問い合せ</a></li>
      </ul>
    </div>
  </div>
  <!-- /headerBar -->
  <!-- globalNav -->
  <nav class="navbar navbar-default">
  <div id="globalNavBar" class="container">
    <h1><a href="/"><img src="/assets/img/logo.png" alt="楽市楽座" width="180" height="29"></a></h1>
    <button class="navbar-toggle" data-toggle="collapse" data-target=".target"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    <div class="collapse navbar-collapse target">
      <ul id="globalNav">
        <li class="market"><a href="/search"><i></i>会場一覧</a></li>
        <li class="reservation"><a href="/reservation"><i></i>出店予約</a></li>
        <li class="news"><a href="/news"><i></i>新着情報</a></li>
        <li class="blog"><a href="/blog"><i></i>ブログ</a></li>
        <li class="mypage"><a href="/mypage"><i></i>マイページ</a></li>
        <li class="guide visible-xs"><a href="/guide">初めての方へ</a></li>
        <li class="inquiry visible-xs"><a href="/inquiry">お問い合せ</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- /globalNav -->
</div>
<!-- /header -->

<!-- content -->
<div id="contentWrap" class="container">
  <div id="contentHome" class="row">
    <?php echo $content; ?>
  </div>
</div>
<!-- /content -->
<!-- footer -->
<div id="footerWrap">
  <div id="footerLink">
    <ul class="container">
      <li class="col-sm-3"><a href="#"><i></i>フリマ開催地大募集</a></li>
      <li class="col-sm-3"><a href="#"><i></i>フリマスタッフ大募集</a></li>
      <li class="col-sm-3"><a href="#"><i></i>飲食出店をお考えの方</a></li>
      <li class="col-sm-3"><a href="#"><i></i>企業出店をお考えの方</a></li>
    </ul>
  </div>
  <div id="footer" class="container">
    <dl class="col-sm-4">
      <dt><a href="">北海道・東北</a></dt>
      <dd><a href="">北海道</a></dd>
      <dd><a href="">青森</a></dd>
      <dd><a href="">岩手</a></dd>
      <dd><a href="">宮城</a></dd>
      <dd><a href="">秋田</a></dd>
      <dd><a href="">山形</a></dd>
      <dd><a href="">福島</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt><a href="">関東</a></dt>
      <dd><a href="">茨城</a></dd>
      <dd><a href="">栃木</a></dd>
      <dd><a href="">群馬</a></dd>
      <dd><a href="">埼玉</a></dd>
      <dd><a href="">千葉</a></dd>
      <dd><a href="">東京</a></dd>
      <dd><a href="">神奈川</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt><a href="">中部</a></dt>
      <dd><a href="">新潟</a></dd>
      <dd><a href="">富山</a></dd>
      <dd><a href="">石川</a></dd>
      <dd><a href="">福井</a></dd>
      <dd><a href="">山梨</a></dd>
      <dd><a href="">長野</a></dd>
      <dd><a href="">岐阜</a></dd>
      <dd><a href="">静岡</a></dd>
      <dd><a href="">愛知</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt><a href="">近畿</a></dt>
      <dd><a href="">三重</a></dd>
      <dd><a href="">滋賀</a></dd>
      <dd><a href="">京都</a></dd>
      <dd><a href="">大阪</a></dd>
      <dd><a href="">兵庫</a></dd>
      <dd><a href="">奈良</a></dd>
      <dd><a href="">和歌山</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt><a href="">中国・四国</a></dt>
      <dd><a href="">鳥取</a></dd>
      <dd><a href="">島根</a></dd>
      <dd><a href="">岡山</a></dd>
      <dd><a href="">広島</a></dd>
      <dd><a href="">山口</a></dd>
      <dd><a href="">徳島</a></dd>
      <dd><a href="">香川</a></dd>
      <dd><a href="">愛媛</a></dd>
      <dd><a href="">愛知</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt><a href="">九州・沖縄</a></dt>
      <dd><a href="">福岡</a></dd>
      <dd><a href="">佐賀</a></dd>
      <dd><a href="">長崎</a></dd>
      <dd><a href="">熊本</a></dd>
      <dd><a href="">大分</a></dd>
      <dd><a href="">宮崎</a></dd>
      <dd><a href="">鹿児島</a></dd>
      <dd><a href="">沖縄</a></dd>
    </dl>
    <ul id="footerNav" class="list-inline">
      <li><a href="">初めての方へ</a></li>
      <li><a href="">利用規約</a></li>
      <li><a href="">お問い合わせ</a></li>
      <li><a href="">運営会社</a></li>
      <li><a href="">サイトマップ</a></li>
      <li><a href="">モバイルサイト</a></li>
      <li><a href="">ブログ</a></li>
      <li><a href="">プライバシーポリシー</a></li>
      <li><a href="">リンク集</a></li>
    </ul>
    <div class="copyright pull-right">
      <p>&copy;楽市楽座</p>
    </div>
  </div>
</div>
<!-- /footer -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</body>
</html>
