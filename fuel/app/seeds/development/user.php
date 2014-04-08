<?php

use \Model_User;

$seeds = array(

    array(
        'email'           => 'rakuichi-test@aucfan.com',
        'password'        => \Auth::hash_password('rakuichi-test@aucfan.com'),
        'last_name'       => 'テスト',
        'last_name_kana'  => 'テスト',
        'first_name'      => '楽市',
        'first_name_kana' => 'らくいち',
        'nick_name'       => '楽市てすと',
        'gender'          => 1,
        'prefecture_id'   => 40,
        'zip'             => '160-0001',
        'tel'             => '03-1212-1212',
        'address'         => '東京都渋谷区道玄坂1-14-6 ヒューマックス渋谷ビル6階',
        'register_status' => \REGISTER_STATUS_ACTIVATED,
    ),
    array(
        'email'           => 'afml_dev@aucfan.com',
        'password'        => \Auth::hash_password('afml_dev@aucfan.com'),
        'last_name'       => 'テスト2',
        'last_name_kana'  => 'テスト2',
        'first_name'      => '楽市',
        'first_name_kana' => 'らくいち',
        'nick_name'       => '楽市てすと2',
        'prefecture_id'   => 31,
        'zip'             => '160-0001',
        'tel'             => '03-1212-1212',
        'gender'          => 2,
        'address'         => '東京都渋谷区道玄坂1-14-6 ヒューマックス渋谷ビル6階',
        'register_status' => \REGISTER_STATUS_ACTIVATED,
    ),
);

foreach ($seeds as $line) {
    $model = Model_User::forge($line);
    $model->save();
}
