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
        $is_valid = false;

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
        $is_valid = false;

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
     * @author shimma
     */
    public static function _validation_valid_zip($val)
    {
        $is_valid = false;

        mb_regex_encoding('UTF-8');
        $pattern = '/^[0-9]{3}-?[0-9]{4}$/';
        $is_valid = (bool) preg_match($pattern, $val);

        return $is_valid;
    }


    /**
     * カタカナチェック
     *
     * @access public
     * @param mixed $val 入力値
     * @return bool チェック結果
     * @author shimma
     */
    public static function _validation_valid_kana($val)
    {
        $is_valid = false;

        mb_regex_encoding('UTF-8');
        $pattern = '/^[ァ-ヶー]+$/u';
        $is_valid = (bool) preg_match($pattern, $val);

        return $is_valid;
    }

    /**
     * 必須チェック（複数チェックボックス）
     *
     * $minで最低チェック数を指定
     */
    public static function _validation_checkbox_require(
        $values, $min = null
    ) {
        $is_valid = false;

        if ($values && is_array($values)) {
            $min = $min ? $min : 1;
            $is_valid = count($values) >= $min;
        }

        return $is_valid;
    }

    /**
     * 値の正当性チェック（複数チェックボックス）
     *
     * @access public
     * @param mixed $val 入力値
     * @param array $option 許可リスト
     * @return bool チェック結果
     * @author shimma
     */
    public static function _validation_checkbox_values($values, $options)
    {
        $is_valid = false;

        if (! $values || ! is_array($values)) {
            $is_valid = true;
        } else {
            foreach ($values as $value) {
                if (! array_key_exists($value, $options)) {
                    $is_valid = flase;
                    break;
                }
            }
        }

        return true;
    }


    /**
     * 会場IDの存在チェック
     *
     * @access public
     * @param  mixed $loocation_id 会場ID
     * @return bool
     * @author ida
     */
    public static function _validation_location_exists($location_id)
    {
        $count = \Model_Location::query()->where(array(
            'location_id' => $location_id,
        ))->count();

        return $count == 1;
    }
}
