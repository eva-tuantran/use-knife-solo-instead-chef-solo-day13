<?php
/**
 * マイリスト
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Favorite  extends \Fuel\Core\Controller_Rest
{
    public function post_add()
    {
        if (! Auth::check()) {
            return $this->response('nologin');
        }
        $fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));

        if (! $fleamarket) {
            return $this->response('nodata');
        }            

        $data = array(
            'user_id'       => Auth::get_user_id(),
            'fleamarket_id' => Input::param('fleamarket_id',1)
        );
        
        $favorite = Model_Favorite::query()
            ->where($data)
            ->get_one();
        
        if (! $favorite) {
            $favorite = Model_Favorite::forge($data);
            try {
                $favorite->save();
            } catch (\Exception $e) {
                throw $e;
                return $this->response(false);
            }
        }

        return $this->response(true);
    }
}
