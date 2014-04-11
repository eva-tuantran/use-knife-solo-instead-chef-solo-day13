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

.btn-list {
  list-style: none;
}

.btn-list li {
  margin-left: 20px;
  float: left;
}

.mail-item {
  padding: 10px;
  border: 1px solid #e6e6fa;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  background-color: #ffffe0;
}

.mail-body {
  min-height: 500px;
}
</style>
<div id="container">
  <div class="contents">
    <form id="mailmagazineForm" role="form" action="/admin/mailmagazine/send" method="post" class="form-horizontal">
        <input id="deliveredTo" type="hidden" name="deliveredTo" value="">
      <div class="form-group">
        <label>件名</label>
        <p class="mail-item"><?php echo $subject;?></p>
        <input id="subject" type="hidden" name="subject" value="<?php echo $subject;?>">
      </div>
      <div class="form-group">
        <label for="exampleInputFile">本文</label>
        <p class="mail-item mail-body"><?php echo nl2br($body);?></p>
      </div>
      <ul class="btn-list">
        <li><button id="doTestSend" type="button" class="btn btn-success">テスト送信</button></li>
        <li><button id="doSend" type="button" class="btn btn-success"><input id="sendCheck"type="checkbox">メールマガジンを送信する</button></li>
        <li><button id="doStop" type="button" class="btn btn-success">送信を中止する</button></li>
      </ul>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function() {
  $("#doTestSend").on("click", function(evt) {
    var deliveredTo = prompt("送信先メールアドレス", "ida@aucfan.com");
    if (! deliveredTo) {
      return false;
    }

    $.ajax({
      type: "post",
      url: '/admin/mailmagazine/test',
      data: {deliveredTo: deliveredTo},
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == '200') {
        alert('送信しました');
      } else {
        alert('送信に失敗しました\n' + json.message);
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
        alert("チェックしてください");
        return false;
    }
    if (! confirm("送信を開始してよろしいですか？")) {
        return false;
    }

    $.ajax({
      type: "post",
      url: '/admin/mailmagazine/send',
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == '200') {
        alert('送信しました');
      } else {
        alert('送信に失敗しました\n' + json.message);
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      alert('送信に失敗しました');
    });
  });

  $("#doStop").on("click", function(evt) {
    if (! confirm("送信を停止してよろしいですか？")) {
        return false;
    }

    $.ajax({
      type: "post",
      url: '/admin/mailmagazine/stop',
      dataType: "json"
    }).done(function(json, textStatus, jqXHR) {
      if (json.status == '200') {
        alert('送信を停止しました');
      } else {
        alert('送信を停止できませんでした\n' + json.error_message);
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      alert('送信を停止できませんでした\n' + json.error_message);
    });
  });
});
</script>
