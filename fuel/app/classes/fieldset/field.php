<?php

class Fieldset_Field extends Fuel\Core\Fieldset_Field
{

    /**
     * バリデーションエラーが発生した場合でもvalidatedされた値を返すようにする
     */
    public function validated()
    {
        $value = $this->fieldset()->validation()->validated($this->name);

        if ($this->error())
        {
            $value = $this->input();
        }

        return $value;
    }


    /**
     * フォーム要素をviewで使いやすい配列で取得
     */
    public function getElements($open = '', $hidden = array())
    {
        if (is_array($open)) {
            $attr = $open;
        } else {
            $attr['action'] = $open;
            $attr['method'] = 'post';
        }

        $attr['id'] = 'form_' . $this->get_name();

        //常にhiddenパラメータでCSRF対策のトークンを付与するようにする
        $hidden[Config::get('security.csrf_token_key')] = Security::fetch_token();
        $form['open'] = $this->form()->open($attr, $hidden);

        foreach ($this->field() as $f) {
            $form[$f->name] = array('label' => $f->label, 'html' => $f->build());
        }

        $form['close'] = '</form>';
        $form['error'] = $this->show_errors();

        return $form;
    }

    /**
     * 数値の入力を受け付けるinput text要素
     *
     * - 自動的に数値バリデーションが追加される
     * - 自動的にime-modeがdisabledに設定される
     */
    public function addTextForNumeric($name, $label)
    {
        return $this->add(
            $name,
            $label,
            array(
                'class' => 'input-medium',
                'style' => 'ime-mode:disabled'
            )
        )->add_rule('valid_string', 'numeric')->set_template('{field}');
    }

    /**
     * 選択肢を一行で表示するRadio要素
     */
    public function addRadioInline($name, $label, $options)
    {
        return $this->add(
            $name,
            $label,
            array(
                'type'    => 'radio',
                'options' => $options,
            )
        )->set_template('{fields}<label class="radio inline">{field}{label}</label>{fields}');
    }

    /**
     * 選択肢を改行するRadio要素
     */
    public function addRadioWithBr($name, $label, $options)
    {
        return $this->add(
            $name,
            $label,
            array(
                'type'    => 'radio',
                'options' => $options,
            )
        )->set_template('{fields}<label class="radio">{field}{label}</label>{fields}');
    }

}
