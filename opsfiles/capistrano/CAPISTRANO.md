# Capistrano経由のdeploy

### 実行環境

- ruby 2.1.2
- bundler

### Bundler経由で依存gemをインストールする

```shell
bundle install --path vendor/bundle
```

### SSHの設定

vagrantのインスタンスに rakuichi-rakuza.vagrant で自動ログインできるようにする

```shell
cd vagrant
vagrant ssh-config >> ~/.ssh/config
```

/etc/hostsにも名前解決ができるように設定を追加する。

```shell
sudo vim /etc/hosts

+ 127.0.0.1 rakuichi-rakuza.vagrant
```

パスワードなしでssh経由でログインできるか確認する

```shell
ssh rakuichi-rakuza.vagrant
```

### ソースコードをvagrantにdeploy

```shell
bundle exec cap development deploy
```

終了したら http://192.168.33.101/ にアクセスしてサイトが表示されることを確認。
