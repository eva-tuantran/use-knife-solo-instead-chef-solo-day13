
<h2>開催一覧</h2>

<table>
  <?php foreach ($fleamarkets as $fleamarket) { ?>
  <tr>
    <td>
      <?php echo e($fleamarket->fleamarket_id); ?>
    </td>
    <td>
      <?php echo e($fleamarket->name); ?>
    </td>
    <td>
      <a href="/admin/fleamarket/?fleamarket_id=<?php echo $fleamarket->fleamarket_id; ?>">詳細</a>
    </td>
    <td>
      <a href="/admin/entry/list?fleamarket_id=<?php echo $fleamarket->fleamarket_id; ?>">一覧</a>
    </td>
    <td>
      <a href="/admin/entry/csv?fleamarket_id=<?php echo e($fleamarket->fleamarket_id); ?>">CSV</a>
    </td>
  </tr>
  <?php } ?>
</table>

