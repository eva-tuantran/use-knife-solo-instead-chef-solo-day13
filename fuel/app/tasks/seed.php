<?php

namespace Fuel\Tasks;

/**
 * seed
 *
 * @author shimma
 * @todo arrayで指定しているものを一括で取り込むようにしました。従来通り一個ずつの対応の場合は修正お願いします。
 */
class seed
{
    public function run()
    {
        $models = array(
            'user',
            'entry',
            'fleamarket',
        );
        foreach ($models as $model) {
            include (APPPATH . 'seeds/' . \Fuel::$env . '/' . $model. '.php');
        }
    }

    // public function run($model = "")
    // {
        // if (! empty($model)) {
            // include (APPPATH . 'seeds/' . \Fuel::$env . '/' . $model. '.php');
        // }
    // }
}
