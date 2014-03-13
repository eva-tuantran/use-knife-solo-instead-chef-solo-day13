<script type="text/javascript">
$(function() {
  $("#form_event_date").datepicker({
    numberOfMonths: 3,
    showButtonPanel: true
  });
  $("#form_event_time_start").timepicker({
    showButtonPanel: true,
    stepMinute: 5
  });
  $("#form_event_time_end").timepicker({
    showButtonPanel: true,
    stepMinute: 5
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
                echo $form->field('reservation_tel')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                echo $form->field('reservation_tel')
                    ->set_template('{field}')
                    ->set_attribute('class', 'medium')
                    ->set_attribute('maxlength', 13);
                ?>
                <div>※「-(ハイフン）」を入れてご入力ください。</div>
                <?php
                if (isset($errors['reservation_tel'])):
                    echo '<div>' . $errors['reservation_tel'] . '</div>';
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
                echo $form->field('event_datetime')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                echo $form->field('event_date')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'x-small'));
                echo $form->field('event_time_start')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'xx-small'));
                echo ' ～ ';
                echo $form->field('event_time_end')
                    ->set_template('{field}')
                    ->set_attribute(array('class' => 'xx-small'));

                if (isset($errors['event_date'])):
                    echo '<div>' . $errors['event_date'] . '</div>';
                endif;
                if (isset($errors['event_time_start'])):
                    echo '<div>' . $errors['event_time_start'] . '</div>';
                endif;
                if (isset($errors['event_time_end'])):
                    echo '<div>' . $errors['event_time_end'] . '</div>';
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
                echo $form->field('prefecture_id')
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
        <tr>
            <td><?php
                echo $form->field('shop_fee_flag')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                $shop_fee_flag = $form->field('shop_fee_flag')
                    ->set_template('{field}')
                    ->set_type('checkbox')
                    ->set_value(FLEAMARKET_SHOP_FEE_FLAG_CHARGE);
                if (isset($data['shop_fee_flag'])
                    && $data['shop_fee_flag'] == FLEAMARKET_SHOP_FEE_FLAG_CHARGE
                ):
                    $shop_fee_flag->set_attribute('checked', 'checked');
                endif;
                echo $shop_fee_flag;

                if (isset($errors['shop_fee_flag'])):
                    echo '<div>' . $errors['shop_fee_flag'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('car_shop_flag')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                $car_shop_flag = $form->field('car_shop_flag')
                    ->set_template('{field}')
                    ->set_type('checkbox')
                    ->set_value(FLEAMARKET_CAR_SHOP_FLAG_OK);
                if (isset($data['car_shop_flag'])
                    && $data['car_shop_flag'] == FLEAMARKET_CAR_SHOP_FLAG_OK
                ):
                    $car_shop_flag->set_attribute('checked', 'checked');
                endif;
                echo $car_shop_flag;

                if (isset($errors['car_shop_flag'])):
                    echo '<div>' . $errors['car_shop_flag'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('pro_shop_flag')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                $pro_shop_flag = $form->field('pro_shop_flag')
                    ->set_template('{field}')
                    ->set_type('checkbox')
                    ->set_value(FLEAMARKET_PRO_SHOP_FLAG_OK);
                if (isset($data['pro_shop_flag'])
                    && $data['pro_shop_flag'] == FLEAMARKET_PRO_SHOP_FLAG_OK
                ):
                    $pro_shop_flag->set_attribute('checked', 'checked');
                endif;
                echo $pro_shop_flag;

                if (isset($errors['pro_shop_flag'])):
                    echo '<div>' . $errors['pro_shop_flag'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('charge_parking_flag')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                $charge_parking_flag = $form->field('charge_parking_flag')
                    ->set_template('{field}')
                    ->set_type('checkbox')
                    ->set_value(FLEAMARKET_CHARGE_PARKING_FLAG_EXIST);
                if (isset($data['charge_parking_flag'])
                    && $data['charge_parking_flag'] == FLEAMARKET_CHARGE_PARKING_FLAG_EXIST
                ):
                    $charge_parking_flag->set_attribute('checked', 'checked');
                endif;
                echo $charge_parking_flag;

                if (isset($errors['charge_parking_flag'])):
                    echo '<div>' . $errors['charge_parking_flag'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('free_parking_flag')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                $free_parking_flag = $form->field('free_parking_flag')
                    ->set_template('{field}')
                    ->set_type('checkbox')
                    ->set_value(FLEAMARKET_FREE_PARKING_FLAG_EXIST);
                if (isset($data['free_parking_flag'])
                    && $data['free_parking_flag'] == FLEAMARKET_FREE_PARKING_FLAG_EXIST
                ):
                    $free_parking_flag->set_attribute('checked', 'checked');
                endif;
                echo $free_parking_flag;

                if (isset($errors['free_parking_flag'])):
                    echo '<div>' . $errors['free_parking_flag'] . '</div>';
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('rainy_location_flag')
                    ->set_template('{label}<span class="text-danger">{required}<span>');
            ?></td>
            <td><?php
                $rainy_location_flag = $form->field('rainy_location_flag')
                    ->set_template('{field}')
                    ->set_type('checkbox')
                    ->set_value(FLEAMARKET_RAINY_LOCATION_FLAG_EXIST);
                if (isset($data['rainy_location_flag'])
                    && $data['rainy_location_flag'] == FLEAMARKET_RAINY_LOCATION_FLAG_EXIST
                ):
                    $rainy_location_flag->set_attribute('checked', 'checked');
                endif;
                echo $rainy_location_flag;

                if (isset($errors['rainy_location_flag'])):
                    echo '<div>' . $errors['rainy_location_flag'] . '</div>';
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
