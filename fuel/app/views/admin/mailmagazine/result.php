<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    <h2 class="panel-title">メルマガ確認</h2>
  </div>
  <div class="panel-body">
    <form id="mailmagazineForm" role="form" action="/admin/mailmagazine/thanks" method="post" class="form-horizontal">
      <?php
          echo \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token());
      ?>
      <div id="contents-wrap" class="row">
        <div class="col-md-6">
          <table class="table">
            <tbody>
              <tr>
                <th>送信対象</th>
                <td>
                  <p><?php
                    $mail_magazine_type = $input_data['mail_magazine_type'];
                    $target = $mail_magazine_types[$mail_magazine_type];
                    switch ($mail_magazine_type):
                        case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL:
                            echo $target;
                            break;
                        case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_REQUEST:
                            echo $target . '<br>';
                            if (isset($input_data['organization_flag'])):
                                if ($input_data['organization_flag'] == \Model_User::ORGANIZATION_FLAG_OFF):
                                    echo '－' . '個人';
                                elseif ($input_data['organization_flag'] == \Model_User::ORGANIZATION_FLAG_ON):
                                    echo '－' . '企業・団体';
                                endif;
                                echo '<br>';
                            endif;

                            $prefecture_name = '全国';
                            if (isset($input_data['prefecture_id'])):
                                $prefecture_name = '';
                                foreach ($prefectures as $prefecture_id => $prefecture):
                                    if (in_array($prefecture_id, $input_data['prefecture_id'])):
                                        $prefecture_name .= $prefecture_name == '' ? '' : '、';
                                        $prefecture_name .= $prefectures[$prefecture_id];
                                    endif;
                                endforeach;
                                echo '－' . $prefecture_name;
                            endif;
                            break;
                        case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_RESEVED_ENTRY:
                            echo $target . '<br>';
                            echo '－' . $fleamarket['name'];
                            break;
                        case \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_WAITING_ENTRY:
                            echo $target . '<br>';
                            echo '－' . $fleamarket['name'];
                            break;
                    endswitch;
                  ?></p>
                </td>
              </tr>
              <tr>
                <th>差出人メールアドレス</th>
                <td><?php echo $input_data['from_email'];?></td>
              </tr>
              <tr>
                <th>差出人</th>
                <td><?php echo $input_data['from_name'];?></td>
              </tr>
              <tr>
                <th>件名</th>
                <td><?php echo $input_data['subject'];?></td>
              </tr>
              <tr>
                <th>本文</th>
                <td><?php echo nl2br(e($body));?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-3">
          <h3>メルマガ対象者</h3>
          <div class="users" style="height: 500px; overflow: scroll;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>対象者数</th>
                  <td><?php echo count($users);?></td>
                </tr>
                <tr>
                  <th colspan="2">名前</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if (! isset($users) || count($users) == 0):
                ?>
                <tr>
                  <td colspan="2">対象ユーザはいません</td>
                </tr>
                <?php
                    elseif ($mail_magazine_type == \Model_Mail_Magazine::MAIL_MAGAZINE_TYPE_ALL):
                ?>
                <tr>
                  <td colspan="2">全員が対象です</td>
                </tr>
                <?php
                    else:
                        foreach ($users as $user):
                ?>
                <tr>
                  <td colspan="2"><?php echo e($user['last_name'] . ' ' . $user['first_name']);?></td>
                </tr>
                <?php
                        endforeach;
                    endif;
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12">
          <p><a href="/admin/mailmagazine/list" class="btn btn-primary active" role="button">一覧に戻る</a></p>
        </div>
      </div>
    </form>
  </div>
</div>
