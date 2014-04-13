<div id="contentMypage" class="row">

  <!-- mypageProfile -->
  <div id="calendar" class="col-sm-3">
    <div class="box clearfix" id="calendar-search">
      <?php echo $calendar; ?>
    </div>

    <!-- <div class="box clearfix"> -->
    <!-- <li><a href="/mypage/account">アカウント設定</a></li> -->
    <!-- </ul> -->
    <!-- </div> -->
  </div>
  <!-- /mypageProfile -->

  <!-- searchResult -->
  <div id="searchResult" class="col-sm-9">
    <!-- pills -->
    <ul class="nav nav-pills">
      <li><a href="/mypage/list?type=entry">これまで参加したフリマ <span class="badge"><?php echo e(Auth::getFinishedEntryCount()); ?>件</span></a></li>
      <li><a href="/mypage/list?type=reserved">出店予約中のフリマ <span class="badge"><?php echo e(Auth::getReservedEntryCount()); ?>件</span></a></li>
      <li><a href="/mypage/list?type=mylist">マイリスト <span class="badge"><?php echo e(Auth::getFavoriteCount()); ?>件</span></a></li>
    </ul>
    <!-- /pills -->
    <!-- search -->
    <div id="search" class="box clearfix">
      <div class="row">
        <form id="form_search" action="/search/1/" method="get">
          <fieldset>
            <div id="searchInput" class="col-md-7">
              <div class="form-group">
                <input type="text" class="form-control" id="keywordInput" placeholder="キーワードを入力" name="conditions[keyword]">
              </div>
              <div id="searchCheckbox">

                <label for="form_shop_fee">
                  <input id="form_shop_fee" type="checkbox" name="conditions[shop_fee]" value="<?php echo \Model_Fleamarket::SHOP_FEE_FLAG_FREE;?>">出店無料
                </label>
                <label for="form_car_shop">
                  <input id="form_car_shop" type="checkbox" name="conditions[car_shop]" value="<?php echo \Model_Fleamarket::CAR_SHOP_FLAG_OK;?>">車出店可
                </label>
                <label for="form_rainy_location">
                  <input id="form_rainy_location" type="checkbox" name="conditions[rainy_location]" value="<?php echo \Model_Fleamarket::RAINY_LOCATION_FLAG_EXIST;?>">雨天開催会場
                </label>
                <label for="form_pro_shop">
                  <input id="form_pro_shop" type="checkbox" name="conditions[form_pro_shop]" value="<?php echo \Model_Fleamarket::PRO_SHOP_FLAG_OK;?>">プロ出店可
                </label>
                <label for="form_charge_parking">
                  <input id="form_charge_parking" type="checkbox" name="conditions[charge_parking]" value="<?php echo \Model_Fleamarket::CHARGE_PARKING_FLAG_EXIST;?>">有料駐車場あり
                </label>
                <label for="form_free_parking">
                  <input id="form_free_parking" type="checkbox" name="conditions[free_parking]" value="<?php echo \Model_Fleamarket::FREE_PARKING_FLAG_EXIST;?>">無料駐車場あり
                </label>

              </div>
            </div>
            <div id="searchSelect" class="col-md-3">
              <div class="form-group">
                <select id="select_region" class="form-control" name="conditions[region]">
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
                <select id="select_prefecture" class="form-control" name="conditions[prefecture]">
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
              <button type="submit" class="btn btn-default">検索</button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
    <!-- /search -->

    <div id="resultTitle">
    <?php
        switch (Input::get('type')) {
            case 'mylist':
                echo "マイリスト";
                break;
            case 'entry':
                echo "出店したフリマ";
                break;
            case 'myfleamarket':
                echo "投稿したフリマ";
                break;
            default:
                echo "フリマ一覧";
                break;
        }
    ?>
    </div>

    <?php foreach ($fleamarkets_view as $fleamarket_view) { echo $fleamarket_view; }; ?>

    <!-- pagination -->
    <?php if ('' != ($pagnation =  $pagination->render())): ?> 
    <?php echo $pagnation; ?>
    <?php else: ?>
    <ul class="pagination">
        <li class="disabled"><a href="javascript:void(0);" rel="prev">«</a></li>
        <li class="active"><a href="javascript:void(0);">1<span class="sr-only"></span></a></li>
        <li class="disabled"><a href="javascript:void(0);" rel="next">»</a></li>
    </ul>
    <?php endif; ?>
    <!-- /pagination -->

  </div>
  <!-- /searchResult -->
</div>
</div>





<script>

$('.fleamarket_cancel').click(function() {
    if (!confirm('フリーマーケットをキャンセルします\nよろしいですか？')) {
    return false;
    }
});


$(function() {
  Calendar.init();
  Search.init();
});

var Calendar = {
  init: function() {
    $(document).on("click", ".calendar_nav a", function(evt) {
      evt.preventDefault();

      var url = $(this).attr("href");
      Calendar.get(url);

      return false;
    });
  },
  get: function(url) {
    if (url == "" || typeof url === "undefined") {
      url = "/calendar/";
    }

    $.ajax({
      type: "get",
      url: url,
      dataType: "html"
    }).done(function(html, textStatus, jqXHR) {
      // $("#calendar").empty();
      // $("#calendar").html(html);
      $("#calendar-search").empty();
      $("#calendar-search").html(html);
    }).fail(function(jqXHR, textStatus, errorThrown) {
    }).always(function() {
    });
  }
};

var Search = {
  init: function() {
    $("#select_region").on("change", function(evt) {
      Search.changeRegion();
    });
  },
  changeRegion: function() {
    $("#select_prefecture").prop("selectedIndex", 0);
    var region_id = $("#select_region").val();
    $.ajax({
      type: "get",
      url: '/search/prefecture',
      dataType: "json",
      data: {region_id: region_id}
    }).done(function(json, textStatus, jqXHR) {
      if (json) {
        $("#select_prefecture").empty();
        $("#select_prefecture").append('<option value="">都道府県</option>');
        $.each(json, function(key, value) {
          $("#select_prefecture").append('<option value="' + key + '">' + value + '</option>');
        });
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
    });
  }
};

$(function () {
  $(".mylist_remove").click(function(){
      var id = $(this).attr('id');
      id = id.match(/^fleamarket_id_(\d+)/)[1];
      $.ajax({
          type: "post",
          url: '/favorite/delete',
          dataType: "json",
          data: {fleamarket_id: id}
      }).done(function(json, textStatus, jqXHR) {
          if(json == 'nologin' || json == 'nodata'){
              alert(json);
          }else if(json){
              alert('削除しました' + id);
              $('#mylist_' + id).remove();
              if ($('#mylist').children('div').length == 0) {
                  $('#mylist').append('<p>マイリストはありません</p>');
              }
          }else{
              alert('失敗しました');
          }
      }).fail(function(jqXHR, textStatus, errorThrown) {
          alert('失敗しました');
      });
  });
});
</script>
