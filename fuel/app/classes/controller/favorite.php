<?php
/**
 * マイリスト
 *
 * @extends  Controller_Base_Template
 * @author Hiroyuki Kobayashi
 */

class Controller_Favorite  extends Controller_Base_Template
{
    protected $fleamarket = null;
    protected $input = array();

    protected $_secure_actions = array('delete');

    public function before()
    {
        parent::before();

        if (! Auth::check()) {
            return $this->responseJson('nologin', true);
        }
        $this->fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
        
        if (! $this->fleamarket) {
            return $this->responseJson('nodata', true);
        }            
        
        $this->input = array(
            'user_id'       => Auth::get_user_id(),
            'fleamarket_id' => Input::param('fleamarket_id')
        );
        
        $this->favorite = Model_Favorite::query()
            ->where($this->input)
            ->get_one();
    }

    public function post_add()
    {
        if (! $this->favorite) {
            $this->favorite = Model_Favorite::forge($this->input);
            try {
                $this->favorite->save();
            } catch (\Exception $e) {
                throw $e;
                return $this->responseJson(false);
            }
        }

        return $this->responseJson(true);
    }

    public function post_delete()
    {
        if ($this->favorite) {
            try {
                $this->favorite->delete();
            } catch (\Exception $e) {
                throw $e;
                return $this->responseJson(false);
            }
        }

        return $this->responseJson(true);
    }

}
