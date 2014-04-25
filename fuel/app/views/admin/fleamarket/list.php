<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">開催一覧</h2>
    <a class="btn btn-primary dropdown-toggle" href="/admin/fleamarket/">新規登録</a>
  </div>
  <div class="panel-body">
    <table class="table table-hover table-condensed" style="">
      <thead>
        <tr>
          <th rowspan="2">フリマID</th>
          <th rowspan="2">開催日</th>
          <th rowspan="2">場所</th>
          <th rowspan="2">名前</th>
          <th colspan="<?php echo count($entry_styles) + 1;?>">予約</th>
          <th rowspan="2">状態</th>
          <th rowspan="2">&nbsp;</th>
        </tr>
        <tr>
        <?php
            foreach ($entry_styles as $entry_Style_name):
        ?>
          <th class="small"><?php echo $entry_Style_name;?></th>
        <?php
            endforeach;
        ?>
          <th>計</th>
        </tr>
      </thead>
      <tbody>
      <?php
          foreach ($fleamarket_list as $fleamarket):
              $fleamarket_id = $fleamarket['fleamarket_id'];
      ?>
        <tr>
          <td><a class="" href="/admin/fleamarket/?fleamarket_id=<?php echo $fleamarket_id;?>"><?php echo e($fleamarket_id);?></a></td>
          <td><?php echo e(date('Y年m月d日', strtotime($fleamarket['event_date'])));?></td>
          <td><?php echo e(@$prefectures[$fleamarket['prefecture_id']]);?></td>
          <td><?php echo e($fleamarket['name']);?></td>
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
            <a class="btn btn-default dropdown-toggle" href="/admin/entry/list?fleamarket_id=<?php echo $fleamarket_id;?>">予約一覧</a>
            <a class="btn btn-default dropdown-toggle" href="/admin/entry/csv?fleamarket_id=<?php echo e($fleamarket_id);?>">CSV</a>
          </td>
        </tr>
      <?php endforeach?>
      </tbody>
    </table>
  </div>
  <div class="panel-footer">
    <?php
        if ('' != ($numbers =  $pagination->render())):
            echo $numbers;
        endif;
    ?>
  </div>
</div>
