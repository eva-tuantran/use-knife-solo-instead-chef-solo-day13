<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">フリマ予約の完了</h2>
  </div>
  <div class="panel-body">
    <div id="contentThanks" class="row">
      <div id="message" class="container">
        <div class="box clearfix">
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
  </div>
