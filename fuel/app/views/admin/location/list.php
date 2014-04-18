<a href="/admin/location/">新規登録</a>
<table>
  <?php if (isset($locations)) { ?>
  <?php foreach ($locations as $location) { ?>
  <tr>
    <td>
      <a href="/admin/location/?location_id=<?php echo $location->location_id; ?>">
	<?php echo e($location->name); ?>
      </a>
    </td>
  </tr>
  <?php }} ?>
</table>

<?php echo Pagination::create_links(); ?>
