<?php

use \Model_Entry;

$seeds = array(

    array(
        // 'entry_id'                  => '',
        'user_id'                   => 1,
        'fleamarket_id'             => 1,
        'fleamarket_entry_style_id' => 1,
        'reservation_number'        => 'ABCABC',
        'item_category'             => '洋服,本,骨董品',
        'item_genres'               => 'フリージャンル',
        'reserved_booth'            => 3,
        'link_from'                 => 'webpage',
        'remarks'                   => '初めてフリマを予約します',
        'entry_status'              => Model_Entry::ENTRY_STATUS_RESERVED,
        'created_user'              => 'somebody',
        // 'updated_user'              => '',
        // 'created_at'                => \Date::forge()->format('mysql'),
        // 'updated_at'                => '',
        // 'deleted_at'                => '',
    ),

    array(
        // 'entry_id'                  => '',
        'user_id'                   => 1,
        'fleamarket_id'             => 2,
        'fleamarket_entry_style_id' => 2,
        'reservation_number'        => 'ABCABC',
        'item_category'             => '電化製品,本',
        'item_genres'               => '色々ジャンル',
        'reserved_booth'            => 3,
        'link_from'                 => 'webpage',
        'remarks'                   => '初めてフリマを予約します',
        'entry_status'              => Model_Entry::ENTRY_STATUS_RESERVED,
        'created_user'              => 'somebody',
        // 'updated_user'              => '',
        // 'created_at'                => \Date::forge()->format('mysql'),
        // 'updated_at'                => '',
        // 'deleted_at'                => '',
    ),

    array(
        // 'entry_id'                  => '',
        'user_id'                   => 1,
        'fleamarket_id'             => 3,
        'fleamarket_entry_style_id' => 2,
        'reservation_number'        => 'ABCABC',
        'item_category'             => '電化製品,本',
        'item_genres'               => '色々ジャンル',
        'reserved_booth'            => 3,
        'link_from'                 => 'webpage',
        'remarks'                   => '初めてフリマを予約します',
        'entry_status'              => Model_Entry::ENTRY_STATUS_RESERVED,
        'created_user'              => 'somebody',
        // 'updated_user'              => '',
        // 'created_at'                => \Date::forge()->format('mysql'),
        // 'updated_at'                => '',
        // 'deleted_at'                => '',
    ),

    array(
        // 'entry_id'                  => '',
        'user_id'                   => 1,
        'fleamarket_id'             => 4,
        'fleamarket_entry_style_id' => 2,
        'reservation_number'        => 'ABCABC',
        'item_category'             => '電化製品,本',
        'item_genres'               => '色々ジャンル',
        'reserved_booth'            => 3,
        'link_from'                 => 'webpage',
        'remarks'                   => '初めてフリマを予約します',
        'entry_status'              => Model_Entry::ENTRY_STATUS_RESERVED,
        'created_user'              => 'somebody',
        // 'updated_user'              => '',
        // 'created_at'                => \Date::forge()->format('mysql'),
        // 'updated_at'                => '',
        // 'deleted_at'                => '',
    ),


);


for ($i=1; $i<100; $i++) {

    $data = array(
        // 'entry_id'                  => '',
        'user_id'                   => 1,
        'fleamarket_id'             => $i,
        'fleamarket_entry_style_id' => mt_rand(1,4),
        'reservation_number'        => 'ABCABC',
        'item_category'             => '電化製品,本',
        'item_genres'               => '色々ジャンル',
        'reserved_booth'            => mt_rand(0,3),
        'link_from'                 => 'webpage',
        'remarks'                   => '初めてフリマを予約します',
        'entry_status'              => Model_Entry::ENTRY_STATUS_RESERVED,
        'created_user'              => 'somebody',
        // 'updated_user'              => '',
        // 'created_at'                => \Date::forge()->format('mysql'),
        // 'updated_at'                => '',
        // 'deleted_at'                => '',
    );

    $model = Model_Entry::forge($data);
    $model->save();
}



// foreach ($seeds as $line) {
    // $model = Model_Entry::forge($line);
    // $model->save();
// }
