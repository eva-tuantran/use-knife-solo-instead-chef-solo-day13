<?php

namespace Fuel\Tasks;

class seed
{
    public function run($model)
    {
        if (!empty($model)) {
            include (APPPATH . 'seeds/' . \Fuel::$env . '/' . $model. '.php');
        }
    }
}
