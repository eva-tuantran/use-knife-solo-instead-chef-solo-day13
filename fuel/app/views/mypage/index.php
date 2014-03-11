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

          <?php for($i=0; $i<6; $i++): ?>
          <div class="col-md-4" style="margin-bottom: 30px;">
            <div class="thumbnail">
              <img data-src="holder.js/245x200" alt="thumbnail">
              <div class="caption">
                <h4>国分寺フリマ</h4>
                <ul>
                  <li>2014/11/30</li>
                  <li>開催名</li>
                  <li>手持ち出店</li>
                  <li>ブース</li>
                </ul>
                <p><a href="#" class="btn btn-warning" role="button">予約解除</a>
                <a href="#" class="btn btn-default" role="button">予約解除</a></p>
                <p><a href="#" class="btn btn-primary" role="button">詳細を確認する</a></p>
              </div>
            </div>
          </div>
          <?php endfor; ?>

        </div>
      </div>
    </div>
  </div>
</div>




