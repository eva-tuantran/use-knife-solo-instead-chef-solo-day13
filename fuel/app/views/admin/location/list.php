<a href="/admin/location/">新規登録</a>
<br><br>
<table>
  <?php if (isset($locations)) { ?>
  <?php foreach ($locations as $location) { ?>
  <tr>
    <td>
      <a href="/admin/location/?location_id=<?php echo $location->location_id; ?>">
	<?php echo e($location->name); ?>
      </a>
    </td>
    <td>
      <a href="/admin/fleamarket/?location_id=<?php echo $location->location_id; ?>">
	フリマ登録
      </a>
  </tr>
  <?php }} ?>
</table>

