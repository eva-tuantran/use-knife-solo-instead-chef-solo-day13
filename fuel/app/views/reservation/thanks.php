<div id="contentForm" class="row">
  <!-- flow -->
  <div id="flow" class="row hidden-xs">
    <div class="steps col-sm-4">
      <div class="box clearfix"><span class="step">STEP1.</span>登録内容の入力</div>
    </div>
    <div class="steps col-sm-4">
      <div class="box clearfix"><span class="step">STEP2.</span>内容確認</div>
    </div>
    <div class="steps col-sm-4">
      <div class="box active clearfix"><span class="step">STEP3.</span>登録完了</div>
    </div>
  </div>
  <!-- /flow -->
  <!-- form -->
  <div id="form" class="container">
    <div class="box clearfix">
      <h3>フリマ予約の完了</h3>
      <p>
      <?php if (! $entry):?>
      予定数に達したため出店予約きませんでした
      <?php else: ?>
      出店予約が完了しました
      <?php endif; ?>
      </p>
    </div>
  </div>
</div>

