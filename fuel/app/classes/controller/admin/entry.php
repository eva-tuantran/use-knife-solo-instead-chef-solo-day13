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
        $this->template->content = $view;

        $total = Model_Entry::findByKeywordCount(
            Input::all()
        );

        $query_string = '';
        foreach (array('reservation_number','fleamarket_id', 'user_id') as $field) {
            $query_string = $query_string . "&${field}=" . urlencode(Input::param($field));
        }
        
        Pagination::set_config(array(
            'pagination_url' => "admin/entry/list?$query_string",
            'uri_segment'    => 4,
            'num_links'      => 10,
            'per_page'       => 50,
            'total_items'    => $total,
            'name'           => 'pagenation',
        ));

        $entries = Model_Entry::findByKeyword(
            Input::all(),
            Pagination::get('per_page'),
            Pagination::get('offset')
        );
        
        $view->set('entries', $entries, false);

        if (Input::param('fleamarket_id')) {
            $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
            $view->set('fleamarket', $fleamarket, false);
        }

        if (Input::param('user_id')) {
            $user = Model_User::find(Input::param('user_id'));
            $view->set('user', $user, false);
        }
    }

    public function action_csv()
    {
        $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));

        $data = array();
        foreach ($fleamarket->entries as $entry) {
            $array = $entry->to_array();

            if ($entry->user) {
                foreach (array('nick_name','last_name','first_name','email') as $column) {
                    $array[$column] = $entry->user->get($column);
                }
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

    public function action_index()
    {
        $view = View::forge('admin/entry/index');
        $this->template->content = $view;
    }
}
