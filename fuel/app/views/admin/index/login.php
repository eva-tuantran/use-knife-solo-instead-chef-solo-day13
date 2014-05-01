<script type="text/javascript">
$(function() {
  $("#inputEmail1").focus();
});
</script>
<div class="center-section">
  <?php if (isset($failed) && $failed):?>
  <div class="alert alert-danger">email又はpasswordが間違っています</div>
  <?php endif;?>
  <form class="form-horizontal" action="/admin/index/login" method="post" role="form">
    <div class="form-group">
      <label class="col-sm-2 control-label" for="inputEmail1">Email</label>
      <div class="col-sm-6">
        <input type="text" id="inputEmail1" class="form-control" name="email">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="exampleInputPassword1">Password</label>
      <div class="col-sm-6">
        <input type="password" class="form-control" name="password">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-6 col-sm-2">
        <button type="submit" class="btn btn-default">Login</button>
      </div>
    </div>
  </form>
</div>
