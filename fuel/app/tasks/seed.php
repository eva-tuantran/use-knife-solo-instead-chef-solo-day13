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
    public function run($model = null)
    {
        if (null == $model || $model == 'all') {
            $model = array(
                'user',
                'entry',
                'fleamarket',
                'favorite',
                'administrator',
            );
        }

        if (! empty($model)) {
            if (! is_array($model)) {
                $model = (array) $model;
            }
            foreach ($model as $m) {
                include (APPPATH . 'seeds/' . \Fuel::$env . '/' . $m . '.php');
            }
        }
    }

    // public function run($model = "")
    // {
        // if (! empty($model)) {
            // include (APPPATH . 'seeds/' . \Fuel::$env . '/' . $model. '.php');
        // }
    // }
}
