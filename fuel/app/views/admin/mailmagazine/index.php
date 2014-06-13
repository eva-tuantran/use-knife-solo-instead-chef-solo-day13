<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">メルマガ登録</h2>
  </div>
  <div class="panel-body">
    <form id="mailmagazineForm" role="form" action="/admin/mailmagazine/confirm" method="post" class="form-horizontal" enctype="multipart/form-data">
      <div id="contents-wrap" class="row">
        <div class="col-md-6">
          <div class="form-group">
            <?php
                foreach ($mail_magazine_types as $mail_magazine_type_id => $mail_magazine_type_name):
            ?>
            <div class="col-md-3">
              <div class="radio">
                <label for="inputMailMagazineType_<?php echo $mail_magazine_type_id;?>" class="control-label">
                  <input id="inputMailMagazineType_<?php echo $mail_magazine_type_id;?>" class="mailMagazineType" type="radio" name="mail_magazine_type" value="<?php echo $mail_magazine_type_id;?>"><?php echo $mail_magazine_type_name;?>
                </label>
              </div>
            </div>
            <?php
                endforeach;
            ?>
            <?php
                if (isset($errors['mail_magazine_type'])):
            ?>
            <div class="error-message"><?php echo $errors['mail_magazine_type'];?></div>
            <?php
                endif;
            ?>
          </div>
          <div id="condition_4" class="form-group condition">
            <label class="col-md-2 control-label">フリマ</label>
            <div class="col-md-5">
              <select class="form-control col-md-2" name="waiting_fleamarket_id">
                <option value="">選択してください</option>
                <?php
                    foreach ($waiting_fleamarket_list as $fleamarket):
                        $event_date = date('Y年m月d日', strtotime($fleamarket->event_date));
                        $selected = '';
                        $selected = $fleamarket->fleamarket_id == @$data['waiting_fleamarket_id'] ? 'selected' : '';
                ?>
                <option value="<?php echo $fleamarket->fleamarket_id;?>" <?php echo $selected;?>>【<?php echo $event_date;?>】<?php echo e($fleamarket->name);?></option>
                <?php
                    endforeach;
                ?>
              </select>
              <div>※１カ月以内でキャンセル待ちが発生しているフリマです</div>
              <?php
                  if (isset($errors['waiting_fleamarket_id'])):
              ?>
              <div class="error-message">フリマを選択してください</div>
              <?php
                  endif;
              ?>
            </div>
          </div>
          <div id="condition_3" class="form-group condition">
            <label class="col-md-2 control-label">フリマ</label>
            <div class="col-md-5">
              <select class="form-control col-md-2" name="reserved_fleamarket_id">
                <option value="">選択してください</option>
                <?php
                    foreach ($reservation_fleamarket_list as $fleamarket):
                        $event_date = date('Y年m月d日', strtotime($fleamarket->event_date));
                        $selected = '';
                        $selected = $fleamarket->fleamarket_id == @$data['reserved_fleamarket_id'] ? 'selected' : '';
                ?>
                <option value="<?php echo $fleamarket->fleamarket_id;?>" <?php echo $selected;?>>【<?php echo $event_date;?>】<?php echo e($fleamarket->name);?></option>
                <?php
                    endforeach;
                ?>
              </select>
              <?php
                  if (isset($errors['reserved_fleamarket_id'])):
              ?>
              <div class="error-message">フリマを選択してください</div>
              <?php
                  endif;
              ?>
            </div>
          </div>
          <div id="condition_2" class="form-group condition">
            <label for="organization_flag" class="col-md-2">ユーザ種別</label>
            <div class="col-md-12">
              <div class="col-md-12 col-md-offset-1 radio clearfix">
                <?php
                    $oraganization_flag_off = 'checked';
                    $oraganization_flag_on = '';
                    if (! empty($data['organization_flag'])):
                        if ($data['organization_flag'] == \Model_User::ORGANIZATION_FLAG_OFF):
                            $oraganization_flag_off = 'checked';
                            $oraganization_flag_on = '';
                        elseif ($data['organization_flag'] == \Model_User::ORGANIZATION_FLAG_ON):
                            $oraganization_flag_off = '';
                            $oraganization_flag_on = 'checked';
                        endif;
                    endif;
                ?>
                <label class="col-md-2">
                  <input type="radio" name="organization_flag" value="<?php echo \Model_User::ORGANIZATION_FLAG_OFF;?>" <?php echo $oraganization_flag_off;?>>個人
                </label>

                <label class="col-md-2">
                  <input type="radio" name="organization_flag" value="<?php echo \Model_User::ORGANIZATION_FLAG_ON;?>" <?php echo $oraganization_flag_on;?>>企業・団体
                </label>
              </div>
              <?php
                  if (isset($errors['organization_flag'])):
              ?>
              <div class="error-message">ユーザ種別を選択してください</div>
              <?php
                  endif;
              ?>
            </div>
            <label for="selectPrefecture" class="col-md-2">都道府県</label>
            <div class="col-md-12">
              <div class="col-md-12 clearfix">
              <?php
                  foreach ($prefectures as $prefecture_id => $prefecture):
                      $checked = '';
                      if (isset($data['prefecture_id'])):
                          $checked = in_array($prefecture_id, $data['prefecture_id']) ? 'checked' : '';
                      endif;
              ?>
                <label for="prefecture<?php echo $prefecture_id;?>" class="col-md-2 control-label">
                  <input id="prefecture<?php echo $prefecture_id;?>" type="checkbox" name="prefecture_id[]" value="<?php echo $prefecture_id;?>" <?php echo $checked;?>>&nbsp;<?php echo $prefecture;?>
                </label>
              <?php
                  endforeach;
              ?>
              </div>
            <?php
                if (isset($errors['prefecture_id'])):
            ?>
            <div class="error-message">都道府県を選択してください</div>
            <?php
                endif;
            ?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6">
              <label for="inputFromMail">差出人メールアドレス</label>
              <?php
                  $from_email = 'info@rakuichi-rakuza.jp';
                  if (isset($data['from_email'])):
                      $from_email = $data['from_email'];
                  endif;
              ?>
              <input id="inputFromMail" class="form-control" type="text" name="from_email" value="<?php echo e($from_email);?>">
              <?php
                if (isset($errors['from_email'])):
              ?>
              <div class="error-message"><?php echo $errors['from_email'];?></div>
              <?php
                  endif;
              ?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6">
              <label for="inputFromName">差出人</label>
              <?php
                  $from_name = '楽市楽座 運営事務局';
                  if (isset($data['from_name'])):
                      $from_name = $data['from_name'];
                  endif;
              ?>
              <input id="inputFromName" class="form-control" type="text" name="from_name" value="<?php echo e($from_name);?>">
              <?php
                  if (isset($errors['from_name'])):
              ?>
              <div class="error-message"><?php echo $errors['from_name'];?></div>
              <?php
                  endif;
              ?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-8">
              <label for="inputSubject">件名</label>
              <input id="inputSubject" class="form-control" type="text" name="subject" value="<?php echo e($data['subject']);?>">
              <?php
                  if (isset($errors['subject'])):
              ?>
              <div class="error-message"><?php echo $errors['subject'];?></div>
              <?php
                  endif;
              ?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-10">
              <label for="file">本文</label>
              <textarea class="form-control" cols="70" rows="20" name="body"><?php echo e($data['body']);?></textarea>
              <?php
                  if (isset($errors['body'])):
              ?>
              <div class="error-message"><?php echo $errors['body'];?></div>
              <?php
                  endif;
              ?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-8">
              <ul id="replace_1" class="list-group replace">
                <li class="list-group-item">ユーザ名を記載する箇所に「##user_name##」を記述してください</li>
              </ul>
              <ul id="replace_2" class="list-group replace">
                <li class="list-group-item">ユーザ名を記載する箇所に「##user_name##」を記述してください</li>
              </ul>
              <ul id="replace_3" class="list-group replace">
                <li class="list-group-item">ユーザ名を挿入する箇所に「##user_name##」を記述してください</li>
                <li class="list-group-item">フリマ名を挿入する箇所に「##fleamarket_name##」を記述してください</li>
                <li class="list-group-item">開催日を挿入する箇所に「##event_date##」を記述してください</li>
                <li class="list-group-item">開始時間を挿入する箇所に「##start_time##」を記述してください</li>
                <li class="list-group-item">終了時間を挿入する箇所に「##end_time##」を記述してください</li>
              </ul>
              <ul id="replace_4" class="list-group replace">
                <li class="list-group-item">ユーザ名を挿入する箇所に「##user_name##」を記述してください</li>
                <li class="list-group-item">フリマ名を挿入する箇所に「##fleamarket_name##」を記述してください</li>
                <li class="list-group-item">開催日を挿入する箇所に「##event_date##」を記述してください</li>
                <li class="list-group-item">開始時間を挿入する箇所に「##start_time##」を記述してください</li>
                <li class="list-group-item">終了時間を挿入する箇所に「##end_time##」を記述してください</li>
              </ul>
            </div>
          </div>
          <p>
            <button id="doSubmit" type="submit" class="btn btn-info">確認する</button>
          </p>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function() {
  $("input.mailMagazineType").on("click", function(evt) {
    var mail_magazine_type = $(this).attr('id').replace('inputMailMagazineType_', '');

    $(".condition").css("display", "none");
    $("#condition_" + mail_magazine_type).css("display", "block");
    $(".replace").css("display", "none");
    $("#replace_" + mail_magazine_type).css("display", "block");
  });

  $("#doSubmit").on("click", function(evt) {
    if (! ($(this).attr('id') == 'inputMailMagazineType_1'
        && $(this).prop("checked"))
    ) {
      return;
    }

    evt.preventDefault();
    $("#dialog .message").text("全員送信ですがよろしいですか？");
    $("#dialog").dialog({
      modal: true,
      buttons: {
        "キャンセル": function() {
          $(this).dialog( "close" );
        },
        "Ok": function() {
          $("#mailmagazineForm").submit();
        }
      }
    });
  });

  $("#inputMailMagazineType_<?php echo isset($data['mail_magazine_type']) ? $data['mail_magazine_type'] : \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY;?>").click();
});
</script>