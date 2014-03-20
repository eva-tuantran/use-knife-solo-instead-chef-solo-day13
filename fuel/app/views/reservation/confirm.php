<h2>reservation</h2>

<?php $input = $fieldset->input(); ?>
<?php $entry_styles = Config::get('master.entry_styles'); ?>

<form action="/reservation/thanks" method="post">

  <table>
    <tr>
      <td>出店方法</td>
      <td>
	<?php echo e($entry_styles[$input['fleamarket_entry_style_id']]); ?>
      </td>
    </tr>
    <tr>
      <td>予約ブース数</td>
      <td>
	<?php echo e($input['reserved_booth']); ?>
      </td>
    </tr>
    <tr>
      <td>出品予定品目</td>
      <td>
	<?php 
	   $item_category_define = Model_Entry::getItemCategoryDefine();
	   echo e($item_category_define[$input['item_category']]);
        ?>
	<br>
	<?php
	   $item_genres_define = Model_Entry::getItemGenresDefine();
	   foreach ($input['item_genres'] as $item_genre) {
	       echo e($item_genres_define[$item_genre]) . "<br />";
	   }
        ?>
      </td>
    </tr>
  </table>
  <?php echo \Form::csrf(); ?>
  <input type="submit" value="登録">
</form>
