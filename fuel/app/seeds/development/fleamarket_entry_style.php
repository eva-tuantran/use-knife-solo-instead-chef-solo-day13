<?php

use \Model_FleamarketEntryStyle;

$seeds = array(
    array(
        'fleamarket_entry_style_id' => 1,
        'fleamarket_id' => 1,
        'entry_style_id' => 1,
        'booth_fee' => 100,
        'max_booth' => 100,
        'reservation_booth_limit' => 10,
        'created_user' => 1,
        'updated_user' => 1,
    ),
    array(
        'fleamarket_entry_style_id' => 2,
        'fleamarket_id' => 1,
        'entry_style_id' => 2,
        'booth_fee' => 100,
        'max_booth' => 100,
        'reservation_booth_limit' => 5,
        'created_user' => 1,
        'updated_user' => 1,
    ),
);

foreach ($seeds as $line) {
    $model = Model_Fleamarket_Entry_Style::forge($line);
    $model->save();
}
