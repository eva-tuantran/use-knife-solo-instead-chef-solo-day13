<?php

/**
 * 独自バリデーション
 *
 * @author ida
 */
class Custom_Validation
{
    /**
     * 電話番号チェック
     *
     * @access public
     * @param mixed $val 入力値
     * @return bool チェック結果
     * @author ida
     */
    public static function _validation_valid_tel($val)
    {
        $is_valid = true;

        mb_regex_encoding('UTF-8');
        $pattern = '/^0[0-9]{1,3}\-[0-9]{2,4}\-[0-9]{4}$/';
        $is_valid = (bool) preg_match($pattern, $val);

        return $is_valid;
    }

    /**
     * 時間チェック
     *
     * 「H:i」形式
     *
     * @access public
     * @param mixed $val 入力値
     * @return bool チェック結果
     * @author ida
     */
    public static function _validation_valid_time($val)
    {
        mb_regex_encoding('UTF-8');
        $pattern = '/^([1-9]{1}|0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}|):'
                 . '(0[0-9]{1}|[1-5]{1}[0-9]{1})$/';
        $is_valid = (bool) preg_match($pattern, $val);

        return $is_valid;
    }

    /**
     * 郵便番号チェック
     *
     * @access public
     * @param mixed $val 入力値
     * @return bool チェック結果
     * @author ida
     */
    public static function _validation_valid_zip($val)
    {
        $is_valid = true;

        mb_regex_encoding('UTF-8');
        $pattern = '/^[0-9]{3}-?[0-9]{4}$/';
        $is_valid = (bool) preg_match($pattern, $val);

        return $is_valid;
    }


}
