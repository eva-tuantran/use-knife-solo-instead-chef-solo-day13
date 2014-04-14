<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>

<div id="contentForm" class="row"> 
  <!-- form -->
  <div id="form" class="container">
    <div class="box clearfix">
      <h3>お問い合わせフォーム</h3>
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
	    <?php echo $errors['inquiry_type']; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">名前</label>
	  <div class="col-sm-6">
	    <input type="text" name="last_name" value="<?php echo e($input['last_name']); ?>" class="form-control">
	    <input type="text" name="first_name" value="<?php echo e($input['first_name']); ?>" class="form-control">
	    <?php if (isset($errors['last_name'])) { ?>
	    <?php echo $errors['last_name']; ?>
	    <?php } ?>
	    <?php if (isset($errors['first_name'])) { ?>
	    <?php echo $errors['first_name']; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">件名</label>
	  <div class="col-sm-6">
	    <input type="text" name="subject" value="<?php echo e($input['subject']); ?>" class="form-control">
	    <?php if (isset($errors['subject'])) { ?>
	    <?php echo $errors['subject']; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">メールアドレス</label>
	  <div class="col-sm-6">
	    <input type="text" name="email" value="<?php echo e($input['email']); ?>" class="form-control">
	    <?php if (isset($errors['email'])) { ?>
	    <?php echo $errors['email']; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">メールアドレス確認用</label>
	  <div class="col-sm-6">
	    <input type="text" name="email2" value="<?php echo e($input['email2']); ?>" class="form-control">
	    <?php if (isset($errors['email2'])) { ?>
	    <?php echo $errors['email2']; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">電話番号</label>
	  <div class="col-sm-6">
	    <input type="text" name="tel" value="<?php echo e($input['tel']); ?>" class="form-control">
	    <?php if (isset($errors['tel'])) { ?>
	    <?php echo $errors['tel']; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">内容</label>
	  <div class="col-sm-6">
	    <textarea name="contents" cols=80 rows=10 class="form-control"><?php echo e($input['contents']); ?></textarea>
	    <?php if (isset($errors['contents'])) { ?>
	    <?php echo $errors['contents']; ?>
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
