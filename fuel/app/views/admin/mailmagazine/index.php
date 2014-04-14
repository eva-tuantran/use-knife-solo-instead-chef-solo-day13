<style type="text/css">
#container {
  text-align: center;
}

.contents {
  margin: 0 auto;
  position: relative;
  padding: 45px 15px 15px;
  background-color: #fff;
  border-width: 1px;
  border-color: #ddd;
  border-radius: 4px 4px 0 0;
  box-shadow: none;
  width: 40%;
  text-align: left;
}

ul {
  list-style: none;
}

.btn-list li {
  margin-left: 20px;
  float: left;
}

.kind {
  display: none;
}
</style>
<div id="container">
  <div class="contents">
    <form id="mailmagazineForm" role="form" action="/admin/mailmagazine/confirm" method="post" class="form-horizontal" enctype="multipart/form-data">
      <div class="form-group">
        <label for="inputType1" class="col-sm-4"><input id="inputType1" type="radio" name="mail_magazine_type" value="<?php echo \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL;?>">全員</label>
        <label for="inputType2" class="col-sm-4"><input id="inputType2" type="radio" name="mail_magazine_type" value="<?php echo \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST;?>">希望者</label>
        <label for="inputType3" class="col-sm-4"><input id="inputType3" type="radio" name="mail_magazine_type" value="<?php echo \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY;?>">出店予約者</label>
      </div>
      <div class="form-group type type2">
        <label for="selectPrefecture" class="col-sm-3">都道府県</label>
        <select id="selectPrefecture" name="prefecture_id">
            <option value="">全国</option>
            <?php
                foreach ($prefectures as $prefecture_id => $prefecture):
                    $selected = '';
                    if (isset($input_data['prefecture_id'])):
                        $selected = $prefecture_id == $input_data['prefecture_id'] ? 'selected' : '';
                    endif;
            ?>
            <option value="<?php echo $prefecture_id;?>" <?php echo $selected;?>><?php echo $prefecture;?></option>
            <?php
                endforeach;
            ?>
        </select>
        <?php
            if (isset($errors['prefecture_id'])):
        ?>
        <div class="bg-warning">都道府県が正しくありません</div>
        <?php
            endif;
        ?>
      </div>
      <div class="form-group type type3">
        <label for="selectFleamarket" class="col-sm-3">フリーマーケット</label>
        <select id="selectFleamarket" name="fleamarket_id">
            <option value="">選択してください</option>
            <?php
                foreach ($fleamarket_list as $fleamarket):
                    $event_date = date('Y年m月d日', strtotime($fleamarket['event_date']));
                    $selected = '';
                    if (isset($input_data['fleamarket_id'])):
                        $selected = $fleamarket['fleamarket_id'] == $input_data['fleamarket_id'] ? 'selected' : '';
                    endif;
            ?>
            <option value="<?php echo $fleamarket['fleamarket_id'];?>" <?php echo $selected;?>>【<?php echo $event_date;?>】<?php echo e($fleamarket['name']);?></option>
            <?php
                endforeach;
            ?>
        </select>
        <?php
            if (isset($errors['fleamarket_id'])):
        ?>
        <div class="bg-warning">フリーマーケットを選択してください</div>
        <?php
            endif;
        ?>
        <?php
            if (isset($errors['mail_magazine_type'])):
        ?>
        <div class="bg-warning"><?php echo $errors['mail_magazine_type'];?></div>
        <?php
            endif;
        ?>
      </div>
      <div class="form-group">
        <label for="inputFromMail">送信メールアドレス</label>
        <input id="inputFromMail" class="form-control" type="text" name="from_email" placeholder="例）info@rakuichi-rakuza.jp" value="<?php echo e($input_data['from_email']);?>">
        <?php
            if (isset($errors['from_email'])):
        ?>
        <div class="bg-warning"><?php echo $errors['from_email'];?></div>
        <?php
            endif;
        ?>
      </div>
      <div class="form-group">
        <label for="inputFromName">送信名</label>
        <input id="inputFromName" class="form-control" type="text" name="from_name" placeholder="例）楽市楽座 運営事務局" value="<?php echo e($input_data['from_name']);?>">
        <?php
            if (isset($errors['from_name'])):
        ?>
        <div class="bg-warning"><?php echo $errors['from_name'];?></div>
        <?php
            endif;
        ?>
      </div>
      <div class="form-group">
        <label for="inputSubject">件名</label>
        <input id="inputSubject" class="form-control" type="text" name="subject" placeholder="例）楽市楽座メールマガジン" value="<?php echo e($input_data['subject']);?>">
        <?php
            if (isset($errors['subject'])):
        ?>
        <div class="bg-warning"><?php echo $errors['subject'];?></div>
        <?php
            endif;
        ?>
      </div>
      <div class="form-group">
        <label for="file">本文</label>
        <textarea class="form-control" cols="78" rows="15" name="body"><?php echo e($input_data['body']);?></textarea>
        <?php
            if (isset($errors['body'])):
        ?>
        <div class="bg-warning"><?php echo $errors['body'];?></div>
        <?php
            endif;
        ?>
      </div>
      <div class="form-group">
        <ul class="help-block type type1 type2">
          <li>ユーザ名を記載する箇所に「##user_name##」を記述してください<li>
        </ul>
        <ul class="help-block type type3">
          <li>ユーザ名を挿入する箇所に「##user_name##」を記述してください<li>
          <li>フリマ名を挿入する箇所に「##fleamarket_name##」を記述してください<li>
          <li>開催日を挿入する箇所に「##event_date##」を記述してください<li>
          <li>開始時間を挿入する箇所に「##start_time##」を記述してください<li>
          <li>終了時間を挿入する箇所に「##end_time##」を記述してください<li>
        </ul>
      </div>
      <ul class="btn-list clearfix">
        <li><button type="submit" class="btn btn-success">確認する</button></li>
      </ul>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function() {
  $("#inputType1").on("click", function(evt) {
    $(".type").css("display", "none");
    $(".type1").css("display", "block");
  });

  $("#inputType2").on("click", function(evt) {
    $(".type").css("display", "none");
    $(".type2").css("display", "block");
  });

  $("#inputType3").on("click", function(evt) {
    $(".type").css("display", "none");
    $(".type3").css("display", "block");
  });


  $("#inputType<?php echo $input_data['mail_magazine_type'] ? $input_data['mail_magazine_type'] : \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY;?>").click();
});
</script>