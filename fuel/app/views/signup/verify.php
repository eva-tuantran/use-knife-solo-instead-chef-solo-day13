<div id="contentForm" class="row">
  <!-- flow -->
  <div id="flow" class="row hidden-xs">
    <div class="steps col-sm-3">
      <div class="box clearfix"><span class="step">STEP1.</span>登録内容の入力</div>
    </div>
    <div class="steps col-sm-3">
      <div class="box clearfix"><span class="step">STEP2.</span>内容確認</div>
    </div>
    <div class="steps col-sm-3">
      <div class="box active clearfix"><span class="step">STEP3.</span>仮登録メール送信</div>
    </div>
    <div class="steps col-sm-3">
      <div class="box clearfix"><span class="step">STEP4.</span>登録完了</div>
    </div>
  </div>
  <!-- /flow -->
  <!-- form -->
  <div id="form" class="container">
    <div class="box clearfix">
    <h3>仮登録メールを送信しました</h3>
    <p>
    下記のメールアドレスに登録用URLを記載したメールを送信しました。
    </p>
    <p style="padding:20px; text-align:center;"> <?php echo $user_input['email']; ?> </p>
    <p>
    登録用URLにアクセスして、店舗情報を登録してください。
    </p>
    <ul>
        <li>※回線の混雑状況によってはメールが届かない場合もございます。</li>
        <li>※メールが届かない場合は<a href="#">コチラ</a></li>
    </ul>
  </div>
  <!-- /form -->
</div>
