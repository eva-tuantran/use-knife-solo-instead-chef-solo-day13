<?php

/**
 * 確認画面用のViewモデル
 *
 * @todo ユーザ投稿をformのhidden要素で持つため生成ロジックがあるが、set_flashでsession側でデータ保持をさせるのであればそちらに統一
 * @author Ricky <master@mistdev.com>
 */
class View_Signup_Confirm extends ViewModel
{

    public function view()
    {
        //getでそのまま取得するとdbのプロパティが全て取得されてしまうため、array_filterを利用して削除します
        $form_inputs = $this->_view->get('user_input', null);
        $form_inputs = array_filter($form_inputs, 'strlen');

        $this->set('user_hidden_inputs', self::renderHiddenInputs($form_inputs), false);
    }

    /**
     * フォームinput情報から確認画面用にhiddenパラメータを作成します
     *
     * @param array $form_inputs
     * @static
     * @access public
     * @return string
     */
    public static function renderHiddenInputs($form_inputs = array())
    {
        $ignore_id= array(
            'submit',
        );

        $html = '';
        foreach ($form_inputs as $id => $value) {
            if (in_array($id, $ignore_id)) {
                continue;
            }
            $html .= "<input type=\"hidden\" id=\"form_${id}\" name=\"${id}\" value=\"${value}\" >\n";
        }

        return $html;
    }

}
