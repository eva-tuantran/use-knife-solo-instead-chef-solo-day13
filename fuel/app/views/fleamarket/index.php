<script type="text/javascript">
$(function() {
    $("#form_event_date").datepicker({
        numberOfMonths: 3,
        showButtonPanel: true
    });
});
</script>
<?php
    echo $form->open('fleamarket/confirm');
?>
<h2><?php echo $title;?></h2>
<table>
    <tbody>
        <tr>
            <td><?php
                echo $form->field('name')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                echo $form->field('name')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
                if (isset($errors['name'])):
                    echo '<div>' . $errors['name'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('promoter_name')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                echo $form->field('promoter_name')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
                if (isset($errors['promoter_name'])):
                    echo '<div>' . $errors['promoter_name'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('website')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('website')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
                if (isset($errors['website'])):
                    echo '<div>' . $errors['website'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('reservation_tel1')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('reservation_tel1')
                    ->set_template('{field}')
                    ->set_attribute('class', 'xx-small')
                    ->set_attribute('maxlength', 4);
                echo ' - ';
                echo $form->field('reservation_tel2')
                    ->set_template('{field}')
                    ->set_attribute('class', 'xx-small')
                    ->set_attribute('maxlength', 4);
                echo ' - ';
                echo $form->field('reservation_tel3')
                    ->set_template('{field}')
                    ->set_attribute('class', 'xx-small')
                    ->set_attribute('maxlength', 4);
                if (isset($errors['promoter_tel1'])):
                    echo '<div>' . $errors['reservation_tel1'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('reservation_email')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('reservation_email')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'x-large'));
                if (isset($errors['reservation_email'])):
                    echo '<div>' . $errors['reservation_email'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('event_date')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                echo $form->field('event_date')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'x-small'));
                echo $form->field('event_hour')
                    ->set_template('{field}時')
                    ->set_attribute('tag', 'select')
                    ->set_attribute('class', 'xx-small')
                    ->set_options($event_hours);
                echo $form->field('event_minute')
                    ->set_template('{field}分')
                    ->set_attribute('tag', 'select')
                    ->set_attribute('class', 'xx-small')
                    ->set_options($event_minutes);
                if (isset($errors['event_date'])):
                    echo '<div>' . $errors['event_date'] . '</div>';
                endif;
           ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('location_name')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                echo $form->field('location_name')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'large'));
                if (isset($errors['location_name'])):
                    echo '<div>' . $errors['location_name'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->label('開催住所');
            ?><span class="text-danger">*<span>
            </td>
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
                    ->set_template('{label}<span class="text-danger">{required}<span>');
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
        <?php
            foreach ($event_abouts as $event_about):
        ?>
        <tr>
            <td><?php
                echo $form->field($event_about['name'])
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field($event_about['name'])
                    ->set_template('{field}')
                    ->set_attribute('tag', 'textarea')
                    ->set_attribute('class', 'about');
                if (isset($errors[$event_about['name']])):
                    echo '<div>' . $event_about['name'] . '</div>';
                endif;
            ?></td>
        </tr>
        <?php
            endforeach;
        ?>
    </tbody>
</table>
<div class="action-section">
<?php
    echo Form::input('confirm', '登録内容の確認', array('type' => 'submit', 'id' => 'do_confoirm'));
?>
</div>
<?php
    echo $form->close();
?>
