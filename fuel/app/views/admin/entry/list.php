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
            <label for="keyword" class="col-md-1 control-label">予約番号</label>
            <div class="col-md-2">
              <input type="text" class="form-control" name="reservation_number" value="<?php echo e(\Input::param('reservation_number'));?>">
            </div>
            <label for="keyword" class="col-md-1 control-label">ユーザID</label>
            <div class="col-md-2">
              <input type="text" class="form-control" name="user_id" value="<?php echo e(\Input::param('user_id'));?>">
            </div>
            <label for="keyword" class="col-md-1 control-label">名前</label>
            <div class="col-md-2">
              <input type="text" class="form-control" name="user_name" value="<?php echo e(\Input::param('user_name'));?>">
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
          <th>名前</th>
          <th>状態</th>
          <th>出店形態</th>
          <th>ブース数</th>
          <th>カテゴリ</th>
          <th>ジャンル</th>
          <th>登録元</th>
          <th>反響</th>
        </tr>
      </thead>
      <tbody>
        <?php
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
          <td>
            <a href="/admin/user/?user_id=<?php echo $entry['user_id'];?>">
              <?php echo e($entry['last_name'] . '&nbsp;' . $entry['first_name']);?>
            </a>
          </td>
          <td class="<?php echo $entry_status_class;?>"><?php echo e(@$entry_statuses[$entry['entry_status']]);?></td>
          <td><?php echo e(@$entry_styles[$entry['entry_style_id']]);?></td>
          <td><?php echo e($entry['reserved_booth']);?></td>
          <td><?php echo e(@$item_categories[$entry['item_category']]);?></td>
          <td><?php echo e($entry['item_genres']);?></td>
          <td><?php //echo e($entry['register_type']);?></td>
          <td><?php echo e($entry['link_from']);?></td>
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
  $(".pagination li", ".panel-footer").on("click", function(evt) {
    evt.preventDefault();
    var action = $("a", this).attr("href");
    $("#searchForm").attr("action", action).submit();
  });
});
</script>
