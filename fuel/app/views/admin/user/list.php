<form action="/admin/user/list" method="GET">
  <input type="text" name="keyword" size=80 value="<?php echo e(Input::param('keyword','')); ?>">
  <input type="submit" value="search">
</form>

<table>
  <?php if (isset($users)) { ?>
  <?php foreach ($users as $user) { ?>
  <tr>
    <td>
      <a href="/admin/user/?user_id=<?php echo $user->user_id; ?>">
	<?php echo e($user->last_name); ?> <?php echo e($user->first_name); ?>
      </a>
    </td>
    <td><?php echo e($user->email); ?></td>
    <td><a href="/admin/user/force_login?user_id=<?php echo $user->user_id; ?>">login</a></td>
  </tr>
  <?php }} ?>
</table>

<?php echo Pagination::create_links(); ?>
