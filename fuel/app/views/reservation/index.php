<?php
    $input  = $fieldset->input();
    $errors = $fieldset->validation()->error_message();
    $entry_styles = Config::get('master.entry_styles');
    $nomail = Session::get('admin.user.nomail');

    $input_genres = array();
    if ($input['item_genres']) {
        foreach ($input['item_genres'] as $item_genre) {
            $input_genres[$item_genre] = 1;
        }
    }
    $fleamarket_id = $fleamarket->fleamarket_id;
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
      <?php if (count($fleamarket->fleamarket_entry_styles) == 0):?>
      <div class="errorMessage">現在予約することが出来ません</div>
      <?php elseif ($user->hasReserved($fleamarket_id)):?>
      <div class="errorMessage">既に予約済みです。解除を希望の場合、<a href="/mypage">マイページにてキャンセル</a>を行って下さい。</div>
      <?php elseif ($user->hasWaiting($fleamarket_id) && ! \Model_Fleamarket::isBoothEmpty($fleamarket_id)):?>
      <div class="errorMessage">既にキャンセル待ちをしています。解除を希望の場合、<a href="/mypage">マイページにてキャンセル</a>を行って下さい。</div>
      <?php else:?>
      <form action="/reservation/confirm" method="post" class="form-horizontal">
        <input type="hidden" name="fleamarket_id" value="<?php echo e($input['fleamarket_id']); ?>">
        <div class="form-group">
          <label class="col-sm-2 control-label">フリマ開催名</label>
          <div class="col-sm-10">
            <label class="control-label fleamarket_content"><?php echo e($fleamarket->name);?></label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">出店方法</label>
          <div id="radio" class="col-sm-10">
            <?php
                foreach ($fleamarket->fleamarket_entry_styles as $fleamarket_entry_style):
                    $checked = '';
                    if ($input['fleamarket_entry_style_id'] == $fleamarket_entry_style->fleamarket_entry_style_id):
                        $checked = 'checked';
                    endif;
            ?>
            <label class="checkbox-inline fleamarket_content">
              <input type="radio" name="fleamarket_entry_style_id" value="<?php echo $fleamarket_entry_style->fleamarket_entry_style_id; ?>" <?php echo $checked;?>>
               <?php echo e($entry_styles[$fleamarket_entry_style->entry_style_id]); ?>
            </label>
            <?php
                endforeach;
            ?>
            <?php if (isset($errors['fleamarket_entry_style_id'])):?>
              <div class="errorMessage"><?php echo $errors['fleamarket_entry_style_id']; ?></div>
            <?php endif;?>
	      </div>
        </div>
        <div id="form-no-waiting">
          <div class="form-group">
            <label class="col-sm-2 control-label">ブース数</label>
            <div class="col-sm-10">
              <select name="reserved_booth" id="reserved_booth">
                <option value="1">1</option>
              </select>
              <?php if (isset($errors['reserved_booth'])):?>
              <div class="errorMessage"><?php echo $errors['reserved_booth']; ?></div>
              <?php endif;?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">出店予定品目</label>
            <div class="col-sm-10">
              <select name="item_category" class="form-control">
              <?php
                  foreach ($item_categories as $item_category => $name):
                      $selected = '';
                      if ($input['item_category'] == $item_category):
                          $selected = 'selected';
                      endif;
              ?>
                <option value="<?php echo e($item_category); ?>" <?php echo $selected;?>><?php echo e($name);?></option>
              <?php
                  endforeach;
              ?>
              </select>
              <?php if (isset($errors['item_category'])):?>
              <div class="errorMessage"><?php echo $errors['item_category'];?></div>
              <?php endif;?>
              <?php
                  foreach ($item_genres as $item_genre => $name):
                      $checked = '';
                      if (isset($input_genres[$item_genre])):
                          $checked = 'checked';
                      endif;
              ?>
              <label class="checkbox">
                <input type="checkbox" id="item" name="item_genres[]" value="<?php echo e($item_genre);?>"<?php echo $checked;?>><?php echo e($name);?>
              </label>
              <?php
                  endforeach;
              ?>
              <?php if (isset($errors['item_genres'])):?>
              <div class="errorMessage"><?php echo $errors['item_genres'];?></div>
              <?php endif;?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">このフリマをどこで知りましたか?</label>
            <div class="col-sm-10">
              <select name="link_from" class="form-control">
              <?php
                  foreach (\Model_Fleamarket::explodeLinkFromList($fleamarket->link_from_list) as $key => $link_from):
                      $selected = '';
                      if ($input['link_from'] == $link_from):
                          $selected = 'selected';
                      endif;
              ?>
                <option value="<?php echo e($link_from); ?>" <?php echo $selected;?>><?php echo e($link_from); ?></option>
              <?php
                  endforeach;
              ?>
              </select>
              <?php if(isset($errors['link_from'])): ?>
              <span class="errorMessage"><?php echo $errors['link_from'];?></span>
              <?php endif;?>
            </div>
          </div>
          <div id="submitButton" class="form-group">
            <button type="submit" class="btn btn-default">内容を確認する<?php if(isset($nomail) && $nomail) {echo '(メール送信なし)';} ?></button>
          </div>
        </div>
      </form>
      <form action="/reservation/waiting" method="post" id="waiting-form">
        <?php echo \Form::csrf(); ?>
        <div id="form-waiting" style="display:none;">
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <p>ブースが予定数に達しました。キャンセル待ちをしますか？</p>
            </div>
          </div>
          <div id="submitButton" class="form-group">
            <input type="hidden" name="fleamarket_id" value="<?php echo e($input['fleamarket_id']); ?>">
            <input type="hidden" name="fleamarket_entry_style_id" id="waiting_fleamarket_entry_style_id">
            <button type="submit" class="btn btn-default" name="waiting">キャンセル待ちをする</button>
          </div>
        </div>
      </form>
      <?php endif;?>
    </div>
  </div>
</div>
<?php
    $reservation_booth_limit = array();
    $remain_booth = array();

    foreach ($fleamarket->fleamarket_entry_styles as $fleamarket_entry_style):
        $reservation_booth_limit[$fleamarket_entry_style->fleamarket_entry_style_id] =
            $fleamarket_entry_style->reservation_booth_limit;
        $remain_booth[$fleamarket_entry_style->fleamarket_entry_style_id] =
            $fleamarket_entry_style->remainBooth();
    endforeach;;
?>
<script type="text/javascript">
var reservation_booth_limit = <?php echo json_encode($reservation_booth_limit);?>;
var remain_booth = <?php echo json_encode($remain_booth);?>;
var can_reserve = <?php echo json_encode($fleamarket->canReserve());?>;

$('input[name="fleamarket_entry_style_id"]').change(function(){
  var id = $('input[name="fleamarket_entry_style_id"]:checked').val();

  if (! id) {
    $('#form-waiting').hide();
    $('#form-no-waiting').hide();
  } else if (! can_reserve || remain_booth[id] <= 0) {
    $('#form-waiting').show();
    $('#form-no-waiting').hide();
    $('#waiting_fleamarket_entry_style_id').val(id);
  } else if (id) {
    $('#form-no-waiting').show();
    $('#form-waiting').hide();

    $('#reserved_booth > option').remove();

    var max = remain_booth[id] < reservation_booth_limit[id] ? remain_booth[id] : reservation_booth_limit[id];
    for (var i = 1; i <= max ; i++) {
      $('#reserved_booth').append($('<option>').html(i).val(i));
    }
  }
});

$('input[name="fleamarket_entry_style_id"]').trigger('change');
$('#reserved_booth').val(<?php echo e($input['reserved_booth']);?>);
</script>
