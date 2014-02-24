<?php

/**
 * CustomValidation
 *
 * @author ida
 */
class CustomValidation
{
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
        Validation::active()->set_message(
            'valid_tel',
            ':label が正しくありません'
        );

        mb_regex_encoding('UTF-8');
        $pattern = '/^\d{2,5}$/';
        $result = preg_match($pattern , $tel);

        return $result === 1;
    }

    /**
     * 電話番号バリデーション
     * 
     * @access public
     * @param mixed $val 
     * @return bool バリデーション結果
     * @author ida
     */
    public static function _validation_valid_time($val)
    {
        $tel1 = Input::post('sponser_tel1');
        $tel2 = Input::post('sponser_tel2');
        $tel3 = Input::post('sponser_tel3');
        $tel = $tel1 . '-' . $tel2 . '-' . $tel3;

        Validation::active()->set_message(
            'valid_time',
            ':label が正しくありません'
        );

        mb_regex_encoding('UTF-8');
        $pattern = '/^\d{2,5}\-?[0-9]{2,4}\-?\d{4}$/';
        $result = preg_match($pattern , $tel);

        return $result === 1;
    }
}