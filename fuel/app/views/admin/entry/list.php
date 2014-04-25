<form action="/admin/entry/list" method="GET">
  <table>
    <tr>
      <td>予約番号</td>
      <td><input type="text" name="reservation_number" value="<?php echo e(Input::param('reservation_number')); ?>">
    </tr>
    <?php if(isset($user)) { ?>
    <tr>
      <td>ユーザー</td>
      <td>
	<a href="/admin/user/?user_id=<?php echo $user->user_id; ?>">
	  <?php echo e($user->last_name); ?> <?php echo e($user->first_name); ?>
	</a>
      </td>
    </tr>
    <?php } ?>
    <?php if(isset($fleamarket)) { ?>
    <tr>
      <td>開催</td>
      <td>
	<a href="/admin/fleamarket/?fleamarket_id=<?php echo $fleamarket->fleamarket_id; ?>">
	  <?php echo e($fleamarket->name); ?>
	</a>
      </td>
    </tr>
    <?php } ?>
  </table>

  <input type="hidden" name="fleamarket_id" value="<?php echo e(Input::param('fleamarket_id','')); ?>">
  <input type="hidden" name="user_id" value="<?php echo e(Input::param('user_id','')); ?>">
  <input type="submit" value="search">
</form>

<table class="table table-hover table-condensed">
<tr>
  <th>ユーザー</th>
  <th>予約番号</th>
  <th>カテゴリ</th>
  <th>ジャンル</th>
  <th>予約ブース数</th>
  <th>link_from</th>
  <th>remarks</th>
</tr>  
<?php foreach ($entries as $entry) { ?>
<tr>
  <td>
    <a href="/admin/user/?user_id=<?php echo $entry->user_id; ?>">
      <?php if ($entry->user) echo e($entry->user->last_name . ' ' . $entry->user->first_name); ?>
    </a>
  </td>
  <td><?php echo e($entry->reservation_number); ?></td>
  <td><?php echo e($entry->item_category); ?></td>
  <td><?php echo e($entry->item_genres); ?></td>
  <td><?php echo e($entry->reserved_booth); ?></td>
  <td><?php echo e($entry->link_from); ?></td>
  <td><?php echo e($entry->remarks); ?></td>
</tr>
<?php } ?>
</table>

<?php echo Pagination::create_links(); ?>
