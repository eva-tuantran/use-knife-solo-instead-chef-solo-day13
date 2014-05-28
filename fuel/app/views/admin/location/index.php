<?php
    $input  = $fieldset->input();
    $errors = $fieldset->validation()->error_message();
    $fields = $fieldset->field();
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">会場情報の入力</h2>
  </div>
  <div class="panel-body">
    <form action="/admin/location/confirm" method="post" class="form-inline" enctype="multipart/form-data">
      <input type="hidden" name="location_id" value="<?php echo e($location_id);?>">
      <div class="row">
        <div class="col-md-6">
          <table class="table-fixed table">
            <tr>
              <th>名前</th>
              <td>
                <input type="text" class="form-control" name="name" value="<?php echo e($fields['name']->value); ?>">
                <?php
                    if (isset($errors['name'])):
                        echo '<div class="error-message">' . $errors['name'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>郵便番号</th>
              <td>
                <input type="text" class="form-control small-width" name="zip" value="<?php echo e($fields['zip']->value); ?>">
                <?php
                    if (isset($errors['zip'])):
                        echo '<div class="error-message">' . $errors['zip'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>都道府県</th>
              <td>
                <select class="form-control" name="prefecture_id">
                  <option value=""></option>
                  <?php
                      foreach ($prefectures as $prefecture_id => $prefecture_name):
                          $selected = '';
                          if ($prefecture_id == $fields['prefecture_id']->value):
                              $selected = 'selected';
                          endif;
                  ?>
                  <option value="<?php echo $prefecture_id; ?>"<?php  echo $selected;?>><?php echo $prefecture_name;?></option>
                  <?php
                      endforeach;
                  ?>
                </select>
                <?php
                    if (isset($errors['prefecture_id'])):
                        echo '<div class="error-message">' . $errors['prefecture_id'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>住所</th>
              <td>
            <input type="text" class="form-control large-width" name="address" value="<?php echo e($fields['address']->value); ?>">
                <?php
                    if (isset($errors['address'])):
                        echo '<div class="error-message">' . $errors['address'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
            <tr>
              <th>googleマップ用住所</th>
              <td>
            <input type="text" class="form-control large-width" name="googlemap_address" value="<?php echo e($fields['googlemap_address']->value); ?>">
                <?php
                    if (isset($errors['googlemap_address'])):
                        echo '<div class="error-message">' . $errors['googlemap_address'] . '</div>';
                    endif;
                ?>
              </td>
            </tr>
          </table>
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
            if (isset($fields)):
               echo e($fields['created_at']->value);
            endif;
        ?></div>
        <div class="col-md-1">更新日時</div>
        <div class="col-md-2"><?php
            if (isset($fields)):
               echo e($fields['updated_at']->value);
            endif;
        ?></div>
    </div>
  </div>
</div>
