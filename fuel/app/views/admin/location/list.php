<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">会場一覧</h2>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-10">
        <form id="searchForm" class="form-horizontal" id="" action="/admin/location/list" method="post" role="form">
          <div class="form-group clearfix">
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
            <label for="name" class="col-md-1 control-label">会場名</label>
            <div class="col-md-2">
              <?php
                  $name = '';
                  if (! empty($conditions['name'])):
                      $name = $conditions['name'];
                  endif;
              ?>
              <input type="text" class="form-control" name="c[name]" value="<?php echo e($name);?>">
            </div>
            <label for="prefecture_id" class="col-md-1 control-label">都道府県</label>
            <div class="col-md-1">
              <select class="form-control" id="prefecture" name="c[prefecture_id]">
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
            <label for="address" class="col-md-1 control-label">住所</label>
            <div class="col-md-2">
              <?php
                  $address = '';
                  if (! empty($conditions['address'])):
                      $address = $conditions['address'];
                  endif;
              ?>
              <input type="text" id="address" class="form-control" name="c[address]" value="<?php echo e($address);?>">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 検 索</button>
          </div>
        </form>
      </div>
    </div>
    <table class="table table-hover table-condensed">
      <thead>
        <tr>
          <th>ID</th>
          <th>会場名</th>
          <th>都道府県</th>
          <th>住所</th>
          <th><a class="btn btn-primary btn-sm" href="/admin/location/">新規登録</a></th>
        </tr>
      </thead>
      <tbody>
      <?php
          if (! $location_list):
      ?>
        <tr>
          <td colspan="5">該当する会場情報はありません</td>
        </tr>
      <?php
          endif;
          foreach ($location_list as $location):
              $location_id = $location['location_id'];
      ?>
        <tr>
          <td><a href="/admin/location/?location_id=<?php echo $location_id;?>"><?php echo $location_id;?></a></td>
          <td><a href="/admin/location/?location_id=<?php echo $location_id;?>"><?php echo e($location['name']);?></a></td>
          <td><?php echo @$prefectures[$location['prefecture_id']];?></td>
          <td><?php echo e($location['address']);?></td>
          <td><a class="btn btn-default btn-sm" href="/admin/fleamarket/?location_id=<?php echo $location_id; ?>">フリマ登録</a></td>
      </tr>
      <?php
          endforeach;
      ?>
      </tbody>
    </table>
  </div>
  <div class="panel-footer">
    <?php
        if ('' != ($pagnation =  $pagination->render())):
            echo $pagnation;
        elseif ($location_list):
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
