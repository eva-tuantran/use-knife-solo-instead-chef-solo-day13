<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
<script type="text/javascript">
$(function() {
/*  var map = new Map("access_map", "<?php echo $fleamarket['googlemap_address'];?>");*/
  var map = new Map("access_map", "東京都渋谷区");
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
<div id="contentDetail" class="row">
  <!-- title -->
  <div id="title" class="container">
    <div class="box clearfix">
      <div class="titleLeft">
        <h2><?php echo e($fleamarket['name']);?></h2>
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
        <li class="button makeReservation"><a href="#"><i></i>出店予約をする</a></li>
        <li class="button print hidden-xs"><a href="#"><i></i>ページの印刷をする</a></li>
      </ul>
    </div>
  </div>
  <!-- /title -->
  <!-- image -->
  <div id="image" class="col-sm-6">
    <h3>開催イメージ</h3>
    <div class="mainPhoto"><img src="img/photo_test_1.jpg" alt="" width="460px" height="300px" class="img-responsive"></div>
    <ul class="thumbnailPhoto">
      <li><img src="img/photo_test_2.jpg" alt="" width="100"></li>
      <li><img src="img/photo_test_3.jpg" alt="" width="100"></li>
      <li><img src="img/photo_test_4.jpg" alt="" width="100"></li>
      <li><img src="img/photo_test_5.jpg" alt="" width="100"></li>
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
        <dd><?php echo e($fleamarket['name']);?></dd>
        <dt>開催日程</dt>
        <dd><?php echo e($fleamarket['event_date']);?></dd>
        <dt>開催時間</dt>
        <dd><?php
            echo e($fleamarket['event_time_start']);
            if ($fleamarket['event_time_end']):
                echo '～' . $fleamarket['event_time_end'];
            endif;
        ?></dd>
        <dt>会場名</dt>
        <dd><?php echo e($fleamarket['location_name']);?></dd>
        <dt>住所</dt>
        <dd><?php
            if ($fleamarket['zip']):
                echo '〒' . e($fleamarket['zip']);
            endif;
            echo e($fleamarket['address']);
        ?></dd>
        <dt>交通・アクセス</dt>
        <dd><?php
            if (isset($fleamarket['abouts'][\Model_Fleamarket_About::ACCESS])):
                echo e($fleamarket['abouts'][\Model_Fleamarket_About::ACCESS]['description']);
            endif;
        ?></dd>
        <dt>出店形態</dt>
        <dd><?php echo e($fleamarket['style_string']);?></dd>
        <dt>出店料金</dt>
        <dd><?php echo e($fleamarket['fee_string']);?></dd>
        <dt>募集ブース</dt>
        <dd><?php echo e($fleamarket['booth_string']);?></dd>
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
        <dt>備考・注意</dt>
        <dd></dd>
      </dl>
      <ul class="mylist">
        <li class="button addMylist"><a href="#"><i></i>マイリストに追加</a></li>
        <li class="button gotoMylist"><a href="#"><i></i>マイリストを見る</a></li>
      </ul>
      <ul class="rightbutton">
        <li class="button makeReservation"><a id="do_reservation" href="/reservation/index/<?php echo $fleamarket['fleamarket_id'];?>"><i></i>出店予約をする</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- /table -->
