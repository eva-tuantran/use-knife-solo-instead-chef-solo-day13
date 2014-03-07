<?php 

class View_Signup_Confirm extends ViewModel
{

    public function view()
    {
        $form_inputs = $this->_view->get('user_input', null);

        $this->set('user_hidden_inputs', self::renderHiddenInputs($form_inputs), false);
    }


    /**
     * フォームinput情報から確認画面用にhiddenパラメータを作成します
     *
     * @author shimma
     */
    public static function renderHiddenInputs($form_inputs = array())
    {
        $ignore_id= array(
            'submit',
        );

        $html = '';
        foreach($form_inputs as $id => $value){
            if(in_array($id, $ignore_id)){
                continue;
            }
            $html .= "<input type=\"hidden\" id=\"form_${id}\" name=\"${id}\" value=\"${value}\" >\n";
        }

        return $html;
    }



}
