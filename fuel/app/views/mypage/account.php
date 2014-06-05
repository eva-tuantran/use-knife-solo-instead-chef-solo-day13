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
              <input type="text" name="last_name" class="form-control" id="inputName" value="<?php echo e($fields['last_name']->value); ?>" required>
              <input type="text" name="first_name" class="form-control" id="inputName" value="<?php echo e($fields['first_name']->value); ?>" required>
              <?php
                  if (isset($errors['last_name'])):
                      echo '<div class="errorMessage">' . $errors['last_name'] . '</div>';
                  endif;
                  if (isset($errors['first_name'])):
                      echo '<div class="errorMessage">' . $errors['first_name'] . '</div>';
                  endif;
              ?>

            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputPhonetic">フリガナ</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputPhonetic" name="last_name_kana" value="<?php echo e($fields['last_name_kana']->value); ?>" required>
              <input type="text" class="form-control" id="inputPhonetic" name="first_name_kana" value="<?php echo e($fields['first_name_kana']->value); ?>" required>
              <?php
                  if (isset($errors['last_name_kana'])):
                      echo '<div class="errorMessage">' . $errors['last_name_kana'] . '</div>';
                  endif;
                  if (isset($errors['first_name_kana'])):
                      echo '<div class="errorMessage">' . $errors['first_name_kana'] . '</div>';
                  endif;
              ?>
            </div>
          </div>
          <div class="form-group form-address">
            <label class="col-sm-2 control-label" for="inputAddress">ご住所</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputZip" placeholder="例）123-4567" name="zip" value="<?php echo e($fields['zip']->value);?>" required>
              <button type="submit" class="btn btn-default" onclick="AjaxZip3.zip2addr('zip','','prefecture_id','address'); return false;">住所を検索</button>
              <select name="prefecture_id" class="form-control">
                <?php foreach ($prefectures as $id => $prefecture):?>
                <option value="<?php echo $id; ?>" <?php if ($id == $fields['prefecture_id']->value) echo 'selected';?>><?php echo e($prefecture);?></option>
                <?php endforeach;?>
              </select>
              <input type="text" name="address" class="form-control" id="inputAddress" value="<?php echo e($fields['address']->value);?>" required>
              <?php
                  if (isset($errors['zip'])):
                      echo '<div class="errorMessage">' . $errors['zip'] . '</div>';
                  endif;
              ?>
              <?php
                  if (isset($errors['address'])):
                      echo '<div class="errorMessage">' . $errors['address'] . '</div>';
                  endif;
              ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputTel">電話番号</label>
            <div class="col-sm-10">
              <input type="tel" class="form-control" id="inputTel" name="tel" value="<?php echo e($fields['tel']->value); ?>" required>
              <?php
                  if (isset($errors['tel'])):
                      echo '<div class="errorMessage">' . $errors['tel'] . '</div>';
                  endif;
              ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputEmail">E-mailアドレス</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo e($fields['email']->value);?>" required>
              <?php
                  if (isset($errors['email'])):
                      echo '<div class="errorMessage">' . $errors['email'] . '</div>';
                  endif;
              ?>
            </div>
          </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="inputNickname">ニックネーム</label>
              <div class="col-sm-10">
                <input name="nick_name" class="form-control" id="inputNickname" value="<?php echo e($fields['nick_name']->value);?>" required>
                <?php
                    if (isset($errors['nick_name'])):
                        echo '<div class="errorMessage">' . $errors['nick_name'] . '</div>';
                    endif;
                ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="mailmagazine">メルマガ購読</label>
              <div class="col-sm-10">
                <div>
                  <label class="radio-inline"><input type="radio" name="mm_flag" value="1" <?php if ($fields['mm_flag']->value === '1'){echo 'checked';}?> >購読する</label>
                  <label class="radio-inline"><input type="radio" name="mm_flag" value="0" <?php if ($fields['mm_flag']->value === '0'){echo 'checked';}?> >購読しない</label>
                </div>
              </div>
            </div>
            <div id="submitButton" class="form-group">
              <button type="submit" class="btn btn-default" onclick="popup(); return false;">変更内容登録</button>
            </div>
          </form>
        </div>
      </div>
      <input type="hidden" name="user_id" value="<?php echo e(\Input::param('user_id')); ?>">
    </form>
  </div>
</div>
<script>
$(function() {
  <?php
      if ($status_code == \STATUS_PROFILE_CHANGE_SUCCESS):
  ?>
  noty({
    text: "ユーザ情報を変更しました。",
    layout: "top",
    timeout: 1500
  });
  <?php
      endif;
  ?>
});
</script>
