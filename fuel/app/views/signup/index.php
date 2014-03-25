<div id="contentForm" class="row">
  <!-- flow -->
  <div id="flow" class="row hidden-xs">
    <div class="steps col-sm-3">
      <div class="box active clearfix"><span class="step">STEP1.</span>登録内容の入力</div>
    </div>
    <div class="steps col-sm-3">
      <div class="box clearfix"><span class="step">STEP2.</span>内容確認</div>
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

    <?php echo $errmsg ?>
    <div class="box clearfix">
      <h3>お客様情報入力欄</h3>
      <form class="form-horizontal" action="/signup/confirm" method="POST">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputName">お名前</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputName_last" placeholder="姓" name="last_name" />
            <input type="text" class="form-control" id="inputName_first" placeholder="名" name="first_name" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPhonetic">フリガナ</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputPhonetic_last" placeholder="セイ" name="last_name_kana" />
            <input type="text" class="form-control" id="inputPhonetic_first" placeholder="メイ" name="first_name_kana" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputAddress">ご住所</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputZip" placeholder="郵便番号" name="zip" />
            <input type="text" class="form-control" id="inputAddress" placeholder="ご住所" name="address" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputTel">電話番号</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputTel" placeholder="電話番号" name="tel" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEmail">E-mailアドレス</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail" placeholder="E-mailアドレス" name="email" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEmail2">E-mailアドレス<br>
            （確認用）</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail2" placeholder="E-mailアドレス（確認用）" name="email-confirm" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPassword">パスワード</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="パスワード" name="password" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPassword2">パスワード<br>
            （確認用）</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword2" placeholder="パスワード（確認用）" name="password-confirm" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputNickname">ニックネーム</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputNickname" placeholder="ニックネーム" name="nick_name" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="terms">利用規約</label>
          <div class="col-sm-10">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="terms">
                利用規約に同意する。 <br>
                <a href="#" target="_blank">規約の確認はコチラ（別ウィンドウで開きます）</a> </label>
            </div>
          </div>
        </div>
        <div id="submitButton" class="form-group">
          <button type="submit" class="btn btn-default">内容を確認する</button>
        </div>
      </form>
    </div>
  </div>
  <!-- /form -->
</div>

