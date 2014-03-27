<?php
/**
 * マイリスト
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Favorite  extends \Fuel\Core\Controller_Rest
{
    public function get_add()
    {
/*
        if (! Auth::check()) {
            return $this->response(array(1 => 2), 200);
        }
*/

        $favorite = Model_Favorite::forge();
        $favorite->set(array(
            'user_id'       => Auth::get_user_id(),
            'fleamarket_id' => Input::param('fleamarket_id')
        ));
        $favorite->save();

        $data = true;
        return $this->response($data, 200);
    }
}
