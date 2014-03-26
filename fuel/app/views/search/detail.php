<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
<script type="text/javascript">
$(function() {
  var map = new Map("access_map", "<?php echo $fleamarket['googlemap_address'];?>");
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
?>
<div id="contentDetail" class="row">
  <!-- title -->
  <div id="title" class="container">
    <div class="box clearfix">
      <div class="titleLeft">
        <h2><?php if ($is_admin_fleamarket):?><strong>楽市楽座主催</strong>&nbsp;<?php endif;?><?php echo e($fleamarket['name']);?></h2>
        <p class="date"><?php
            echo e($fleamarket['event_date']);
            echo e($fleamarket['event_time_start']);
            if ($fleamarket['event_time_end']):
                echo '～' . $fleamarket['event_time_end'];
            endif;
        ?></p>
        <ul class="mylist">
          <li class="button addMylist"><a href="#"><i></i>マイリストに追加</a></li>
          <li class="button gotoMylist"><a href="#"><i></i>マイリストを見る</a></li>
        </ul>
      </div>
      <ul class="rightbutton">
        <?php if ($is_admin_fleamarket):?>
        <li class="button makeReservation"><a href="/reservation/index/<?php echo e($fleamarket_id);?>/"><i></i>出店予約をする</a></li>
        <?php endif;?>
        <li class="button print hidden-xs"><a href="#"><i></i>ページの印刷をする</a></li>
      </ul>
    </div>
  </div>
  <!-- /title -->
  <!-- image -->
  <div id="image" class="col-sm-6">
    <h3>開催イメージ</h3>
    <div class="mainPhoto"><img src="http://dummyimage.com/460x300/00bfff/fff.jpg" alt="" width="460px" height="300px" class="img-responsive"></div>
    <ul class="thumbnailPhoto">
      <li><img src="http://dummyimage.com/100x65/ff0000/fff.jpg" alt="" width="100"></li>
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
    <div class="box clearfix"><?php echo e($fleamarket['description']);?></div>
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
        <dt>開催日程</dt>
        <dd><?php
            if ($fleamarket['event_date']):
                echo e($fleamarket['event_date']);
            else:
                echo '-';
            endif;
        ?></dd>
        <dt>開催時間</dt>
        <dd><?php
            if ($fleamarket['event_time_start']):
                echo e($fleamarket['event_time_start']);
            else:
                echo '-';
            endif;
            if ($fleamarket['event_time_end']):
                echo '～' . $fleamarket['event_time_end'];
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
                echo e($fleamarket['abouts'][\Model_Fleamarket_About::ACCESS]['description']);
            else:
                echo '-';
            endif;
        ?></dd>
        <dt>出店形態</dt>
        <dd><?php
            if ($fleamarket['style_string']):
                echo e($fleamarket['style_string']);
            else:
                echo '-';
            endif;
        ?></dd>
        <dt>出店料金</dt>
        <dd><?php
            if ($fleamarket['fee_string']):
                echo e($fleamarket['fee_string']);
            else:
                echo '-';
            endif;
        ?></dd>
        <dt>募集ブース</dt>
        <dd><?php
            if ($fleamarket['booth_string']):
                echo e($fleamarket['booth_string']);
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
        <dd><?php echo e($about['description']);?></dd>
        <?php
                    $about_count++;
                endforeach;
            endif;
        ?>
      </dl>
      <ul class="mylist">
        <li class="button addMylist"><a href="#"><i></i>マイリストに追加</a></li>
        <li class="button gotoMylist"><a href="#"><i></i>マイリストを見る</a></li>
      </ul>
      <ul class="rightbutton">
        <?php if ($is_admin_fleamarket):?>
        <li class="button makeReservation"><a id="do_reservation" href="/reservation/index/<?php echo e($fleamarket_id);?>/"><i></i>出店予約をする</a></li>
        <?php endif;?>
      </ul>
    </div>
  </div>
</div>
<!-- /table -->
