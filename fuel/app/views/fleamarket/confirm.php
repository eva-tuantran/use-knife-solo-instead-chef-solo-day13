<?php
    echo $form->open('fleamarket/register');
    echo Form::hidden(
        Config::get('security.csrf_token_key'), Security::fetch_token()
    );
?>
<table>
    <tbody>
        <tr>
            <td><?php
                echo $form->field('sponsor_name')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['sponsor_name'])):
                    echo Security::htmlentities($data['sponsor_name']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('sponsor_website')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['sponsor_website'])):
                    echo Security::htmlentities($data['sponsor_website']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('sponsor_tel1')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['sponsor_tel1'])):
                    echo Security::htmlentities($data['sponsor_tel1']);
                endif;
                echo ' - ';
                if (isset($data['sponsor_tel2'])):
                    echo Security::htmlentities($data['sponsor_tel2']);
                endif;
                echo ' - ';
                if (isset($data['sponsor_tel3'])):
                    echo Security::htmlentities($data['sponsor_tel3']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('sponsor_email')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['sponsor_email'])):
                    echo Security::htmlentities($data['sponsor_email']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('event_date')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['event_date'])):
                    echo Security::htmlentities($data['event_date']);
                endif;
                if (isset($data['event_time_hour'])):
                    echo Security::htmlentities($data['event_time_hour']);
                endif;
                echo ':';
                if (isset($data['event_time_minute'])):
                    echo Security::htmlentities($data['event_time_minute']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('fleamarket_name')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['fleamarket_name'])):
                    echo Security::htmlentities($data['fleamarket_name']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td>開催住所</td>
            <td><?php
                if (isset($data['zip'])):
                    echo Security::htmlentities($data['zip']);
                endif;
                if (isset($data['prefecture'])):
                    echo Security::htmlentities($data['prefecture']);
                endif;
                if (isset($data['address'])):
                    echo Security::htmlentities($data['address']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('description')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['description'])):
                    echo Security::htmlentities($data['description']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_access')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['about_access'])):
                    echo Security::htmlentities($data['about_access']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_event_time')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['about_event_time'])):
                    echo Security::htmlentities($data['about_event_time']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_booth')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['about_booth'])):
                    echo Security::htmlentities($data['about_booth']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_shop_cautions')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['about_shop_cautions'])):
                    echo Security::htmlentities($data['about_shop_cautions']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_shop_style')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['about_shop_style'])):
                    echo Security::htmlentities($data['about_shop_style']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_shop_fee')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['about_shop_fee'])):
                    echo Security::htmlentities($data['about_shop_fee']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('about_parking')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['about_parking'])):
                    echo Security::htmlentities($data['about_parking']);
                endif;
            ?></td>
        </tr>
    </tbody>
</table>
<?php echo $form->close();?>
