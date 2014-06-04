<script type="text/javascript">
$(function() {

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
      <div class="box clearfix"><span class="step">STEP1.</span>登録内容の入力</div>
    </div>
    <div class="steps col-sm-4">
      <div class="box active clearfix"><span class="step">STEP2.</span>内容確認</div>
    </div>
    <div class="steps col-sm-4">
      <div class="box clearfix"><span class="step">STEP3.</span>登録完了</div>
    </div>
  </div>
  <!-- /flow -->
  <!-- form -->
  <div id="form" class="container">
    <div class="box clearfix">
      <h3>開催情報の確認</h3>
      <form id="confirmForm" class="form-horizontal" action="/fleamarket/thanks/" method="post">
      <?php
          echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());
      ?>
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
          <div class="col-sm-10"><?php echo e($fleamarket_fields['promoter_name']->value);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputWebsite">主催者ホームページ</label>
          <div class="col-sm-10"><?php echo e($fleamarket_fields['website']->value);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputReservationTel">予約受付電話番号</label>
          <div class="col-sm-10"><?php echo e($fleamarket_fields['reservation_tel']->value);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputReservationEmail">予約受付<br>E-mailアドレス</label>
          <div class="col-sm-10"><?php echo e($fleamarket_fields['reservation_email']->value);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventDate">開催日</label>
          <div class="col-sm-10"><?php echo e($fleamarket_fields['event_date']->value);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventTimeStart">開始時間</label>
          <div class="col-sm-10"><?php echo e($fleamarket_fields['event_time_start']->value);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventTimeEnd">終了時間</label>
          <div class="col-sm-10"><?php echo e($fleamarket_fields['event_time_end']->value);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputName">フリマ名</label>
          <div class="col-sm-10"><?php echo e($fleamarket_fields['name']->value);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPlaceName">会場名</label>
          <div class="col-sm-10"><?php echo e($location_fields['name']->value);?></div>
        </div>
        <div class="form-group form-address">
          <label class="col-sm-2 control-label" for="inputZip">ご住所</label>
          <div class="col-sm-10">
            <div>〒<?php echo e($location_fields['zip']->value);?></div>
            <div><?php echo e($prefectures[$location_fields['prefecture_id']->value] . $location_fields['address']->value);?></div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputAboutAccess">最寄り駅または<br>交通アクセス</label>
          <div class="col-sm-10"><?php echo e($fleamarket_about_fields['description']->value);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputDescription">内容<br>（出店方法、募集数、料金等）</label>
          <div class="col-sm-10"><?php echo nl2br(e($fleamarket_fields['description']->value));?></div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputDescription">イメージ画像<br>（1画像につき1.0MBまで）</label>
          <div class="col-sm-10">
            <?php
                for ($num = 1; $num <= $upload_file_limit; $num++):
                    $filed = 'image_' . $num;
                    $upload_file = isset($upload_files[$filed]) ? $upload_files[$filed] : null;
                    $fleamarket_image = $getFleamarketImageByPriority($num);
            ?>
            <label>イメージ<?php echo $num;?></label>
            <div class="uploadImageBox">
            <?php
                    if ($upload_file):
            ?>
              <img class="img-rounded uploadImage" src="<?php echo $image_temporary_path . $upload_file['saved_as'];?>">
            <?php
                    elseif ($fleamarket_image):
            ?>
              <img class="img-rounded uploadImage" src="<?php echo $fleamarket_image->Url();?>">
            <?php
                    endif;
                    if ($upload_file && $fleamarket_image):
                        echo '更新';
                    elseif (! empty($delete_image) && isset($delete_image[$num])):
                        echo '削除';
                    endif;
            ?>
            </div>
            <hr>
            <?php
                endfor;
            ?>
            <?php
                if (isset($fleamarket_image_errors)):
                    echo '<div class="errorMessage">' . $fleamarket_image_errors . '</div>';
                endif;
            ?>
          </div>
        </div>
        <div id="submitButton" class="form-group">
          <a id="doBack" href="/fleamarket" class="btn btn-default">入力に戻る</a>
          <button id="doRegister" type="submit" class="btn btn-default">登録する</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function() {
  $("#doBack").on("click", function(evt) {
    evt.preventDefault();
    var action = $(this).attr("href");
    $("#confirmForm").attr('action', action).submit();
  });
});
</script>
