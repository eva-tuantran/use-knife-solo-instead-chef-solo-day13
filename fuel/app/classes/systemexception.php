<?php
/**
 * システムとしてのエラーを補足する
 *
 * @author ida
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
        $error_list = Lang::load('error', $error_code);

        if (! isset($error_list[$error_code])) {
            $error_code = 0;
        }

        $params = array(
            'error_code' => $error_code,
            'error_message' => $error_list[$error_code],
        );
        $response = \Request::forge('errors/index', false)
            ->execute($params)->response();

		return $response;
	}
}
