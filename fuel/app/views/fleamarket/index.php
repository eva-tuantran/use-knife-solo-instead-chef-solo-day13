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
<h2><?php echo $title;?></h2>
<table>
    <tbody>
        <tr>
            <td><?php
                echo $form->field('sponsor_name')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                echo $form->field('sponsor_name')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
                if (isset($errors['sponsor_name'])):
                    echo '<div>' . $errors['sponsor_name'] . '</div>';
                endif;
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
                if (isset($errors['sponsor_website'])):
                    echo '<div>' . $errors['sponsor_website'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('sponsor_tel1')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('sponsor_tel1')
                    ->set_template('{field}')
                    ->set_attribute('class', 'xx-small')
                    ->set_attribute('maxlength', 4);
                echo ' - ';
                echo $form->field('sponsor_tel2')
                    ->set_template('{field}')
                    ->set_attribute('class', 'xx-small')
                    ->set_attribute('maxlength', 4);
                echo ' - ';
                echo $form->field('sponsor_tel3')
                    ->set_template('{field}')
                    ->set_attribute('class', 'xx-small')
                    ->set_attribute('maxlength', 4);
                if (isset($errors['sponsor_tel1'])):
                    echo '<div>' . $errors['sponsor_tel1'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('sponsor_email')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('sponsor_email')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'x-large'));
                if (isset($errors['sponsor_email'])):
                    echo '<div>' . $errors['sponsor_email'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->label('開催日時');
            ?></td>
            <td><?php
                echo $form->field('event_date')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'x-small'));
                echo $form->field('event_time_hour')
                    ->set_template('{field}')
                    ->set_attribute('tag', 'select')
                    ->set_attribute('class', 'xx-small')
                    ->set_options($hours);
                echo $form->field('event_time_minute')
                    ->set_template('{field}')
                    ->set_attribute('tag', 'select')
                    ->set_attribute('class', 'xx-small')
                    ->set_options($minutes);
                if (isset($errors['event_date'])):
                    echo '<div>' . $errors['sponser_email'] . '</div>';
                endif;
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
                if (isset($errors['fleamarket_name'])):
                    echo '<div>' . $errors['fleamarket_name'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->label('開催住所');
            ?></td>
            <td><?php
                echo $form->field('zip')
                    ->set_template('<div>〒 {field}</div>')
                    ->set_attribute(array('class' => 'x-small'));
                echo $form->field('prefecture')
                    ->set_template('{field}')
                    ->set_attribute('tag', 'select')
                    ->set_attribute('class', 'x-small')
                    ->set_options($prefectures);
                echo $form->field('address')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
                if (isset($errors['address'])):
                    echo '<div>' . $errors['address'] . '</div>';
                endif;
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
                    ->set_attribute('tag', 'textarea')
                    ->set_attribute('class', 'description');
                if (isset($errors['description'])):
                    echo '<div>' . $errors['description'] . '</div>';
                endif;
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
                    ->set_attribute('tag', 'textarea')
                    ->set_attribute('class', 'about');
                if (isset($errors['about_access'])):
                    echo '<div>' . $errors['about_access'] . '</div>';
                endif;
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
                    ->set_attribute('tag', 'textarea')
                    ->set_attribute('class', 'about');
                if (isset($errors['about_event_time'])):
                    echo '<div>' . $errors['about_event_time'] . '</div>';
                endif;
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
                    ->set_attribute('tag', 'textarea')
                    ->set_attribute('class', 'about');
                if (isset($errors['about_booth'])):
                    echo '<div>' . $errors['about_booth'] . '</div>';
                endif;
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
                    ->set_attribute('tag', 'textarea')
                    ->set_attribute('class', 'about');

                if (isset($errors['about_shop_cautions'])):
                    echo '<div>' . $errors['about_shop_cautions'] . '</div>';
                endif;
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
                    ->set_attribute('tag', 'textarea')
                    ->set_attribute('class', 'about');

                if (isset($errors['about_shop_style'])):
                    echo '<div>' . $errors['about_shop_style'] . '</div>';
                endif;
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
                    ->set_attribute('tag', 'textarea')
                    ->set_attribute('class', 'about');

                if (isset($errors['about_shop_fee'])):
                    echo '<div>' . $errors['about_shop_fee'] . '</div>';
                endif;
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
                    ->set_attribute('tag', 'textarea')
                    ->set_attribute('class', 'about');

                if (isset($errors['about_parking'])):
                    echo '<div>' . $errors['about_parking'] . '</div>';
                endif;
            ?></td>
        </tr>
    </tbody>
</table>
<?php
    echo Form::input('confirm', '確認', array('type' => 'submit', 'id' => 'do_confoirm'));
    echo $form->close();
?>
