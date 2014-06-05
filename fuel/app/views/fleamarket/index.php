<script type="text/javascript">
$(function() {
  $("#inputEventDate").datepicker({
    numberOfMonths: 3,
    showButtonPanel: true
  });
  $("#inputEventTimeStart").timepicker({
    showButtonPanel: true,
    stepMinute: 5
  });
  $("#inputEventTimeEnd").timepicker({
    showButtonPanel: true,
    stepMinute: 5
  });
});
</script>
<?php
    $location_fields = $location_fieldset->field();
    $location_errors = $location_fieldset->validation()->error_message();

    $fleamarket_fields = $fleamarket_fieldset->field();
    $fleamarket_errors = $fleamarket_fieldset->validation()->error_message();

    $fleamarket_about_fields = $fleamarket_about_fieldset->field();
    $fleamarket_about_errors = $fleamarket_about_fieldset->validation()->error_message();

//    $fleamarket_image_fields = $fleamarket_image_fieldset->field();
//    $fleamarket_image_errors = $fleamarket_image_fieldset->validation()->error_message();
?>
<div id="contentForm" class="row">
  <!-- flow -->
  <div id="flow" class="row hidden-xs">
    <div class="steps col-sm-4">
      <div class="box active clearfix"><span class="step">STEP1.</span>登録内容の入力</div>
    </div>
    <div class="steps col-sm-4">
      <div class="box clearfix"><span class="step">STEP2.</span>内容確認</div>
    </div>
    <div class="steps col-sm-4">
      <div class="box clearfix"><span class="step">STEP3.</span>登録完了</div>
    </div>
  </div>
  <!-- /flow -->
  <!-- form -->
  <div id="form" class="container">
    <div class="box clearfix">
      <h3>開催情報の入力</h3>
      <form class="form-horizontal" action="/fleamarket/confirm/" method="post" enctype="multipart/form-data">
        <?php
            if (! empty($location_id)):
        ?>
          <input type="hidden" name="location_id" value="<?php echo e($location_id);?>">
        <?php
            endif;
        ?>
        <?php
            if (! empty($fleamarket_id)):
        ?>
        <input type="hidden" name="fleamarket_id" value="<?php echo e($fleamarket_id);?>">
        <?php
            endif;
        ?>
        <?php
            if (! empty($fleamarket_about_id)):
        ?>
        <input type="hidden" name="fleamarket_about_id" value="<?php echo e($fleamarket_about_id);?>">
        <?php
            endif;
        ?>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputPromoterName">主催者名</label>
            <div class="col-sm-10">
              <input id="inputPromoterName" type="text" class="form-control" name="f[promoter_name]" placeholder="主催者名を入力" value="<?php echo e($fleamarket_fields['promoter_name']->value);?>" required>
            <?php
                if (isset($fleamarket_errors['promoter_name'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['promoter_name'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputWebsite">主催者ホームページ</label>
          <div class="col-sm-10">
            <input id="inputWebsite" type="text" class="form-control" name="f[website]" placeholder="例）http://◯◯◯◯.com" value="<?php echo e($fleamarket_fields['website']->value);?>">
            <?php
                if (isset($fleamarket_errors['website'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['website'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputReservationTel">予約受付電話番号</label>
          <div class="col-sm-10">
            <input id="inputReservationTel" type="text" class="form-control" name="f[reservation_tel]" placeholder="例）03-1234-5678　半角英数字で入力してください" value="<?php echo e($fleamarket_fields['reservation_tel']->value);?>" required>
            <?php
                if (isset($fleamarket_errors['reservation_tel'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['reservation_tel'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputReservationEmail">予約受付<br>E-mailアドレス</label>
          <div class="col-sm-10">
            <input id="inputReservationEmail" type="email" class="form-control" name="f[reservation_email]" placeholder="例）your@email.com　半角英数字で入力してください" value="<?php echo e($fleamarket_fields['reservation_email']->value);?>" required>
            <?php
                if (isset($fleamarket_errors['reservation_email'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['reservation_email'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputReservationEmail2">E-mailアドレス<br>（確認用）</label>
          <div class="col-sm-10">
            <input id="inputReservationEmail2" type="email" class="form-control" name="f[reservation_email_confirm]" placeholder="確認のため、もう一度メールアドレスを入力してください" value="<?php echo e($fleamarket_fields['reservation_email_confirm']->value);?>" required>
            <?php
                if (isset($fleamarket_errors['reservation_email_confirm'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['reservation_email_confirm'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventDate">開催日</label>
          <div class="col-sm-10">
            <?php
                $event_date = '';
                if (isset($fleamarket_fields['event_date']) && $fleamarket_fields['event_date']->value != ''):
                    $event_date = date('Y/m/d', strtotime($fleamarket_fields['event_date']->value));
                endif;
            ?>
            <input id="inputEventDate" type="text" class="form-control" name="f[event_date]" placeholder="例）2014/01/25" value="<?php echo e($event_date);?>" required>
            <?php
                if (isset($fleamarket_errors['event_date'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['event_date'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventTimeStart">開始時間</label>
          <div class="col-sm-10">
            <?php
                $event_time_start = '';
                if (isset($fleamarket_fields['event_time_start']) && $fleamarket_fields['event_time_start']->value != ''):
                    $event_time_start = substr($fleamarket_fields['event_time_start']->value, 0, 5);
                endif;
            ?>
            <input id="inputEventTimeStart" type="text" class="form-control" name="f[event_time_start]" placeholder="例）09:00" value="<?php echo e($event_time_start);?>" required>
            <?php
                if (isset($fleamarket_errors['event_time_start'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['event_time_start'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventTimeEnd">終了時間</label>
          <div class="col-sm-10">
            <?php
                $event_time_end = '';
                if (isset($fleamarket_fields['event_time_end']) && $fleamarket_fields['event_time_end']->value != ''):
                    $event_time_end = substr($fleamarket_fields['event_time_end']->value, 0, 5);
                endif;
            ?>
            <input id="inputEventTimeEnd" type="text" class="form-control" name="f[event_time_end]" placeholder="例）16:00" value="<?php echo e($event_time_end);?>" required>
            <?php
                if (isset($fleamarket_errors['event_time_end'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['event_time_end'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputName">フリマ名</label>
          <div class="col-sm-10">
            <input id="inputName" type="text" class="form-control" name="f[name]" placeholder="例）◯◯フリーマーケット" value="<?php echo e($fleamarket_fields['name']->value);?>" required>
            <?php
                if (! empty($fleamarket_errors['name'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['name'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPlaceName">会場名</label>
          <div class="col-sm-10">
            <input id="inputPlaceName" type="text" class="form-control" name="l[name]" placeholder="例）◯◯公園" value="<?php echo e($location_fields['name']->value);?>" required>
            <?php
                if (isset($location_errors['name'])):
                    echo '<div class="errorMessage">' . $location_errors['name'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group form-address">
          <label class="col-sm-2 control-label" for="inputZip">ご住所</label>
          <div class="col-sm-10">
            <input id="inputZip" type="text" class="form-control" name="l[zip]" placeholder="例）1234567" value="<?php echo e($location_fields['zip']->value);?>" required>
            <button type="submit" class="btn btn-default" onclick="AjaxZip3.zip2addr('l[zip]','','l[prefecture_id]','l[address]'); return false;">住所を検索</button>
            <select class="form-control" name="l[prefecture_id]">
              <option value="">都道府県</option>
              <?php
                  foreach ($prefectures as $id => $name):
                      $selected = ($id == $location_fields['prefecture_id']->value) ? 'selected' : '';
              ?>
              <option label="<?php echo $name;?>" value="<?php echo $id;?>" <?php echo $selected;?>><?php echo $name;?></option>
              <?php
                  endforeach;
              ?>
            </select>
            <input id="inputAddress" type="text" class="form-control" name="l[address]" placeholder="住所を入力" value="<?php echo e($location_fields['address']->value);?>" required>
            <?php
                if (isset($location_errors['zip'])):
                    echo '<div class="errorMessage">' . $location_errors['zip'] . '</div>';
                endif;
            ?>
            <?php
                if (isset($location_errors['prefecture_id'])):
                    echo '<div class="errorMessage">' . $location_errors['prefecture_id'] . '</div>';
                endif;
            ?>
            <?php
                if (isset($location_errors['address'])):
                    echo '<div class="errorMessage">' . $location_errors['address'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputAboutAccess">最寄り駅または<br>交通アクセス</label>
          <div class="col-sm-10">
            <input id="inputAboutAccess" type="text" class="form-control" name="fa[description]" placeholder="例）JR山手線、JR埼京線「渋谷駅」より 徒歩5分" value="<?php echo e($fleamarket_about_fields['description']->value);?>">
            <?php
                if (isset($fleamarket_about_errors['description'])):
                    echo '<div class="errorMessage">' . $fleamarket_about_errors['description'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputDescription">内容<br>（出店方法、募集数、料金等）</label>
          <div class="col-sm-10">
            <textarea id="inputDescription" class="form-control" name="f[description]" rows="5" placeholder="例）車出店可能、募集ブース30、無料" required><?php echo e($fleamarket_fields['description']->value);?></textarea>
            <?php
                if (isset($fleamarket_errors['description'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['description'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputImage">イメージ画像<br>（1画像につき1.0MBまで）</label>
          <div class="col-sm-10">
            <?php
                for ($num = 1; $num <= $upload_file_limit; $num++):
                    $filed = 'image_' . $num;
                    $fleamarket_image = $getFleamarketImageByPriority($num);
            ?>
            <label>イメージ<?php echo $num;?></label>
            <?php
                    $checked = '';
                    if ($fleamarket_image):
                        $checkd = empty($delete_image[$num]) ? '': 'checked';
            ?>
            <div class="uploadImageBox">
              <img class="img-rounded uploadImage" src="<?php echo $fleamarket_image->Url();?>">
              <input id="deleteImage" type="checkbox" name="deleteImage[<?php echo $num;?>]" value="<?php echo $num;?>" <?php echo $checkd;?>>削除
            </div>
            <?php
                    endif;
            ?>
            <div><input id="inputFile<?php echo $num;?>" type="file" name="image_<?php echo $num;?>"></div>
            <?php
                if (isset($upload_file_errors[$filed])):
                    foreach ($upload_file_errors[$filed] as $error):
                        echo '<div class="errorMessage">' . $error['message'] . '</div>';
                    endforeach;
                endif;
            ?>
            <hr>
            <?php
                endfor;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="terms">利用規約</label>
          <div class="col-sm-10">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="f[agreement]" value="1">
                利用規約に同意する。 <br>
                <a href="/info/agreement" target="_blank">規約の確認はコチラ（別ウィンドウで開きます）</a> </label>
            </div>
            <?php
                if (isset($fleamarket_errors['agreement'])):
                    echo '<div class="errorMessage">' . $fleamarket_errors['agreement'] . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div id="submitButton" class="form-group">
          <button id="do_confoirm" type="submit" class="btn btn-default">内容を確認する</button>
        </div>
      </form>
    </div>
  </div>
</div>
