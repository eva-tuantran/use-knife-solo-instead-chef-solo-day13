<h2>マイページ</h2>

<div class="container">
  <div class="row">

    <div class="col-md-2">
      <div class="panel panel-info">
        <img data-src="holder.js/158x158" alt="thumbnail">
        ようこそ <?php echo Auth::get_screen_name(); ?> さん
        <ul>
          <li>フリマ登録情報</li>
          <li><a href="/mypage/account">アカウント設定</a></li>
          <li><a href="/login/out">ログアウト</a></li>
        </ul>
      </div>
    </div>

    <div class="col-md-10">

      <div class="panel panel-default panel-primary">
        <div class="panel-heading">フリマ予約情報</div>
        <div class="panel-body">
          <?php if(empty($entries)): ?>
              <p>現在予約しているフリーマーケットがありません。</p>
          <?php else: ?>
          <?php foreach($entries as $entry): ?>
              <div class="col-md-4" style="margin-bottom: 30px;">
                <div class="thumbnail">
                  <img data-src="holder.js/245x200" alt="thumbnail">
                  <div class="caption">
                    <ul>
                      <li><?php echo $entry['event_date'] ?></li>
                      <li><?php echo $entry['name'] ?></li>
                      <li><?php echo $entry['fleamarket_entry_style_name'] ?></li>
                      <li>ブース</li>
                    </ul>
                    <p>
                      <form action="/mypage/cancel" accept-charset="utf8" method="post">
                        <input type="hidden" name="fleamarket_id" value="<?php echo $entry['fleamarket_id'] ?>" />
                        <input type="submit" name="submit" class="btn btn-primary" value="予約解除" />
                      </form>
                    <p><a href="/detail/<?php echo $entry['fleamarket_id'] ?>" class="btn btn-primary" role="button">詳細を確認する</a></p>
                  </div>
                </div>
              </div>
          <?php endforeach; ?>
          <?php endif ?>
        </div>
      </div>

    </div>

  </div>

  </div>
</div>
