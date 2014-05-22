<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">メルマガ確認</h2>
  </div>
  <div class="panel-body">
    <form id="mailmagazineForm" role="form" action="/admin/mailmagazine/send" method="post" class="form-horizontal">
      <div id="contents-wrap" class="row">
        <div class="col-md-6">
          <table class="table">
            <tbody>
              <tr>
                <th>送信対象</th>
                <td><?php
                    $type = $input_data['mail_magazine_type'];
                    switch ($type):
                        case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL:
                            echo $mail_magazine_types[$type];
                            break;
                        case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                            $prefecture_name = '全国';
                            if (isset($input_data['prefecture_id'])):
                                $prefecture_name = '';
                                foreach ($prefectures as $prefecture_id => $prefecture):
                                    if (in_array($prefecture_id, $input_data['prefecture_id'])):
                                        $prefecture_name .= $prefecture_name == '' ? '' : '、';
                                        $prefecture_name .= $prefectures[$prefecture_id];
                                    endif;
                                endforeach;
                            endif;
                            echo  $mail_magazine_types[$type] . '－' . $prefecture_name;
                            break;
                        case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
                            echo $mail_magazine_types[$type] . '－' . $fleamarket['name'];
                            break;
                    endswitch;
                ?></td>
              </tr>
              <tr>
                <th>差出人メールアドレス</th>
                <td><?php echo $input_data['from_email'];?></td>
              </tr>
              <tr>
                <th>差出人</th>
                <td><?php echo $input_data['from_name'];?></td>
              </tr>
              <tr>
                <th>件名</th>
                <td><?php echo $input_data['subject'];?></td>
              </tr>
              <tr>
                <th>本文</th>
                <td><?php echo nl2br(e($body));?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-3">
          <h3>メルマガ対象者</h3>
          <div class="users" style="height: 500px; overflow: scroll;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>対象者数</th>
                  <td><?php echo count($users);?></td>
                </tr>
                <tr>
                  <th colspan="2">名前</th>
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
                  <td colspan="2"><?php echo e($user['last_name'] . ' ' . $user['first_name']);?></td>
                </tr>
                <?php
                        endforeach;
                    endif;
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12">
          <p>
            <a href="/admin/mailmagazine/list" class="btn btn-primary active" role="button">一覧に戻る</a>
            <button id="doStop" type="button" class="btn btn-success">送信を中止する</button>
          </p>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function() {
  var $dialog = $("#dialog");

  var timer = setInterval(function() {
    $.ajax({
      type: "post",
      url: '/admin/mailmagazine/checkprocess',
      data: {mail_magazine_id: <?php echo $mail_magazine->mail_magazine_id;?>},
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == "300") {
        $("#doStop").css("display", "none");
        clearInterval(timer);
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      clearInterval(timer);
    });
  }, 500);

  $("#doStop").on("click", function(evt) {
    evt.preventDefault();
    confirmDialog("メール送信を停止してもよろしいですか？");
  });

  var doStop = function() {
    $.ajax({
      type: "post",
      url: '/admin/mailmagazine/stop',
      data: {mail_magazine_id: <?php echo $mail_magazine->mail_magazine_id;?>},
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == "200") {
        showDialog("メール送信を停止しました");
      } else if (json.status == "300") {
        showDialog("メール送信は終了しています");
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      showDialog("メール送信を停止できませんでした\n" + json.message);
    });
  };

  var showDialog = function(message) {
    var $dialog_clone = $dialog.clone();
    $(".message", $dialog_clone).text(message);
    $dialog_clone.dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $(this).dialog("destroy");
        }
      }
    });
  };

  var confirmDialog = function(message) {
    var $dialog_clone = $dialog.clone();
    $(".message", $dialog_clone).text(message);
    $dialog_clone.dialog({
      modal: true,
      buttons: {
        "キャンセル": function() {
          $(this).dialog("destroy");
        },
        "停止": function() {
          doStop();
          $(this).dialog("destroy");
        }
      }
    });
  };
});
</script>
