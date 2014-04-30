<?php
    $input  = $fieldsets['fleamarket']->input();
    $errors = $fieldsets['fleamarket']->validation()->error_message();
    $fields = $fieldsets['fleamarket']->field();

    $is_delete = array();
    if (isset($input['delete_priorities'])){
        foreach ($input['delete_priorities'] as $priority){
            $is_delete[$priority] = 1;
        }
    }
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">フリマ確認</h2>
  </div>
  <div class="panel-body">
    <form action="/admin/fleamarket/thanks" method="post">
      <?php echo Form::csrf(); ?>
      <input type="hidden" name="fleamarket_id" value="<?php echo e(Input::param('fleamarket_id')); ?>">
      <div class="row">
        <div class="col-md-6">
          <table class="table">
            <tr>
              <td>開催地</td>
              <td><?php
                 foreach ($locations as $location):
                     if ($location->location_id == $input['location_id']):
                         echo e($location->name);
                         break;
                     endif;
                 endforeach;
              ?></td>
            </tr>
            <tr>
              <td>フリマ名</td>
              <td><?php echo e($input['name']);?></td>
            </tr>
            <tr>
              <td>主催者名</td>
              <td><?php echo e($input['promoter_name']);?></td>
            </tr>
            <tr>
              <td>開催日</td>
              <td><?php echo e($input['event_date']);?></td>
            </tr>
            <tr>
              <td>開催時間</td>
              <td><?php echo e($input['event_time_start']);?></td>
            </tr>
            <tr>
              <td>終了時間</td>
              <td><?php echo e($input['event_time_end']);?></td>
            </tr>
            <tr>
              <td>開催状況</td>
              <td><?php echo $event_statuses[$input['event_status']];?></td>
            </tr>
            <tr>
              <td>内容</td>
              <td><?php echo e($input['description']);?></td>
            </tr>
            <tr>
              <td>予約受付開始日</td>
              <td><?php echo e($input['reservation_start']);?></td>
            </tr>
            <tr>
              <td>予約受付終了日</td>
              <td><?php echo e($input['reservation_end']);?></td>
            </tr>
            <tr>
              <td>予約受付電話番号</td>
              <td><?php echo e($input['reservation_tel']);?></td>
            </tr>
            <tr>
              <td>予約受付E-mailアドレス</td>
              <td><?php echo e($input['reservation_email']);?></td>
            </tr>
            <tr>
              <td>主催者ホームページ</td>
              <td><?php echo e($input['website']);?></td>
            </tr>
            <tr>
              <td>出品物の種類</td>
              <td><?php echo e($input['item_categories']);?></td>
            </tr>
            <tr>
              <td>反響項目リスト</td>
              <td><?php echo e($input['link_from_list']);?></td>
            </tr>
            <tr>
              <td>ピックアップ</td>
              <td><?php echo $input['pickup_flag'] == \Model_Fleamarket::PICKUP_FLAG_ON ? '対象' : '対象外';?></td>
            </tr>
            <tr>
              <td>出店料</td>
              <td><?php echo $input['shop_fee_flag'] == \Model_Fleamarket::SHOP_FEE_FLAG_CHARGE? '有料' : '無料';?></td>
            </tr>
            <tr>
              <td>車出店</td>
              <td><?php echo $input['car_shop_flag'] == \Model_Fleamarket::CAR_SHOP_FLAG_OK? 'OK' : 'NG';?></td>
            </tr>
            <tr>
              <td>プロ出店</td>
              <td><?php echo $input['pro_shop_flag'] == \Model_Fleamarket::PRO_SHOP_FLAG_OK? 'OK' : 'NG';?></td>
            </tr>
            <tr>
              <td>有料駐車場</td>
              <td><?php echo $input['charge_parking_flag'] == \Model_Fleamarket::CHARGE_PARKING_FLAG_EXIST? 'あり' : 'なし';?></td>
            </tr>
            <tr>
              <td>無料駐車場</td>
              <td><?php echo $input['free_parking_flag'] == \Model_Fleamarket::FREE_PARKING_FLAG_EXIST? 'あり' : 'なし';?></td>
            </tr>
            <tr>
              <td>雨天開催会場</td>
              <td><?php echo $input['rainy_location_flag'] == \Model_Fleamarket::RAINY_LOCATION_FLAG_EXIST? '対象' : 'なし';?>
              </td>
            </tr>
            <tr>
              <td>表示</td>
              <td><?php echo $input['display_flag'] ? '表示' : '非表示'; ?></td>
            </tr>
            <tr>
              <td>予約状況</td>
              <td><?php
                  if ($input['event_reservation_status'] == \Model_Fleamarket::EVENT_RESERVATION_STATUS_ENOUGH):
                      echo 'まだまだあります';
                  elseif ($input['event_reservation_status'] == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FEW):
                      echo '残り僅か！';
                  elseif ($input['event_reservation_status'] == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL):
                      echo '満員';
                  endif;
              ?></td>
            </tr>
            <tr>
              <td>登録タイプ</td>
              <td><?php
                  if ($input['register_type'] == \Model_Fleamarket::REGISTER_TYPE_ADMIN):
                      echo '運営事務局';
                  elseif ($input['register_type'] == \Model_Fleamarket::REGISTER_TYPE_USER):
                      echo 'ユーザー投稿';
                  endif;
              ?></td>
            </tr>
          </table>
        </div>
        <div class="col-md-6">
          <h3>画像イメージ</h3>
          <table class="table">
            <?php foreach (range(1, 4) as $priority):?>
            <tr>
              <td>ファイル<?php echo($priority); ?></td>
              <td>
                <?php if (isset($is_delete[$priority])):?>
                <img src="<?php echo $fleamarket->fleamarket_image($priority)->Url(); ?>">(削除)
                <?php elseif (isset($files["upload${priority}"])):?>
                <img src="/files/admin/fleamarket/img/<?php echo $files["upload${priority}"]['saved_as']; ?>">(更新)
                <?php elseif( $fleamarket && $fleamarket->fleamarket_image($priority) ):?>
                <img src="<?php echo $fleamarket->fleamarket_image($priority)->Url(); ?>">
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach;?>
          </table>
        </div>
        <div class="col-md-6">
          <h3>説明</h3>
          <table class="table">
            <?php foreach (\Model_Fleamarket_About::getAboutTitles() as $id => $title):?>
            <tr>
              <td><?php echo e($title); ?></td>
              <td><?php
                  $input = $fieldsets['fleamarket_abouts'][$id]->input();
                  echo e($input['description']);
            ?></td>
            </tr>
            <?php endforeach;?>
          </table>
        </div>
        <div class="col-md-6">
          <h3>出店形態</h3>
          <table class="table">
            <?php foreach ($entry_styles as $id => $entry_style):?>
            <tr>
              <td><?php echo e($entry_style); ?></td>
              <td>
                <p>出店料：<?php
                    $input = $fieldsets['fleamarket_entry_styles'][$id]->input();
                    echo e($input['booth_fee']);
                ?></p>
                <p>最大出店ブース数：<?php
                   $input = $fieldsets['fleamarket_entry_styles'][$id]->input();
                   echo e($input['max_booth']);
                ?></p>
                <p>予約可能出店ブース上限：<?php
                     $input = $fieldsets['fleamarket_entry_styles'][$id]->input();
                     echo e($input['reservation_booth_limit']);
                ?></p>
              </td>
            </tr>
            <?php endforeach;?>
          </table>
        </div>
        <div class="col-md-12 btn-group">
          <button type="submit" class="btn btn-primary">登録する</button>
        </div>
      </div>
    </form>
  </div>
  <div class="panel-footer">
    <div class="row">
        <div class="col-md-1">登録日時</div>
        <div class="col-md-2"><?php
            if (isset($fleamarket)):
               echo e($fleamarket->created_at);
            endif;
        ?></div>
        <div class="col-md-1">更新日時</div>
        <div class="col-md-2"><?php
            if (isset($fleamarket)):
               echo e($fleamarket->updated_at);
            endif;
        ?></div>
    </div>
</div>
