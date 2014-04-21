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
<?php if (! empty($meta)) { echo Html::meta($meta); }; ?>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/reset.css" rel="stylesheet">
<link href="/assets/css/base.css" rel="stylesheet">
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<?php echo Asset::render('add_css', false);?>
<?php echo Asset::render('add_js', false);?>
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
            <li class="login"><a href="/login/out"><i></i>ログアウト</a></li>
        <?php else: ?>
            <li class="user">ようこそ、ゲストさん</li>
            <li class="login"><a href="/login"><i></i>ログイン</a></li>
            <li class="regist"><a href="/signup"><i></i>会員登録</a></li>
        <?php endif; ?>
        <li class="guide hidden-xs"><a href="/info/visitor"><i></i>初めての方へ</a></li>
        <li class="inquiry hidden-xs"><a href="/inquiry"><i></i>お問い合せ</a></li>
      </ul>
    </div>
  </div>
  <!-- /headerBar -->
  <!-- globalNav -->
  <nav class="navbar navbar-default">
    <div id="globalNavBar" class="container">
      <h1><a href="/"><img src="/assets/img/logo.png" alt="楽市楽座" width="240" height="40"></a></h1>
      <button class="navbar-toggle" data-toggle="collapse" data-target=".target"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <div class="collapse navbar-collapse target">
        <ul id="globalNav">
          <li class="market"><a href="/search/1"><i></i>フリマ会場一覧</a></li>
          <li class="reservation"><a href="/search?reservation=1"><i></i>出店予約</a></li>
          <li class="post"><a href="/fleamarket"><i></i>フリマ投稿</a></li>
          <!-- <li class="news"><a href="/news"><i></i>新着情報</a></li> -->
          <li class="blog"><a href="http://aucfan.com/article/" target="_blank"><i></i>新着ブログ(仮)</a></li>
          <li class="mypage"><a href="/mypage"><i></i>マイページ</a></li>
          <li class="guide visible-xs"><a href="/guide">初めての方へ</a></li>
          <li class="inquiry visible-xs"><a href="/inquiry">お問い合せ</a></li>
        </ul>
        <?php
	   if (! isset($is_top) || ! $is_top):
        ?>
        <!-- globalNavBottom -->
        <div id="globalNavBottom">
          <ul class="breadcrumb hidden-xs">
            <li><a href="/">ホーム</a></li>
            <li class="active"><?php echo $title; ?></li>
          </ul>
          <form id="form_search_calendar" action="/search/1" method="get">
            <input type="text" class="form-control" id="keywordInput" placeholder="キーワードを入力" name="c[keyword]">
          </form>
        </div>
        <!-- /globalNavBottom -->
        <?php
            endif;
        ?>
      </div>
    </div>
  </nav>
<!-- /globalNav -->
</div>
<!-- /header -->

<!-- content -->
<div id="contentWrap" class="container">
  <?php echo $content; ?>
</div>
<!-- /content -->
<!-- footer -->
<div id="footerWrap">
  <div id="footerLink">
    <ul class="container">
      <li class="col-sm-3"><a href="/info"><i></i>フリマ開催地大募集</a></li>
      <li class="col-sm-3"><a href="/info/staff"><i></i>フリマスタッフ大募集</a></li>
      <li class="col-sm-3"><a href="/info/food"><i></i>飲食出店をお考えの方</a></li>
      <li class="col-sm-3"><a href="/info/corporation"><i></i>企業出店をお考えの方</a></li>
    </ul>
  </div>
  <div id="footer" class="container">
    <dl class="col-sm-4">
      <dt>北海道・東北</dt>
      <dd><a href="/search/1?prefecture=hokkaido">北海道</a></dd>
      <dd><a href="/search/1?prefecture=aomori">青森</a></dd>
      <dd><a href="/search/1?prefecture=iwate">岩手</a></dd>
      <dd><a href="/search/1?prefecture=miyagi">宮城</a></dd>
      <dd><a href="/search/1?prefecture=akita">秋田</a></dd>
      <dd><a href="/search/1?prefecture=yamagata">山形</a></dd>
      <dd><a href="/search/1?prefecture=fukushima">福島</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt>関東</dt>
      <dd><a href="/search/1?prefecture=ibaraki">茨城</a></dd>
      <dd><a href="/search/1?prefecture=tochigi">栃木</a></dd>
      <dd><a href="/search/1?prefecture=gunma">群馬</a></dd>
      <dd><a href="/search/1?prefecture=saitama">埼玉</a></dd>
      <dd><a href="/search/1?prefecture=chiba">千葉</a></dd>
      <dd><a href="/search/1?prefecture=tokyo">東京</a></dd>
      <dd><a href="/search/1?prefecture=kanagawa">神奈川</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt>中部</dt>
      <dd><a href="/search/1?prefecture=niigata">新潟</a></dd>
      <dd><a href="/search/1?prefecture=toyama">富山</a></dd>
      <dd><a href="/search/1?prefecture=ishikawa">石川</a></dd>
      <dd><a href="/search/1?prefecture=fukui">福井</a></dd>
      <dd><a href="/search/1?prefecture=yamanashi">山梨</a></dd>
      <dd><a href="/search/1?prefecture=nagano">長野</a></dd>
      <dd><a href="/search/1?prefecture=gifu">岐阜</a></dd>
      <dd><a href="/search/1?prefecture=shizuoka">静岡</a></dd>
      <dd><a href="/search/1?prefecture=aichi">愛知</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt>近畿</dt>
      <dd><a href="/search/1?prefecture=mie">三重</a></dd>
      <dd><a href="/search/1?prefecture=shiga">滋賀</a></dd>
      <dd><a href="/search/1?prefecture=kyoto">京都</a></dd>
      <dd><a href="/search/1?prefecture=osaka">大阪</a></dd>
      <dd><a href="/search/1?prefecture=hyogo">兵庫</a></dd>
      <dd><a href="/search/1?prefecture=nara">奈良</a></dd>
      <dd><a href="/search/1?prefecture=wakayama">和歌山</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt>中国・四国</dt>
      <dd><a href="/search/1?prefecture=tottori">鳥取</a></dd>
      <dd><a href="/search/1?prefecture=shimane">島根</a></dd>
      <dd><a href="/search/1?prefecture=okayama">岡山</a></dd>
      <dd><a href="/search/1?prefecture=hiroshima">広島</a></dd>
      <dd><a href="/search/1?prefecture=yamaguchi">山口</a></dd>
      <dd><a href="/search/1?prefecture=tokushima">徳島</a></dd>
      <dd><a href="/search/1?prefecture=kagawa">香川</a></dd>
      <dd><a href="/search/1?prefecture=ehime">愛媛</a></dd>
      <dd><a href="/search/1?prefecture=kochi">高知</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt>九州・沖縄</dt>
      <dd><a href="/search/1?prefecture=fukuoka">福岡</a></dd>
      <dd><a href="/search/1?prefecture=saga">佐賀</a></dd>
      <dd><a href="/search/1?prefecture=nagasaki">長崎</a></dd>
      <dd><a href="/search/1?prefecture=kumamoto">熊本</a></dd>
      <dd><a href="/search/1?prefecture=oita">大分</a></dd>
      <dd><a href="/search/1?prefecture=miyazaki">宮崎</a></dd>
      <dd><a href="/search/1?prefecture=kagoshima">鹿児島</a></dd>
      <dd><a href="/search/1?prefecture=okinawa">沖縄</a></dd>
    </dl>
    <ul id="footerNav" class="list-inline">
      <li><a href="/info/visitor">初めての方へ</a></li>
      <li><a href="/info/agreement">利用規約</a></li>
      <li><a href="/info/question">よくある質問</a></li>
      <li><a href="/inquiry">お問い合わせ</a></li>
      <li><a href="/info/manager">運営会社</a></li>
      <li><a href="http://aucfan.com/article/">ブログ</a></li>
      <li><a href="/info/policy">プライバシーポリシー</a></li>
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
