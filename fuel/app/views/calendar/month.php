<style type="text/css">
#calendar_section {width: 300px;}
#calendar_section .calendar_nav {margin: 0; padding: 0; width: 100%;}
#calendar_section .calendar_nav li {width: 32%; display: inline-block; *display: inline; *zoom: 1; text-align: center;}
#calendar_section .calendar_table {width: 300px;}
#calendar_section .calendar_table th, #calendar_section .calendar_table td {border:1px solid #ccc; text-align: center;}
</style>
<div id="calendar_section">
  <?php if ($is_navigation): ?>
  <ul class="calendar_nav">
    <li><a href="<?php echo $nav_prev;?>" class="prev">&laquo;前月</a></li>
    <li><?php echo $year . '年' . $month;?></li>
    <li><a href="<?php echo $nav_next;?>" class="next">翌月&raquo;</a></li>
  </ul>
  <?php endif; ?>
  <table class="calendar_table">
    <tbody>
      <tr>
      <?php foreach($days as $name): ?>
        <th><?php echo $name; ?></th>
      <?php endforeach; ?>
      </tr>
      <?php foreach($calendar as $week): ?>
      <tr>
        <?php foreach($week as $day): ?>
        <td><?php echo $day['day']; ?></td>
        <?php endforeach; ?>
      </tr>
      <?php endforeach; ?>
  </table>
</div>
