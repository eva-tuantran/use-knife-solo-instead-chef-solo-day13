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

      <form id="confirmation" action="verify" accept-charset="utf-8" method="post">
        <table>
          <?php echo \Form::csrf(); ?>
          <tr>
            <td class=""><label id="label_first_name" for="form_first_name">名</label>*</td>
            <td class=""><?php echo $user_input["first_name"]; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_last_name" for="form_last_name">姓</label>*</td>
            <td class=""><?php echo $user_input["last_name"]; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_first_name_kana" for="form_first_name_kana">メイ</label>*</td>
            <td class=""><?php echo $user_input["first_name_kana"]; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_last_name_kana" for="form_last_name_kana">セイ</label>*</td>
            <td class=""><?php echo $user_input["last_name_kana"]; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_gender" for="form_gender">性別</label></td>
            <td class=""><?php echo $user_input["gender"]; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_prefecture_id" for="form_prefecture_id">都道府県</label></td>
            <td class=""><?php echo $user_input["prefecture_id"]; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_address" for="form_address">住所</label>*</td>
            <td class=""><?php echo $user_input["address"]; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_zip" for="form_zip">郵便番号</label></td>
            <td class=""><?php echo $user_input["zip"]; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_email" for="form_email">Eメール</label>*</td>
            <td class=""><?php echo $user_input["email"]; ?></td>
          </tr>

          <tr>
            <td class=""><label id="label_password" for="form_password">パスワード</label>*</td>
            <td class="">******</td>
          </tr>
        </table>
        <div class="text-center">
          <p>
            <input type="submit" value="本登録用URLをメールで送信する" id="form_submit" name="submit" /><br />
            <a href="#" onClick="history.back(); return false;">修正を加える</a>
          </p>
        </div>
      </form>
    </div>
  </div>
</div>
