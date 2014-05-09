<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $entry_styles = Config::get('master.entry_styles'); ?>
<?php $nomail = Session::get('admin.user.nomail'); ?>
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
      <h3>フリマ予約情報入力欄</h3>
      <?php if (count($fleamarket->fleamarket_entry_styles) == 0){ ?>
      <span class="errorMessage">現在予約することが出来ません</span>
      <?php }elseif ($user->hasEntry($fleamarket->fleamarket_id)) { ?>
      <span class="errorMessage">既に予約済みです。キャンセルの場合、<a href="/mypage">マイページにてキャンセル</a>を行って下さい。</span>
      <?php }elseif ($user->hasWaiting($fleamarket->fleamarket_id)) { ?>
      <span class="errorMessage">既にキャンセル待ち済みです。</span>
      <?php }else{ ?>
      <form action="/reservation/confirm" method="POST" class="form-horizontal">

	<div class="form-group">
	  <label class="col-sm-2 control-label">フリマ開催名</label>
	  <div class="col-sm-10">
	    <label class="control-label fleamarket_content"><?php echo e($fleamarket->name); ?></label>
	  </div>
	</div>

	<div class="form-group">
	  <label class="col-sm-2 control-label">出店方法</label>
	  <div id="radio" class="col-sm-10">
            <?php foreach ($fleamarket->fleamarket_entry_styles as $fleamarket_entry_style){ ?>

            <label class="checkbox-inline fleamarket_content">
              <input type="radio" name="fleamarket_entry_style_id"
		     value="<?php echo $fleamarket_entry_style->fleamarket_entry_style_id; ?>"<?php if ($input['fleamarket_entry_style_id']
												    == $fleamarket_entry_style->fleamarket_entry_style_id) {
                     echo ' checked';} ?>>

            <?php echo e($entry_styles[$fleamarket_entry_style->entry_style_id]); ?>
            </label>
            <?php } ?>
            <?php if (isset($errors['fleamarket_entry_style_id'])) { ?>
            <span class="errorMessage"><?php echo $errors['fleamarket_entry_style_id']; ?></span>
            <?php } ?>
	  </div>
	</div>
	<div id="form-no-waiting">
	  <div class="form-group">
	    <label class="col-sm-2 control-label">ブース数</label>
	    <div class="col-sm-10">
              <select name="reserved_booth" id="reserved_booth">
		<option value="1">1</option>
              </select>
              <?php if (isset($errors['reserved_booth'])) { ?>
              <span class="errorMessage"><?php echo $errors['reserved_booth']; ?></span>
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
	      <span class="errorMessage"><?php echo $errors['item_category']; ?></span>
	      <?php } ?>
	      <?php foreach (Model_Entry::getItemGenresDefine() as $item_genres => $name) { ?>
	      <label class="checkbox">
		<input type="checkbox" id="item" name="item_genres[]" value="<?php echo e($item_genres); ?>"<?php if (isset($input_genres[$item_genres])) { echo ' checked'; } ?>>
		<?php echo e($name); ?>
	      </label>
	      <?php } ?>
	      <?php if (isset($errors['item_genres'])) { ?>
	      <span class="errorMessage"><?php echo $errors['item_genres']; ?></span>
	      <?php } ?>
	    </div>
	  </div>

  <div class="form-group">
      <label class="col-sm-2 control-label">このフリマをどこで知りましたか?</label>
      <div class="col-sm-10">
        <select name="item_category" class="form-control">

        </select>
        <?php if (isset($errors['item_category'])) { ?>
        <span class="errorMessage"><?php echo $errors['item_category']; ?></span>
        <?php } ?>
        <?php if (isset($errors['item_genres'])) { ?>
        <span class="errorMessage"><?php echo $errors['item_genres']; ?></span>
        <?php } ?>
      </div>
    </div>

	  <input type="hidden" name="fleamarket_id" value="<?php echo e($input['fleamarket_id']); ?>">
          <div id="submitButton" class="form-group">
            <button type="submit" class="btn btn-default">内容を確認する<?php if(isset($nomail) && $nomail) {echo '(メール送信なし)';} ?></button>
          </div>
	</div>
      </form>
      <form action="/reservation/waiting" method="POST" id="waiting-form">
	<div id="form-waiting" style="display:none;">
	  <div class="form-group">
	    <label class="col-sm-2 control-label"></label>
	    <div class="col-sm-10">
	      <label class="control-label">ブースが予定数に達しました。キャンセル待ちをしますか？</label>
	    </div>
	  </div>
          <div id="submitButton" class="form-group">
	    <input type="hidden" name="fleamarket_id" value="<?php echo e($input['fleamarket_id']); ?>">
	    <input type="hidden" name="fleamarket_entry_style_id" id="waiting_fleamarket_entry_style_id">
            <button type="submit" class="btn btn-default" name="waiting">キャンセル待ちをする</button>
          </div>
	</div>
	<?php echo \Form::csrf(); ?>
      </form>
      <?php } ?>
    </div>
  </div>
</div>

<?php
   $reservation_booth_limit = array();
   $remain_booth = array();

   foreach ($fleamarket->fleamarket_entry_styles as $fleamarket_entry_style){
     $reservation_booth_limit[$fleamarket_entry_style->fleamarket_entry_style_id] =
                  $fleamarket_entry_style->reservation_booth_limit;
     $remain_booth[$fleamarket_entry_style->fleamarket_entry_style_id] =
                  $fleamarket_entry_style->remainBooth();
   }
?>
<script type="text/javascript">
  var reservation_booth_limit = <?php echo json_encode($reservation_booth_limit); ?>;
  var remain_booth = <?php echo json_encode($remain_booth); ?>;
  var can_reserve = <?php echo json_encode($fleamarket->canReserve()); ?>;

  $('input[name="fleamarket_entry_style_id"]').change(function(){

    var id = $('input[name="fleamarket_entry_style_id"]:checked').val();

    if(!id){
        $('#form-waiting').hide();
        $('#form-no-waiting').hide();
    }else if(!can_reserve || remain_booth[id] <= 0){
        $('#form-waiting').show();
        $('#form-no-waiting').hide();
        $('#waiting_fleamarket_entry_style_id').val(id);
    }else if(id){
      $('#form-no-waiting').show();
      $('#form-waiting').hide();

      $('#reserved_booth > option').remove();

      var max = remain_booth[id] < reservation_booth_limit[id] ? remain_booth[id] : reservation_booth_limit[id];
      for(var i = 1; i<= max ; i++){
        $('#reserved_booth').append($('<option>').html(i).val(i));
      }
    }
  });

  $('input[name="fleamarket_entry_style_id"]').trigger('change');
  $('#reserved_booth').val(<?php echo e($input['reserved_booth']); ?>);
</script>
