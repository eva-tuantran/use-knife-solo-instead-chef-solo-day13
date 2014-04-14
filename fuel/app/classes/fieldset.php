<?php

/**
 * フィールドセットの拡張。
 *
 * @author shimma
 */
class Fieldset extends Fuel\Core\Fieldset
{

    /**
     * バリデーションエラーが発生した場合でもvalidatedされた値を返すようにする
     *
     * @param  mixed $field
     * @access public
     * @return void
     * @author shimma
     */
    public function validated($field = null)
    {
        $value = $this->fieldset()->validation()->validated($this->name);

        if ($this->error()) {
            $value = $this->input();
        }

        return $value;
    }

}
