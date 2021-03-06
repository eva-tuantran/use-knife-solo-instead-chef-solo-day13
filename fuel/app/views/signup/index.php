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

    <div class="box clearfix">
      <h3>お客様情報入力欄</h3>
      <form class="form-horizontal" action="/signup/confirm" method="POST">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputName">お名前 *</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputName_last" placeholder="姓を入力" name="last_name" style="width: 10em; float: left; margin-right: 10px;" value="<?php echo $input['last_name'] ?>" required/>
            <input type="text" class="form-control" id="inputName_first" placeholder="名を入力" name="first_name" style="width: 10em;" value="<?php echo $input['first_name'] ?>" required/>
            <?php if (isset($errors['last_name']) || isset($errors['first_name'])): ?>
              <span class="errorMessage">名前は必須入力です</span>
            <?php endif; ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPhonetic">フリガナ *</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputPhonetic_last" placeholder="セイを入力" name="last_name_kana" style="width: 10em; float: left; margin-right: 10px;" value="<?php echo $input['last_name_kana'] ?>" required/>
            <input type="text" class="form-control" id="inputPhonetic_first" placeholder="メイを入力" name="first_name_kana" style="width: 10em;" value="<?php echo $input['first_name_kana'] ?>" required/>
            <?php if (isset($errors['last_name_kana']) || isset($errors['first_name_kana'])): ?>
              <span class="errorMessage">正しいカナを入力して下さい</span>
            <?php endif; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputGender">性別<br>
         （任意）</label>
          <div id="radio" class="col-sm-10">
            <input type="radio" id="inputGender" name="gender" value="1" <?php if($input['gender'] === 1) echo 'checked'; ?> />男性
            <input type="radio" id="inputGender" name="gender" value="2" <?php if($input['gender'] === 2) echo 'checked'; ?> />女性
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputBirthday">誕生日<br>
         （任意）</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputBirthday" name="birthday" min="1900-01-01" max="<?php echo date('Y-m-d'); ?>" style="width: 12em;" value="<?php echo $input['birthday']; ?>" />
          </div>
        </div>
        <div class="form-group form-address">
          <label class="col-sm-2 control-label" for="inputAddress">ご住所 *</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputZip" placeholder="例）123-4567" name="zip" value="<?php echo $input['zip'] ?>" required/>
            <button type="button" class="btn btn-default" onclick="AjaxZip3.zip2addr('zip','','prefecture_id','address'); return false;">住所を検索</button>
            <select class="form-control" name="prefecture_id">
              <option>都道府県</option>
              <?php foreach ($prefectures as $prefecture_id => $name): ?>
                <option value="<?php echo $prefecture_id; ?>" <?php if($input['prefecture_id'] == $prefecture_id):?>selected<?php endif; ?> name='pref01'><?php echo $name; ?></option>
              <?php endforeach; ?>
            </select>
            <input type="text" class="form-control" id="inputAddress" placeholder="住所を入力" name="address" value="<?php echo $input['address'] ?>" required/>
            <?php if (isset($errors['zip'])) { echo '<span class="errorMessage">' .$errors['zip']. '</span>'; } ?>
            <?php if (isset($errors['prefecture_id'])) { echo '<span class="errorMessage">' .$errors['prefecture_id']. '</span>'; } ?>
            <?php if (isset($errors['address'])) { echo '<span class="errorMessage">' .$errors['address']. '</span>'; } ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputTel">電話番号 *</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputTel" placeholder="例）03-1234-5678　半角英数字で入力してください" name="tel" value="<?php echo $input['tel'] ?>" required/>
            <?php if (isset($errors['tel'])) { echo '<span class="errorMessage">' .$errors['tel']. '</span>'; } ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEmail">E-mailアドレス *</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail" placeholder="例）your@email.com　半角英数字で入力してください" name="email" value="<?php echo $input['email'] ?>" required/>
            <?php if (isset($errors['email'])) { echo '<span class="errorMessage">' .$errors['email']. '</span>'; } ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEmail2">E-mailアドレス *<br>
            （確認用）</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="inputEmail2" placeholder="確認のため、もう一度メールアドレスを入力してください" name="email2" value="<?php echo $input['email2'] ?>" required/>
              <?php if (isset($errors['email2'])) { echo '<span class="errorMessage">' .$errors['email2']. '</span>'; } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputPassword">パスワード *</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="inputPassword" placeholder="半角英数字6文字以上で入力してください" name="password" value="<?php echo $input['password'] ?>"required/>
              <?php if (isset($errors['password'])) { echo '<span class="errorMessage">' .$errors['password']. '</span>'; } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputPassword2">パスワード *<br>
              （確認用）</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword2" placeholder="確認のため、もう一度パスワードを入力してください" name="password2" value="<?php echo $input['password2'] ?>" required/>
                <?php if (isset($errors['password2'])) { echo '<span class="errorMessage">' .$errors['password2']. '</span>'; } ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="inputNickname">ニックネーム *</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputNickname" placeholder="ニックネームを入力" name="nick_name" value="<?php echo $input['nick_name'] ?>" required/>
                <?php if (isset($errors['nick_name'])) { echo '<span class="errorMessage">' .$errors['nick_name']. '</span>'; } ?>
              </div>
            </div>

          <div class="form-group">
              <label class="col-sm-2 control-label" for="inputMm_flag">メールマガジン購読  *</label>
              <div id="radio" class="col-sm-10">
                <input type="radio" name="mm_flag" id="inputMm_flag" value="1" checked />購読する
                <input type="radio" name="mm_flag" id="inputMm_flag" value="0" />購読しない
                <?php if (isset($errors['mm_flag'])) { echo '<span class="errorMessage">' .$errors['mm_flag']. '</span>'; } ?>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="terms">利用規約 *</label>
              <div class="col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="terms" value="agree" <?php if(isset($input['terms'])):?>checked<?php endif ?>>
                    利用規約に同意する。 <br>
                    <a href="/info/agreement" target="_blank">規約の確認はコチラ（別ウィンドウで開きます）</a> </label>
                  </div>
                  <?php if (isset($errors['terms'])) { echo '<span class="errorMessage">' .$errors['terms']. '</span>'; } ?>
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

