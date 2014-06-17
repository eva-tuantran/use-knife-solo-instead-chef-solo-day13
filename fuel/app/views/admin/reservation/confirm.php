<?php
    $input = $fieldset->input();
    $entry_styles = Config::get('master.entry_styles');
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">フリマ予約の内容確認</h2>
  </div>
  <!-- form -->
  <div class="panel-body">
    <div id="contentForm" clas="row">
      <div id="form" class="container">
        <div class="box clearfix">
          <form action="/admin/reservation/thanks" method="post" class="form-horizontal">
            <?php echo \Form::csrf(); ?>
            <div class="box clearfix">
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
    </div>
  </div>
</div>
