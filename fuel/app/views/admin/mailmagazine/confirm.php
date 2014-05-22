<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">メルマガ確認</h2>
  </div>
  <div class="panel-body">
    <form id="mailmagazineForm" role="form" action="/admin/mailmagazine/thanks" method="post" class="form-horizontal">
      <?php
          echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token());
      ?>
      <div id="contents-wrap" class="row">
        <div class="col-md-6">
          <table class="table">
            <tbody>
              <tr>
                <th>送信対象</th>
                <td>
                  <p><?php
                    $type = $input_data['mail_magazine_type'];
                    $target = $mail_magazine_types[$type];
                    switch ($type):
                        case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL:
                            echo $target;
                            break;
                        case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                            echo $target . '<br>';
                            if (isset($input_data['organization_flag'])):
                                if ($input_data['organization_flag'] == \Model_User::ORGANIZATION_FLAG_OFF):
                                    echo '－' . '個人';
                                elseif ($input_data['organization_flag'] == \Model_User::ORGANIZATION_FLAG_ON):
                                    echo '－' . '企業・団体';
                                endif;
                                echo '<br>';
                            endif;

                            $prefecture_name = '全国';
                            if (isset($input_data['prefecture_id'])):
                                $prefecture_name = '';
                                foreach ($prefectures as $prefecture_id => $prefecture):
                                    if (in_array($prefecture_id, $input_data['prefecture_id'])):
                                        $prefecture_name .= $prefecture_name == '' ? '' : '、';
                                        $prefecture_name .= $prefectures[$prefecture_id];
                                    endif;
                                endforeach;
                                echo '－' . $prefecture_name;
                            endif;
                            break;
                        case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
                            echo $target . '<br>';
                            echo '－' . $fleamarket['name'];
                            break;
                    endswitch;
                  ?></p>
                </td>
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
                    elseif ($type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL):
                ?>
                <tr>
                  <td colspan="2">全員が対象です</td>
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
            <a href="/admin/mailmagazine" class="btn btn-default">入力に戻る</a>
            <?php
                if (! isset($users) || (isset($users) && count($users) > 0)):
            ?>
            <button id="doTestSend" type="button" class="btn btn-info">テスト送信する</button>
            <button id="doSend" type="button" class="btn btn-danger"><input id="sendCheck"type="checkbox">送信する</button>
            <?php
                endif;
            ?>
          </p>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function() {
  var $dialog = $("#dialog");

  $("#doTestSend").on("click", function(evt) {
    var deliveredTo = prompt("送信先メールアドレス", "テスト送信するアドレス@aucfan.com");
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
        showDialog("送信しました");
      } else {
        showDialog("送信に失敗しました\n" + json.message);
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      showDialog("送信に失敗しました");
    });
  });

  $("#sendCheck").on("click", function(evt) {
      evt.stopPropagation();
  });

  $("#doSend").on("click", function(evt) {
    if (! $("#sendCheck").prop("checked")) {
      showDialog("チェックをしてください");
      return false;
    }

    $.ajax({
      type: "post",
      url: '/admin/mailmagazine/checkprocess',
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == '300') {
        confirmDialog("送信を開始します。よろしいですか？");
      } else if (json.status == '200') {
        showDialog("他のメルマガを送信中です");
      } else {
        showDialog("送信確認でエラーが発生しました\n" + json.message);
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      showDialog("送信確認でエラーが発生しました\n" + textStatus);
    });
  });

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
        "送信": function() {
          $(this).dialog("destroy");
          var action = location.href;
　        $("#mailmagazineForm").submit();
        }
      }
    });
  };
});
</script>
