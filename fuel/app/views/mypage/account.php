<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $fields = $fieldset->field(); ?>

<!-- content -->
<div id="contentWrap" class="container">
  <div id="contentForm" class="row">
    <!-- form -->
    <div id="form" class="container">

      <div class="box clearfix">
        <h3>ユーザー情報の変更</h3>
        <form action="/mypage/save" method="post" class="form-horizontal" enctype="multipart/form-data">

          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputName">お名前</label>
            <div class="col-sm-10">
              <input type="text" name="last_name" class="form-control" id="inputName" value="<?php echo e($fields['last_name']->value); ?>">
              <input type="text" name="first_name" class="form-control" id="inputName" value="<?php echo e($fields['first_name']->value); ?>">
              <?php
              if (isset($errors['last_name'])) {
                echo $errors['last_name'];
              }
              if (isset($errors['first_name'])) {
                echo $errors['first_name'];
              }
              ?>

            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputPhonetic">フリガナ</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputPhonetic" name="last_name_kana" value="<?php echo e($fields['last_name_kana']->value); ?>">
              <input type="text" class="form-control" id="inputPhonetic" name="first_name_kana" value="<?php echo e($fields['first_name_kana']->value); ?>">
              <?php
              if (isset($errors['last_name_kana'])) {
                echo $errors['last_name_kana'];
              }
              if (isset($errors['first_name_kana'])) {
                echo $errors['first_name_kana'];
              }
              ?>
            </div>

          </div>
          <div class="form-group form-address">
            <label class="col-sm-2 control-label" for="inputAddress">ご住所</label>
            <div class="col-sm-10">

              <input type="text" class="form-control" id="inputZip" placeholder="例）123-4567" name="zip" value="<?php echo e($fields['zip']->value); ?>">
              <?php
              if (isset($errors['zip'])) {
                echo $errors['zip'];
              }
              ?>
              <button type="submit" class="btn btn-default" onclick="AjaxZip3.zip2addr('zip','','form-control','address'); return false;">住所を検索</button>

              <select name="form-control" class="form-control">
                <?php foreach ($prefectures as $id => $prefecture) { ?>
                <option value="<?php echo $id; ?>"<?php if ($id == $fields['prefecture_id']->value) echo ' selected=selected';?>><?php echo e($prefecture); ?></option>
                <?php } ?>
              </select>

              <input type="text" name="address" class="form-control" id="inputAddress" value="<?php echo e($fields['address']->value); ?>">
              <?php
              if (isset($errors['address'])) {
                echo $errors['address'];
              }
              ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputTel">電話番号</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputTel" name="tel" value="<?php echo e($fields['tel']->value); ?>">
              <?php
              if (isset($errors['tel'])) {
                echo $errors['tel'];
              }
              ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputEmail">E-mailアドレス</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo e($fields['email']->value); ?>">
              <?php
              if (isset($errors['email'])) {
                echo $errors['email'];
              }
              ?>
            </div>
          </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="inputNickname">ニックネーム</label>
              <div class="col-sm-10">
                <input type="text" name="nick_name" class="form-control" id="inputNickname" value="<?php echo e($fields['nick_name']->value); ?>">
                <?php
                if (isset($errors['nick_name'])) {
                  echo $errors['nick_name'];
                }
                ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="mailmagazine">メルマガ購読</label>
              <div class="col-sm-10">
                <div>
                  <label class="radio-inline"><input type="radio" name="mm_flag" value="1" <?php if(e($fields['mm_flag']->value) === '1'){echo 'checked="checked"';}?> >購読する</label>
                  <label class="radio-inline"><input type="radio" name="mm_flag" value="0" <?php if(e($fields['mm_flag']->value) === '0'){echo 'checked="checked"';}?> >購読しない</label>
                </div>
              </div>
            </div>

            <div id="submitButton" class="form-group">
              <button type="submit" class="btn btn-default">変更内容登録</button>
            </div>

          </form>
        </div>
      </div>

      <input type="hidden" name="user_id" value="<?php echo e(Input::param('user_id')); ?>">
    </form>
  </div>
</div>