<table class="table-fixed table">
  <thead>
    <tr>
      <th>会場名</th>
      <th>住所</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
  <?php
      if (! $location_list):
  ?>
    <tr>
      <td colspan="3">検索条件に該当する会場情報はありません</td>
    </tr>
  <?php
      else:
          foreach ($location_list as $location):
  ?>
    <tr>
      <td><?php echo e($location['name']);?></td>
      <td><?php echo e(@$prefectures[$location['prefecture_id']]);?><?php echo e($location['address']);?></td>
      <td><button id="location_id_<?php echo $location['location_id'];?>" type="button" class="btn btn-default btn-xs">選択</button></td>
    </tr>
  <?php
          endforeach;
      endif;
  ?>
  </tbody>
</table>
<script type="text/javascript">
$(function() {
  $("button[id^='location_id_']").on("click", function(evt) {
    var location_id = $(this).attr("id").replace("location_id_", "");
    $("#location_id").val(location_id);
    $dialog.dialog("close");
  });
});
</script>