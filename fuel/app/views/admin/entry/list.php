<table>
<tr>
  <th>ユーザー</th>
  <th>予約番号</th>
  <th>カテゴリ</th>
  <th>ジャンル</th>
  <th>予約ブース数</th>
  <th>link_from</th>
  <th>remarks</th>
</tr>  
<?php foreach ($fleamarket->entries as $entry) { ?>
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

