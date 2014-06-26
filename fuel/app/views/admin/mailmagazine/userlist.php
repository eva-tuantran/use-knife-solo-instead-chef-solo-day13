<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
      <h2 class="panel-title">メルマガ送信一覧</h2>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6">
        メルマガ：<?php echo e($mail_magazine['subject']);?>
      </div>
      <div class="col-md-10">
        <table class="table table-hover table-condensed" style="">
          <thead>
            <tr>
              <th>名前</th>
              <th>送信日時</th>
              <th>送信状況</th>
            </tr>
          </thead>
          <tbody>
          <?php
              if (! $mail_magazine_user_list):
          ?>
            <tr>
              <td colspan="3">メルマガ送信先情報はありません</td>
            </tr>
          <?php
              else:
                  foreach ($mail_magazine_user_list as $mail_magazine_user):
                      $user_id = $mail_magazine_user['user_id'];
          ?>
            <tr>
              <td>
                  <?php echo e($mail_magazine_user['last_name']);?>&nbsp;<?php echo e($mail_magazine_user['first_name']);?>
              </td>
              <td><?php echo e($mail_magazine_user['updated_at']);?></td>
              <td><?php echo e(@$send_status[$mail_magazine_user['send_status']]);?></td>
            </tr>
          <?php
                  endforeach;
              endif;
          ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-12">
        <p>
          <a href="/admin/mailmagazine/list" class="btn btn-primary active" role="button">一覧に戻る</a>
        </p>
      </div>
    </div>
  </div>
  <div class="panel-footer">
    <?php
        if ('' != ($pagnation =  $pagination->render())):
            echo $pagnation;
        elseif ($mail_magazine_user_list):
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
