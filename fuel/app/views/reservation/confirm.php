<?php
    $input = $fieldset->input();
    $entry_styles = Config::get('master.entry_styles');
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
    <form action="/reservation/thanks" method="post" class="form-horizontal">
      <?php echo \Form::csrf(); ?>
      <div class="box clearfix">
        <h3>フリマ予約の内容確認</h3>
        <div class="form-group">
  	    <label class="col-sm-2 control-label">出店方法</label>
          <div class="col-sm-10"><?php echo e($entry_styles[$fleamarket_entry_style->entry_style_id]); ?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">ブース数</label>
          <div class="col-sm-10"><?php echo e($input['reserved_booth']); ?></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">出品予定品目</label>
          <div class="col-sm-10">
            <p><?php
                $item_category_define = \Model_Entry::getItemCategories();
                echo e($item_category_define[$input['item_category']]);
            ?></p>
            <ul><?php
                $item_genres_define = \Model_Entry::getItemGenres();
                foreach ($input['item_genres'] as $item_genre):
                    echo '<li>' . e($item_genres_define[$item_genre]) . "</li>";
                endforeach;;
            ?></ul>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">このフリマをどこで知りましたか</label>
          <div class="col-sm-10"><?php echo e($input['link_from']);?></div>
        </div>
        <div id="submitButton" class="form-group">
          <button type="submit" value="登録" class="btn btn-default">登録</button>
        </div>
      </div>
    </form>
  </div>
</div>
