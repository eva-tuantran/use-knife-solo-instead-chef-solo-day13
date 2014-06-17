<div id="contentForm" class="row">
  <!-- flow -->
  <div id="flow" class="row hidden-xs">
    <div class="steps col-sm-3">
      <div class="box clearfix"><span class="step">STEP1.</span>登録内容の入力</div>
    </div>
    <div class="steps col-sm-3">
      <div class="box active clearfix"><span class="step">STEP2.</span>内容確認</div>
    </div>
    <div class="steps col-sm-3">
      <div class="box clearfix"><span class="step">STEP3.</span>仮登録メール送信</div>
    </div>
    <div class="steps col-sm-3">
      <div class="box clearfix"><span class="step">STEP4.</span>登録完了</div>
    </div>
  </div>
  <!-- /flow -->
  <!-- form -->
  <div id="form" class="container">
    <div class="box clearfix">
      <h3>お客様情報入力欄</h3>
      <form class="form-horizontal" action="/signup/verify" method="POST">
        <?php echo \Form::csrf(); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputName">お名前</label>
          <div class="col-sm-10">
            <?php echo $input["last_name"]; ?>
            <?php echo $input["first_name"]; ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPhonetic">フリガナ</label>
          <div class="col-sm-10">
            <?php echo $input["last_name_kana"]; ?>
            <?php echo $input["first_name_kana"]; ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputGender">性別</label>
          <div class="col-sm-10">
            <?php if($input["gender"] === '1'): ?>
              男性
            <?php elseif($input["gender"] === '2'): ?>
              女性
            <?php else: ?>
              選択なし
            <?php endif; ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputBirthday">誕生日</label>
          <div class="col-sm-10">
            <?php if(!isset($input["birthday"]) || $input["birthday"] === ""): ?>
              選択なし
            <?php elseif(isset($input["birthday"])): ?>
              <?php echo date('Y年n月j日', strtotime($input["birthday"])); ?>
            <?php endif; ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputAddress">ご住所</label>
          <div class="col-sm-10">
            <?php echo $input["zip"]; ?>
            <?php echo $input["address"]; ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputTel">電話番号</label>
          <div class="col-sm-10">
            <?php echo $input["tel"]; ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEmail">E-mailアドレス</label>
          <div class="col-sm-10">
            <?php echo $input["email"]; ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPassword">パスワード</label>
          <div class="col-sm-10">
             セキュリティのため隠されております。
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputNickname">ニックネーム</label>
          <div class="col-sm-10">
            <?php echo $input["nick_name"]; ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputMm_flag">メールマガジン購読</label>
          <div class="col-sm-10">
            <?php if($input["mm_flag"] === '1'): ?>
              購読する
            <?php else: ?>
              購読しない
            <?php endif; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="terms">利用規約</label>
          <div class="col-sm-10">
            <p>同意する</p>
          </div>
        </div>
        <div id="submitButton" class="form-group">
          <button type="submit" class="btn btn-default">仮登録する</button>
        </div>
      </form>
    </div>
  </div>
  <!-- /form -->
</div>
