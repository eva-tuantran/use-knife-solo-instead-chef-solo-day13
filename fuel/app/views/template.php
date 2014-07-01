<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="フリーマーケット楽市楽座">
<?php echo empty($meta) ? : Html::meta($meta);?>
<meta property="og:title" content="<?php echo @$title;?>">
<meta property="og:description" content="<?php echo @$description;?>">
<meta property="og:url" content="http://www.rakuichi-rakuza.jp/">
<meta property="og:image" content="http://www.rakuichi-rakuza.jp/assets/img/ogimage.png">
<link rel="apple-touch-icon" href="http://www.rakuichi-rakuza.jp/assets/img/ogimage.png">
<meta property="og:site_name" content="フリーマーケット楽市楽座">
<meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=yes">
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/reset.css" rel="stylesheet">
<link href="/assets/css/base.css?20140526" rel="stylesheet">
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<?php echo Asset::render('add_css', false);?>
<?php echo Asset::render('add_js', false);?>
</head>
<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KWFSV9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KWFSV9');</script>
<!-- End Google Tag Manager -->
<!-- header -->
<div id="header">
  <!-- headerBar -->
  <div id="headerBarWrap">
    <div id="headerBar" class="container">
      <div id="headerDescription" class="hidden-xs">
        <p>フリーマーケット楽市楽座の情報サイト</p>
      </div>
      <ul>
        <?php if (Auth::check()): ?>
            <li class="user">ようこそ、<?php echo e(Auth::get_screen_name());?> さん</li>
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
          <li class="market"><a href="/all"><i></i>フリマ会場一覧</a></li>
          <li class="reservation"><a href="/all?<?php echo urlencode('ac[event_status][]');?>=2"><i></i>出店予約</a></li>
          <li class="post"><a href="/fleamarket"><i></i>フリマ投稿</a></li>
          <li class="blog"><a href="/blog"><i></i>新着ブログ</a></li>
          <li class="mypage"><a href="/mypage"><i></i>マイページ</a></li>
          <li class="guide visible-xs"><a href="/guide">初めての方へ</a></li>
          <li class="inquiry visible-xs"><a href="/inquiry">お問い合せ</a></li>
        </ul>
        <?php
            if (! isset($is_top) || ! $is_top):
        ?>
        <!-- globalNavBottom -->
        <div id="globalNavBottom">
          <?php
              if (! empty($crumbs)):
          ?>
          <ul class="breadcrumb hidden-xs">
            <?php
                $crumb_count = count($crumbs);
                for ($i = 0; $i < $crumb_count; $i++):
                    if ($i === $crumb_count - 1):
            ?>
            <li class="active"><?php echo $crumbs[$i];?></li>
            <?php
                    else:
            ?>
            <li><?php echo $crumbs[$i];?></li>
            <?php
                    endif;
                endfor;
            ?>
          </ul>
          <?php
              endif;
          ?>
          <form id="form_search_keyword" action="/all" method="get">
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
      <dd><a href="/hokkaido">北海道</a></dd>
      <dd><a href="/aomori">青森</a></dd>
      <dd><a href="/iwate">岩手</a></dd>
      <dd><a href="/miyagi">宮城</a></dd>
      <dd><a href="/akita">秋田</a></dd>
      <dd><a href="/yamagata">山形</a></dd>
      <dd><a href="/fukushima">福島</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt>関東</dt>
      <dd><a href="/ibaraki">茨城</a></dd>
      <dd><a href="/tochigi">栃木</a></dd>
      <dd><a href="/gunma">群馬</a></dd>
      <dd><a href="/saitama">埼玉</a></dd>
      <dd><a href="/chiba">千葉</a></dd>
      <dd><a href="/tokyo">東京</a></dd>
      <dd><a href="/kanagawa">神奈川</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt>中部</dt>
      <dd><a href="/niigata">新潟</a></dd>
      <dd><a href="/toyama">富山</a></dd>
      <dd><a href="/ishikawa">石川</a></dd>
      <dd><a href="/fukui">福井</a></dd>
      <dd><a href="/yamanashi">山梨</a></dd>
      <dd><a href="/nagano">長野</a></dd>
      <dd><a href="/gifu">岐阜</a></dd>
      <dd><a href="/shizuoka">静岡</a></dd>
      <dd><a href="/aichi">愛知</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt>近畿</dt>
      <dd><a href="/mie">三重</a></dd>
      <dd><a href="/shiga">滋賀</a></dd>
      <dd><a href="/kyoto">京都</a></dd>
      <dd><a href="/osaka">大阪</a></dd>
      <dd><a href="/hyogo">兵庫</a></dd>
      <dd><a href="/nara">奈良</a></dd>
      <dd><a href="/wakayama">和歌山</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt>中国・四国</dt>
      <dd><a href="/tottori">鳥取</a></dd>
      <dd><a href="/shimane">島根</a></dd>
      <dd><a href="/okayama">岡山</a></dd>
      <dd><a href="/hiroshima">広島</a></dd>
      <dd><a href="/yamaguchi">山口</a></dd>
      <dd><a href="/tokushima">徳島</a></dd>
      <dd><a href="/kagawa">香川</a></dd>
      <dd><a href="/ehime">愛媛</a></dd>
      <dd><a href="/kochi">高知</a></dd>
    </dl>
    <dl class="col-sm-4">
      <dt>九州・沖縄</dt>
      <dd><a href="/fukuoka">福岡</a></dd>
      <dd><a href="/saga">佐賀</a></dd>
      <dd><a href="/nagasaki">長崎</a></dd>
      <dd><a href="/kumamoto">熊本</a></dd>
      <dd><a href="/oita">大分</a></dd>
      <dd><a href="/miyazaki">宮崎</a></dd>
      <dd><a href="/kagoshima">鹿児島</a></dd>
      <dd><a href="/okinawa">沖縄</a></dd>
    </dl>
    <ul id="footerNav" class="list-inline">
      <li><a href="/info/visitor">初めての方へ</a></li>
      <li><a href="/info/agreement">利用規約</a></li>
      <li><a href="/info/question">よくある質問</a></li>
      <li><a href="/inquiry">お問い合わせ</a></li>
      <li><a href="/info/manager">運営会社</a></li>
      <li><a href="/blog">ブログ</a></li>
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
