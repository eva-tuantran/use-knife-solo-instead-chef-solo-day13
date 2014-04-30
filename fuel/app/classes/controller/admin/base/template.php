<?php

class Controller_Admin_Base_Template extends Controller_Template
{
    protected $administrator = null;

    public function before()
    {
        $this->template = 'admin/template';

        if ($this->request->action != 'login') {
            $this->administrator = \Session::get('admin.administrator');
            if (! $this->administrator) {
                \Response::redirect('admin/login');
            }
        }

        parent::before();
    }

    /**
     * JSON で返却 $send が true だと send して exit します
     *
     * @param $data 返却する値 $send
     * @access protected
     * @return Response
     * @author kobayasi
     */
    protected function response_json($data = false, $send = false)
    {
        $response = new \Response(json_encode($data), 200);
        $response->set_header('Content-Type', 'application/json');
        if ($send) {
            $response->send(true);
            exit;
        }
        return $response;
    }

    public function after($response)
    {
        return parent::after($response);
    }
}
