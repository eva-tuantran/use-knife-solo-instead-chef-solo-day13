<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>

<div id="contentForm" class="row">
  <!-- form -->
  <div id="form" class="container">
    <div class="box clearfix">
      <h3>お問い合わせフォーム</h3>

<?php if(date("Ymd") >= 20150421 && date("Ymd") <= 20150513): ?>
<div style="border: 1px solid #ddd;background-color: #fafafa;margin: 10px;padding: 10px 20px;color: #ff4444;font-weight: bold;">
【ゴールデンウィーク期間のサポートについて】<br />
2015年5月2日（土）～5月6日（水）まで、お問い合わせ対応や各種サポートをお休みさせていただきます。<br />
5月1日（金）15時以降にいただいたメールは、5月7日（木）以降順次対応とさせていただきます。<br />
また、長期の休暇となるため、ご返答にお時間がかかることが見込まれますことをご了承下さい。
</div>
<?php endif; ?>

      <form action="/inquiry/confirm" method="POST" class="form-horizontal">
	<div class="form-group">
	  <label class="col-sm-2 control-label">お問い合わせの種類</label>
	  <div class="col-sm-6">
	    <select name="inquiry_type" class="form-control">
	      <option value="1"<?php if ($input['inquiry_type'] == 1) { echo ' selected=selected'; }?>>
		楽市楽座について
	      </option>
	      <option value="2"<?php if ($input['inquiry_type'] == 2) { echo ' selected=selected'; }?>>
		フリーマーケットについて
	      </option>
	      <option value="3"<?php if ($input['inquiry_type'] == 3) { echo ' selected=selected'; }?>>
		楽市楽座のウェブサイトについて
	      </option>
	      <option value="4"<?php if ($input['inquiry_type'] == 4) { echo ' selected=selected'; }?>>
		そのほかのお問い合わせについて
	      </option>
	    </select>
	    <?php if (isset($errors['inquiry_type'])) { ?>
	    <?php echo '<span class="errorMessage">' .$errors['inquiry_type']. '</span>'; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">名前</label>
	  <div class="col-sm-6">
	    <input type="text" name="last_name" value="<?php echo e($input['last_name']); ?>" class="form-control" required>
	    <input type="text" name="first_name" value="<?php echo e($input['first_name']); ?>" class="form-control" required>
	    <?php if (isset($errors['last_name'])) { ?>
	    <?php echo '<span class="errorMessage">' .$errors['last_name']. '</span>'; ?>
	    <?php } ?>
	    <?php if (isset($errors['first_name'])) { ?>
	    <?php echo '<span class="errorMessage">' .$errors['first_name']. '</span>'; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">件名</label>
	  <div class="col-sm-6">
	    <input type="text" name="subject" value="<?php echo e($input['subject']); ?>" class="form-control" required>
	    <?php if (isset($errors['subject'])) { ?>
	    <?php echo '<span class="errorMessage">' .$errors['subject']. '</span>'; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">メールアドレス</label>
	  <div class="col-sm-6">
	    <input type="text" name="email" value="<?php echo e($input['email']); ?>" class="form-control" required>
	    <?php if (isset($errors['email'])) { ?>
	    <?php echo '<span class="errorMessage">' .$errors['email']. '</span>'; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">メールアドレス確認用</label>
	  <div class="col-sm-6">
	    <input type="text" name="email2" value="<?php echo e($input['email2']); ?>" class="form-control" required>
	    <?php if (isset($errors['email2'])) { ?>
	    <?php echo '<span class="errorMessage">' .$errors['email2']. '</span>'; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">電話番号</label>
	  <div class="col-sm-6">
	    <input type="text" name="tel" value="<?php echo e($input['tel']); ?>" class="form-control" required>
	    <?php if (isset($errors['tel'])) { ?>
	    <?php echo '<span class="errorMessage">' .$errors['tel']. '</span>'; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">内容</label>
	  <div class="col-sm-6">
	    <textarea name="contents" cols=80 rows=10 class="form-control" required><?php echo e($input['contents']); ?></textarea>
	    <?php if (isset($errors['contents'])) { ?>
	    <?php echo '<span class="errorMessage">' .$errors['contents']. '</span>'; ?>
	    <?php } ?>
	  </div>
	</div>
	<div id="submitButton" class="form-group">
	  <button type="submit" class="btn btn-default">内容を確認する</button>
	</div>
      </form>
    </div>
  </div>
</div>
