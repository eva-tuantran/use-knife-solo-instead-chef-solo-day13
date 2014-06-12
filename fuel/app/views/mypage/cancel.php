<div id="contentError" class="row">
<div id="error" class="container">
  <div class="box clearfix">
    <?php
        $cancel_title = '';
        switch ($cancel):
            case 'reservation':
                $cancel_title = '出店予約を解除しています';
                break;
            case 'waiting':
                $cancel_title = 'キャンセル待ちを解除しています';
                break;
        endswitch;;
    ?>
    <h3><?php echo $cancel_title;?></h3>
    <p>しばらくお待ち下さい....</p>
</div>
</div>
