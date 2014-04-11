<?php

/**
 * View_Mypage_List ViewModel
 *
 * @author shimma
 */
class View_Mypage_List extends View_Mypage_Base
{

    public function view()
    {
        parent::view();

        $fleamarkets = array();
        foreach ($this->fleamarkets as $fleamarket) {
            $fleamarkets[] = $this->addDisplayStrings($fleamarket);
        }
        $this->fleamarkets = $fleamarkets;
    }

}
