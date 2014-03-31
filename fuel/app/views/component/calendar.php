<h3><?php echo $calendar['year'];?>年<?php echo $calendar['month'];?></h3>
<ul class="calendar_nav">
  <li class="prev"><i></i><a href="<?php echo $calendar['nav_prev'];?>">前月</a></li>
  <li class="next"><a href="<?php echo $calendar['nav_next'];?>">翌月</a><i></i></li>
</ul>
<div id="calendar_section">
<table class="calendar_table">
  <thead>
    <tr>
    <?php foreach($calendar['days'] as $name): ?>
      <th><?php echo $name; ?></th>
    <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach($calendar['calendar'] as $week): ?>
    <tr>
      <?php foreach($week as $day): ?>
      <td>
        <?php if (isset($day['is_event']) && $day['is_event'] === true):?>
          <a href="/search/1/?d=<?php echo $day['date'];?>"><?php echo $day['day'];?></a>
        <?php else:?>
          <?php echo $day['day']; ?>
        <?php endif;?>
      </td>
      <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
</table>
</div>
