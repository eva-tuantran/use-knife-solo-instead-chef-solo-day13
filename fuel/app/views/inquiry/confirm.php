<?php $input = $fieldset->input(); ?>

<div id="contentForm" class="row"> 
  <!-- form -->
  <div id="form" class="container">
    <div class="box clearfix">
      <h3>お問い合わせフォーム</h3>
      <form action="/inquiry/thanks" method="POST" class="form-horizontal">
	<div class="form-group">
	  <label class="col-sm-2 control-label">お問い合わせの種類</label>
	  <div class="col-sm-6">
	    <?php echo e(\Model_Contact::inquiry_type_to_label($input['inquiry_type'])); ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">名前</label>
	  <div class="col-sm-6">
	    <?php echo e($input['last_name']); ?><?php echo e($input['first_name']); ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">件名</label>
	  <div class="col-sm-6">
	    <?php echo e($input['subject']); ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">メールアドレス</label>
	  <div class="col-sm-6">
	    <?php echo e($input['email']); ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">電話番号</label>
	  <div class="col-sm-6">
	    <?php echo e($input['tel']); ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">内容</label>
	  <div class="col-sm-6">
	    <?php echo nl2br(e($input['contents'])); ?>
	  </div>
	</div>
	<div id="submitButton" class="form-group">
	  <button type="submit" class="btn btn-default">内容を送信する</button>
	</div>
	<?php echo \Form::csrf(); ?>
      </form>
    </div>
  </div>
</div>

