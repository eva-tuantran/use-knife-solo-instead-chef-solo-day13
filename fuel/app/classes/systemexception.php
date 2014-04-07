<?php
/**
 * システムとしてのエラーを補足する
 *
 * @author ida
 */

class SystemException extends \FuelException
{
	public function response()
	{
        $error_code = $this->getMessage();
        $errors = Lang::load('error', $error_code);

        $response = \Request::forge('errors/index', false)
            ->execute(array(
                'error_code' => $error_code,
                'error_message' => $errors[$error_code])
            )
            ->response();

		return $response;
	}
}
