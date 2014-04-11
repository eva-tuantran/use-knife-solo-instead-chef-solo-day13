<?php

/**
 * View_Mypage_Index ViewModel
 *
 * @author shimma
 */
class View_Mypage_Index extends View_Mypage_Base
{

    public function view()
    {
        parent::view();

        $entries = array();
        foreach ($this->entries as $fleamarket) {
            $entries[] = $this->addDisplayStrings($fleamarket);
        }
        $this->entries = $entries;

        $mylists = array();
        foreach ($this->mylists as $fleamarket) {
            $mylists[] = $this->addDisplayStrings($fleamarket);
        }
        $this->mylists = $mylists;

        $myfleamarkets = array();
        foreach ($this->myfleamarkets as $fleamarket) {
            $myfleamarkets[] = $this->addDisplayStrings($fleamarket);
        }
        $this->myfleamarkets = $myfleamarkets;
    }

}
