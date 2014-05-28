<?php
    $input  = $fieldset->input();
    $errors = $fieldset->validation()->error_message();
    $fields = $fieldset->field();
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">ユーザ情報の確認</h2>
  </div>
  <div class="panel-body">
    <form action="/admin/user/thanks" method="post" class="form-horizontal">
      <input type="hidden" name="user_id" value="<?php echo e($user_id);?>">
      <?php echo Form::csrf();?>
      <div class="row">
        <div class="col-md-6">
          <table class="table table-fixed">
            <tr>
              <th>ニックネーム</th>
              <td><?php echo e($input['nick_name']);?></td>
            </tr>
            <tr>
              <th>氏名</th>
              <td><?php echo e($input['last_name']);?>&nbsp;<?php echo e($input['first_name']);?></td>
            </tr>
            <tr>
              <th>フリガナ</th>
              <td><?php echo e($input['last_name_kana']); ?>&nbsp;<?php echo e($input['first_name_kana']);?></td>
            </tr>
            <tr>
              <th>誕生日</th>
              <td><?php echo e($input['birthday']);?></td>
            </tr>
            <tr>
              <th>性別</th>
              <td><?php
                  if ($input['gender'] == \Model_User::GENDER_MALE):
                      echo '男性';
                  elseif ($input['gender'] == \Model_User::GENDER_FEMALE):
                      echo '女性';
                  endif;
              ?></td>
            </tr>
            <tr>
              <th>都道府県</th>
              <td><?php echo e($prefectures[$input['prefecture_id']]);?></td>
            </tr>
            <tr>
              <th>住所</th>
              <td><?php echo e($input['address']);?></td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td><?php echo e($input['tel']);?></td>
            </tr>
            <tr>
              <th>電話番号（モバイル）</th>
              <td><?php echo e($input['mobile_tel']);?></td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td><?php echo e($input['email']);?></td>
            </tr>
            <tr>
              <th>メールアドレス（モバイル）</th>
              <td><?php echo e($input['mobile_email']);?></td>
            </tr>
            <tr>
              <th>登録元</th>
              <td><?php echo e($devices[$input['device']]);?></td>
            </tr>
            <?php
                if (empty($user_id)):
            ?>
            <tr>
              <th>パスワード</th>
              <td><?php echo e($input['password']);?></td>
            </tr>
            <?php
                endif;
            ?>
            <tr>
              <th>管理者メモ</th>
              <td><?php echo e($input['admin_memo']);?></td>
            </tr>
            <tr>
              <th>企業・団体フラグ</th>
              <td><?php
                  if ($input['organization_flag'] == \Model_User::ORGANIZATION_FLAG_OFF):
                      echo '個人';
                  elseif ($input['organization_flag'] == \Model_User::ORGANIZATION_FLAG_ON):
                      echo '企業・団体';
                  endif;
              ?></td>
            </tr>
            <tr>
              <th>登録ステータス</th>
              <td><?php echo e($register_statuses[$input['register_status']]);?></td>
            </tr>
            <tr>
              <th>最終ログイン時刻</th>
              <td><?php echo e($input['last_login']);?></td>
            </tr>
          </table>
        </div>
        <div class="col-md-12 btn-group">
          <button type="submit" class="btn btn-primary">登録する</button>
        </div>
      </div>
    </form>
  </div>
  <div class="panel-footer">
    <div class="row">
        <div class="col-md-1">登録日時</div>
        <div class="col-md-2"><?php
            if (isset($user)):
               echo e($user->created_at);
            endif;
        ?></div>
        <div class="col-md-1">更新日時</div>
        <div class="col-md-2"><?php
            if (isset($user)):
               echo e($user->updated_at);
            endif;
        ?></div>
    </div>
  </div>
</div>
