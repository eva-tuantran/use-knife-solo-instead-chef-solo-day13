<style type="text/css">
#container {
  text-align: center;
}

.contents {
  margin: 0 auto 30px;
  position: relative;
  padding: 45px 15px 15px;
  background-color: #fff;
  border-width: 1px;
  border-color: #ddd;
  border-radius: 4px 4px 0 0;
  box-shadow: none;
  width: 40%;
  text-align: left;
}

.users {
  margin: 0 auto 30px;
  position: relative;
  padding: 45px 15px 15px;
  background-color: #fff;
  border-width: 1px;
  border-color: #ddd;
  border-radius: 4px 4px 0 0;
  box-shadow: none;
  width: 100%;
  text-align: left;
  height: 300px;
  overflow: scroll;
}

.btn-list {
  margin: 0 auto 30px;
  width: 100%;
  list-style: none;
}

.btn-list li {
  margin-left: 20px;
  float: left;
}

.mail-item {
  padding: 10px;
  border: 1px solid #e6e6fa;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  background-color: #ffffe0;
}

.mail-body {
  min-height: 500px;
}

</style>
<div id="container">
  <div class="contents">
    <form id="mailmagazineForm" role="form" action="/admin/mailmagazine/thanks" method="post" class="form-horizontal">
      <div class="form-group">
        <label>送信種類</label>
        <p class="mail-item"><?php
            switch ($input_data['mail_magazine_type']):
                case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL:
                    echo '全員';
                    break;
                case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                    echo '希望者【' . $prefectures[$input_data['prefecture_id']] . '】';
                    break;
                case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
                    echo '出店予約者';
                    break;
            endswitch;
        ?></p>
      </div>
      <div class="form-group">
        <label>送信メールアドレス</label>
        <p class="mail-item"><?php echo $input_data['from_email'];?></p>
      </div>
      <div class="form-group">
        <label>送信名</label>
        <p class="mail-item"><?php echo $input_data['from_name'];?></p>
      </div>
      <div class="form-group">
        <label>件名</label>
        <p class="mail-item"><?php echo $input_data['subject'];?></p>
      </div>
      <div class="form-group">
        <label for="exampleInputFile">本文</label>
        <p class="mail-item mail-body"><?php echo nl2br(e($body));?></p>
      </div>
      <?php
          $type = $input_data['mail_magazine_type'];
          if ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST
              || $type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY
          ):
              if ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST):
      ?>
      <div class="form-group">
        <label>都道府県</label>
        <p class="mail-item"><?php echo $prefectures[$input_data['prefecture_id']];?></p>
      </div>
      <?php
              elseif ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY):
      ?>
      <div class="form-group">
        <label>フリーマーケット</label>
        <p class="mail-item"><?php echo $fleamarket['name'];?></p>
      </div>
      <?php
              endif;
      ?>
      <div class="form-group">
        <label>対象者数</label>
        <p class="mail-item"><?php echo count($users);?></p>
      </div>
      <div class="form-group">
        <label>対象者一覧</label>
      </div>
      <div class="users">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>名前</th>
            </tr>
          </thead>
          <tbody>
            <?php
                if (! isset($users) || count($users) == 0):
            ?>
            <tr>
              <td colspan="2">対象ユーザはいません</td>
            </tr>
            <?php
                else:
                    foreach ($users as $user):
            ?>
            <tr>
              <td><?php echo e($user['last_name'] . ' ' . $user['first_name']);?></td>
            </tr>
            <?php
                    endforeach;
                endif;
            ?>
          </tbody>
        </table>
      </div>
      <?php
          endif;
      ?>
      <ul class="btn-list clearfix">
        <li><a href="/admin/mailmagazine" class="btn btn-default">入力に戻る</a></li>
        <?php
            if (! isset($users) || (isset($users) && count($users) > 0)):
        ?>
        <li><button id="doTestSend" type="button" class="btn btn-success">テスト送信する</button></li>
        <li><button id="doSend" type="button" class="btn btn-success"><input id="sendCheck"type="checkbox">送信する</button></li>
        <?php
            endif;
        ?>
      </ul>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function() {
  $("#doTestSend").on("click", function(evt) {
    var deliveredTo = prompt("送信先メールアドレス", "ida@aucfan.com");
    if (! deliveredTo) {
      return false;
    }

    $.ajax({
      type: "post",
      url: '/admin/mailmagazine/test',
      data: {deliveredTo: deliveredTo},
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == '200') {
        alert('送信しました');
      } else {
        alert('送信に失敗しました\n' + json.message);
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      alert('送信に失敗しました');
    });
  });

  $("#sendCheck").on("click", function(evt) {
      evt.stopPropagation();
  });

  $("#doSend").on("click", function(evt) {
    if (! $("#sendCheck").prop("checked")) {
        alert("チェックしてください");
        return false;
    }

    $.ajax({
      type: "post",
      url: '/admin/mailmagazine/checkprocess',
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == '200') {
        if (confirm("送信を開始してよろしいでつか？")) {
            $("#mailmagazineForm").submit();
        }
      } else if (json.status == '300') {
        alert('他の送信処理が実行されています');
      } else {
        alert('送信確認でエラーが発生しました\n' + json.message);
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      alert('送信確認でエラーが発生しました\n' + textStatus);
    });
  });
});
</script>
