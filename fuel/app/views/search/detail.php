<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
<script type="text/javascript">
$(function() {
  var map = new Map("access_map", "<?php echo $fleamarket['googlemap_address'];?>");

  var mainimage = $(".mainPhoto img").attr("src");
  $(".thumbnailPhoto img").on("click", function(evt) {
    var thumbimage = $(this).attr("src");
    $(".mainPhoto img").fadeOut("fast", function() {
      $(this).attr('src', thumbimage).fadeIn();
    });
  });

  $("#do_print").on("click", function(evt) {
    evt.preventDefault();
    window.print();
  });
});

function Map() {
  this.initialize.apply(this, arguments);
}

Map.prototype = {
  google_maps: null,
  initialize: function(id, address) {
    var latlng = new google.maps.LatLng(41, 133);
    var opts = {
      zoom: 15,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: latlng
    };

    Map.google_maps = new google.maps.Map(document.getElementById(id), opts);
    var geocoder = new google.maps.Geocoder();
    var req = {
      address: address
    };

    geocoder.geocode(req, this.draw);
  },
  draw: function(result, status) {
    if (status != google.maps.GeocoderStatus.OK) {
      return;
    }

    var latlng = result[0].geometry.location;
    Map.google_maps.setCenter(latlng);

    var marker = new google.maps.Marker({
      position: latlng,
      map: Map.google_maps,
      title: latlng.toString(),
      draggable: true
    });
    google.maps.event.addListener(marker, 'dragend', function(event) {
      marker.setTitle(event.latLng.toString());
    });
  }
};
</script>
<?php
    $fleamarket_id = $fleamarket['fleamarket_id'];
    $is_admin_fleamarket = false;
    if ($fleamarket['register_type'] == \Model_Fleamarket::REGISTER_TYPE_ADMIN):
        $is_admin_fleamarket = true;
    endif;
    if ($is_admin_fleamarket):
        $reservation_button = '出店予約をする';
        if ($fleamarket['event_reservation_status'] == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL):
            $reservation_button = 'キャンセル待ちをする';
        endif;
    endif;

    $total_booth = 0;
    $entry_style_string = '';
    $shop_fee_string = '';
    if ($fleamarket['entry_styles']):
        foreach ($fleamarket['entry_styles'] as $entry_style):
            $entry_type_id = $entry_style['entry_style_id'];

            $total_booth += $entry_style['max_booth'];

            $entry_style_string .= $entry_style_string != '' ? '/' : '';
            $entry_style_string .= $entry_styles[$entry_type_id];

            $shop_fee_string .= $shop_fee_string != '' ? '/' : '';
            $shop_fee_string .= $entry_styles[$entry_type_id];
            $booth_fee = $entry_style['booth_fee'];
            if ($booth_fee > 0):
                $booth_fee = number_format($booth_fee) . '円';
            else:
                $booth_fee = '無料';
            endif;
            $shop_fee_string .= '：' . $booth_fee;
        endforeach;
    endif;
?>
<div id="contentDetail" class="row">
  <!-- title -->
  <div id="title" class="container">
    <div class="box clearfix">
      <div class="titleLeft">
        <h2>
          <?php if ($is_admin_fleamarket):?>
          <strong><img src="/assets/img/resultPush.png" alt="楽市楽座主催" width="78" height="14"></strong>
          <?php endif;?><?php echo e($fleamarket['name']);?>
        </h2>
        <p class="date"><?php
            echo e(date('Y年n月j日', strtotime($fleamarket['event_date'])));
            echo '(' . $week_list[date('w', strtotime($fleamarket['event_date']))] . ')';
            echo '&nbsp;';
            echo e(date('G:i', strtotime($fleamarket['event_time_start'])));
            if ($fleamarket['event_time_end']):
                echo '～' . e(date('G:i', strtotime($fleamarket['event_time_end'])));
            endif;
        ?></p>
        <ul class="mylist">
          <li class="button addMylist"><a href="#" id="fleamarket_id_<?php echo $fleamarket['fleamarket_id'];?>"><i></i>マイリストに追加</a></li>
          <li class="button gotoMylist"><a href="/mypage/list?type=mylist"><i></i>マイリストを見る</a></li>
        </ul>
      </div>
      <ul class="rightbutton">
        <?php
            if ($is_admin_fleamarket && $fleamarket['event_status'] == \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT):
                $reservation_button = '出店予約をする';
                if ($fleamarket['event_reservation_status'] == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL):
                    $reservation_button = 'キャンセル待ちをする';
                endif;
        ?>
        <li class="button makeReservation"><a href="/reservation/?fleamarket_id=<?php echo e($fleamarket_id);?>"><i></i><?php echo $reservation_button;?></a></li>
        <?php
            endif;
        ?>
        <li id="do_print" class="button print hidden-xs"><a href="#"><i></i>ページの印刷をする</a></li>
      </ul>
    </div>
  </div>
  <!-- /title -->
  <!-- image -->
  <div id="image" class="col-sm-6">
    <h3>開催イメージ</h3>
    <div class="mainPhoto"><img src="http://dummyimage.com/460x300/00bfff/fff.jpg" alt="" width="460px" height="300px" class="img-responsive"></div>
    <ul class="thumbnailPhoto">
      <li><img src="http://dummyimage.com/100x65/00bfff/fff.jpg" alt="" width="100"></li>
      <li><img src="http://dummyimage.com/100x65/32cd32/fff.jpg" alt="" width="100"></li>
      <li><img src="http://dummyimage.com/100x65/ffd700/fff.jpg" alt="" width="100"></li>
      <li><img src="http://dummyimage.com/100x65/4b0082/fff.jpg" alt="" width="100"></li>
    </ul>
  </div>
  <!-- /image -->
  <!-- map -->
  <div id="map" class="col-sm-6">
    <h3>会場周辺地図</h3>
    <div id="access_map" style="width: 100%; height: 390px;"></div>
  </div>
  <!-- /map -->
  <!-- text -->
  <div id="text" class="col-sm-12">
<!--  <div id="text" class="container"> -->
    <div class="box clearfix"><?php echo nl2br(e($fleamarket['description']));?></div>
  </div>
  <!-- /text -->
  <!-- table -->
  <div id="table" class="col-sm-12">
<!--  <div id="table" class="container"> -->
    <div class="box clearfix">
      <h3>開催情報</h3>
      <dl class="dl-horizontal">
        <dt>フリマ開催名</dt>
        <dd><?php
            if ($fleamarket['name']):
                echo e($fleamarket['name']);
            else:
                echo '-';
            endif;
        ?></dd>
<?php
    if (! $is_admin_fleamarket):
?>
        <dt>主催者ホームページ</dt>
        <dd><a href="<?php echo e($fleamarket['website']);?>" target="_blank"><?php echo e($fleamarket['website']);?></a></dd>
<?php
    endif;
?>
        <dt>開催日程</dt>
        <dd><?php
            if ($fleamarket['event_date']):
                echo e(date('Y年n月j日', strtotime($fleamarket['event_date'])));
                echo '(' . $week_list[date('w', strtotime($fleamarket['event_date']))] . ')';
            else:
                echo '-';
            endif;
        ?></dd>
        <dt>開催時間</dt>
        <dd><?php
            if ($fleamarket['event_time_start']):
                echo e(date('G:i', strtotime($fleamarket['event_time_start'])));
            else:
                echo '-';
            endif;
            if ($fleamarket['event_time_end']):
                echo '～' . e(date('G:i', strtotime($fleamarket['event_time_end'])));
            endif;
        ?></dd>
        <dt>会場名</dt>
        <dd><?php
            if ($fleamarket['location_name']):
                echo e($fleamarket['location_name']);
            else:
                echo '-';
            endif;
        ?></dd>
        <dt>住所</dt>
        <dd><?php
            if ($fleamarket['zip']):
                echo '〒' . e($fleamarket['zip']);
            endif;
            if ($fleamarket['address']):
                echo '&nbsp;' . e($fleamarket['address']);
            endif;
        ?></dd>
        <dt>交通・アクセス</dt>
        <dd><?php
            if (isset($fleamarket['abouts'][\Model_Fleamarket_About::ACCESS])):
                $about_access = $fleamarket['abouts'][\Model_Fleamarket_About::ACCESS];
                echo nl2br(e($about_access['description']));
            else:
                echo '-';
            endif;
        ?></dd>
<?php
    if ($is_admin_fleamarket):
?>
        <dt>出店形態</dt>
        <dd><?php
            if ($entry_style_string):
                echo e($entry_style_string);
            else:
                echo '-';
            endif;
        ?></dd>
        <dt>出店料金</dt>
        <dd><?php
            if ($shop_fee_string):
                echo e($shop_fee_string);
            else:
                echo '-';
            endif;
        ?></dd>
        <dt>募集ブース</dt>
        <dd><?php
            if ($total_booth > 0):
                echo e($total_booth . '店');
            else:
                echo '-';
            endif;
        ?></dd>
        <?php
            if (count($fleamarket['abouts']) > 0):
                $about_count = 0;
                foreach ($fleamarket['abouts'] as $about_id => $about):
                    if ($about_id == \Model_Fleamarket_About::ACCESS):
                        continue;
                    endif;
        ?>
        <dt><?php echo e($about['title']);?></dt>
        <dd><?php echo nl2br(e($about['description']));?></dd>
        <?php
                    $about_count++;
                endforeach;
            endif;
        ?>
<?php
    endif;
?>
      </dl>
      <ul class="mylist <?php if (! $is_admin_fleamarket):?>noneReservation<?php endif;?>">
        <li class="button addMylist"><a href="#" id="fleamarket_id_<?php echo $fleamarket['fleamarket_id'];?>"><i></i>マイリストに追加</a></li>
        <li class="button gotoMylist"><a href="/mypage/list?type=mylist"><i></i>マイリストを見る</a></li>
      </ul>
      <ul class="rightbutton">
        <?php
            if ($is_admin_fleamarket && $fleamarket['event_status'] == \Model_Fleamarket::EVENT_STATUS_RESERVATION_RECEIPT):
                $reservation_button = '出店予約をする';
                if ($fleamarket['event_reservation_status'] == \Model_Fleamarket::EVENT_RESERVATION_STATUS_FULL):
                    $reservation_button = 'キャンセル待ちをする';
                endif;
        ?>
        <li class="button makeReservation"><a id="do_reservation" href="/reservation/?fleamarket_id=<?php echo e($fleamarket_id);?>"><i></i><?php echo $reservation_button;?></a></li>
        <?php
            endif;
        ?>
      </ul>
    </div>
  </div>
</div>
<!-- /table -->
<script type="text/javascript">
$(function() {
  $(".addMylist a").click(function(evt) {
      evt.preventDefault();
      var id = $(this).attr('id');
      id = id.match(/^fleamarket_id_(\d+)/)[1];
      $.ajax({
          type: "post",
          url: '/favorite/add',
          dataType: "json",
          data: {fleamarket_id: id}
      }).done(function(json, textStatus, jqXHR) {
          if(json == 'nologin' || json == 'nodata'){
              alert(json);
          }else if(json){
              alert('登録しました');
          }else{
              alert('失敗しました');
          }
      }).fail(function(jqXHR, textStatus, errorThrown) {
          alert('失敗しました');
      });
  });
});
</script>
