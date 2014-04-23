
## 楽市楽座プロジェクト本体

```
git@gitlab.aucfan.com:devs/rakuichi-rakuza.git
git@gitlab.aucfan.com:devs/rakuichi-rakuza.wiki.git
```

## ステージング環境起動方法

Vagrantを起動します

```sh
$ cd vagrant
$ vagrant up web1
$
$ vagrant ssh web1
```

ブラウザで動作を確認します

```
http://192.168.33.101
```

### 注意点
virtualhostは特になしでも動作しますが、ブログ(wordpress)のみURLが固定で指定されているため、
完全なサイトを再現するためにはwww.rakuichi-rakuza.jpをhostsとして設定してください。


## データベースの接続について

```
 $db = Database_Connection::instance();
```

のように引数なしだと slave 側に接続してしまうため、
master へのトランザクションをはるときなどは、

```
 $db = Database_Connection::instance('master');
```

のように明示的に指定してください。




# やり残した点 (2014/4/23)

## Lsyncd未実装

lsyncdが出来なかったため、下記のcrontabを設定して稼働させている。(Webサーバ)

```
* * * * * /deploy/rakuichi-rakuza/bin/uploadfiles_sync.sh 192.168.4.204 >>/var/log/sync.$(date "+\%Y\%m\%d") 2>&1
```
