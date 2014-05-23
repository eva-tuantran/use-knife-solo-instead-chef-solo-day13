<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">ユーザ一覧</h2>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-10">
        <form id="searchForm" class="form-horizontal" id="" action="/admin/user/list" method="post" role="form">
          <div class="form-group">
            <label for="user_id" class="col-md-1 control-label">会員番号</label>
            <div class="col-md-2">
              <?php
                  $user_id = '';
                  if (! empty($conditions['user_id'])):
                      $user_id = $conditions['user_id'];
                  endif;
              ?>
              <input type="text" class="form-control" id="user_id" placeholder="ユーザID" name="c[user_id]" value="<?php echo e($user_id);?>">
            </div>
            <label for="user_old_id" class="col-md-1 control-label">旧会員番号</label>
            <div class="col-md-2">
              <?php
                  $user_old_id = '';
                  if (! empty($conditions['user_old_id'])):
                      $user_old_id = $conditions['user_old_id'];
                  endif;
              ?>
              <input type="text" class="form-control" id="user_old_id" placeholder="旧ユーザID" name="c[user_old_id]" value="<?php echo e($user_old_id);?>">
            </div>
            <label for="user_name" class="col-md-1 control-label">名前</label>
            <div class="col-md-2">
              <?php
                  $user_name = '';
                  if (! empty($conditions['user_name'])):
                      $user_name = $conditions['user_name'];
                  endif;
              ?>
              <input type="text" class="form-control" id="user_name" placeholder="名前" name="c[user_name]" value="<?php echo e($user_name);?>">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 検 索</button>
          </div>
          <div class="form-group">
            <label for="prefecture_id" class="col-md-1 control-label">都道府県</label>
            <div class="col-md-1">
              <select class="form-control" id="prefecture_id" name="c[prefecture_id]">
                <option value=""></option>
              <?php
                  foreach ($prefectures as $prefecture_id => $prefecture_name):
                      $selected = '';
                      if (! empty($conditions['prefecture_id'])
                          && $prefecture_id == $conditions['prefecture_id']
                      ):
                          $selected = 'selected';
                      endif;
              ?>
                <option value="<?php echo $prefecture_id;?>" <?php echo $selected;?>><?php echo $prefecture_name;?></option>
              <?php
                  endforeach;
              ?>
              </select>
            </div>
            <label for="email" class="col-md-1 control-label">メールアドレス</label>
            <div class="col-md-2">
              <?php
                  $email = '';
                  if (! empty($conditions['email'])):
                      $email = $conditions['email'];
                  endif;
              ?>
              <input type="text" class="form-control" id="email" placeholder="メールアドレス" name="c[email]" value="<?php echo e($email);?>">
            </div>
            <label for="tel" class="col-md-1 control-label">電話番号</label>
            <div class="col-md-2">
              <?php
                  $tel = '';
                  if (! empty($conditions['tel'])):
                      $tel = $conditions['tel'];
                  endif;
              ?>
              <input type="text" class="form-control" id="tel" placeholder="電話番号" name="c[tel]" value="<?php echo e($tel);?>">
            </div>
          </div>
        </form>
      </div>
    </div>
    <table class="table table-hover table-condensed" style="">
      <thead>
        <tr>
          <th>会員番号<br>(旧会員番号)</th>
          <th>氏名</th>
          <th>性別</th>
          <th>都道府県</th>
          <th>住所</th>
          <th>メールアドレス</th>
          <th>電話番号</th>
          <th>強制ログイン</th>
          <th>ユーザ種別</th>
          <th>登録元</th>
          <th>状態</th>
          <th><a class="btn btn-primary btn-sm" href="/admin/user/">新規登録</a></th>
        </tr>
      </thead>
      <tbody>
        <?php
            if (! $user_list):
        ?>
        <tr>
          <td colspan="12">該当するユーザ情報はありません</td>
        </tr>
        <?php
            endif;
            foreach ($user_list as $user):
                $user_id = $user['user_id'];
        ?>
        <tr>
          <td>
            <p><a href="/admin/user/?user_id=<?php echo $user_id;?>"><?php echo e($user['user_id']);?>
            <?php
                if(@$user['user_old_id']):
            ?>
            <br>(<?php echo e($user['user_old_id']);?>)
            <?php
                endif;
            ?>
            </a></p>
          </td>
          <td>
            <p><a href="/admin/user/?user_id=<?php echo $user_id;?>"><?php echo e($user['last_name']); ?>&nbsp;<?php echo e($user['first_name']);?>
            <?php
                if (@$user['last_name_kana'] || @$user['first_name_kana']):
            ?>
            <br><span class="small">(<?php echo e($user['last_name_kana']); ?>&nbsp;<?php echo e($user['first_name_kana']);?>)</span>
            <?php
                endif;
            ?>
            </a></p>
          </td>
          <td><?php echo e(@$gender_list[$user['gender']]);?></td>
          <td><?php echo e(@$prefectures[$user['prefecture_id']]);?></td>
          <td><?php echo e($user['address']);?></td>
          <td><?php echo e($user['email']);?></td>
          <td><?php echo e($user['tel']);?></td>
          <td>
            <p><a href="/admin/user/force_login?user_id=<?php echo $user_id;?>">予約確認メールあり</a></p>
            <p><a href="/admin/user/force_login?user_id=<?php echo $user_id;?>&nomail=1">予約確認メールなし</a></p>
          </td>
          <td><?php
              if ($user['organization_flag'] == \Model_User::ORGANIZATION_FLAG_ON):
                  echo '団体・企業';
              else:
                  echo '個人';
              endif;
          ?></td>
          <td><?php echo e(@$devices[$user['device']]);?></td>
          <td><?php echo $register_statuses[$user['register_status']];?></td>
          <td>
            <a class="btn btn-default btn-sm" href="/admin/entry/list?user_id=<?php echo $user_id;?>">予約一覧</a>
            <a class="btn btn-danger btn-sm doDelete" href="/admin/user/delete?user_id=<?php echo $user_id;?>">削除</a>
          </td>
        </tr>
        <?php
            endforeach;
        ?>
      </tbody>
    </table>
  </div>
  <div class="panel-footer">
    <?php
        if ('' != ($pagnation =  $pagination->render())):
            echo $pagnation;
        elseif ($user_list):
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

  $(".doDelete").on("click", function(evt) {
    evt.preventDefault();
    var href = $(this).attr("href");
    $("#message", $dialog).text("削除してもよろしいですか？");

    $dialog.dialog({
      modal: true,
      buttons: {
        "キャンセル": function() {
          $(this).dialog( "close" );
        },
        "実行": function() {
          doDelete(href);
          $(this).dialog( "close" );
        }
      }
    });
  });

  var doDelete = function(url) {
    var url = location.protocol + "//" + location.host + url;
    $.ajax({
      type: "post",
      url: url,
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == 200) {
        message = '削除しました';
      } else if (json.status == 400) {
        message = '削除に失敗しました';
      }
      confirmDialog(message, json.status);
    }).fail(function(jqXHR, textStatus, errorThrown) {
      confirmDialog('削除に失敗しました');
    });
  };

  var confirmDialog = function(message, status) {
    $("#message", $dialog).text(message);
    $dialog.dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $(this).dialog( "close" );
          if (status == 200) {
            var action = location.href;
            $("#searchForm").attr("action", action).submit();
          }
        }
      }
    });
  };
});
</script>
