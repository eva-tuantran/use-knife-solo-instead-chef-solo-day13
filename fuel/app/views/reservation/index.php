<h2>reservation</h2>

<?php $input  = $fieldset->input(); ?>
<?php $errors = $fieldset->validation()->error_message(); ?>

<form action="/reservation/confirm" method="POST">
  <table>
    <tr>
      <td>出店方法</td>
      <td>
	<?php foreach ($fleamarket->fleamarket_entry_styles as $fleamarket_entry_style){ ?>
	<input type="radio" name="fleamarket_entry_style_id" 
	       value="<?php echo $fleamarket_entry_style->fleamarket_entry_style_id; ?>">
	<?php echo $fleamarket_entry_style->fleamarket_entry_style_id; ?>
	<?php } ?>
	<?php if (isset($errors['fleamarket_entry_style_id'])) { ?>
	<?php echo $errors['fleamarket_entry_style_id']; ?>
	<?php } ?>
      </td>
    </tr>
    <tr>
      <td>予約ブース数</td>
      <td>
         <input type="text" name="reserved_booth">
	 <?php if (isset($errors['reserved_booth'])) { ?>
	 <?php echo $errors['reserved_booth']; ?>
	 <?php } ?>
      </td>
    </tr>
    <tr>
      <td>出品予定品目</td>
      <td>
	<select name="item_category">
	  <option value="1">リサイクル品</option>
	  <option value="2">手作り品</option>
	</select>
	<br />
	<input type="checkbox" name="item_genres[]" value="1">コンピュータ
	<input type="checkbox" name="item_genres[]" value="2">家電
	<input type="checkbox" name="item_genres[]" value="3">カメラ
	<input type="checkbox" name="item_genres[]" value="4">音楽
      </td>
    </tr>
  </table>
  <input type="hidden" name="fleamarket_id" value="<?php echo e(Input::param('fleamarket_id')); ?>">
  <input type="submit" value="確認">
</form>
