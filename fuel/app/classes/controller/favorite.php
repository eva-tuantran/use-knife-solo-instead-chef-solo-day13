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

    public function before()
    {
        parent::before();

        if (! Auth::check()) {
            return $this->response_json('nologin', true);
        }
        $this->fleamarket = Model_Fleamarket::find(Input::param('fleamarket_id'));
        
        if (! $this->fleamarket) {
            return $this->response_json('nodata', true);
        }            
        
        $this->input = array(
            'user_id'       => Auth::get_user_id(),
            'fleamarket_id' => Input::param('fleamarket_id',1)
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
                return $this->response_json(false);
            }
        }

        return $this->response_json(true);
    }

    public function post_delete()
    {
        if ($this->favorite) {
            try {
                $this->favorite->delete();
            } catch (\Exception $e) {
                throw $e;
                return $this->response_json(false);
            }
        }

        return $this->response_json(true);
    }

}
