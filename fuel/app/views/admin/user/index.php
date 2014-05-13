<?php
    $input  = $fieldset->input();
    $errors = $fieldset->validation()->error_message();
    $fields = $fieldset->field();
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">ユーザ情報の入力</h2>
  </div>
  <div class="panel-body">
    <form action="/admin/user/confirm" method="post" class="form-inline" enctype="multipart/form-data" role="form">
      <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>">
      <div class="row">
        <div class="col-md-6">
          <table class="table">
            <tr>
              <th>ニックネーム</th>
              <td>
                <input type="text" class="form-control" name="nick_name" value="<?php echo e($fields['nick_name']->value); ?>">
                <?php
                    if (isset($errors['nick_name'])):
                        echo '<div class="error-message">' . $errors['nick_name'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>名前</th>
              <td>
                <input type="text" class="form-control" name="last_name" value="<?php echo e($fields['last_name']->value); ?>">
                <input type="text" class="form-control" name="first_name" value="<?php echo e($fields['first_name']->value); ?>">
                <?php
                    if (isset($errors['last_name'])):
                        echo '<div class="error-message">' . $errors['last_name'] . '</div>';
                    endif;
                    if (isset($errors['first_name'])):
                        echo '<div class="error-message">' . $errors['first_name'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>フリガナ</th>
              <td>
                <input type="text" class="form-control" name="last_name_kana" value="<?php echo e($fields['last_name_kana']->value); ?>">
                <input type="text" class="form-control" name="first_name_kana" value="<?php echo e($fields['first_name_kana']->value); ?>">
                <?php
                    if (isset($errors['last_name_kana'])):
                        echo '<div class="error-message">' . $errors['last_name_kana'] . '</div>';
                    endif;
                    if (isset($errors['first_name_kana'])):
                        echo '<div class="error-message">' . $errors['first_name_kana'] . '</div>';
                    endif;
                ?>
                </td>
            </tr>
            <tr>
              <th>誕生日</th>
              <td>
                <input id="birthday" type="text" class="form-control small-width" name="birthday" value="<?php echo e($fields['birthday']->value); ?>">
                <?php
                    if (isset($errors['birthday'])):
                        echo '<div class="error-message">' . $errors['birthday'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>性別</th>
              <td>
                <div class="radio">
                  <label><input type="radio" class="form-control" name="gender" value="1"<?php if ($fields['gender']->value == 1) { echo ' checked'; } ?>>男性</label>
                </div>
                <div class="radio">
                  <label><input type="radio" class="form-control" name="gender" value="2"<?php if ($fields['gender']->value == 2) { echo ' checked'; } ?>>女性</label>
                </div>
                <?php
                    if (isset($errors['gender'])):
                        echo '<div class="error-message">' . $errors['gender'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>郵便番号</th>
              <td>
                <input type="text" class="form-control small-width" name="zip" value="<?php echo e($fields['zip']->value); ?>">
                <?php
                    if (isset($errors['zip'])):
                        echo '<div class="error-message">' . $errors['zip'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>都道府県</th>
              <td>
                <select class="form-control" name="prefecture_id">
                  <option value=""></option>
                  <?php
                      foreach ($prefectures as $prefecture_id => $prefecture):
                          $selected = '';
                          if ($prefecture_id == $fields['prefecture_id']->value):
                              $selected = 'selected';
                          endif;
                  ?>
                  <option value="<?php echo $prefecture_id;?>"<?php echo $selected;?>><?php echo $prefecture;?></option>
                  <?php
                      endforeach;
                  ?>
                </select>
                <?php
                    if (isset($errors['prefecture_id'])):
                        echo '<div class="error-message">' . $errors['prefecture_id'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>住所</th>
              <td>
                <input type="text" class="large-width form-control" name="address" value="<?php echo e($fields['address']->value); ?>">
                <?php
                    if (isset($errors['address'])):
                        echo '<div class="error-message">' . $errors['address'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td>
                <input type="text" class="form-control" name="tel" value="<?php echo e($fields['tel']->value); ?>">
                <?php
                    if (isset($errors['tel'])):
                        echo '<div class="error-message">' . $errors['tel'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>電話番号（モバイル）</th>
              <td>
                <input type="text" class="form-control" name="mobile_tel" value="<?php echo e($fields['mobile_tel']->value); ?>">
                <?php
                    if (isset($errors['mobile_tel'])):
                        echo '<div class="error-message">' . $errors['mobile_tel'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td>
                <input type="text" class="form-control large-width" name="email" value="<?php echo e($fields['email']->value); ?>">
                <?php
                    if (isset($errors['email'])):
                        echo '<div class="error-message">' . $errors['email'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>メールアドレス（モバイル）</th>
              <td>
                <input type="text" class="form-control large-width" name="mobile_email" value="<?php echo e($fields['mobile_email']->value); ?>">
                <?php
                    if (isset($errors['mobile_email'])):
                        echo '<div class="error-message">' . $errors['mobile_email'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <?php
                if (empty($user_id)):
            ?>
            <tr>
              <th>パスワード</th>
              <td>
                <input type="text" class="form-control large-width" name="password">
                <?php
                    if (isset($errors['password'])):
                        echo '<div class="error-message">' . $errors['password'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <?php
                endif;
            ?>
            <tr>
              <th>登録元</th>
              <td>
                <select class="form-control" name="device">
                  <option value=""></option>
                  <?php
                      foreach ($devices as $device_key => $device):
                          $selected = '';
                          if ($device_key == $fields['device']->value):
                              $selected = 'selected';
                          endif;
                  ?>
                  <option value="<?php echo $device_key;?>"<?php echo $selected;?>><?php echo $device;?></option>
                  <?php
                      endforeach;
                  ?>
                </select>
                <?php
                    if (isset($errors['device'])):
                        echo '<div class="error-message">' . $errors['device'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>メールマガジン購読</th>
              <td>
                <div class="radio">
                  <label><input type="radio" class="form-control" name="mm_flag" value="1" <?php echo $fields['mm_flag']->value ? 'checked' : '';?>>購読する</label>
                </div>
                <div class="radio">
                  <label><input type="radio" class="form-control" name="mm_flag" value="0" <?php echo $fields['mm_flag']->value ? '' : 'checked';?>>購読しない</label>
                </div>
                <?php
                    if (isset($errors['mm_flag'])):
                        echo '<div class="error-message">' . $errors['mm_flag'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>管理者メモ</th>
              <td>
                <textarea class="form-control" name="admin_memo" cols="50" rows="5"><?php echo e($fields['admin_memo']->value); ?></textarea>
                <?php
                    if (isset($errors['admin_memo'])):
                        echo '<div class="error-message">' . $errors['admin_memo'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>企業・団体フラグ</th>
              <td>
                <div class="radio">
                  <label><input type="radio" class="form-control" name="organization_flag" value="0" <?php echo $fields['organization_flag']->value ? '' : 'checked';?>>個人</label>
                </div>
                <div class="radio">
                  <label><input type="radio" class="form-control" name="organization_flag" value="1" <?php echo $fields['organization_flag']->value ? 'checked' : '';?>>企業・団体</label>
                </div>
                <?php
                    if (isset($errors['organization_flag'])):
                        echo '<div class="error-message">' . $errors['organization_flag'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>登録ステータス</th>
              <td>
                <?php
                    foreach ($register_statuses as $register_status_key => $register_status):
                        $checked = '';
                        if ($register_status_key == $fields['register_status']->value):
                            $checked = 'checked';
                        endif;
                ?>
                <div class="radio">
                  <label><input type="radio" class="form-control" name="register_status" value="<?php echo $register_status_key;?>"<?php echo $checked;?>><?php echo $register_status;?></label>
                </div>
                <?php
                    endforeach;
                ?>
                <?php
                    if (isset($errors['register_status'])):
                        echo '<div class="error-message">' . $errors['register_status'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>最終ログイン時刻</th>
              <td> <?php echo e($fields['last_login']->value); ?></td>
            </tr>
          </table>
        </div>
        <div class="col-md-12 btn-group">
          <button type="submit" class="btn btn-info">内容を確認する</button>
        </div>
      </div>
    </form>
  </div>
  <div class="panel-footer">
    <div class="row">
        <div class="col-md-1">登録日時</div>
        <div class="col-md-2"><?php
            if (isset($fields)):
               echo e($fields['created_at']->value);
            endif;
        ?></div>
        <div class="col-md-1">更新日時</div>
        <div class="col-md-2"><?php
            if (isset($fields)):
               echo e($fields['updated_at']->value);
            endif;
        ?></div>
    </div>
  </div>
</div>
