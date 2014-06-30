<h3><?php echo $calendar['year'];?>年<?php echo $calendar['month'];?></h3>
<ul class="calendar_nav">
  <li class="prev"><i></i><a href="<?php echo $calendar['nav_prev'];?>">前月</a></li>
  <li class="next"><a href="<?php echo $calendar['nav_next'];?>">翌月</a><i></i></li>
</ul>
<div id="calendar_section">
<table class="calendar_table">
  <thead>
    <tr><?php
        foreach ($calendar['days'] as $name):
            echo '<th>' . $name . '</th>';
        endforeach;
    ?></tr>
  </thead>
  <tbody>
  <?php foreach ($calendar['calendar'] as $week):?>
    <tr><?php
        foreach ($week as $day):
            if (isset($day['is_event']) && $day['is_event'] === true):
                echo '<td><a href="/all?' . urlencode('c[event_date]') . '=' . $day['date'] . '">' . $day['day']. '</a></td>';
            else:
                echo '<td>' . $day['day'] . '</td>';
            endif;
        endforeach;
    ?></tr>
  <?php endforeach;?>
</table>
</div>
