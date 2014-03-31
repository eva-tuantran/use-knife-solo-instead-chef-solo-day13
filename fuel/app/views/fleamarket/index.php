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
    if (isset($fleamarket_id)):
        $fleamarket = $fleamarket;
        $fleamarket_abouts = $fleamarket_about;
        $location = $location;
    else:
        $fleamarket = $fleamarket_fieldset->input();
        $fleamarket_errors = $fleamarket_fieldset->validation()->error_message();

        $fleamarket_abouts = $fleamarket_about_fieldset->input();
        $fleamarket_about_errors =
            $fleamarket_about_fieldset->validation()->error_message();

        $location = $location_fieldset->input();
        $location_errors =
            $location_fieldset->validation()->error_message();
    endif;
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
      <form class="form-horizontal" action="/fleamarket/confirm" method="post">
        <?php
            if (isset($fleamarket_id)):
        ?>
        <input type="hidden" name="f[fleamarket_id]" value="<?php echo e($fleamarket_id);?>">
        <?php
            endif;
        ?>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputPromoterName">主催者名</label>
          <div class="col-sm-10">
              <input id="inputPromoterName" type="text" class="form-control" name="f[promoter_name]" placeholder="主催者名を入力" value="<?php echo e($fleamarket['promoter_name']);?>">
            <?php
              if (isset($fleamarket_errors['promoter_name'])):
            ?>
              <div><?php echo $fleamarket_errors['promoter_name'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputWebsite">主催者ホームページ</label>
          <div class="col-sm-10">
            <input id="inputWebsite" type="text" class="form-control" name="f[website]" placeholder="例）http://◯◯◯◯.com" value="<?php echo e($fleamarket['website']);?>">
            <?php
              if (isset($fleamarket_errors['website'])):
            ?>
              <div><?php echo $fleamarket_errors['website'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputReservationTel">予約受付電話番号</label>
          <div class="col-sm-10">
            <input id="inputReservationTel" type="text" class="form-control" name="f[reservation_tel]" placeholder="例）03-1234-5678　半角英数字で入力してください" value="<?php echo e($fleamarket['reservation_tel']);?>">
            <?php
              if (isset($fleamarket_errors['reservation_tel'])):
            ?>
              <div><?php echo $fleamarket_errors['reservation_tel'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputReservationEmail">予約受付<br>E-mailアドレス</label>
          <div class="col-sm-10">
            <input id="inputReservationEmail" type="email" class="form-control" name="f[reservation_email]" placeholder="例）your@email.com　半角英数字で入力してください" value="<?php echo e($fleamarket['reservation_email']);?>">
            <?php
              if (isset($fleamarket_errors['reservation_email'])):
            ?>
              <div><?php echo $fleamarket_errors['reservation_email'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputReservationEmail2">E-mailアドレス<br>（確認用）</label>
          <div class="col-sm-10">
            <input id="inputReservationEmail2" type="email" class="form-control" name="f[reservation_email_confirm]" placeholder="確認のため、もう一度メールアドレスを入力してください" value="<?php echo e($fleamarket['reservation_email_confirm']);?>">
            <?php
              if (isset($fleamarket_errors['reservation_email_confirm'])):
            ?>
              <div><?php echo $fleamarket_errors['reservation_email_confirm'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventDate">開催日</label>
          <div class="col-sm-10">
            <input id="inputEventDate" type="text" class="form-control" name="f[event_date]" placeholder="例）2014/01/25" value="<?php echo e($fleamarket['event_date']);?>">
            <?php
              if (isset($fleamarket_errors['event_date'])):
            ?>
              <div><?php echo $fleamarket_errors['event_date'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventTimeStart">開始時間</label>
          <div class="col-sm-10">
            <input id="inputEventTimeStart" type="text" class="form-control" name="f[event_time_start]" placeholder="例）09:00" value="<?php echo e(date('G:i', strtotime($fleamarket['event_time_start'])));?>">
            <?php
              if (isset($fleamarket_errors['event_time_start'])):
            ?>
              <div><?php echo $fleamarket_errors['event_time_start'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputEventTimeEnd">終了時間</label>
          <div class="col-sm-10">
            <input id="inputEventTimeEnd" type="text" class="form-control" name="f[event_time_end]" placeholder="例）16:00" value="<?php echo e(date('G:i', strtotime($fleamarket['event_time_end'])));?>">
            <?php
              if (isset($fleamarket_errors['event_time_end'])):
            ?>
              <div><?php echo $fleamarket_errors['event_time_end'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputName">フリマ名</label>
          <div class="col-sm-10">
            <input id="inputName" type="text" class="form-control" name="f[name]" placeholder="例）◯◯フリーマーケット" value="<?php echo e($fleamarket['name']);?>">
            <?php
              if (isset($fleamarket_errors['name'])):
            ?>
              <div><?php echo $fleamarket_errors['name'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputPlaceName">会場名</label>
          <div class="col-sm-10">
            <input id="inputPlaceName" type="text" class="form-control" name="l[name]" placeholder="例）◯◯公園" value="<?php echo e($location['name']);?>">
            <?php
              if (isset($location_errors['name'])):
            ?>
              <div><?php echo $location_errors['name'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group form-address">
          <label class="col-sm-2 control-label" for="inputZip">ご住所</label>
          <div class="col-sm-10">
            <input id="inputZip" type="text" class="form-control" name="l[zip]" placeholder="例）1234567" value="<?php echo $location_input['zip'];?>">
            <button type="submit" class="btn btn-default" onclick="AjaxZip3.zip2addr('l[zip]','','l[address]','l[address]'); return false;">住所を検索</button>
            <select class="form-control" name="l[prefecture_id]">
              <option value="">都道府県</option>
              <?php
                  foreach ($prefectures as $id => $name):
                      $selected = ($id == $location['prefecture_id']) ? 'selected' : '';
              ?>
                <option label="<?php echo $name;?>" value="<?php echo $id;?>" <?php echo $selected;?>><?php echo $name;?></option>
              <?php
                  endforeach;
              ?>
            </select>
            <input id="inputAddress" type="text" class="form-control" name="l[address]" placeholder="住所を入力" value="<?php echo e($location['address']);?>">
            <?php
              if (isset($location_errors['zip'])):
            ?>
              <div><?php echo $location_errors['zip'];?></div>
            <?php
              endif;
            ?>
            <?php
              if (isset($location_errors['prefecture_id'])):
            ?>
              <div><?php echo $location_errors['prefecture_id'];?></div>
            <?php
              endif;
            ?>
            <?php
              if (isset($location_errors['address'])):
            ?>
              <div><?php echo $location_errors['address'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputAboutAccess">最寄り駅または<br>交通アクセス</label>
          <div class="col-sm-10">
            <input id="inputAboutAccess" type="text" class="form-control" name="fa[description]" placeholder="例）JR山手線、JR埼京線「渋谷駅」より 徒歩5分" value="<?php echo e($fleamarket_abouts['description']);?>">
            <?php
              if (isset($fleamarket_about_errors['description'])):
            ?>
              <div><?php echo $fleamarket_about_errors['description'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="inputDescription">内容<br>（出店方法、募集数、料金等）</label>
          <div class="col-sm-10">
            <textarea id="inputDescription" class="form-control" name="f[description]" rows="5" placeholder="例）車出店可能、募集ブース30、無料"><?php echo e($fleamarket['description']);?></textarea>
            <?php
              if (isset($fleamarket_errors['description'])):
            ?>
              <div><?php echo $fleamarket_errors['description'];?></div>
            <?php
              endif;
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="terms">利用規約</label>
          <div class="col-sm-10">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="agreement" value="1">
                利用規約に同意する。 <br>
                <a href="#" target="_blank">規約の確認はコチラ（別ウィンドウで開きます）</a> </label>
            </div>
          </div>
        </div>
        <div id="submitButton" class="form-group">
          <button id="do_confoirm" type="submit" class="btn btn-default">内容を確認する</button>
        </div>
      </form>
    </div>
  </div>
</div>
