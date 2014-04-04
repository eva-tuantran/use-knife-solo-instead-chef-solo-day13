<?php

class Controller_Admin_Base_Template extends Controller_Template
{
    public function before()
    {
        $this->template = 'admin/template';
        parent::before();
    }

    public function after($response)
    {
        return parent::after($response);
    }
}
