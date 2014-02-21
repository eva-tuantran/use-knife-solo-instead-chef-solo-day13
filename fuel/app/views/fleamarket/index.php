<style type="text/css">
    .small {
        width: 50px;
    }
    textarea {
        width: 250px;
        height: 100px;
    }
    table td {
        padding: 5px;
    }
</style>
<form method="post" action="/flamarket/confirm">
<table>
    <tbody>
        <tr>
            <td>主催者</td>
            <td><input id="sponsor_name" name="sponsor_name" type="text" value=""></td>
        </tr>
        <tr>
            <td>主催者ホームページ</td>
            <td><input id="sponsor_website" name="sponsor_website" type="text" value=""></td>
        </tr>
        <tr>
            <td>予約受付電話番号</td>
            <td>
                <input id="sponser_te1l" class="small" name="sponser_tel1" type="text" value="">-
                <input id="sponser_tel2" class="small" name="sponser_tel2" type="text" value="">-
                <input id="sponser_tel3" class="small" name="sponser_tel3" type="text" value="">
            </td>
        </tr>
        <tr>
            <td>予約受付メールアドレス</td>
            <td><input id="sponser_email" name="sponser_email" type="text" value=""></td>
        </tr>
        <tr>
            <td>開催日</td>
            <td>
                <input id="event_date" name="event_date" type="text" value="">
            </td>
        </tr>
        <tr>
            <td>開催日時間</td>
            <td>
                <select id="event_time_hour" name="event_time">
                    <option value="08">08</option>
                    <option value="08">09</option>
                </select>
                <select id="event_time_minute" name="event_time">
                    <option value="00">00</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="45">45</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>フリマ名および会場名</td>
            <td><input id="fleamarket_name" name="fleamarket_name" type="text" value=""></td>
        </tr>
        <tr>
            <td>開催住所</td>
            <td>
                <div>〒<input id="location_zip" class="small" name="location_zip" type="text" value=""></div>
                <div>
                    <select id="location_pref" name="location_pref">
                        <option value="">選択してください</option>
                        <option value="">東京</option>
                    </select>
                </div>
                <div><input id="location_address" name="location_address" type="text" value=""></div>
            </td>
        </tr>
        <tr>
            <td>フリマ説明</td>
            <td>
                <textarea id="description" name="description" type="text" value=""></textarea>
            </td>
        </tr>
        <tr>
            <td>最寄り駅または交通アクセス</td>
            <td>
                <textarea id="about_access" name="about_access" type="text" value=""></textarea>
            </td>
        </tr>
        <tr>
            <td>出店に際してのご注意</td>
            <td>
                <textarea id="about_shop" name="about_shop" type="text" value=""></textarea>
            </td>
        </tr>
        <tr>
            <td>出店形態について</td>
            <td>
                <textarea id="about_shop_style" name="about_shop_style" type="text" value=""></textarea>
            </td>
        </tr>
        <tr>
            <td>出店料金について</td>
            <td>
                <textarea id="about_shop_fee" name="about_shop_fee" type="text" value=""></textarea>
            </td>
        </tr>
        <tr>
            <td>募集ブース数について</td>
            <td>
                <textarea id="about_booth" name="about_booth" type="text" value=""></textarea>
            </td>
        </tr>
        <tr>
            <td>開催時間について</td>
            <td>
                <textarea id="about_event" name="about_event" type="text" value=""></textarea>
            </td>
        </tr>
        <tr>
            <td>駐車場について</td>
            <td>
                <textarea id="about_parking" name="about_parking" type="text" value=""></textarea>
            </td>
        </tr>
    </tbody>
</table>
</form>
