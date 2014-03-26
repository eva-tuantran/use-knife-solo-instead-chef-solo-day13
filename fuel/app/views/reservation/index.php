<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $entry_styles = Config::get('master.entry_styles'); ?>

<?php
   $input_genres = array();
   if ($input['item_genres']) {
       foreach ($input['item_genres'] as $item_genre) {
           $input_genres[$item_genre] = 1;
       }
   }
?>

<div id="contentForm" class="row"> 
  <!-- flow -->
  <div id="flow" class="row hidden-xs">
    <div class="steps col-sm-3">
      <div class="box active clearfix"><span class="step">STEP1.</span>登録内容の入力</div>
    </div>
    <div class="steps col-sm-3">
      <div class="box clearfix"><span class="step">STEP2.</span>内容確認</div>
    </div>
    <div class="steps col-sm-3">
      <div class="box clearfix"><span class="step">STEP3.</span>仮登録メール送信</div>
    </div>
    <div class="steps col-sm-3">
      <div class="box clearfix"><span class="step">STEP3.</span>登録完了</div>
    </div>
  </div>
  <!-- /flow --> 
  <!-- form -->
  <div id="form" class="container">
    <div class="box clearfix">
      <h3>フリマ登録情報入力欄</h3>
      <form action="/reservation/confirm" method="POST" class="form-horizontal">
	<div class="form-group">
	  <label class="col-sm-2 control-label">出店方法</label>
	  <div class="col-sm-10">
	    <?php foreach ($fleamarket->fleamarket_entry_styles as $fleamarket_entry_style){ ?>
	    
	    <label class="checkbox-inline">
	      <input type="radio" name="fleamarket_entry_style_id" 
		     value="<?php echo $fleamarket_entry_style->fleamarket_entry_style_id; ?>"<?php if ($input['fleamarket_entry_style_id'] 
		     == $fleamarket_entry_style->fleamarket_entry_style_id) {
	             echo ' checked';} ?>>
	    </label>
	    <?php echo e($entry_styles[$fleamarket_entry_style->entry_style_id]); ?>
	    <?php } ?>
	    <?php if (isset($errors['fleamarket_entry_style_id'])) { ?>
	    <?php echo $errors['fleamarket_entry_style_id']; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">ブース数</label>
	  <div class="col-sm-10">
            <input type="text" name="reserved_booth" value="<?php echo e($input['reserved_booth']); ?>">
	    <?php if (isset($errors['reserved_booth'])) { ?>
	    <?php echo $errors['reserved_booth']; ?>
	    <?php } ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">出店予定品目</label>
	  <div class="col-sm-10">
	<select name="item_category" class="form-control">
          <?php foreach (Model_Entry::getItemCategoryDefine() as $item_category => $name) { ?>
          <option value="<?php echo e($item_category); ?>"
          <?php if($input['item_category'] == $item_category){ echo ' selected=selected'; } ?>>
	  <?php echo e($name); ?></option>
	  <?php } ?>
	</select>
	<?php if (isset($errors['item_category'])) { ?>
	<?php echo $errors['item_category']; ?>
	<?php } ?>
	<?php foreach (Model_Entry::getItemGenresDefine() as $item_genres => $name) { ?>
	<label class="checkbox">
	  <input type="checkbox" id="item" name="item_genres[]" value="<?php echo e($item_genres); ?>"<?php if (isset($input_genres[$item_genres])) { echo ' checked'; } ?>>
	  <?php echo e($name); ?>	
	</label>
	<?php } ?>
	<?php if (isset($errors['item_genres'])) { ?>
	<?php echo $errors['item_genres']; ?>
	<?php } ?>
	  </div>
	</div>
	<input type="hidden" name="fleamarket_id" value="<?php echo e($input['fleamarket_id']); ?>">
        <div id="submitButton" class="form-group">
          <button type="submit" class="btn btn-default">内容を確認する</button>
        </div>
      </form>
    </div>
  </div>
</div>
