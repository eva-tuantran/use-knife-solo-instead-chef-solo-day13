<?php
    $input  = $fieldset->input();
    $errors = $fieldset->validation()->error_message();
    $fields = $fieldset->field();
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">会場情報の確認</h2>
  </div>
  <div class="panel-body">
    <form action="/admin/location/thanks" method="post" class="form-horizontal">
      <input type="hidden" name="location_id" value="<?php echo e($location_id);?>">
      <?php echo Form::csrf();?>
      <div class="row">
        <div class="col-md-6">
          <table class="table-fixed table">
            <tr>
              <th>会場名</th>
              <td><?php echo e($input['name']); ?></td>
            </tr>
            <tr>
              <th>郵便番号</th>
              <td><?php echo e($input['zip']); ?></td>
            </tr>
            <tr>
              <th>都道府県</th>
              <td><?php echo e($prefectures[$input['prefecture_id']]); ?></td>
            </tr>
            <tr>
              <th>住所</th>
              <td><?php echo e($input['address']); ?></td>
            </tr>
            <tr>
              <th>googleマップ用住所</th>
              <td><?php echo e($input['googlemap_address']); ?></td>
            </tr>
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
            if (isset($location)):
               echo e($location->created_at);
            endif;
        ?></div>
        <div class="col-md-1">更新日時</div>
        <div class="col-md-2"><?php
            if (isset($location)):
               echo e($location->updated_at);
            endif;
        ?></div>
    </div>
  </div>
</div>
