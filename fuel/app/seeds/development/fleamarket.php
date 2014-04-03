<?php

use \Model_Fleamarket;
use \Model_Fleamarket_About;
use \Model_Fleamarket_Entry_Style;
use \Model_Location;
use \Model_Entry;

srand((float) microtime() * 10000000);
$group_codes = array(
    'Neo', 'Morpheus', 'Trinity', 'Cypher', 'Tank', 'Matrix',
    'Luke', 'Leia', 'Han', 'Darth', 'R2D2', 'C3PO', 'Starwars'
);
$event_statuses = \Model_Fleamarket::getEventStatuses();

$event_reservation_statuses = array(1, 2, 3);

$event_months = array('03', '04', '05', '06');
$event_days = array('01', '02', '08', '09', '15', '16', '22', '23', '30');
$event_start_list = array('09:00:00', '09:15:00', '09:30:00', '10:00:00', '10:30:00');
$event_end_list = array('16:00:00', '16:30:00', '17:15:00', '15:30:00', '19:00:00');

$item_categories = array(
    '1' => 'リサイクル品',
    '2' => '手作り品',
);

$lead_to_list = array(
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

$pickup_list = array(
    \Model_Fleamarket::PICKUP_FLAG_OFF,
    \Model_Fleamarket::PICKUP_FLAG_ON,
);

$shop_fee_list = array(
    \Model_Fleamarket::SHOP_FEE_FLAG_FREE,
    \Model_Fleamarket::SHOP_FEE_FLAG_CHARGE,
);

$car_shop_list = array(
    \Model_Fleamarket::CAR_SHOP_FLAG_NG,
    \Model_Fleamarket::CAR_SHOP_FLAG_OK,
);

$pro_shop_list = array(
    \Model_Fleamarket::PRO_SHOP_FLAG_NG,
    \Model_Fleamarket::PRO_SHOP_FLAG_OK,
);

$charge_parking_list = array(
    \Model_Fleamarket::CHARGE_PARKING_FLAG_NONE,
    \Model_Fleamarket::CHARGE_PARKING_FLAG_EXIST,
);

$free_parking_list = array(
    \Model_Fleamarket::FREE_PARKING_FLAG_NONE,
    \Model_Fleamarket::FREE_PARKING_FLAG_EXIST,
);

$rainy_location_list = array(
    \Model_Fleamarket::RAINY_LOCATION_FLAG_NONE,
    \Model_Fleamarket::RAINY_LOCATION_FLAG_EXIST,
);

$register_types = array(
    \Model_Fleamarket::REGISTER_TYPE_ADMIN,
    \Model_Fleamarket::REGISTER_TYPE_USER,
);

$prefectures = \Config::get('master.prefectures');

$cities = array('葛飾区' , '大田区', '品川区', '調布市', '多摩市', '西東京市', '杉並区', );

$entry_styles = array(
    '1' => '手持ち出店',
    '2' => '手持ち出店（プロ）',
    '3' => '車出店',
    '4' => '車出店（プロ）',
);

$booth_fee_list = array(
    0, 500, 1000, 1500, 2000, 2500, 3000
);

$about_titles = \Model_Fleamarket_About::getAboutTitles();

$event_numbers = array();

for ($i = 1; $i <= 100; $i++) {
    $rand = mt_rand(1, 30);
    $group_code = array_rand($group_codes);
    $group_code_name = $group_codes[$group_code];

    $register_type = array_rand($register_types);

    // 開催地情報
    $prefecture_id = 13; // array_rand($prefectures);
    $city = array_rand($event_end_list);

    $location_line = array(
        'branch_id'     => null,
        'name'          => $group_code_name . 'の会場',
        'zip'           => '100-0001',
        'prefecture_id' => $prefecture_id,
        'address'       => $prefectures[$prefecture_id] . $cities[$city],
        'googlemap_address' => $prefectures[$prefecture_id] . $cities[$city],
        'register_type' => $register_types[$register_type],
        'created_user'  => 0,
        'updated_user'  => null,
        'created_at'    => \Date::forge()->format('mysql'),
        // 'updated_at'    =>
        // 'deleted_at'    =>
    );
    $location = \Model_Location::forge($location_line);
    $location->save();
    $location_id = $location->location_id;

    // フリマ情報
    if (isset($event_numbers[$group_code])) {
        $event_number = ++$event_numbers[$group_code];
    } else {
        $event_number = $event_numbers[$group_code] = 1;
    }

    $event_status = array_rand($event_statuses);
    $event_reservation_statuse = array_rand($event_reservation_statuses);
    $event_month = array_rand($event_months);
    $event_day = array_rand($event_days);
    $event_date = '2014-' . $event_months[$event_month] . '-' . $event_days[$event_day];
    $event_start = array_rand($event_start_list);
    $event_end = array_rand($event_end_list);

    $tmp_start = '00:00:00';
    $tmp_end = '23:59:59';
    $tmp_start_datetime = $event_date . ' ' . $tmp_start;
    $tmp_end_datetime = $event_date . ' ' . $tmp_end;
    $reservation_start = date('Y-m-d H:i:s', strtotime($tmp_start_datetime . ' -30 day'));
    $reservation_end = date('Y-m-d H:i:s', strtotime($tmp_end_datetime . ' -7 day'));

    $pickup = array_rand($pickup_list);
    $shop_fee = array_rand($shop_fee_list);
    $car_shop = array_rand($car_shop_list);
    $pro_shop = array_rand($pro_shop_list);
    $charge_parking = array_rand($charge_parking_list);
    $free_parking = array_rand($free_parking_list);
    $rainy_location = array_rand($rainy_location_list);

    if ($register_types[$register_type] == \Model_Fleamarket::REGISTER_TYPE_USER) {
        $event_status = \Model_Fleamarket::EVENT_STATUS_SCHEDULE;
    }
    $fleamarket_line = array(
        'location_id'         => $location_id,
        'group_code'          => $group_code_name,
        'name'                => $group_code_name . 'フリーマーケット',
        'promoter_name'       => '株式会社オークファン',
        'event_number'        => $event_number,
        'event_date'          => $event_date,
        'event_time_start'    => $event_start_list[$event_start],
        'event_time_end'      => $event_end_list[$event_end],
        'event_status'        => $event_status,
        'headline'            => 'headline!' . str_repeat('テスト', $rand),
        'information'         => 'information!' . str_repeat('テスト', $rand),
        'description'         => 'description!' . str_repeat('テスト', $rand),
        'reservation_serial'  => 1,
        'reservation_start'   => $reservation_start,
        'reservation_end'     => $reservation_end,
        'reservation_tel'     => '03-1222-2222',
        'reservation_email'   => 'sample' . $i . '@aucfan.com',
        'website'             => 'http://www.yahoo.co.jp',
        'item_categories'     => implode(',', $item_categories),
        'link_from_list'      => implode(',', $lead_to_list),
        'pickup_flag'         => \Model_fleamarket::PICKUP_FLAG_ON,
        'pickup_flag'         => $pickup_list[$pickup],
        'shop_fee_flag'       => $shop_fee_list[$shop_fee],
        'car_shop_flag'       => $car_shop_list[$car_shop],
        'pro_shop_flag'       => $pro_shop_list[$pro_shop],
        'charge_parking_flag' => $charge_parking_list[$charge_parking],
        'free_parking_flag'   => $free_parking_list[$free_parking],
        'rainy_location_flag' => $rainy_location_list[$rainy_location],
        'donation_fee'        => 0,
        'donation_point'      => null,
        'register_type'       => $register_types[$register_type],
        'display_flag'        => \Model_fleamarket::DISPLAY_FLAG_ON,
        'created_user'        => 0,
        'updated_user'        => null,
        'created_at'          => \Date::forge()->format('mysql'),
        // 'updated_at',
        // 'deleted_at',
    );
    $fleamarket = \Model_Fleamarket::forge($fleamarket_line);
    $fleamarket->save();
    $fleamarket_id = $fleamarket->fleamarket_id;

    // フリマ出店形態情報
    $entry_style_rand = mt_rand(0, 2);
    if ($entry_style_rand == 0
        && $register_types[$register_type] == \Model_Fleamarket::REGISTER_TYPE_ADMIN
    ) {
        $entry_style_rand = 1;
    } elseif ($register_types[$register_type] == \Model_Fleamarket::REGISTER_TYPE_USER) {
        $entry_style_rand = 0;
    }
    if ($entry_style_rand > 0) {
        $entry_style_list = array_rand($entry_styles, $entry_style_rand);
        if (! is_array($entry_style_list)) {
            $entry_style_list = (array) $entry_style_list;
        }

        foreach ($entry_style_list as $entry_style_id) {
            $booth_fee = array_rand($booth_fee_list);
            $max_booth = mt_rand(20, 100);
            $reservation_booth_limit = mt_rand(1, 10);

            $entry_style_line = array(
                'fleamarket_id' => $fleamarket_id,
                'entry_style_id' => $entry_style_id,
                'booth_fee' => $booth_fee_list[$booth_fee],
                'max_booth' => $max_booth,
                'reservation_booth_limit' => $reservation_booth_limit,
                'created_user' => 0,
                'updated_user' => null,
                'created_at' => \Date::forge()->format('mysql'),
                // 'updated_at',
                // 'deleted_at',
            );
            \Model_Fleamarket_Entry_Style::forge($entry_style_line)->save();
        }
    }

    // フリマ出店形態情報
    $about_rand = mt_rand(0, 7);
    if ($about_rand > 0) {
        $about_list = array_rand($about_titles, $about_rand);
        if (! is_array($about_list)) {
            $about_list = (array) $about_list;
        }

        foreach ($about_list as $about_id) {
            $about_line = array(
                'fleamarket_id' => $fleamarket_id,
                'about_id' => $about_id,
                'title' => $about_titles[$about_id],
                'description' => str_repeat('テスト', $rand),
                'created_user' => 0,
                'updated_user' => null,
                'created_at' => \Date::forge()->format('mysql'),
                // 'updated_at',
                // 'deleted_at',
            );
            \Model_Fleamarket_About::forge($about_line)->save();
        }
    }
}
