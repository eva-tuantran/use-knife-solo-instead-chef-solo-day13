<?php

use \Model_Favorite;

for ($i=1; $i<100; $i++) {

    $user_id = mt_rand(1,2);
    // $fleamarket_id = mt_rand(1,50);
    $fleamarket_id = $i; //ユニークキー制約が残っているため一旦インクリメントで実装

    $seed = array(
        'user_id'       => $user_id,
        'fleamarket_id' => $fleamarket_id,
    );

    $model = Model_Favorite::forge($seed);
    $model->save();
}
