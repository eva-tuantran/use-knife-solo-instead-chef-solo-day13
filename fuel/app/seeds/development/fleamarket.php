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

$event_reservation_statuses = array(
    \Model_Fleamarket::EVENT_RESERVATION_STATUS_ENOUGH,
    \Model_Fleamarket::EVENT_RESERVATION_STATUS_FEW,
    \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL,
);

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

$about_titles = \Model_Fleamarket_About::getAboutTitles();
$abouts = getFleamarketAbouts();

$prefectures = \Config::get('master.prefectures');
$location_list = getLocations();

$entry_styles = array(
    '1' => '手持ち出店',
    '2' => '手持ち出店（プロ）',
    '3' => '車出店',
    '4' => '車出店（プロ）',
);

$booth_fee_list = array(
    0, 500, 1000, 1500, 2000, 2500, 3000
);

$event_numbers = array();

// \DB::query('TRUNCATE TABLE fleamarkets')->execute();
// \DB::query('TRUNCATE TABLE fleamarket_entry_styles')->execute();
// \DB::query('TRUNCATE TABLE fleamarket_abouts')->execute();
// \DB::query('TRUNCATE TABLE locations')->execute();

for ($i = 1; $i <= 1000; $i++) {
    $group_code = array_rand($group_codes);
    $group_code_name = $group_codes[$group_code];

    $register_type = array_rand($register_types);

    // 開催地情報
    $location_name = array_rand($location_list, 1);
    $location = $location_list[$location_name];
    list($prefecture, $address) = getAddress($location);
    $prefecture_id = array_search($prefecture, $prefectures);

    $location_line = array(
        'branch_id'     => null,
        'name'          => $location_name,
        'zip'           => '100-0001',
        'prefecture_id' => $prefecture_id,
        'address'       => $address,
        'googlemap_address' => $location,
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
    $event_reservation_status = array_rand($event_reservation_statuses);
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
        'location_id'              => $location_id,
        'group_code'               => $group_code_name,
        'name'                     => $group_code_name . 'フリーマーケット',
        'promoter_name'            => '株式会社オークファン',
        'event_number'             => $event_number,
        'event_date'               => $event_date,
        'event_time_start'         => $event_start_list[$event_start],
        'event_time_end'           => $event_end_list[$event_end],
        'event_status'             => $event_status,
        'event_reservation_status' => $event_reservation_status,
        'headline'                 => 'headline!',
        'information'              => 'information!',
        'description'              => getFleamarketDescription(),
        'reservation_serial'       => 1,
        'reservation_start'        => $reservation_start,
        'reservation_end'          => $reservation_end,
        'reservation_tel'          => '03-1222-2222',
        'reservation_email'        => 'sample' . $i . '@aucfan.com',
        'website'                  => 'http://www.yahoo.co.jp',
        'item_categories'          => implode(',', $item_categories),
        'link_from_list'           => implode(',', $lead_to_list),
        'pickup_flag'              => \Model_fleamarket::PICKUP_FLAG_ON,
        'pickup_flag'              => $pickup_list[$pickup],
        'shop_fee_flag'            => $shop_fee_list[$shop_fee],
        'car_shop_flag'            => $car_shop_list[$car_shop],
        'pro_shop_flag'            => $pro_shop_list[$pro_shop],
        'charge_parking_flag'      => $charge_parking_list[$charge_parking],
        'free_parking_flag'        => $free_parking_list[$free_parking],
        'rainy_location_flag'      => $rainy_location_list[$rainy_location],
        'donation_fee'             => 0,
        'donation_point'           => null,
        'register_type'            => $register_types[$register_type],
        'display_flag'             => \Model_fleamarket::DISPLAY_FLAG_ON,
        'created_user'             => 0,
        'updated_user'             => null,
        'created_at'               => \Date::forge()->format('mysql'),
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
            if ($shop_fee_list[$shop_fee] == \Model_Fleamarket::SHOP_FEE_FLAG_FREE) {
                $booth_fee = 0;
            } else {
                $booth_fee_key = array_rand($booth_fee_list);
                $booth_fee = $booth_fee_list[$booth_fee_key];
            }
            $max_booth = mt_rand(20, 100);
            $reservation_booth_limit = mt_rand(1, 10);

            $entry_style_line = array(
                'fleamarket_id' => $fleamarket_id,
                'entry_style_id' => $entry_style_id,
                'booth_fee' => $booth_fee,
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

    // フリマ説明情報
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
                'description' => $abouts[$about_id],
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

/**
 * 住所から都道府県を省く
 *
 * @access private
 * @param string $address 住所
 * @return string
 * @author ida
 */
function getAddress($address)
{
    $address_pattern = '/(東京都|北海道|(?:京都|大阪)府|.{6,9}県)'
                     . '((?:四日市|廿日市|野々市|かすみがうら|つくばみらい|いちき串木野)市|'
                     . '(?:杵島郡大町|余市郡余市|高市郡高取)町|'
                     . '.{3,12}市.{3,12}区|.{3,9}区|.{3,15}市(?=.*市)|'
                     . '.{3,15}市|.{6,27}町(?=.*町)|.{6,27}町|'
                     . '.{9,24}村(?=.*村)|.{9,24}村)(.*)/';
    preg_match($address_pattern, $address, $matches);
    $address = @$matches[2] . @$matches[3];

    return array($matches[1], $address);
}

function getLocations()
{
    return array(
        'としまえん園'          => '東京都練馬区向山3-25-1',
        '川崎競馬 芝生広場'     => '神奈川県川崎市川崎区富士見1-5-1',
        '大井競馬場'            => '東京都品川区勝島2-1-2',
        'グランディ21'          => '宮城県宮城郡利府町菅谷字舘40-1',
        'くりはま花の国'        => '神奈川県横須賀市神明町1',
        '仙台大観音参道'        => '宮城県仙台市泉区実沢座中山南31-7',
        '大島小松川公園'        => '東京都江東区大島9･江戸川区小松川1',
        '船橋競馬場'            => '千葉県船橋市若松1-2-1',
        '富士急ハイランド'      => '山梨県富士吉田市新西原 5丁目 6−1',
        '出玉本舗玉五郎北見店'  => '北海道北見市中の島町1丁目7-8',
        '夢屋新井田店'          => '青森県八戸市新井田西一丁目4番3号',
        '扇町公園'              => '大阪府大阪市北区扇町1丁目',
        '伊勢崎オートレース場'  => '群馬県伊勢崎市宮子町3074',
        'ガイア那須塩原店'      => '栃木県那須塩原市一区町105-128',
        'ガイア郡山大町店'      => '福島県郡山市大町2-3-2',
        '日本一の芋煮会フェスティバル' => '山形県山形市馬見ヶ崎河川敷',
        'ガイア横手Ⅰ･Ⅱ'       => '秋田県横手市安田字縄手添31',
        'ガイア前沢店'          => '岩手県奥州市前沢区竹沢63',
        'イオンタウン矢本'      => '宮城県東松島市小松字上浮足43番地',
        '川越水上公園'          => '埼玉県川越市大字池辺880',
        '西武園ゆうえんち'      => '埼玉県所沢市山口2964',
        '幕張海浜公園'          => '千葉県千葉市美浜区ひび野2丁目116',
        '潮田公園'              => '神奈川県横浜市鶴見区向井町2丁目71',
        '登米市ワコーボール'    => '宮城県登米市迫町佐沼字江合1丁目2-4',
        'ペルチ土浦店'          => '茨城県土浦市有明町1-30',
        'ダイナム大田原店'      => '栃木県大田原市中田原737番地',
        'ARK480'                => '群馬県高崎市箕郷町上芝281-1',
        'さいたま上尾水上公園'  => '埼玉県上尾市日の出2丁目',
        'SHIBUYA-AX'            => '東京都渋谷区神南2-1-1',
        '隅田公園'              => '東京都台東区花川戸1',
        'オゼック国分寺店'      => '東京都国分寺市東元町4丁目1−36',
        'バリアンリゾート玉三郎新発田店' => '新潟県新発田市舟入町3-8-9',
        'ニューラッキー古正寺店' => '新潟県長岡市古正寺123番地1',
        '夢屋小諸店'            => '長野県小諸市御影新田2758-1',
        '夢屋浜松店'            => '静岡県浜松市中区上島7-6-38',
        '玉越中川店'            => '愛知県名古屋市中川区長須賀1-203',
        '玉越浄水店'            => '愛知県豊田市浄水町155-5',
        '玉越本店'              => '愛知県名古屋市守山区白山一丁目2301',
        '信頼の森松阪三雲店'    => '三重県三重県松阪市市場庄町1240',
        'クァトロブーム金沢店'  => '石川県金沢市副都心北部大河端土地区画整理事業地内1街区1番',
        'クァトロブーム新田塚店' => '福井県福井市二の宮5丁目8-36',
        '楽々タウン'            => '大阪府堺市西区浜寺船尾町東2-272',
        'ウインアップ'          => '大阪府大阪市平野区長吉長原西1-1-30',
        'キコーナ東大阪店'      => '大阪府東大阪市長田中3-1-29',
        '楽パチや・ビバダイヤ'  => '大阪府大阪府泉佐野市鶴原1596-1',
        'コード太秦店'          => '京都府京都府京都市右京区太秦下刑部町18',
        'ダイナム 愛知川店 ゆったり館' => '滋賀県滋賀県愛知郡愛荘町長野24',
        'テンイチ外川店'        => '奈良県大和郡山市外川町1-42',
        'リゲル姫路店'          => '兵庫県姫路市西庄119',
        '尼ぱち屋'              => '兵庫県尼崎市東難波町5丁目28-31',
        'TAIYO88'               => '岡山県倉敷市神田1丁目6-14',
        'ジャンボ久世店'        => '岡山県真庭市富尾235',
        '川棚温泉'              => '山口県下関市豊浦町大字川棚6860',
        '信頼の森善通寺店'      => '香川県香川県善通寺市弘田町894',
        'パーラーグランド住吉店' => '徳島県徳島市住吉5-7-4',
        '信頼の森 愛媛今治店'   => '愛媛県今治市古国分1丁目8番65号',
        'おもちゃ倉庫 福岡本店' => '福岡県福岡市東区箱崎7-9-58',
        'マルハン佐賀店'        => '佐賀県佐賀市巨勢町牛島760-1',
        'NASA稲佐店'            => '長崎県長崎市旭町7-12',
        '南大分セントラルパーク' => '大分県大分市奥田659-1',
        '夢屋天草店'            => '熊本県天草市本渡町本戸馬場2254',
        'ベリーズ日南店'        => '宮崎県日南市平野601番地',
    );
}

function getFleamarketDescription()
{
    $description = <<< "DESCRIPTION"
毎回大好評!(^^)!
車出店しかも出店無料!!
とっても貴重な会場で開催がまたまた決定!!(^_-)-☆

会場は、地元から長年愛されている
『○○○○ △△△△』さんの駐車場!!(^^♪

国分寺駅から京王バス(府中駅行き)に乗って5分!
『藤塚バス停』のすぐ目の前!!
アクセスも良好な会場です(*^_^*)

フリマにぴったりなこのシーズン♪♪
休日は、家族で友人でフリマに行こう(^^)v

※【ご出店者様へ】雨天時は、翌日の日曜日に順延となります。順延日もご出店が可能な方のみ、ご予約頂きますよう、宜しくお願い致します。
-------------------------------
※【ご来場者様へ】無料駐車場は台数に限りがありますので、満車の時はお車を駐車できないことがあります。公共交通機関のご利用にご協力下さい。
DESCRIPTION;

    return $description;
}

function getFleamarketAbouts()
{
    return array(
        \Model_Fleamarket_About::ACCESS     => '国分寺駅から京王バス(府中駅行き)藤塚バス停下車すぐ目の前',
        \Model_Fleamarket_About::EVENT_TIME => '開催時間について	9時〜14時(※搬入時間8時〜9時) ※原則出店者の途中退出はできません。',
        \Model_Fleamarket_About::SHOP_CAUTION => '≪出品禁止物≫ プロ出店禁止(※プロ出店は家庭の不用品の域を越える荷物の方や新品商品、専門的品揃え、仕入品などの業者的な商品を販売する店舗になります) 多量の新品商品、天然石使用の手作り品、飲食物、動植物、化粧品、医薬品(酒、たばこ、法律に違反するもの)偽ブランドコピー品、複製ソフト(録画、録音、複写等)、危険な刀物類(模造刀、ナイフ、包丁、モデルガン、危険な工具類も含む)、アダルト関連(風紀を乱すもの)、 テキ屋的販売、有料くじ、盗品・法律で禁じられている物、 当 日に他のお店で買った物、骨董品関連(高額商品、不当商品等を含む)、また、販売に対してスタッフが不適応と判断した品物',
        \Model_Fleamarket_About::SHOP_FEE   => 'チャリティフリマ ``出店料無料`` (家庭の不用品、手作り・アート出店)',
        \Model_Fleamarket_About::SHOP_STYLE => '車出店:間口2.5×7.0m (縦だし出店*お車を含めたスペースになります)',
        \Model_Fleamarket_About::BOOTH      => "限定60店舗(家庭の不用品・手作り品・アート出店)\n※雨天時は、翌日の日曜日に順延となります。順延日もご出店が可能な方のみ、ご予約頂きますよう、宜しくお願い致します。",
        \Model_Fleamarket_About::PARKING    => '無料駐車場有り',
    );
}
