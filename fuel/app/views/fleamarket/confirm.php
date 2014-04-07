<script type="text/javascript">
$(function() {

});
</script>
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
      <form class="form-horizontal" action="/fleamarket/thanks/" method="post">
        <?php
            echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());
        ?>
        <?php
          if (isset($fleamarket['fleamarket_id'])
              && ! empty($fleamarket['fleamarket_id'])
          ):
        ?>
            <input type="hidden" name="fleamarket_id" value="<?php echo e($fleamarket['fleamarket_id']);?>">
        <?php
          endif;
        ?>
        <?php
          if (isset($fleamarket_about['fleamarket_about_id'])
              && ! empty($fleamarket_about['fleamarket_about_id'])
          ):
        ?>
            <input type="hidden" name="fleamarket_about_id" value="<?php echo e($fleamarket_about['fleamarket_about_id']);?>">
        <?php
          endif;
        ?>
        <?php
          if (isset($location['location_id'])
              && ! empty($location['location_id'])
          ):
        ?>
            <input type="hidden" name="location_id" value="<?php echo e($location['location_id']);?>">
        <?php
          endif;
        ?>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPromoterName">主催者名</label>
          <div class="col-sm-10"><?php echo e($fleamarket['promoter_name']);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputWebsite">主催者ホームページ</label>
          <div class="col-sm-10"><?php echo e($fleamarket['website']);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputReservationTel">予約受付電話番号</label>
          <div class="col-sm-10"><?php echo e($fleamarket['reservation_tel']);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputReservationEmail">予約受付<br>E-mailアドレス</label>
          <div class="col-sm-10"><?php echo e($fleamarket['reservation_email']);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventDate">開催日</label>
          <div class="col-sm-10"><?php echo e($fleamarket['event_date']);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventTimeStart">開始時間</label>
          <div class="col-sm-10"><?php echo e($fleamarket['event_time_start']);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventTimeEnd">終了時間</label>
          <div class="col-sm-10"><?php echo e($fleamarket['event_time_end']);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputName">フリマ名</label>
          <div class="col-sm-10"><?php echo e($fleamarket['name']);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPlaceName">会場名</label>
          <div class="col-sm-10"><?php echo e($location['name']);?></div>
        </div>
        <div class="form-group form-address">
          <label class="col-sm-2 control-label" for="inputZip">ご住所</label>
          <div class="col-sm-10">
            <div>〒<?php echo e($location['zip']);?></div>
            <div><?php echo e($prefectures[$location['prefecture_id']] . $location['address']);?></div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputAboutAccess">最寄り駅または<br>交通アクセス</label>
          <div class="col-sm-10"><?php echo e($fleamarket_about['description']);?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputDescription">内容<br>（出店方法、募集数、料金等）</label>
          <div class="col-sm-10"><?php echo nl2br(e($fleamarket['description']));?></div>
        </div>
        <div id="submitButton" class="form-group">
          <a href="/fleamarket" class="btn btn-default">入力に戻る</a>
          <button id="do_register" type="submit" class="btn btn-default">登録する</button>
        </div>
      </form>
    </div>
  </div>
</div>
