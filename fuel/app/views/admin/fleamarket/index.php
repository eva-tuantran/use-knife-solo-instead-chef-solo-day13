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
      collapsible: true
  });

  $("#addLinkFromList").on("click", function(evt) {
    $(this).before('\
      <div>\
        <input type="text" name="link_from_list[]" class="form-control">\
        <input type="button" value="削除" class="form-control" onclick="remove_form(this)">\
      </div>\
    ');
  });

  var $search_dialog = $("#searchLocationDialog");
  $("#doLocationSearch").on("click", function(evt) {
    $search_dialog.dialog({
      modal: true,
      width: 800,
      height: 550,
      buttons: {
        "閉じる": function() {
          $(this).dialog("close");
        }
      }
    });
  });

  $("#doSearch").on("click", function(evt) {
    $.ajax({
      type: "post",
      url: "/admin/fleamarket/searchlocation",
      data: {
        name: $.trim($("#locationName").val()),
        prefecture_id: $("#prefectureId").val()
      },
      dataType: "html"
    }).done(function(html, textStatus, jqXHR) {
      if (jqXHR.status === 200) {
        $("#contents", $search_dialog).empty();
        $("#contents", $search_dialog).append(html);
      } else {
        showDialog("会場情報の取得に失敗しました");
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      showDialog("会場情報の取得に失敗しました");
    });
  });

  var $dialog = $("#dialog");
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

});

var remove_form = function(o) {
  var parentNode = o.parentNode;
  parentNode.remove();
};
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
    <form action="/admin/fleamarket/confirm" method="post" class="form-inline" enctype="multipart/form-data">
      <input type="hidden" name="fleamarket_id" value="<?php echo e(\Input::param('fleamarket_id'));?>">
      <div class="row">
        <div class="col-md-6">
          <table class="table-fixed table">
            <tr>
              <th>会場</th>
              <td>
                <select id="location_id" class="form-control" name="location_id">
                <?php
                    if (empty($location_id) && $fields['location_id']->value != ''):
                        $location_id = $fields['location_id']->value;
                    endif;
                    foreach ($locations as $location):
                        $selected = '';
                        if ($location_id == $location->location_id):
                            $selected = 'selected';
                        endif;
                ?>
                <option value="<?php echo $location->location_id;?>" <?php echo $selected;?>><?php echo e($location->name);?></option>
                <?php
                    endforeach;
                ?>
                </select>
                <button id="doLocationSearch" type="button" class="btn btn-default">会場検索</button>
                <?php
                    if (isset($errors['location_id'])):
                       echo '<div class="error-message">' . $errors['location_id'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>フリマ名</th>
              <td>
                <input type="text" class="form-control" name="name" value="<?php echo e($fields['name']->value);?>">
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
                <input type="text" class="form-control" name="promoter_name" value="<?php echo e($fields['promoter_name']->value);?>">
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
                <input type="text" class="form-control" name="event_date" value="<?php echo e($fields['event_date']->value);?>" id="inputEventDate">
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
                <input type="text" class="form-control" name="event_time_start" value="<?php echo e($fields['event_time_start']->value);?>" id="inputEventTimeStart">
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
                <input type="text" class="form-control" name="event_time_end" value="<?php echo e($fields['event_time_end']->value);?>" id="inputEventTimeEnd">
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
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['event_status']->value == \Model_Fleamarket::EVENT_STATUS_SCHEDULE):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="event_status" value="<?php echo \Model_Fleamarket::EVENT_STATUS_SCHEDULE;?>" <?php echo $checkd;?>>開催予定</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['event_status']->value == \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="event_status" value="<?php echo \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT;?>" <?php echo $checkd;?>>予約受付中</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['event_status']->value == \Model_Fleamarket::EVENT_STATUS_RECEIPT_END):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="event_status" value="<?php echo \Model_Fleamarket::EVENT_STATUS_RECEIPT_END;?>" <?php echo $checkd;?>>受付終了</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['event_status']->value == \Model_Fleamarket::EVENT_STATUS_CLOSE):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="event_status" value="<?php echo \Model_Fleamarket::EVENT_STATUS_CLOSE;?>" <?php echo $checkd;?>>開催終了</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['event_status']->value == \Model_Fleamarket::EVENT_STATUS_CANCEL):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="event_status" value="<?php echo \Model_Fleamarket::EVENT_STATUS_CANCEL;?>" <?php echo $checkd;?>>中止</label>
                </div>
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
                <textarea class="form-control" name="description" cols="55" rows="8"><?php echo e($fields['description']->value);?></textarea>
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
                <input type="text" class="form-control" name="reservation_start" value="<?php echo e($fields['reservation_start']->value);?>" id="inputReservationStart">
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
                <input type="text" class="form-control" name="reservation_end" value="<?php echo e($fields['reservation_end']->value);?>" id="inputReservationEnd">
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
                <input type="text" class="form-control" name="reservation_tel" value="<?php echo e($fields['reservation_tel']->value);?>">
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
                <input type="text" class="form-control" name="reservation_email" value="<?php echo e($fields['reservation_email']->value);?>">
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
                <input type="text" class="form-control" name="website" value="<?php echo e($fields['website']->value);?>">
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
                <input type="text" class="form-control" name="item_categories" value="<?php echo e($fields['item_categories']->value);?>">
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
                <?php foreach(\Model_Entry::getLinkFromList() as $key => $link_from): ?>
                  <div>
                    <input type="text" class="form-control" name="link_from_list[]" value="<?php echo $link_from;?>">
                    <input type="button" class="form-control" value="削除" onclick="remove_form(this)"><br>
                  </div>
                <?php endforeach; ?>
                <?php
                    if (isset($errors['link_from_list'])):
                       echo '<div class="error-message">' . $errors['link_from_list'] . '</div>';
                    endif;
                ?>
                <p>
                  <button id="addLinkFromList" type="button" class="form-control">さらに追加</button>
                </p>
              </td>
            </tr>
            <tr>
              <th>ピックアップ</th>
              <td>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['pickup_flag']->value == \Model_Fleamarket::PICKUP_FLAG_ON):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="pickup_flag" value="<?php echo \Model_Fleamarket::PICKUP_FLAG_ON;?>" <?php echo $checkd;?>>対象</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['pickup_flag']->value == \Model_Fleamarket::PICKUP_FLAG_OFF):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="pickup_flag" value="<?php echo \Model_Fleamarket::PICKUP_FLAG_OFF?>" <?php echo $checkd;?>>対象外</label>
                </div>
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
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['shop_fee_flag']->value == \Model_Fleamarket::SHOP_FEE_FLAG_FREE):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="shop_fee_flag" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_FREE;?>" <?php echo $checkd;?>>無料</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['shop_fee_flag']->value == \Model_Fleamarket::SHOP_FEE_FLAG_CHARGE):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="shop_fee_flag" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_CHARGE;?>" <?php echo $checkd;?>>有料</label>
                </div>
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
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['car_shop_flag']->value == \Model_Fleamarket::CAR_SHOP_FLAG_OK):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="car_shop_flag" value="<?php echo \Model_Fleamarket::CAR_SHOP_FLAG_OK;?>" <?php echo $checkd;?>>OK</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['car_shop_flag']->value == \Model_Fleamarket::CAR_SHOP_FLAG_NG):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="car_shop_flag" value="<?php echo \Model_Fleamarket::CAR_SHOP_FLAG_NG;?>" <?php echo $checkd;?>>NG</label>
                </div>
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
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['pro_shop_flag']->value == \Model_Fleamarket::PRO_SHOP_FLAG_OK):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="pro_shop_flag" value="<?php echo \Model_Fleamarket::PRO_SHOP_FLAG_OK;?>" <?php echo $checkd;?>>OK</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['pro_shop_flag']->value == \Model_Fleamarket::PRO_SHOP_FLAG_NG):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="pro_shop_flag" value="<?php echo \Model_Fleamarket::PRO_SHOP_FLAG_NG;?>" <?php echo $checkd;?>>NG</label>
                </div>
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
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['charge_parking_flag']->value == \Model_Fleamarket::CHARGE_PARKING_FLAG_EXIST):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="charge_parking_flag" value="<?php echo \Model_Fleamarket::CHARGE_PARKING_FLAG_EXIST;?>" <?php echo $checkd;?>>あり</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['charge_parking_flag']->value == \Model_Fleamarket::CHARGE_PARKING_FLAG_NONE):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="charge_parking_flag" value="<?php echo \Model_Fleamarket::CHARGE_PARKING_FLAG_NONE;?>" <?php echo $checkd;?>>なし</label>
                </div>
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
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['free_parking_flag']->value == \Model_Fleamarket::FREE_PARKING_FLAG_EXIST):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="free_parking_flag" value="<?php echo \Model_Fleamarket::FREE_PARKING_FLAG_EXIST;?>" <?php echo $checkd;?>>あり</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['free_parking_flag']->value == \Model_Fleamarket::FREE_PARKING_FLAG_NONE):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="free_parking_flag" value="<?php echo \Model_Fleamarket::FREE_PARKING_FLAG_NONE;?>" <?php echo $checkd;?>>なし</label>
                </div>
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
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['rainy_location_flag']->value == \Model_Fleamarket::RAINY_LOCATION_FLAG_EXIST):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="rainy_location_flag" value="<?php echo \Model_Fleamarket::RAINY_LOCATION_FLAG_EXIST;?>" <?php echo $checkd;?>>対象</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['rainy_location_flag']->value == \Model_Fleamarket::RAINY_LOCATION_FLAG_NONE):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="rainy_location_flag" value="<?php echo \Model_Fleamarket::RAINY_LOCATION_FLAG_NONE;?>" <?php echo $checkd;?>>対象外</label>
                </div>
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
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['display_flag']->value == \Model_Fleamarket::DISPLAY_FLAG_ON):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="display_flag" value="<?php echo \Model_Fleamarket::DISPLAY_FLAG_ON;?>" <?php echo $checkd;?>>表示</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['display_flag']->value == \Model_Fleamarket::DISPLAY_FLAG_OFF):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="display_flag" value="<?php echo \Model_Fleamarket::DISPLAY_FLAG_OFF;?>" <?php echo $checkd;?>>非表示</label>
                </div>
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
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['event_reservation_status']->value == \Model_Fleamarket::EVENT_RESERVATION_STATUS_ENOUGH):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="event_reservation_status" value="<?php echo \Model_Fleamarket::EVENT_RESERVATION_STATUS_ENOUGH;?>" <?php echo $checkd;?>>まだまだあります</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['event_reservation_status']->value == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FEW):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="event_reservation_status" value="<?php echo \Model_Fleamarket::EVENT_RESERVATION_STATUS_FEW;?>" <?php echo $checkd;?>>残り僅か！</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['event_reservation_status']->value == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="event_reservation_status" value="<?php echo \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL;?>" <?php echo $checkd;?>>満員</label>
                </div>
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
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['register_type']->value == \Model_Fleamarket::REGISTER_TYPE_ADMIN):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="register_type" value="<?php echo \Model_Fleamarket::REGISTER_TYPE_ADMIN;?>" <?php echo $checkd;?>>運営事務局</label>
                </div>
                <div class="radio">
                  <?php
                      $checkd = '';
                      if ($fields['register_type']->value == \Model_Fleamarket::REGISTER_TYPE_USER):
                          $checkd = 'checked';
                      endif;
                  ?>
                  <label><input type="radio" class="form-control" name="register_type" value="<?php echo \Model_Fleamarket::REGISTER_TYPE_USER;?>" <?php echo $checkd;?>>ユーザー投稿</label>
                </div>
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
              <table class="table-fixed table">
                <?php foreach (range(1, 4) as $priority):?>
                <tr>
                  <th>ファイル<?php echo $priority;?></th>
                  <td>
                    <?php if ($fleamarket && $fleamarket->fleamarket_image($priority)):?>
                    <img src="<?php echo $fleamarket->fleamarket_image($priority)->Url();?>" class="img-responsive">
                    <input type="checkbox" class="form-control" name="delete_priorities[]" value="<?php echo $priority;?>">削除する
                    <?php endif;?>
                    <input type="file" class="form-control" name="upload<?php echo $priority;?>">
                  </td>
                </tr>
                <?php endforeach;?>
              </table>
            </div>
            <h3>説明</h3>
            <div>
              <table class="table-fixed table">
                <?php foreach (\Model_Fleamarket_About::getAboutTitles() as $id => $title):?>
                <tr>
                  <th><?php echo e($title);?></th>
                  <td>
                    <textarea name="fleamarket_about_<?php echo $id; ?>_description" class="form-control" cols="55" rows="8"><?php echo e($fieldsets['fleamarket_abouts'][$id]->field('description')->value);?></textarea>
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
              <table class="table-fixed table">
                <?php foreach ($entry_styles as $id => $entry_style):?>
                <tr>
                  <th><?php echo e($entry_style);?></th>
                  <td>
                    <?php $errors = $fieldsets['fleamarket_entry_styles'][$id]->validation()->error_message();?>
                    <table>
                      <tr>
                        <th>出店料</th>
                        <td>
                          <input type="text" class="form-control" name="fleamarket_entry_style_<?php echo $id;?>_booth_fee" value="<?php echo e($fieldsets['fleamarket_entry_styles'][$id]->field('booth_fee')->value);?>">
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
                          <input type="text" class="form-control" name="fleamarket_entry_style_<?php echo $id;?>_max_booth" value="<?php echo e($fieldsets['fleamarket_entry_styles'][$id]->field('max_booth')->value);?>">
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
                          <input type="text" class="form-control" name="fleamarket_entry_style_<?php echo $id;?>_reservation_booth_limit" value="<?php echo e($fieldsets['fleamarket_entry_styles'][$id]->field('reservation_booth_limit')->value);?>">
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
<div id="searchLocationDialog" class="afDialog">
  <div class="contents">
    <div class="form-group">
      <div class="col-md-5">
        <input id="locationName" type="text" class="form-control col-md-3" name="name" placeholder="会場名">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-3">
        <select id="prefectureId" class="form-control" id="prefecture" name="prefecture_id">
          <option value="">都道府県</option>
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
    </div>
    <button id="doSearch" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 検 索</button>
    <div class="container-fluid">
      <div class="row">
        <div id="contents" class="col-md-12">
        </div>
      </div>
    </div>
  </div>
</div>
