<?php echo Asset::css('jquery-ui.min.css')?>
<?php echo Asset::js('jquery-1.10.2.js')?>
<?php echo Asset::js('jquery-ui.min.js')?>
<?php echo Asset::js('jquery.ui.datepicker-ja.js')?>
<style type="text/css">
    .small {
        width: 50px;
    }

    .medium {
        width: 100px;
    }
    .large {
        width: 200px;
    }

    textarea {
        width: 300px;
        height: 100px;
    }

    table td {
        padding: 5px;
    }
</style>
<script type="text/javascript">
$(function() {
    $("#form_event_date").datepicker();
});
</script>
<?php
    echo $form->open('fleamarket/confirm');
    echo Form::hidden(
        Config::get('security.csrf_token_key'), Security::fetch_token()
    );
?>
<div><?php
foreach ($errors as $field => $error) {
    echo $error->get_message();
}
?></div>
<table>
    <tbody>
        <tr>
            <td><?php
                echo $form->field('sponsor_name')
                    ->set_template('{label}{required}');
            ?></td>
            <td><?php
                echo $form->field('sponsor_name')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
                echo $form->field('sponsor_name')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('sponsor_website')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('sponsor_website')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
                echo $form->field('sponsor_website')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('sponser_tel1')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('sponser_tel1')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'small'));
                echo ' - ';
                echo $form->field('sponser_tel2')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'small'));
                echo ' - ';
                echo $form->field('sponser_tel3')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'small'));
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('sponser_email')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('sponser_email')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
                echo $form->field('sponser_email')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('event_date')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('event_date')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'medium'));
                echo $form->field('event_time_hour')
                    ->set_template('{label}');
                echo $form->field('event_time_hour')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'small'));
                echo $form->field('event_time_minute')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'small'));
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('fleamarket_name')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('fleamarket_name')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
                echo $form->field('fleamarket_name')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td>開催住所</td>
            <td><?php
                echo $form->field('zip')
                    ->set_template('<div>〒 {field}</div>')
                    ->set_attribute(array('class' => 'small'));
                echo $form->field('prefecture')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'medium'));
                echo $form->field('address')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('description')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('description')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'txt_half'));
                echo $form->field('description')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_access')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('about_access')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'txt_half'));
                echo $form->field('description')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_event_time')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('about_event_time')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'txt_half'));
                echo $form->field('about_event_time')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_booth')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('about_booth')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'txt_half'));
                echo $form->field('about_booth')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_shop_cautions')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('about_shop_cautions')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'txt_half'));
                echo $form->field('about_shop_cautions')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_shop_style')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('about_shop_style')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'txt_half'));
                echo $form->field('about_shop_style')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_shop_fee')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('about_shop_fee')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'txt_half'));
                echo $form->field('about_shop_fee')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_parking')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('about_parking')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'txt_half'));
                echo $form->field('about_parking')
                    ->set_template('<div>{error_msg}</div>');
            ?></td>
        </tr>
    </tbody>
</table>
<?php echo $form->field('confirm');?>
<?php echo $form->close();?>
