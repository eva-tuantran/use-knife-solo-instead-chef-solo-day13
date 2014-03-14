<table>
    <tbody>
        <tr>
            <td><?php
                echo $form->field('name')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['name'])):
                    echo e($data['name']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('promoter_name')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['promoter_name'])):
                    echo e($data['promoter_name']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('website')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['website'])):
                    echo e($data['website']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('reservation_tel')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['reservation_tel'])
                    && $data['reservation_tel'] != ''
                ):
                    $tel1 = e($data['reservation_tel']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('reservation_email')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['reservation_email'])):
                    echo e($data['reservation_email']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('event_datetime')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['event_date'])
                    && $data['event_date'] != ''
                ):
                    echo e($data['event_date']);
                endif;
                echo '&nbsp;';
                if (isset($data['event_time_start'])
                    && $data['event_time_start'] != ''
                ):
                    echo e($data['event_time_start']);
                endif;
                echo ' ～ ';
                if (isset($data['event_time_end'])
                    && $data['event_time_end'] != ''
                ):
                    echo e($data['event_time_end']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('location_name')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['location_name'])):
                    echo e($data['location_name']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->label('開催住所');
            ?></td>
            <td>
                <div><?php
                    if (isset($data['zip'])):
                        echo '〒' . e($data['zip']);
                    endif;
                ?></div>
                <?php
                    if (isset($data['prefecture_id'])):
                        $prefecture = $prefectures[$data['prefecture_id']];
                        echo e($prefecture);
                    endif;
                    if (isset($data['address'])):
                        echo e($data['address']);
                    endif;
                ?>
            </td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('description')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['description'])):
                    echo e($data['description']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('shop_fee_flag')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['shop_fee_flag'])):
                    echo e($data['shop_fee_flag']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('car_shop_flag')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['car_shop_flag'])):
                    echo e($data['car_shop_flag']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('pro_shop_flag')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['pro_shop_flag'])):
                    echo e($data['pro_shop_flag']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('charge_parking_flag')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['charge_parking_flag'])):
                    echo e($data['charge_parking_flag']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('free_parking_flag')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['free_parking_flag'])):
                    echo e($data['free_parking_flag']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('rainy_location_flag')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['rainy_location_flag'])):
                    echo e($data['rainy_location_flag']);
                endif;
            ?></td>
        </tr>
        <?php
            if ($event_abouts):
                foreach ($event_abouts as $event_about):
        ?>
        <tr>
            <td><?php
                echo $form->field($event_about['name'])
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data[$event_about['name']])):
                    echo e($data[$event_about['name']]);
                endif;
            ?></td>
        </tr>
        <?php
                endforeach;
            endif;
        ?>
    </tbody>
</table>
<?php
    echo $form->open(
        array('action' => 'fleamarket/thanks', 'method' => 'post', 'id' => 'form_confirm')
    );
    echo Form::hidden(
        Config::get('security.csrf_token_key'), Security::fetch_token()
    );
?>
<div class="action-section">
<?php
    echo Html::anchor('/fleamarket/index', '入力に戻る', array('id' => 'do_back', 'class' => ''));
    echo Form::input('confirm', '登録する', array('type' => 'submit', 'id' => 'do_register'));
?>
</div>
<?php
    echo $form->close();
?>
