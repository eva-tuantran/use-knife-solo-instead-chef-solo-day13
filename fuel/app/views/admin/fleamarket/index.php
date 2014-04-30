<script type="text/javascript">
$(function() {
  $("#inputEventDate").datepicker({
    numberOfMonths: 3,
    showButtonPanel: true
  });
  $("#inputReservationStart").datepicker({
    numberOfMonths: 3,
    showButtonPanel: true
  });
  $("#inputReservationEnd").datepicker({
    numberOfMonths: 3,
    showButtonPanel: true
  });
  $("#inputEventTimeStart").timepicker({
    showButtonPanel: true,
    stepMinute: 5
  });
  $("#inputEventTimeEnd").timepicker({
    showButtonPanel: true,
    stepMinute: 5
  });

  $("#accordion").accordion({
      heightStyle: "content",
      activate: function(event, ui) {}
  });
});
</script>
<?php
    $input  = $fieldsets['fleamarket']->input();
    $fields = $fieldsets['fleamarket']->field();
    $errors = $fieldsets['fleamarket']->validation()->error_message();
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">フリマ情報の入力</h2>
  </div>
  <div class="panel-body">
    <form action="/admin/fleamarket/confirm" method="post" class="form-horizontal" enctype="multipart/form-data">
      <input type="hidden" name="fleamarket_id" value="<?php echo e(\Input::param('fleamarket_id'));?>">
      <div class="row">
        <div class="col-md-6">
          <table class="fleamarket-table table">
            <tr>
              <th>開催地</th>
              <td>
                <select name="location_id">
                <?php
                    foreach ($locations as $location):
                        $selected = '';
                        if (isset($fields['location_id']->value) && $location->location_id == $fields['location_id']->value):
                            $selected = 'selected';
                        endif;
                ?>
                <option value="<?php echo $location->location_id;?>" <?php echo $selected;?>><?php echo e($location->name);?></option>
                <?php
                    endforeach;
                ?>
                </select>
              </td>
            </tr>
            <tr>
              <th>フリマ名</th>
              <td>
                <input type="text" name="name" value="<?php echo e($fields['name']->value);?>">
                <?php
                    if (isset($errors['name'])):
                       echo '<div class="error-message">' . $errors['name'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>主催者名</th>
              <td>
                <input type="text" name="promoter_name" value="<?php echo e($fields['promoter_name']->value);?>">
                <?php
                    if (isset($errors['promoter_name'])):
                       echo '<div class="error-message">' . $errors['promoter_name'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>開催日</th>
              <td>
                <input type="text" name="event_date" value="<?php echo e($fields['event_date']->value);?>" id="inputEventDate">
                <?php
                    if (isset($errors['event_date'])):
                       echo '<div class="error-message">' . $errors['event_date'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>開催時間</th>
              <td>
                <input type="text" name="event_time_start" value="<?php echo e($fields['event_time_start']->value);?>" id="inputEventTimeStart">
                <?php
                    if (isset($errors['event_time_start'])):
                       echo '<div class="error-message">' . $errors['event_time_start'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>終了時間</th>
              <td>
                <input type="text" name="event_time_end" value="<?php echo e($fields['event_time_end']->value);?>" id="inputEventTimeEnd">
                <?php
                    if (isset($errors['event_time_end'])):
                       echo '<div class="error-message">' . $errors['event_time_end'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>開催状況</th>
              <td>
                <input type="radio" name="event_status" value="<?php echo \Model_Fleamarket::EVENT_STATUS_SCHEDULE;?>" <?php if ($fields['event_status']->value == \Model_Fleamarket::EVENT_STATUS_SCHEDULE) { echo 'checked'; } ?>>開催予定
                <input type="radio" name="event_status" value="<?php echo \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT;?>" <?php if ($fields['event_status']->value == \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT) { echo 'checked'; } ?>>予約受付中
                <input type="radio" name="event_status" value="<?php echo \Model_Fleamarket::EVENT_STATUS_RECEIPT_END;?>" <?php if ($fields['event_status']->value == \Model_Fleamarket::EVENT_STATUS_RECEIPT_END) { echo 'checked'; } ?>>受付終了
                <input type="radio" name="event_status" value="<?php echo \Model_Fleamarket::EVENT_STATUS_CLOSE;?>" <?php if ($fields['event_status']->value == \Model_Fleamarket::EVENT_STATUS_CLOSE) { echo 'checked'; } ?>>開催終了
                <input type="radio" name="event_status" value="<?php echo \Model_Fleamarket::EVENT_STATUS_CANCEL;?>" <?php if ($fields['event_status']->value == \Model_Fleamarket::EVENT_STATUS_CANCEL) { echo 'checked'; } ?>>中止
                <?php
                    if (isset($errors['event_status'])):
                       echo '<div class="error-message">' . $errors['event_status'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>内容</th>
              <td>
                <textarea name="description" cols="55" rows="8"><?php echo e($fields['description']->value);?></textarea>
                <?php
                    if (isset($errors['description'])):
                       echo '<div class="error-message">' . $errors['description'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>予約受付開始日</th>
              <td>
                <input type="text" name="reservation_start" value="<?php echo e($fields['reservation_start']->value);?>" id="inputReservationStart">
                <?php
                    if (isset($errors['reservation_start'])):
                       echo '<div class="error-message">' . $errors['reservation_start'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>予約受付終了日</th>
              <td>
                <input type="text" name="reservation_end" value="<?php echo e($fields['reservation_end']->value);?>" id="inputReservationEnd">
                <?php
                    if (isset($errors['reservation_end'])):
                       echo '<div class="error-message">' . $errors['reservation_end'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>予約受付電話番号</th>
              <td>
                <input type="text" name="reservation_tel" value="<?php echo e($fields['reservation_tel']->value);?>">
                <?php
                    if (isset($errors['reservation_tel'])):
                       echo '<div class="error-message">' . $errors['reservation_tel'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>予約受付E-mailアドレス</th>
              <td>
                <input type="text" name="reservation_email" value="<?php echo e($fields['reservation_email']->value);?>">
                <?php
                    if (isset($errors['reservation_email'])):
                       echo '<div class="error-message">' . $errors['reservation_email'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>主催者ホームページ</th>
              <td>
                <input type="text" name="website" value="<?php echo e($fields['website']->value);?>">
                <?php
                    if (isset($errors['website'])):
                       echo '<div class="error-message">' . $errors['website'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>出品物の種類</th>
              <td>
                <input type="text" name="item_categories" value="<?php echo e($fields['item_categories']->value);?>">
                <?php
                    if (isset($errors['item_categories'])):
                       echo '<div class="error-message">' . $errors['item_categories'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>反響項目リスト</th>
              <td>
                <input type="text" name="link_from_list" value="<?php echo e($fields['link_from_list']->value);?>">
                <?php
                    if (isset($errors['link_from_list'])):
                       echo '<div class="error-message">' . $errors['link_from_list'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>ピックアップ</th>
              <td>
                <input type="radio" name="pickup_flag" value="<?php echo \Model_Fleamarket::PICKUP_FLAG_ON;?>" <?php if ($fields['pickup_flag']->value == \Model_Fleamarket::PICKUP_FLAG_ON) { echo 'checked'; }?>>対象
                <input type="radio" name="pickup_flag" value="<?php echo \Model_Fleamarket::PICKUP_FLAG_OFF?>" <?php if ($fields['pickup_flag']->value == \Model_Fleamarket::PICKUP_FLAG_OFF) { echo 'checked'; }?>>対象外
                <?php
                    if (isset($errors['pickup_flag'])):
                       echo '<div class="error-message">' . $errors['pickup_flag'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>出店料</th>
              <td>
                <input type="radio" name="shop_fee_flag" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_FREE;?>" <?php if ($fields['shop_fee_flag']->value == \Model_Fleamarket::SHOP_FEE_FLAG_FREE) { echo 'checked'; }?>>無料
                <input type="radio" name="shop_fee_flag" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_CHARGE;?>" <?php if ($fields['shop_fee_flag']->value == \Model_Fleamarket::SHOP_FEE_FLAG_CHARGE) { echo 'checked'; }?>>有料
                <?php
                    if (isset($errors['shop_fee_flag'])):
                       echo '<div class="error-message">' . $errors['shop_fee_flag'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>車出店</th>
              <td>
                <input type="radio" name="car_shop_flag" value="<?php echo \Model_Fleamarket::CAR_SHOP_FLAG_OK;?>" <?php if ($fields['car_shop_flag']->value == \Model_Fleamarket::CAR_SHOP_FLAG_OK) { echo 'checked'; }?>>OK
                <input type="radio" name="car_shop_flag" value="<?php echo \Model_Fleamarket::CAR_SHOP_FLAG_NG;?>" <?php if ($fields['car_shop_flag']->value == \Model_Fleamarket::CAR_SHOP_FLAG_NG) { echo 'checked'; }?>>NG
                <?php
                    if (isset($errors['car_shop_flag'])):
                       echo '<div class="error-message">' . $errors['car_shop_flag'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>プロ出店</th>
              <td>
                <input type="radio" name="pro_shop_flag" value="<?php echo \Model_Fleamarket::PRO_SHOP_FLAG_OK;?>" <?php if ($fields['pro_shop_flag']->value == \Model_Fleamarket::PRO_SHOP_FLAG_OK) { echo 'checked'; }?>>OK
                <input type="radio" name="pro_shop_flag" value="<?php echo \Model_Fleamarket::PRO_SHOP_FLAG_NG;?>" <?php if ($fields['pro_shop_flag']->value == \Model_Fleamarket::PRO_SHOP_FLAG_NG) { echo 'checked'; }?>>NG
                <?php
                    if (isset($errors['pro_shop_flag'])):
                       echo '<div class="error-message">' . $errors['pro_shop_flag'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>有料駐車場</th>
              <td>
                <input type="radio" name="charge_parking_flag" value="<?php echo \Model_Fleamarket::CHARGE_PARKING_FLAG_EXIST;?>" <?php if ($fields['charge_parking_flag']->value == \Model_Fleamarket::CHARGE_PARKING_FLAG_EXIST) { echo 'checked'; } ?>>あり
                <input type="radio" name="charge_parking_flag" value="<?php echo \Model_Fleamarket::CHARGE_PARKING_FLAG_NONE;?>" <?php if ($fields['charge_parking_flag']->value == \Model_Fleamarket::CHARGE_PARKING_FLAG_NONE) { echo 'checked'; } ?>>なし
                <?php
                    if (isset($errors['charge_parking_flag'])):
                       echo '<div class="error-message">' . $errors['charge_parking_flag'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>無料駐車場</th>
              <td>
                <input type="radio" name="free_parking_flag" value="<?php echo \Model_Fleamarket::FREE_PARKING_FLAG_EXIST;?>" <?php if ($fields['free_parking_flag']->value == \Model_Fleamarket::FREE_PARKING_FLAG_EXIST) { echo 'checked'; } ?>>あり
                <input type="radio" name="free_parking_flag" value="<?php echo \Model_Fleamarket::FREE_PARKING_FLAG_NONE;?>" <?php if ($fields['free_parking_flag']->value == \Model_Fleamarket::FREE_PARKING_FLAG_NONE) { echo 'checked'; } ?>>なし
                <?php
                    if (isset($errors['free_parking_flag'])):
                       echo '<div class="error-message">' . $errors['free_parking_flag'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>雨天開催会場</th>
              <td>
                <input type="radio" name="rainy_location_flag" value="<?php echo \Model_Fleamarket::RAINY_LOCATION_FLAG_EXIST;?> "<?php if ($fields['rainy_location_flag']->value == \Model_Fleamarket::RAINY_LOCATION_FLAG_EXIST) { echo 'checked'; } ?>>対象
                <input type="radio" name="rainy_location_flag" value="<?php echo \Model_Fleamarket::RAINY_LOCATION_FLAG_NONE;?>" <?php if ($fields['rainy_location_flag']->value == \Model_Fleamarket::RAINY_LOCATION_FLAG_NONE) { echo 'checked'; } ?>>対象外
                <?php
                    if (isset($errors['rainy_location_flag'])):
                       echo '<div class="error-message">' . $errors['rainy_location_flag'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>表示</th>
              <td>
                <input type="radio" name="display_flag" value="<?php echo \Model_Fleamarket::DISPLAY_FLAG_ON;?>" <?php if ($fields['display_flag']->value == \Model_Fleamarket::DISPLAY_FLAG_ON) { echo 'checked'; } ?>>表示
                <input type="radio" name="display_flag" value="<?php echo \Model_Fleamarket::DISPLAY_FLAG_OFF;?>" <?php if ($fields['display_flag']->value == \Model_Fleamarket::DISPLAY_FLAG_OFF) { echo 'checked'; } ?>>非表示
                <?php
                    if (isset($errors['display_flag'])):
                       echo '<div class="error-message">' . $errors['display_flag'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>予約状況</th>
              <td>
                <input type="radio" name="event_reservation_status" value="<?php echo \Model_Fleamarket::EVENT_RESERVATION_STATUS_ENOUGH;?>" <?php if ($fields['event_reservation_status']->value == \Model_Fleamarket::EVENT_RESERVATION_STATUS_ENOUGH) { echo 'checked'; } ?>>まだまだあります
                <input type="radio" name="event_reservation_status" value="<?php echo \Model_Fleamarket::EVENT_RESERVATION_STATUS_FEW;?>" <?php if ($fields['event_reservation_status']->value == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FEW) { echo 'checked'; } ?>>残り僅か！
                <input type="radio" name="event_reservation_status" value="<?php echo \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL;?>" <?php if ($fields['event_reservation_status']->value == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL) { echo 'checked'; } ?>>満員
                <?php
                    if (isset($errors['event_reservation_status'])):
                        echo '<div class="error-message">' . $errors['event_reservation_status'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>登録タイプ</th>
              <td>
                <input type="radio" name="register_type" value="<?php echo \Model_Fleamarket::REGISTER_TYPE_ADMIN;?>" <?php if ($fields['register_type']->value == \Model_Fleamarket::REGISTER_TYPE_ADMIN) { echo 'checked'; } ?>>運営事務局
                <input type="radio" name="register_type" value="<?php echo \Model_Fleamarket::REGISTER_TYPE_USER;?>" <?php if ($fields['register_type']->value == \Model_Fleamarket::REGISTER_TYPE_USER) { echo 'checked'; } ?>>ユーザー投稿
                <?php
                    if (isset($errors['register_type'])):
                       echo '<div class="error-message">' . $errors['register_type'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-6">
          <div id="accordion">
            <h3>画像イメージ</h3>
            <div>
              <table class="fleamarket-table table">
                <?php foreach (range(1, 4) as $priority):?>
                <tr>
                  <th>ファイル<?php echo $priority;?></th>
                  <td>
                    <?php if ($fleamarket && $fleamarket->fleamarket_image($priority)):?>
                    <img src="<?php echo $fleamarket->fleamarket_image($priority)->Url();?>" class="img-responsive">
                    <input type="checkbox" name="delete_priorities[]" value="<?php echo $priority;?>">削除する
                    <?php endif;?>
                    <input type="file" name="upload<?php echo $priority;?>">
                  </td>
                </tr>
                <?php endforeach;?>
              </table>
            </div>
            <h3>説明</h3>
            <div>
              <table class="fleamarket-table table">
                <?php foreach (\Model_Fleamarket_About::getAboutTitles() as $id => $title):?>
                <tr>
                  <th><?php echo e($title);?></th>
                  <td>
                    <textarea name="fleamarket_about_<?php echo $id; ?>_description" cols="55" rows="8"><?php echo e($fieldsets['fleamarket_abouts'][$id]->field('description')->value);?></textarea>
                    <?php $errors = $fieldsets['fleamarket_abouts'][$id]->validation()->error_message();?>
                    <?php
                        if (isset($errors['description'])):
                            echo '<div class="error-message">' . $errors['description'] . '</div>';
                        endif;
                    ?>
                  </td>
                </tr>
                <?php endforeach;?>
              </table>
            </div>
            <h3><a class="anchor" href="#entry_style_section">出店形態</a></h3>
            <div id="entry_style_section">
              <table class="fleamarket-table table">
                <?php foreach ($entry_styles as $id => $entry_style):?>
                <tr>
                  <th><?php echo e($entry_style);?></th>
                  <td>
                    <?php $errors = $fieldsets['fleamarket_entry_styles'][$id]->validation()->error_message();?>
                    <table>
                      <tr>
                        <th>出店料</th>
                        <td>
                          <input type="text" name="fleamarket_entry_style_<?php echo $id;?>_booth_fee" value="<?php echo e($fieldsets['fleamarket_entry_styles'][$id]->field('booth_fee')->value);?>">
                          <?php
                              if (isset($errors['booth_fee'])):
                                  echo '<div class="error-message">' . $errors['booth_fee'] . '</div>';
                              endif;
                           ?>
                        </td>
                      </tr>
                      <tr>
                        <th>最大出店ブース数</th>
                        <td>
                          <input type="text" name="fleamarket_entry_style_<?php echo $id;?>_max_booth" value="<?php echo e($fieldsets['fleamarket_entry_styles'][$id]->field('max_booth')->value);?>">
                          <?php
                              if (isset($errors['max_booth'])):
                                  echo '<div class="error-message">' . $errors['max_booth'] . '</div>';
                              endif;
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <th>予約可能出店ブース上限</th>
                        <td>
                          <input type="text" name="fleamarket_entry_style_<?php echo $id;?>_reservation_booth_limit" value="<?php echo e($fieldsets['fleamarket_entry_styles'][$id]->field('reservation_booth_limit')->value);?>">
                          <?php
                              if (isset($errors['reservation_booth_limit'])):
                                  echo '<div class="error-message">' . $errors['reservation_booth_limit'] . '</div>';
                              endif;
                          ?>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <?php endforeach;?>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-12 btn-group">
          <button type="submit" class="btn btn-info">内容を確認する</button>
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
</div>