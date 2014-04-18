<form action="/admin/user/list" method="GET">
  <table>
    <tr>
      <td>氏名</td>
      <td><input type="text" name="name" value="<?php echo e(Input::param('name','')); ?>"></td>
    </tr>
    <tr>
      <td>住所</td>
      <td><input type="text" name="address" value="<?php echo e(Input::param('address','')); ?>"></td>
    </tr>
    <tr>
      <td>メールアドレス</td>
      <td><input type="text" name="email" value="<?php echo e(Input::param('email','')); ?>"></td>
    </tr>
    <tr>
      <td>電話番号</td>
      <td><input type="text" name="tel" value="<?php echo e(Input::param('tel','')); ?>"></td>
    </tr>
    <tr>
      <td>旧会員番号</td>
      <td><input type="text" name="user_old_id" value="<?php echo e(Input::param('user_old_id','')); ?>"></td>
    </tr>
  </table>
  <input type="submit" value="search">
</form>

<table>
  <tr>
    <th>氏名</th>
    <th>メールアドレス</th>
    <th>電話番号</th>
    <th>login</th>
    <th>予約</th>
  </tr>
  <?php if (isset($users)) { ?>
  <?php foreach ($users as $user) { ?>
  <tr>
    <td>
      <a href="/admin/user/?user_id=<?php echo $user->user_id; ?>">
	<?php echo e($user->last_name); ?> <?php echo e($user->first_name); ?>
      </a>
    </td>
    <td><?php echo e($user->email); ?></td>
    <td><?php echo e($user->tel); ?></td>
    <td>
      <a href="/admin/user/force_login?user_id=<?php echo $user->user_id; ?>">login(予約確認メールあり)</a>
      <a href="/admin/user/force_login?user_id=<?php echo $user->user_id; ?>&nomail=1">login(予約確認メールなし)</a>
    </td>
    <td>
      <a href="/admin/entry/list?user_id=<?php echo $user->user_id; ?>">予約</a>
    </td>
  </tr>
  <?php }} ?>
</table>

<?php echo Pagination::create_links(); ?>
