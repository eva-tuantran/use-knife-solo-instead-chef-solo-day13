<?php
/**
 * 
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Admin_Entry extends Controller_Admin_Base_Template
{
    public function action_list()
    {
        $view = View::forge('admin/entry/list');

        $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
        if ($fleamarket) {
            $view->set('fleamarket', $fleamarket, false);
        }
        
        $this->template->content = $view;
    }

    public function action_csv()
    {
        $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));

        $data = array();
        foreach ($fleamarket->entries as $entry) {
            $array = $entry->to_array();

            foreach (array(       
                'nick_name',
                'last_name',
                'first_name',
                'email',
            ) as $column) {
                $array[$column] = $entry->user->get($column);
            }
            $data[] = $array;
        }
        return $this->response_csv($data);
    }

    protected function response_csv($data)
    {
        $csv = mb_convert_encoding(
            Format::forge($data)->to_csv(),
            'SJIS-win',
            'UTF-8'
        );

        $response = new Response($csv, 200, array(
            'Content-Type'        => 'application/csv',
            'Content-Disposition' => 'attachment; filename="hoge.csv"',
        ));

        return $response;
    }
}
