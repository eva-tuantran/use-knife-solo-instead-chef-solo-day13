<?php

use \Model_Administrator;

$data = array(
    'administrator_id' => 1,
    'last_name' => '楽市楽座',
    'first_name' => '管理者',
    'last_name_kana' => 'ラクイチラクザ',
    'first_name_kana' => 'カンリシャ',
    'email' => 'admin@rakuichi-rakuza.jp',
    'password' => \Auth::hash_password('admin@rakuichi-rakuza.jp'),
    'created_user' => 0
);


$model = Model_Administrator::forge($data);
$model->save();
