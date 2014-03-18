<style type="text/css">
.title {text-align: left; border-bottom: 1px solid #ccc;}
table {margin-bottom: 10px; width: 800px; border: 1px solid #ccc;}
table th, table td {padding: 10px; border: 1px solid #ccc;}
.event_info li {margin-left: 10px;padding: 5px; border: 1px solid #ccc; float: left;}
.event_info .invalid {background-color: #666}
.action_buttons li {margin-left: 10px; float: left;}
.action_buttons .reservation {background-color: #ffa500}
</style>
<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
<script type="text/javascript">
$(function() {
  $(".pagination li").on("click", function(evt) {
      evt.preventDefault();
      var href = $(this).find("a").attr("href");
      $("#form_search").attr("action", href).submit();
  });

  $("#do_filter").on("click", function(evt) {
      evt.preventDefault();
      $("#form_search").submit();
  });

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
    echo Form::open(array(
        'action' => 'search/index',
        'method' => 'post',
        'id' => 'form_search',
    ));
?>
<h2><?php echo e($fleamarket['name']);?></h2>
<h2><?php echo $title;?></h2>
<div class="row">
  <div class="col-md-6">
    <p>開催イメージ</p>
    <div><img src="/path/to/aaa,jpg"></div>
  </div>
  <div class="col-md-6">
    <p>会場周辺地図</p>
    <div id="access_map" style="width: 400px; height: 400px;"></div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <p>基本情報</p>
    <table>
      <tbody>
        <tr>
          <th>会場名</th>
          <td><?php echo e($fleamarket['location_name']);?></td>
        </tr>
        <tr>
          <th>住所</th>
          <td><?php echo e($fleamarket['address']);?></td>
        </tr>
        <tr>
          <th>交通・アクセス</th>
          <td><?php
            if (isset($fleamarket['abouts'][FLEAMARKET_ABOUT_ACCESS])):
                echo e($fleamarket['abouts'][FLEAMARKET_ABOUT_ACCESS]['description']);
            endif;
          ?></td>
        </tr>
      </tbody>
  </table>
</div>
<div class="row">
  <div class="col-md-12">
    <p>詳細情報</p>
    <table>
      <tbody>
        <tr>
          <th>開催名</th>
          <td colspan="3"><?php echo e($fleamarket['name']);?></td>
        </tr>
        <tr>
          <th>開催時間</th>
          <td><?php
              echo e($fleamarket['event_time_start']);
              if ($fleamarket['event_time_end'] != ''):
                  echo '～' . $fleamarket['event_time_end'];
              endif;
          ?></td>
          <th>出店料金</th>
          <td><?php echo e($fleamarket['fee_string']);?></td>
        </tr>
        <tr>
          <th>開催形態</th>
          <td><?php echo e($fleamarket['style_string']);?></td>
          <th>予約ブース数</th>
          <td><?php echo e($fleamarket['booth_string']);?></td>
        </tr>
        <?php
            if (count($fleamarket['abouts']) > 0):
                $about_count = 0;
                foreach ($fleamarket['abouts'] as $about_id => $about):
                    if ($about_id == FLEAMARKET_ABOUT_ACCESS):
                        continue;
                    endif;
                    if ($about_count % 2 == 0):
                        echo "<tr>";
                    endif;
        ?>
          <th><?php echo e($about['title']);?></th>
          <td><?php echo e($about['description']);?></td>
        <?php
                    if ($about_count % 2 == 1):
                        echo "</tr>";
                    endif;
                    $about_count++;
                endforeach;
            endif;
        ?>
      </tbody>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <ul class="action_buttons">
      <li><?php echo Html::anchor('/mypage/listadd/' . $fleamarket['fleamarket_id'], 'マイリストに追加', array('id' => 'do_mylist', 'class' => ''));// @TODO: マイページ機能待ち?></li>
      <li><?php echo Html::anchor('/mypage/mylist/' . $fleamarket['fleamarket_id'], 'マイリストを見る', array('id' => 'do_detail', 'class' => ''));// @TODO: マイページ機能待ち?></li>
      <li class="reservation"><?php echo Html::anchor('/reservation/index/' . $fleamarket['fleamarket_id'], '出店予約をする', array('id' => 'do_reservation', 'class' => ''));// @TODO: 出店機能待ち?></li>
    </ul>
  </div>
</div>
