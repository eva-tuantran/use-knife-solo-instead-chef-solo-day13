<?php
/**
 * システムとしてのエラーを補足する
 *
 *
 * @todo: SystemExceptionのメール送信のみなので、PHP自体のエラーの時も送信できるようにする
 *
 * @author ida
 * @author shimma
 */

class SystemException extends \FuelException
{
    public function __construct($message = '', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function response()
    {
        $error_code = $this->getMessage();
        $error_list = Lang::load('error/user', $error_code);

        if (! isset($error_list[$error_code])) {
            $error_code = \Model_Error::ER00001;
        }
        $error_message = $error_list[$error_code];

        $params = array(
            'error_code'    => $error_code,
            'error_message' => $error_message,
            'line'          => $this->getLine(),
            'file'          => $this->getFile(),
            'url'           => Uri::main(),
            'input'         => print_r(Input::all(), true),
            'real_ip'       => Input::real_ip(),
            'user_agent'    => Input::user_agent(),
            'user_id'       => Auth::get_user_id(),
            'occurred_at'   => date('Y/m/d H:i:s'),
        );

        $email = new Model_Email();
        $email->sendMailByParams('error', $params);

        $response = \Request::forge('errors/index', false)
            ->execute($params)->response();

        return $response;
    }
}
