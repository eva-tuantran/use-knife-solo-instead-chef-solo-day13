<div class="container">
  <div class="row">
    <ul class="col-xs-12 nav navbar-nav">
      <li class="col-xs-3 text-center"><dl><dt>STEP1</dt><dd>登録内容の入力</dd></dl></li>
      <li class="col-xs-3 text-center alert-info"><dl><dt>STEP2</dt><dd>内容確認</dd></dl></li>
      <li class="col-xs-3 text-center"><dl><dt>STEP3</dt><dd>仮登録メール送信</dd></dl></li>
      <li class="col-xs-3 text-center"><dl><dt>STEP4</dt><dd>登録完了</dd></dl></li>
    </ul>
  </div>
</div>

<div class="container">

  <div class="row">
    <div class="col-md-12">
    <h2 class="text-center">楽市楽座ID(無料)を登録する</h2>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <form id="confirmation" action="register/create" accept-charset="utf-8" method="post">
      <?php echo $user_hidden_inputs; ?>
        <table>
          <tr>
            <td class=""><label id="label_name-first" for="form_name-first">名</label>*</td>
            <td class=""><?php echo $user_input['name-first']; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_name-last" for="form_name-last">姓</label>*</td>
            <td class=""><?php echo $user_input['name-last']; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_postal-code" for="form_postal-code">郵便番号</label>*</td>
            <td class=""><?php echo $user_input['postal-code']; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_address" for="form_address">住所</label>*</td>
            <td class=""><?php echo $user_input['address']; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_email" for="form_email">Eメール</label>*</td>
            <td class=""><?php echo $user_input['email']; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_username" for="form_username">ユーザー名</label>*</td>
            <td class=""><?php echo $user_input['username']; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_password" for="form_password">パスワード</label>*</td>
            <td class="">*******</td>
          </tr>

          <tr>
            <td class=""></td>
            <td class=""><input type="submit" value="本登録用URLをメールで送信する" id="form_submit" name="submit" /></td>
            <td class=""><input type="submit" value="入力した内容を修正する" id="form_back" name="submit" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
