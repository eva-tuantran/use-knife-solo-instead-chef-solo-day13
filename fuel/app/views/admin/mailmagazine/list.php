<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
      <h2 class="panel-title">メルマガ一覧</h2>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-10">
        <form class="form-horizontal" id="" action="/admin/mailmagazine/list" method="post" role="form">
          <div class="form-group">
            <label for="register_type" class="col-md-1 control-label">送信種類</label>
            <div class="col-md-2">
              <select class="form-control" id="register_type" name="c[mail_magazine_type]">
                <option value=""></option>
              <?php
                  foreach ($mail_magazine_types as $mail_magazine_type_id => $mail_magazine_type_name):
                      $selected = '';
                      if (! empty($conditions['mail_magazine_type'])
                          && $mail_magazine_type_id == $conditions['mail_magazine_type']
                      ):
                          $selected = 'selected';
                      endif;
              ?>
                <option value="<?php echo $mail_magazine_type_id;?>" <?php echo $selected;?>><?php echo $mail_magazine_type_name;?></option>
              <?php
                  endforeach;
              ?>
              </select>
            </div>
            <label for="event_status" class="col-md-1 control-label">送信状況</label>
            <div class="col-md-2">
              <select class="form-control" id="event_status" name="c[send_status]">
                <option value=""></option>
              <?php
                  foreach ($send_statuses as $send_status_id => $send_status_name):
                      $selected = '';
                      if (! empty($conditions['send_status'])
                          && $send_status_id == $conditions['send_status']
                      ):
                          $selected = 'selected';
                      endif;
              ?>
                <option value="<?php echo $send_status_id;?>" <?php echo $selected;?>><?php echo $send_status_name;?></option>
              <?php
                  endforeach;
              ?>
              </select>
            </div>
            <button type="submit" class="btn btn-default" <?php echo $selected;?>><span class="glyphicon glyphicon-search"></span> 検 索</button>
          </div>
        </form>
      </div>
    </div>
    <table class="table table-hover table-condensed" style="">
      <thead>
        <tr>
          <th>メルマガID</th>
          <th>送信日時</th>
          <th>種類</th>
          <th>件名</th>
          <th>送信状態</th>
          <th>登録日時</th>
          <th><a class="btn btn-primary btn-sm" href="/admin/mailmagazine/">新規登録</a></th>
        </tr>
      </thead>
      <tbody>
      <?php
          if (! $mail_magazine_list):
      ?>
        <tr>
          <td colspan="6">該当するメルマガ情報はありません</td>
        </tr>
      <?php
          else:
              foreach ($mail_magazine_list as $mail_magazine):
                  $mail_magazine_id = $mail_magazine['mail_magazine_id'];
      ?>
        <tr>
          <!-- <td><a href="/admin/mailmagazine/index?mail_magazine_id=<?php echo $mail_magazine_id;?>"><?php echo e($mail_magazine_id);?></a></td>-->
          <td><?php echo e($mail_magazine_id);?></td>
          <td><?php
              if (! empty($mail_magazine['send_datetime'])):
                  echo e(date('Y年m月d日 H:i', strtotime($mail_magazine['send_datetime'])));
              endif;
          ?></td>
          <td><?php echo e(@$mail_magazine_types[$mail_magazine['mail_magazine_type']]);?></td>
          <!-- <td><a href="/admin/mailmagazine/index?mail_magazine_id=<?php echo $mail_magazine_id;?>"><?php echo e($mail_magazine['subject']);?></a></td>-->
          <td><?php echo e($mail_magazine['subject']);?></td>
          <td><?php echo e(@$send_statuses[$mail_magazine['send_status']]);?></td>
          <td><?php
              if (! empty($mail_magazine['created_at'])):
                  echo e(date('Y年m月d日 H:i', strtotime($mail_magazine['created_at'])));
              endif;
          ?></td>
          <td>
            <a class="btn btn-default btn-sm dropdown-toggle" href="/admin/mailmagazine/userlist/<?php echo $mail_magazine_id;?>">送信一覧</a>
            <?php
                if ($mail_magazine['send_status'] == \Model_Mail_Magazine::SEND_STATUS_SAVED):
            ?>
            <!-- <a class="btn btn-default dropdown-toggle" href="#" disabled="disabled">送信する(未実装)</a> -->
            <?php
                elseif ($mail_magazine['send_status'] == \Model_Mail_Magazine::SEND_STATUS_CANCEL):
            ?>
            <!-- <a class="btn btn-default dropdown-toggle" href="#" disabled="disabled">送信を再開する(未実装)</a> -->
            <?php
                elseif ($mail_magazine['send_status'] == \Model_Mail_Magazine::SEND_STATUS_ERROR_END):
            ?>
            <!-- <a class="btn btn-default dropdown-toggle" href="#" disabled="disabled">送信を再開する(未実装)</a> -->
            <?php
                endif;
            ?>
          </td>
        </tr>
      <?php
              endforeach;
          endif;
      ?>
      </tbody>
    </table>
  </div>
  <div class="panel-footer">
    <?php
        if ('' != ($pagnation =  $pagination->render())):
            echo $pagnation;
        elseif ($mail_magazine_list):
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
  $(".pagination li", ".panel-footer").on("click", function(evt) {
    evt.preventDefault();
    var action = $("a", this).attr("href");
    $("#searchForm").attr("action", action).submit();
  });
});
</script>
