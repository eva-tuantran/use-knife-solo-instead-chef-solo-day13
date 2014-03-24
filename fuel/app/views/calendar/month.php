<h3><?php echo $year;?>年<?php echo $month;?></h3>
<ul class="calendar_nav">
  <li><a href="<?php echo $nav_prev;?>" class="prev">&laquo;前月</a></li>
  <li><a href="<?php echo $nav_next;?>" class="next">次月&raquo;</a></li>
</ul>
<div id="calendar_section">
<table class="calendar_table">
  <thead>
    <tr>
    <?php foreach($days as $name): ?>
      <th><?php echo $name; ?></th>
    <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach($calendar as $week): ?>
    <tr>
      <?php foreach($week as $day): ?>
      <td>
        <?php if (isset($day['is_event']) && $day['is_event'] === true):?>
          <a href="/search/<?php echo $day['date'] . '/1/';?>"><?php echo $day['day']; ?></a>
        <?php else:?>
          <?php echo $day['day']; ?>
        <?php endif;?>
      </td>
      <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
</table>
</div>
