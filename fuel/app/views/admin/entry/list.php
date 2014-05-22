<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">予約履歴一覧</h2>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-10">
        <form id="searchForm" class="form-horizontal" id="" action="/admin/entry/list" method="post" role="form">
          <input type="hidden" name="fleamarket_id" value="<?php echo e(Input::param('fleamarket_id','')); ?>">
          <div class="form-group clearfix">
            <label for="reservation_number" class="col-md-1 control-label">予約番号</label>
            <div class="col-md-2">
              <?php
                  $reservation_number = '';
                  if (! empty($conditions['reservation_number'])):
                      $reservation_number = $conditions['reservation_number'];
                  endif;
              ?>
              <input type="text" id="reservation_number" class="form-control" name="c[reservation_number]" value="<?php echo e($reservation_number);?>">
            </div>
            <label for="user_id" class="col-md-1 control-label">ユーザID</label>
            <div class="col-md-2">
              <?php
                  $user_id = '';
                  if (! empty($conditions['user_id'])):
                      $user_id = $conditions['user_id'];
                  endif;
              ?>
              <input type="text" id="user_id" class="form-control" name="c[user_id]" value="<?php echo e($user_id);?>">
            </div>
            <label for="user_name" class="col-md-1 control-label">名前</label>
            <div class="col-md-2">
              <?php
                  $user_name = '';
                  if (! empty($conditions['user_name'])):
                      $user_name = $conditions['user_name'];
                  endif;
              ?>
              <input type="text" id="user_name" class="form-control" name="c[user_name]" value="<?php echo e($user_name);?>">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 検 索</button>
          </div>
          <div class="col-md-6 well-sm">
            <table class="table">
              <?php if (isset($user)):?>
              <tr>
                <td class="col-md-3">ユーザー</td>
                <td>
                  <a href="/admin/user/?user_id=<?php echo $user->user_id; ?>">
                    <?php echo e($user->last_name); ?>&nbsp;<?php echo e($user->first_name); ?>
                  </a>
                </td>
              </tr>
              <?php endif;?>
              <?php if (isset($fleamarket)):?>
              <tr>
                <td class="col-md-3">フリマ</td>
                <td>
                  <a href="/admin/fleamarket/?fleamarket_id=<?php echo $fleamarket->fleamarket_id;?>">
                    <?php echo e($fleamarket->name); ?>
                  </a>
                </td>
              </tr>
              <?php endif;?>
              <tr>
                <td class="col-md-3">総件数<br>（ｷｬﾝｾﾙ、ｷｬﾝｾﾙ待ち含む）</td>
                <td><?php echo isset($total_count) ? $total_count : 0;?>件</td>
              </tr>
            </table>
          </div>
        </form>
      </div>
    </div>
    <table class="table table-hover table-condensed">
      <thead>
        <tr>
          <th>予約番号</th>
          <th>受付日</th>
          <th>フリマ名</th>
          <th>予約者</th>
          <th>状態</th>
          <th>出店形態</th>
          <th>ブース数</th>
          <th>カテゴリ</th>
          <th>ジャンル</th>
          <th>登録元</th>
          <th>反響</th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php
            if (! $entry_list):
        ?>
        <tr>
          <td colspan="11">該当する予約履歴情報はありません</td>
        </tr>
        <?php
          endif;
            foreach ($entry_list as $entry):
                $entry_status_class = '';
                switch ($entry['entry_status']):
                    case \Model_Entry::ENTRY_STATUS_RESERVED:
                          $entry_status_class = '';
                        break;
                    case \Model_Entry::ENTRY_STATUS_WAITING:
                        $entry_status_class = 'warning';
                        break;
                    case \Model_Entry::ENTRY_STATUS_CANCELED:
                        $entry_status_class = 'danger';
                        break;
                    default:
                        break;
                endswitch;
        ?>
        <tr>
          <td><?php echo e($entry['reservation_number']);?></td>
          <td><?php
              $created_at = strtotime($entry['created_at']);
              echo e(date('Y/m/d H:i', $created_at));
          ?></td>
          <td style="width: 15em;"><?php echo e($entry['name']);?></td>
          <td>
            <a href="/admin/user/?user_id=<?php echo $entry['user_id'];?>">
              <?php echo e($entry['last_name'] . '&nbsp;' . $entry['first_name']);?>
            </a>
          </td>
          <td class="<?php echo $entry_status_class;?>"><?php echo e(@$entry_statuses[$entry['entry_status']]);?></td>
          <td><?php echo e(@$entry_styles[$entry['entry_style_id']]);?></td>
          <td><?php echo e($entry['reserved_booth']);?></td>
          <td><?php echo e(@$item_categories[$entry['item_category']]);?></td>
          <td style="width: 10em;"><?php echo e($entry['item_genres']);?></td>
          <td><?php //echo e($entry['register_type']);?></td>
          <td><?php echo e($entry['link_from']);?></td>
          <td>
            <?php
                $disabled = '';
                if ($entry['entry_status'] != \Model_Entry::ENTRY_STATUS_RESERVED):
                    $disabled = 'disabled';
                endif;
            ?>
            <a class="btn btn-default btn-sm doSendmail <?php echo $disabled;?>" href="/admin/entry/sendmail?entry_id=<?php echo $entry['entry_id'];?>">メール送信</a>
            <a class="btn btn-warning btn-sm doCancel <?php echo $disabled;?>" href="/admin/entry/cancel?entry_id=<?php echo $entry['entry_id'];?>">予約解除</a>
          </td>
        </tr>
        <?php
            endforeach;
        ?>
      <tbody>
    </table>
  </div>
  <div class="panel-footer">
    <?php
        if ('' != ($pagnation =  $pagination->render())):
            echo $pagnation;
        elseif ($entry_list):
    ?>
    <ul class="pagination">
      <li class="disabled"><a href="javascript:void(0);" rel="prev">«</a></li>
      <li class="active"><a href="javascript:void(0);">1<span class="sr-only"></span></a></li>
      <li class="disabled"><a href="javascript:void(0);" rel="next">»</a></li>
    </ul>
    <?php
        endif;
    ?>
  </div>
</div>
<script type="text/javascript">
$(function() {
  var $dialog = $("#dialog");

  $(".pagination li", ".panel-footer").on("click", function(evt) {
    evt.preventDefault();
    var action = $("a", this).attr("href");
    $("#searchForm").attr("action", action).submit();
  });

  $(".doSendmail").on("click", function(evt) {
    evt.preventDefault();

    var href = $(this).attr("href");
    var $dialog_clone = $dialog.clone();

    $(".message", $dialog_clone).text("メールを送信します");
    $dialog_clone.append(
      '<label><input class="mails" type="checkbox" name="mails" value="reservation">出店予約メール</label>'
    );

    $dialog_clone.dialog({
      modal: true,
      buttons: {
        "キャンセル": function() {
          $(this).dialog("destroy");
        },
        "実行": function() {
          if (! $(".mails:checked").prop('checked')) {
            confirmDialog("送信するメールを選択してください");
            return;
          }
          doSendmail(href);
          $(this).dialog("destroy");
        }
      }
    });
  });

  var doSendmail = function(url) {
    var url = location.protocol + "//" + location.host + url;
    var mail = '';
    $(".mails:checked").each(function(index, checkbox) {
      mail += "&" + $(this).attr("name") + "[]=" + $(this).val();
    });
    if (mail) {
      url += encodeURI(mail);
    }

    $.ajax({
      type: "post",
      url: url,
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == 200) {
        message = 'メールを送信しました';
      } else if (json.status == 400) {
        message = 'メールの送信に失敗しました';
      }
      confirmDialog(message, json.status);
    }).fail(function(jqXHR, textStatus, errorThrown) {
      confirmDialog('メールの送信に失敗しました');
    });
  };

  $(".doCancel").on("click", function(evt) {
    evt.preventDefault();

    var href = $(this).attr("href");
    var $dialog_clone = $dialog.clone();

    $(".message", $dialog_clone).text("予約解除してもよろしいですか？");
    $(".contents", $dialog_clone).append(
      '<label><input id="sendmail" type="checkbox" name="sendmail">予約解除メールを送信する</label>'
    );

    $dialog_clone.dialog({
      modal: true,
      buttons: {
        "キャンセル": function() {
          $(this).dialog("destroy");
        },
        "実行": function() {
          doCancel(href);
          $(this).dialog("destroy");
        }
      }
    });
  });

  var doCancel = function(url) {
    var url = location.protocol + "//" + location.host + url;
    if ($("#sendmail").prop('checked')) {
      url += "&sendmail=1";
    }

    $.ajax({
      type: "post",
      url: url,
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == 200) {
        message = '出店予約を解除しました';
      } else if (json.status == 300) {
        message = '出店予約を解除しましたが、メールの送信に失敗しました。';
      } else if (json.status == 400) {
        message = '出店予約の解除に失敗しました';
      }
      confirmDialog(message, json.status);
    }).fail(function(jqXHR, textStatus, errorThrown) {
      confirmDialog('出店予約の解除に失敗しました');
    });
  };

  var confirmDialog = function(message, status) {
    var $dialog_clone = $dialog.clone();
    $(".message", $dialog_clone).text(message);
    $dialog_clone.dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $(this).dialog("destroy");
          var action = location.href;
　        $("#searchForm").attr("action", action).submit();
        }
      }
    });
  };
});
</script>
