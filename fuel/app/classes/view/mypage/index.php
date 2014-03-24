<?php

/**
 * View_Mypage_Index ViewModel
 *
 * @author shimma
 */
class View_Mypage_Index extends ViewModel
{

    protected $master_entry_styles;


    /**
     * view method
     *
     * @access public
     * @return void
     * @author shimma
     */
    public function view()
    {
        $this->master_entry_styles = Config::get('master.entry_styles');

        foreach ($this->entries as &$entry) {
            $this->addDisplayStrings($entry);
        }
        unset($entry);

    }


    /**
     * 数字で渡ってくるパラメータを文字列に変換したものを付与します。
     *
     * @access private
     * @return void
     * @author shimma
     */
    public function addDisplayStrings(&$entry)
    {
        $entry['fleamarket_entry_style_name'] = '名称がありません';

        if (isset($entry['fleamarket_entry_style_id'])) {
            $id = $entry['fleamarket_entry_style_id'];

            if (isset($this->master_entry_styles[$id])) {
                $entry['fleamarket_entry_style_name'] = $this->master_entry_styles[$id];
            }
        }
    }

}
