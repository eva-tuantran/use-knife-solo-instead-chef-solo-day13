<h2>reservation</h2>

<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>
<?php $entry_styles = Config::get('master.entry_styles'); ?>
<?php
   $input_genres = array();
   if ($input['item_genres']) {
       foreach ($input['item_genres'] as $item_genre) {
           $input_genres[$item_genre] = 1;
       }
   }
?>

<form action="/reservation/confirm" method="POST">
  <table>
    <tr>
      <td>出店方法</td>
      <td>
	<?php foreach ($fleamarket->fleamarket_entry_styles as $fleamarket_entry_style){ ?>
	<input type="radio" name="fleamarket_entry_style_id" 
	       value="<?php echo $fleamarket_entry_style->fleamarket_entry_style_id; ?>"
	       <?php if ($input['fleamarket_entry_style_id'] 
		     == $fleamarket_entry_style->fleamarket_entry_style_id) {
	             echo ' checked';} ?>>
	<?php echo e($entry_styles[$fleamarket_entry_style->entry_style_id]); ?>
	<?php } ?>
	<?php if (isset($errors['fleamarket_entry_style_id'])) { ?>
	<?php echo $errors['fleamarket_entry_style_id']; ?>
	<?php } ?>
      </td>
    </tr>
    <tr>
      <td>予約ブース数</td>
      <td>
         <input type="text" name="reserved_booth" value="<?php echo e($input['reserved_booth']); ?>">
	 <?php if (isset($errors['reserved_booth'])) { ?>
	 <?php echo $errors['reserved_booth']; ?>
	 <?php } ?>
      </td>
    </tr>
    <tr>
      <td>出品予定品目</td>
      <td>
	<select name="item_category">
          <?php foreach (Model_Entry::getItemCategoryDefine() as $item_category => $name) { ?>
	  <option value="<?php echo e($item_category); ?>"><?php echo e($name); ?></option>
	  <?php } ?>
	</select>
	<?php if (isset($errors['item_category'])) { ?>
	<?php echo $errors['item_category']; ?>
	<?php } ?>
	<br />
	<?php foreach (Model_Entry::getItemGenresDefine() as $item_genres => $name) { ?>
	<input type="checkbox" name="item_genres[]" value="<?php echo e($item_genres); ?>"
	       <?php if (isset($input_genres[$item_genres])) { echo ' checked'; } ?>>
	<?php echo e($name); ?>	<?php } ?>
	 <?php if (isset($errors['item_genres'])) { ?>
	 <br />
	 <?php echo $errors['item_genres']; ?>
	 <?php } ?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="fleamarket_id" value="<?php echo e($input['fleamarket_id']); ?>">
  <input type="submit" value="確認">
</form>
