
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


## トランザクションについて

```
 $db = Database_Connection::instance();
```

のように引数なしだと slave 側に接続してしまうため、
master へのトランザクションは、

```
 $db = Database_Connection::instance('master');
```

のように明示的に指定してください。
