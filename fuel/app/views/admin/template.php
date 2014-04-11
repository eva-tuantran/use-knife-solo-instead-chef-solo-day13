<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<script src="/assets/js/jquery.min.js"></script>
</head>
<body>
<head>
  <script src="/assets/js/jquery.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
  <?php echo Asset::render('add_css');?>
  <?php echo Asset::render('add_js');?>
</head>
<body>
  <?php echo $content; ?>
</body>
</html>
