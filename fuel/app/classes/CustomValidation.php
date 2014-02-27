<?php

/**
 * CustomValidation
 *
 * @author ida
 */
class CustomValidation
{
    /**
     * 数字チェック
     *
     * @access public
     * @param mixed $val 検証する値
     * @return bool
     * @author ida
     */
    public function _validation_valid_numeric($val)
    {
        return (preg_match('/^[0-9]+$/', $val) > 0);
    }

    /**
     *  アルファベットチェック
     *
     * @access public
     * @param mixed $val 検証する値
     * @return bool
     * @author ida
     */
    public function _valition_valid_alpha($val)
    {
        return (preg_match('/^[a-zA-Z]+$/', $val) > 0);
    }

    /**
     * 電話番号バリデーション
     *
     * @access public
     * @param mixed $val
     * @return bool バリデーション結果
     * @author ida
     */
    public static function _validation_required_tel($val)
    {
        $tel1 = Input::post('sponsor_tel1');
        $tel2 = Input::post('sponsor_tel2');
        $tel3 = Input::post('sponsor_tel3');
        $tel = (string) $tel1 . $tel2 . $tel3;

        return $tel !== '';
    }

    /**
     * 電話番号バリデーション
     *
     * @access public
     * @param mixed $val
     * @return bool バリデーション結果
     * @author ida
     */
    public static function _validation_valid_tel($val)
    {
        $tel1 = Input::post('sponsor_tel1');
        $tel2 = Input::post('sponsor_tel2');
        $tel3 = Input::post('sponsor_tel3');
        $tel = $tel1 . '-' . $tel2 . '-' . $tel3;

        mb_regex_encoding('UTF-8');
        $pattern = '/^[0-9]{2,}\-[0-9]{2,}\-{0,1}[0-9]{2,}$/';
        $result = preg_match($pattern , $tel);

        return $result === 1;
    }
}
