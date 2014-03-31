<?php

/**
 * Calendar Controller.
 *
 * @extends  Controller_Base_Template
 */
class Controller_Calendar extends Controller
{
    /**
     * action_index
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_index()
    {
        $year = (int) $this->param('year', date('Y'));
        $month = (int) $this->param('month', date('n'));

        $view_model = ViewModel::forge('component/calendar');
        $view_model->set('year', $year);
        $view_model->set('month', $month);

        return $view_model;
    }
}
