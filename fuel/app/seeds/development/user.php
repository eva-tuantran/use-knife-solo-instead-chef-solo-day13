<?php

use \Model_User;

$seeds = array(

    array(
        'email'           => 'shimma@aucfan.com',
        'password'        => \Auth::hash_password('shimma@aucfan.com'),
        'last_name'       => '新間',
        'last_name_kana'  => 'シンマ',
        'first_name'      => '楽市',
        'first_name_kana' => 'ラクイチ',
        'nick_name'       => 'てすと',
        'gender'          => 1,
        'prefecture_id'   => 40,
        'zip'             => 'abababab',
        'tel'             => '03-1234-5678',
        'address'         => '東京都渋谷区道玄坂1-14-6 ヒューマックス渋谷ビル6階',
        'mm_flag'         => 1,
        'register_status' => \REGISTER_STATUS_ACTIVATED,
    ),
    array(
        'email'           => 'h_kobayashi@aucfan.com',
        'password'        => \Auth::hash_password('h_kobayashi@aucfan.com'),
        'last_name'       => '小林',
        'last_name_kana'  => 'コバヤシ',
        'first_name'      => '楽市',
        'first_name_kana' => 'ラクイチ',
        'nick_name'       => 'テスト',
        'prefecture_id'   => 13,
        'zip'             => 'aaaa',
        'tel'             => '03-1369-2480',
        'gender'          => 2,
        'address'         => '東京都渋谷区道玄坂1-14-6 ヒューマックス渋谷ビル6階',
        'mm_flag'         => 1,
        'register_status' => \REGISTER_STATUS_ACTIVATED,
    ),
    array(
        'email'           => 'ida@aucfan.com',
        'password'        => \Auth::hash_password('ida@aucfan.com'),
        'last_name'       => '井田',
        'last_name_kana'  => 'イダ',
        'first_name'      => '楽市',
        'first_name_kana' => 'ラクイチ',
        'nick_name'       => 'テスト',
        'prefecture_id'   => 31,
        'zip'             => 'aaaa',
        'tel'             => '03-5678-1234',
        'gender'          => 2,
        'address'         => '東京都渋谷区道玄坂1-14-6 ヒューマックス渋谷ビル6階',
        'mm_flag'         => 1,
        'register_status' => \REGISTER_STATUS_ACTIVATED,
    ),
);

foreach ($seeds as $line) {
    \Model_User::forge($line)->save();
}
