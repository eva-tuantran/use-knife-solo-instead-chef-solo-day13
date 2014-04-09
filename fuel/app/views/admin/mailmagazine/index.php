<style type="text/css">
#container {
  text-align: center;
}

.contents {
  margin: 0 auto;
  position: relative;
  padding: 45px 15px 15px;
  background-color: #fff;
  border-width: 1px;
  border-color: #ddd;
  border-radius: 4px 4px 0 0;
  box-shadow: none;
  width: 50%;
  text-align: left;
}

.btn-list li {
  margin-left: 20px;
  float: left;
}
</style>
<div id="container">
  <div class="contents">
    <form id="mailmagazineForm" role="form" action="/admin/mailmagazine/send" method="post" class="form-horizontal">
        <input id="deliveredTo" type="hidden" name="deliveredTo" value="">
      <div class="form-group">
        <label for="exampleInputEmail1">件名</label>
        <input id="exampleInputEmail1" class="form-control" type="email" name="subject" placeholder="例）楽市楽座メールマガジン">
      </div>
      <div class="form-group">
        <label for="exampleInputFile">本文</label>
        <input id="exampleInputFile" type="file" name="body" >
        <p class="help-block">ユーザ名を挿入する箇所に「##user_name##」と記述してください</p>
      </div>
      <ul class="btn-list">
        <li><button id="doTestSend" type="button" class="btn btn-success">テスト送信</button></li>
        <li><button id="doSend" type="button" class="btn btn-success"><input id="sendCheck"type="checkbox">メールマガジンを送信する</button></li>
      </ul>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function() {
  $("#doTestSend").on("click", function(evt) {
    var result = prompt("テスト送信先", "ida@aucfan.com");
    if (! result) {
      return false;
    }

    $("#deliveredTo").val(result);
    var form = $('#mailmagazineForm').get()[0];
console.log(form);
    var formData = new FormData(form);
    $.ajax({
      type: "post",
      url: '/admin/mailmagazine/test',
      contentType: false,
      processData: false,
      data: formData,
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
console.log(json);
      if (json.status == '200') {
        alert('送信しました');
      } else {
        alert('送信に失敗しました\n' + json.error);
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      alert('送信に失敗しました');
    });
  });

  $("#sendCheck").on("click", function(evt) {
      evt.stopPropagation();
  });

  $("#doSend").on("click", function(evt) {
    if (! $("#sendCheck").prop("checked")) {
        alert("送信するときはチェックしてください");
    }
console.log('A');
  });
});
</script>
