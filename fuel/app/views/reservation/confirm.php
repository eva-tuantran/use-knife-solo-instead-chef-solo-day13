<?php $input = $fieldset->input(); ?>
<?php $entry_styles = Config::get('master.entry_styles'); ?>

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
      <form action="/reservation/thanks" method="post" class="form-horizontal">
	<div class="form-group">
	  <label class="col-sm-2 control-label">出店方法</label>
	  <div class="col-sm-10">
	    <?php echo e($entry_styles[$input['fleamarket_entry_style_id']]); ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">ブース数</label>
	  <div class="col-sm-10">
	    <?php echo e($input['reserved_booth']); ?>
	  </div>
	</div>
	<div class="form-group">
	  <label class="col-sm-2 control-label">出品予定品目</label>
	  <div class="col-sm-10">
	    <?php 
	       $item_category_define = Model_Entry::getItemCategoryDefine();
	       echo e($item_category_define[$input['item_category']]);
            ?>
	    <br>
	    <?php
	       $item_genres_define = Model_Entry::getItemGenresDefine();
	       foreach ($input['item_genres'] as $item_genre) {
	       echo e($item_genres_define[$item_genre]) . "<br />";
	       }
            ?>
	  </div>
	</div>
        <div id="submitButton" class="form-group">
	  <?php echo \Form::csrf(); ?>
	  <?php if ($fleamarket_entry_style->isNeedWaiting()) { ?>
	  すでに予約数が限度に達しています。キャンセル待ちをしますか？<br />
	  <button type="submit" name="cancel" value="キャンセル待ちをする" class="btn btn-default">キャンセル待ちをする
	  <?php } else { ?>
	  <button type="submit" value="登録" class="btn btn-default">登録</button>
	  <?php } ?>
        </div>
      </form>
    </div>
  </div>
</div>
