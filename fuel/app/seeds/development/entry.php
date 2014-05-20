<?php
use \Model_Entry;
use \Model_Fleamarket;
use \Model_Fleamarket_Entry_Style;
use \Model_User;

$item_categories = array(
    '1' => 'リサイクル品',
    '2' => '手作り品',
);

$item_genres = \Model_Entry::getItemGenresDefine();

$link_from_list = array(
    '1' => '楽市モバイルサイト',
    '2' => '楽市PCサイト',
    '3' => '会場設置チラシ',
    '4' => '友人・知人から聞いて',
    '5' => 'GOOGLE・YAHOO検索',
    '6' => '地域情報誌',
    '7' => '新聞折り込み',
    '8' => 'フリーマーケットへ行こう',
    '9' => 'フリーマーケットガイド(モバフリ)',
    '10' => 'ポスター',
    '11' => '楽市メルマガ',
    '12' => '楽市ブログ',
    '13' => 'Facebook',
    '14' => 'mixi',
);

$entry_statuses = \Model_Entry::getEntryStatuses();

$fleamarkets = \Model_Fleamarket::find('all', array(
    'select' => array('fleamarket_id'),
//    'where' => array(
//        array('event_status', Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT)
//    )
));

$users = \Model_User::find('all', array(
    'select' => array('user_id')
));

for ($i = 1; $i < 1000; $i++) {
    $item_category = array_rand($item_categories);
    $item_genre = array_rand($item_genres);
    $link_from = array_rand($link_from_list);
    $entry_status = array_rand($entry_statuses);

    while (true) {
        $fleamarket_key = array_rand($fleamarkets);
        $fleamarket = $fleamarkets[$fleamarket_key];

        $fleamarket_entry_styles = \Model_Fleamarket_Entry_Style::find('all', array(
            'select' => array('fleamarket_entry_style_id'),
            'where' => array(
                array('fleamarket_id', $fleamarket->fleamarket_id),
            ),
        ));

        if ($fleamarket_entry_styles) {
            $fleamarket_entry_style_key = array_rand($fleamarket_entry_styles);
            $fleamarket_entry_style = $fleamarket_entry_styles[$fleamarket_entry_style_key];
            break;
        }
    }

    $user_key = array_rand($users);
    $user = $users[$user_key];


    $data = array(
        'user_id'                   => $user->user_id,
        'fleamarket_id'             => $fleamarket->fleamarket_id,
        'fleamarket_entry_style_id' => $fleamarket_entry_style->fleamarket_entry_style_id,
        'reservation_number'        => str_pad($fleamarket->fleamarket_id, 5, "0", STR_PAD_LEFT) . '-' . str_pad($i, 5, "0", STR_PAD_LEFT),
        'item_category'             => $item_category,
        'item_genres'               => $item_genres[$item_genre],
        'reserved_booth'            => mt_rand(1,3),
        'link_from'                 => $link_from_list[$link_from],
        'remarks'                   => '初めてフリマを予約します' . $i,
        'entry_status'              => $entry_status,
        'created_user'              => 0,
        // 'updated_user'              => '',
        // 'created_at'                => \Date::forge()->format('mysql'),
        // 'updated_at'                => '',
        // 'deleted_at'                => '',
    );

    $entry = \Model_Entry::forge($data);
    $entry->save();
}



// foreach ($seeds as $line) {
    // $model = Model_Entry::forge($line);
    // $model->save();
// }
