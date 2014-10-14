<div class="row">
  <form id="form_search" action="" method="get">
    <fieldset>
      <?php
          if ($is_top):
      ?>
      <div id="searchTitle" class="col-md-2">
        <h2><i></i>条件で探す</h2>
      </div>
      <?php
          endif;
      ?>
      <div id="searchInput" class="<?php echo $is_top ? 'col-md-5' : 'col-md-7';?>">
        <div class="form-group">
          <input id="form_keyword" type="text" class="form-control" placeholder="キーワードを入力" name="c[keyword]">
        </div>
        <div id="searchCheckbox">
          <label for="form_shop_fee">
            <input id="form_shop_fee" type="checkbox" name="c[shop_fee]" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_FREE;?>">出店無料
          </label>
          <label for="form_car_shop">
            <input id="form_car_shop" type="checkbox" name="c[car_shop]" value="<?php echo \Model_Fleamarket::CAR_SHOP_FLAG_OK;?>">車出店可
          </label>
          <label for="form_rainy_location">
            <input id="form_rainy_location" type="checkbox" name="c[rainy_location]" value="<?php echo \Model_Fleamarket::RAINY_LOCATION_FLAG_EXIST;?>">雨天開催会場
          </label>
          <label for="form_pro_shop">
            <input id="form_pro_shop" type="checkbox" name="c[pro_shop]" value="<?php echo \Model_Fleamarket::PRO_SHOP_FLAG_OK;?>">プロ出店可
          </label>
          <label for="form_charge_parking">
            <input id="form_charge_parking" type="checkbox" name="c[charge_parking]" value="<?php echo \Model_Fleamarket::CHARGE_PARKING_FLAG_EXIST;?>">有料駐車場あり
          </label>
          <label for="form_free_parking">
            <input id="form_free_parking" type="checkbox" name="c[free_parking]" value="<?php echo \Model_Fleamarket::FREE_PARKING_FLAG_EXIST;?>">無料駐車場あり
          </label>
        </div>
      </div>
      <div id="searchSelect" class="col-md-3">
        <div class="form-group">
          <select id="selectRegion" class="form-control" name="c[region]">
            <option value="">エリア</option>
            <?php
              foreach ($regions as $region_id => $name):
            ?>
              <option value="<?php echo $region_id;?>"><?php echo $name;?></option>
            <?php
              endforeach;
            ?>
          </select>
        </div>
        <div class="form-group">
          <select id="selectPrefecture" class="form-control" name="c[prefecture]">
            <option value="">都道府県</option>
            <?php
              foreach ($prefectures as $prefecture_id => $name):
            ?>
              <option value="<?php echo $prefecture_id;?>"><?php echo $name;?></option>
            <?php
              endforeach;
            ?>
          </select>
        </div>
      </div>
      <div id="searchButton" class="col-md-2">
        <button id="doSearch" type="button" class="btn btn-default">検索</button>
      </div>
    </fieldset>
  </form>
</div>
<script type="text/javascript">
$(function() {
  Search.init();
});

var Search = {
  regions: <?php echo json_encode($regions);?>,
  alphabet_regions: <?php echo json_encode($alphabet_regions);?>,
  region_prefectures: <?php echo json_encode($region_prefectures);?>,
  prefectures: <?php echo json_encode($prefectures);?>,
  alphabet_prefectures: <?php echo json_encode($alphabet_prefectures);?>,
  init: function() {
    $("#form_keyword").keypress(function(evt) {
      if (evt.which == 13) {
        evt.preventDefault();
        $("#doSearch").click();
      }
    });
    $("#selectRegion").on("change", function(evt) {
      evt.preventDefault();
      Search.changeRegion();
    });
    $("#doSearch").on("click", function(evt) {
        evt.preventDefault();
        var $form = $("#form_search");
        var region = $("#selectRegion").val();
        var prefecture = $("#selectPrefecture").val();

        var area = 'all';
        if (prefecture != '') {
          area = Search.alphabet_prefectures[prefecture];
        } else if (region != '') {
          area = Search.alphabet_regions[region];
        }

        var query = $form.serialize();
        if (query != '') {
          query = '?' + query;
        }

        $form.attr("action", area + query).submit();
    });
  },
  changeRegion: function() {
    $("#selectPrefecture").empty();
    var region_id = $("#selectRegion").val();
    var $selectPrefecture = $("#selectPrefecture");
    $selectPrefecture.empty();

    $.each(Search.region_prefectures, function(i, prefs) {
      if (region_id == i) {
        Search.createPrefecture($selectPrefecture, prefs);
      }
    });
  },
  createPrefecture: function($select, prefs) {
    $select.append('<option value="">都道府県</option>');
    $.each(prefs, function(i, v) {
      $select.append(
        '<option value="' + v + '">' + Search.prefectures[v] + '</option>'
      );
    });
  }
};
</script>