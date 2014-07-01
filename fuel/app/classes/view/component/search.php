<?php

/**
 * View_Component_Search ViewModel
 *
 * @author ida
 *
 */
class View_Component_Search extends \ViewModel
{
    public function view()
    {
        $this->regions = \Config::get('master.regions');
        $this->alphabet_regions = \Config::get('master.alphabet_regions');
        $this->region_prefectures = \Config::get('master.region_prefectures');
        $this->prefectures = \Config::get('master.prefectures');
        $this->alphabet_prefectures = \Config::get('master.alphabet_prefectures');
    }
}