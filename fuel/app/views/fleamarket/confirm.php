<script type="text/javascript">
$(function() {
    $("#do_back").on("click", function(evt) {
        evt.preventDefault();
        $("#form_confirm").attr('action', '/fleamarket/back').submit();
    });
});
</script>
<table>
    <tbody>
        <tr>
            <td><?php
                echo $form->field('name')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['name'])):
                    echo Security::htmlentities($data['name']);
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
                    echo Security::htmlentities($data['promoter_name']);
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
                    echo Security::htmlentities($data['website']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('reservation_tel1')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['reservation_tel1'])
                    && $data['reservation_tel1'] != ''
                ):
                    $tel1 = Security::htmlentities($data['reservation_tel1']);
                    echo $tel1 . '-';
                endif;
                if (isset($data['reservation_tel2'])
                    && $data['reservation_tel2'] != ''
                ):
                    $tel2 = Security::htmlentities($data['reservation_tel2']);
                    echo $tel2 . '-';
                endif;
                if (isset($data['reservation_tel3'])
                    && $data['reservation_tel3'] != ''
                ):
                    echo Security::htmlentities($data['reservation_tel3']);
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
                    echo Security::htmlentities($data['reservation_email']);
                endif;
            ?></td>
        </tr>
        <tr>
            <td><?php
                echo $form->field('event_date')
                    ->set_template('{label}');
            ?></td>
            <td><?php
                if (isset($data['event_date'])
                    && $data['event_date'] != ''
                ):
                    $event_date =  Security::htmlentities($data['event_date']);
                    echo $event_date . '&nbsp;';
                endif;
                if (isset($data['event_hour'])
                    && $data['event_hour'] != ''
                ):
                    $event_hour = Security::htmlentities($data['event_hour']);
                    echo $event_hour . ':';
                endif;
                if (isset($data['event_minute'])
                    && $data['event_minute'] != ''
                ):
                    echo Security::htmlentities($data['event_minute']);
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
                    echo Security::htmlentities($data['location_name']);
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
                        echo '〒' . Security::htmlentities($data['zip']);
                    endif;
                ?></div>
                <?php
                    if (isset($data['prefecture'])):
                        $prefecture = $app_config['prefectures'][$data['prefecture']];
                        echo Security::htmlentities($prefecture);
                    endif;
                    if (isset($data['address'])):
                        echo Security::htmlentities($data['address']);
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
                    echo Security::htmlentities($data['description']);
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
                if (isset($data[$event_about['name']])):
                    echo Security::htmlentities($data[$event_about['name']]);
                endif;
            ?></td>
        </tr>
        <?php
            endforeach;
        ?>
    </tbody>
</table>
<?php
    echo $form->open(
        array('action' => 'fleamarket/register', 'method' => 'post', 'id' => 'form_confirm')
    );
    echo Form::hidden(
        Config::get('security.csrf_token_key'), Security::fetch_token()
    );
?>
<div class="action-section">
<?php
    echo Form::input('confirm', '入力に戻る', array('type' => 'button', 'id' => 'do_back'));
    echo Form::input('confirm', '登録する', array('type' => 'submit', 'id' => 'do_register'));
?>
</div>
<?php
    echo $form->close();
?>
