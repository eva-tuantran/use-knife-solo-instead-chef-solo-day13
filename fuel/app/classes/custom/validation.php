<?php

/**
 * 独自バリデーション
 *
 * @author ida
 */
class Custom_Validation
{
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
        $result = false;
        if ($val !== '') {
            mb_regex_encoding('UTF-8');

            $pattern = '/^0[0-9]{1,3}\-[0-9]{2,4}\-[0-9]{4}$/';
            $mach = preg_match($pattern , $val);
            $result = $mach === 1;
        }

        return $result;
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
        $isValid = true;
        if ($val !== '') {
            mb_regex_encoding('UTF-8');

            $pattern = '/^0[0-9]{1,3}\-[0-9]{2,4}\-[0-9]{4}$/';
            $mach = preg_match($pattern , $val);
            $isValid = $mach === 1;
        }

        return $isValid;
    }

    /**
     * 日時バリデーション
     *
     * 「yyyy/mm/dd H:i」形式
     *
     * @access public
     * @param mixed $val
     * @return bool バリデーション結果
     * @author ida
     */
    public static function _validation_valid_datetime($val)
    {
        mb_regex_encoding('UTF-8');
        $pattern = '/^(2[0-9]{3})[\/|\-]'
                 . '([1-9]{1}|0[1-9]{1}|1[0-2]{1})[\/|\-]'
                 . '([1-9]{1}|0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})\s'
                 . '([1-9]{1}|0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}|):'
                 . '(0[0-9]{1}|[1-5]{1}[0-9]{1})$/';

        $isValid = false;
        $isValid = (bool) preg_match($pattern , $val, $matches);

        if ($isValid) {
            $isValid = checkdate($matches[2], $matches[3], $matches[1]);
        }

        return $isValid;
    }
}
