<style type="text/css">
table {width: 800px; border: 1px solid #ccc;}
table td {padding: 10px;}
.first-td {border-bottom: 1px solid #ccc}
.left-td {border-left: 1px solid #ccc;}
.right-td {border-right: 1px solid #ccc;}
.last-td {}
.event_info li {margin-left: 10px;padding: 5px; border: 1px solid #ccc; float: left;}
.event_info .invalid {background-color: #666}
.action_buttons li {margin-left: 10px; float: left;}
.action_buttons .reservation {background-color: #ffa500}
</style>
<script type="text/javascript">
$(function() {
});
</script>
<?php
    echo Form::open(array(
        'action' => 'search/',
        'method' => 'post',
        'id' => 'form_search_calendar',
    ));
?>
<h2><?php echo $title;?></h2>
<?php
    echo Form::open(array(
        'action' => 'search/detail',
        'method' => 'post',
        'id' => 'form_search_condition',
    ));
?>
<table>
    <tbody>
<?php
    if (! $fleamarket_list):
?>
        <tr>
            <td colspan="5">条件に一致するフリーマーケットはありませんでした</td>
        </tr>
<?php
    else:
        foreach ($fleamarket_list as $fleamarket):
            $fleamarket_id = $fleamarket['fleamarket_id'];
?>
        <tr>
            <td colspan="5" class="first-td"><?php
                echo e($fleamarket['name']);
            ?></td>
        </tr>
        <tr>
            <td rowspan="6" class="left-td"><?php
                // @TODO: フリマ登録に画像登録機能追加後に実装
                echo Html::img('path/to/aaa.jpg');
            ?></td>
            <td>開催日</td>
            <td><?php
                echo e($fleamarket['event_date']);
            ?></td>
            <td>出店形態</td>
            <td class="right-td"><?php
                echo e($fleamarket['style_string']);
            ?></td>
        </tr>
        <tr>
            <td>開催時間</td>
            <td><?php
                echo e($fleamarket['event_start_time']);
                if ($fleamarket['event_end_time'] != ''):
                    echo '～' . $fleamarket['event_end_time'];
                endif;
            ?></td>
            <td>出店料金</td>
            <td class="right-td"><?php echo e($fleamarket['fee_string']); ?></td>
        </tr>
        <tr>
            <td>交通</td>
            <td colspan="3"><?php
                echo e(@$fleamarket['about_access']);
            ?></td>
        </tr>
        <tr>
            <td colspan="4" class="right-td">
                <ul class="event_info">
                    <li class="<?php echo $fleamarket['car_shop_flag'] == 0 ? 'invalid': '';?>">車出店可能</li>
                    <li class="<?php echo $fleamarket['charge_parking_flag'] == 0 ? 'invalid': '';?>">有料駐車場</li>
                    <li class="<?php echo $fleamarket['free_parking_flag'] == 0 ? 'invalid': '';?>">無料駐車場</li>
                    <li class="<?php echo $fleamarket['rainy_location_flag'] == 0 ? 'invalid': '';?>">雨天開催会場</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td colspan="4"><?php
                echo e($fleamarket['booth_string']);
            ?></td>
        </tr>
        <tr>
            <td colspan="4" class="last-td">
                <ul class="action_buttons">
                    <li><?php
                        // @TODO: マイページ機能待ち？
                        echo Html::anchor('/mypage/mylist/' . $fleamarket_id, 'マイリストに追加', array('id' => 'do_mylist', 'class' => ''));
                    ?></li>
                    <li><?php
                        echo Html::anchor('/search/detail/' . $fleamarket_id, '詳細情報を見る', array('id' => 'do_detail', 'class' => ''));
                    ?></li>
                    <li class="reservation"><?php
                        echo Html::anchor('/reservation/index/' . $fleamarket_id, '出店予約をする', array('id' => 'do_reservation', 'class' => ''));
                    ?></li>
                </ul>
            </td>
        </tr>
<?php
        endforeach;
    endif;
?>
    </tbody>
</table>
<?php
    echo Form::close();
?>
