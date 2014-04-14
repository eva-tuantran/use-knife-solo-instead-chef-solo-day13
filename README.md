
### 楽市楽座プロジェクト本体

```
git@gitlab.aucfan.com:devs/rakuichi-rakuza.git
git@gitlab.aucfan.com:devs/rakuichi-rakuza.wiki.git
```

### Quickstart

Vagrantを起動します
```sh
$ cd vagrant
$ vagrant up
$
$ vagrant ssh
```

vagrantでログイン後、データベースに情報を入れます
```
$ cd /var/www/html/
$ php oil r seed user
```

ブラウザで動作を確認します
```
http://192.168.33.101
```
