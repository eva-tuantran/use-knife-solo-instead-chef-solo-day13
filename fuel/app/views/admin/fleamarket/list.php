<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">フリマ一覧</h2>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-10">
        <form id="searchForm" class="form-horizontal" id="" action="/admin/fleamarket/list" method="post" role="form">
          <div class="form-group">
            <label for="register_type" class="col-md-1 control-label">種類</label>
            <div class="col-md-2">
              <select class="form-control" id="register_type" name="c[register_type]">
                <option value="all">すべて</option>
              <?php
                  foreach ($register_types as $register_type_id => $register_type_name):
                      $selected = '';
                      if (! empty($conditions['register_type'])
                          && $register_type_id == $conditions['register_type']
                      ):
                          $selected = 'selected';
                      endif;
              ?>
                <option value="<?php echo $register_type_id;?>" <?php echo $selected;?>><?php echo $register_type_name;?></option>
              <?php
                  endforeach;
              ?>
              </select>
            </div>
            <label for="event_status" class="col-md-1 control-label">開催状況</label>
            <div class="col-md-2">
              <select class="form-control" id="event_status" name="c[event_status]">
                <option value="all">すべて</option>
              <?php
                  foreach ($event_statuses as $event_statuse_id => $event_statuse_name):
                      $selected = '';
                      if (! empty($conditions['event_status'])
                          && $event_statuse_id == $conditions['event_status']
                      ):
                          $selected = 'selected';
                      endif;
              ?>
                <option value="<?php echo $event_statuse_id;?>" <?php echo $selected;?>><?php echo $event_statuse_name;?></option>
              <?php
                  endforeach;
              ?>
              </select>
            </div>
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
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 検 索</button>
          </div>
          <div class="form-group">
            <label for="keyword" class="col-md-1 control-label">キーワード</label>
            <div class="col-md-4">
              <?php
                  $keyword = '';
                  if (! empty($conditions['keyword'])):
                      $keyword = $conditions['keyword'];
                  endif;
              ?>
              <input type="text" class="form-control" id="keyword" placeholder="フリマ名" name="c[keyword]" value="<?php echo e($keyword);?>">
            </div>
          </div>
        </form>
      </div>
    </div>
    <table class="table table-hover table-condensed" style="">
      <thead>
        <tr>
          <th rowspan="2">フリマID</th>
          <th rowspan="2">開催日</th>
          <th rowspan="2">場所</th>
          <th rowspan="2">&nbsp;</th>
          <th rowspan="2">名前</th>
          <th colspan="<?php echo count($entry_styles) + 1;?>">予約</th>
          <th rowspan="2">開催状況</th>
          <th rowspan="2">
            <a class="btn btn-primary btn-sm" href="/admin/fleamarket/">新規登録</a>
          </th>
        </tr>
        <tr>
        <?php
            foreach ($entry_styles as $entry_style_name):
        ?>
          <th class="small"><?php echo $entry_style_name;?></th>
        <?php
            endforeach;
        ?>
          <th>計</th>
        </tr>
      </thead>
      <tbody>
      <?php
          if (! $fleamarket_list):
      ?>
        <tr>
          <td colspan="<?php echo (7 + (count($entry_styles) + 1));?>">検索条件に該当するフリマ情報はありません</td>
        </tr>
      <?php
          else:
              foreach ($fleamarket_list as $fleamarket):
                  $fleamarket_id = $fleamarket['fleamarket_id'];
      ?>
        <tr>
          <td><a href="/admin/fleamarket/?fleamarket_id=<?php echo $fleamarket_id;?>"><?php echo e($fleamarket_id);?></a></td>
          <td><?php echo e(date('Y年m月d日', strtotime($fleamarket['event_date'])));?></td>
          <td><?php echo e(@$prefectures[$fleamarket['prefecture_id']]);?></td>
          <td>
            <?php
                if ( $fleamarket['register_type'] == \Model_Fleamarket::REGISTER_TYPE_ADMIN):
            ?>
              <span class="label label-success">楽</span>
            <?php
                endif;
            ?>
          </td>
          <td><a href="/admin/fleamarket/?fleamarket_id=<?php echo $fleamarket_id;?>"><?php echo e($fleamarket['name']);?></a></td>
          <?php
              foreach ($entry_styles as $entry_style_id => $entry_style_name):
          ?>
          <td>
              <?php
                foreach ($fleamarket['entry_styles'] as $entry_style):
                    if ($entry_style_id == $entry_style['entry_style_id']):
                        echo $entry_style['reseved_booth'] . '/' . $entry_style['max_booth'];
                        break;
                    endif;
                endforeach;
              ?>
          </td>
          <?php
            endforeach;
          ?>
          <td>
              <a href="/admin/entry/list?fleamarket_id=<?php echo $fleamarket_id;?>">
              <?php
                echo @$fleamarket['total_reseved_booth'];?>/<?php echo @$fleamarket['total_booth'];
              ?>
              </a>
          </td>
          <td><?php echo e(@$event_statuses[$fleamarket['event_status']]);?></td>
          <td>
            <a class="btn btn-default btn-sm" href="/admin/entry/list?fleamarket_id=<?php echo $fleamarket_id;?>">予約一覧</a>
            <a class="btn btn-default btn-sm" href="/admin/entry/csv?fleamarket_id=<?php echo e($fleamarket_id);?>">CSV</a>
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
        elseif ($fleamarket_list):
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
