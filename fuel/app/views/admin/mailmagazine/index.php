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

ul {
  list-style: none;
}

.btn-list li {
  margin-left: 20px;
  float: left;
}
</style>
<div id="container">
  <div class="contents">
    <form id="mailmagazineForm" role="form" action="/admin/mailmagazine/confirm" method="post" class="form-horizontal" enctype="multipart/form-data">
      <div class="form-group">
        <label for="exampleInputEmail1">件名</label>
        <input id="subject" class="form-control" type="subject" name="subject" placeholder="例）楽市楽座メールマガジン" value="<?php echo $subject;?>">
      </div>
      <div class="form-group">
        <label for="file">本文</label>
        <input id="file" type="file" name="body" >
        <ul class="help-block">
          <li>ユーザ名を挿入する箇所に「##user_name##」と記述してください<li>
        </ul>
      </div>
      <ul class="btn-list">
        <li><button type="submit" class="btn btn-success">確認する</button></li>
      </ul>
    </form>
  </div>
</div>
