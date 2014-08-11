システム構成概要
============================================================

## ソースコード

  ```
  git@gitlab.aucfan.com:devs/rakuichi-rakuza.git
  ```

  基本的に全ての構成物は上記のディレクトリに格納されている。
  今回からChefを経由してデプロイしたため、インフラ構成も含め格納されている。


## デプロイ先

  下記にhostingされています。

  ```
  /deploy/rakuichi-rakuza/
  ```


## 概要図


  ![概略図](https://gitlab.aucfan.com/devs/rakuichi-rakuza/raw/feature/readme/doc/system_overview.png)

  1台のApplication ServerにApache, MySQL, Memcachedが同居している。
  現状ではnrt01の一台構成でLVSを経由せず稼働している。(要冗長化)


## サーバIPアドレス構成(2014/5/1 現在)

  ![IPアドレス](https://gitlab.aucfan.com/devs/rakuichi-rakuza/raw/feature/readme/doc/system_ipaddr.png)

  - サーバ自体はnrt01(web), nrt02(lvs), ceb01(web), ceb02(lvs)の4台用意されている。
  - LVSの検証が間に合わず、nrt01以外は上記の図の通りの稼働状況。
  - nrt03とceb03は未インストールで枠として残っている




ステージング環境起動方法
============================================================


## Vagrantによるローカル環境構築

  デフォルトのVagrantfileではWebサーバ2台とLVS2台の完全構成を再現します。
  基本的に1台で完結しますので、ローカル開発では1台のみ構築させます。


### 起動

  git cloneした先のapp dirに移動し、以下のコマンドを実行します。

  ```sh
  $ cd vagrant
  $ vagrant up web1
  $ vagrant ssh web1
  ```

  web1 ~ web4がそれぞれのサーバに対応しています。

  完了後ブラウザで動作を確認します

  ```
  http://192.168.33.101
  ```

  Gitで管理しているこのディレクトリ自体がVagrantにより共有フォルダ化します。
  そのため、このフォルダ内部のファイルを編集することでダイレクトにVirtualboxの仮想環境に反映されます。



### 仮想環境の再度読み込み

  provisionコマンドを利用することで、インフラ設計を再度既存の仮想マシンに適応することが出来ます。
  chefのcookbookの更新適応や、何かシステムに不具合が発生した場合は、まずこのコマンドの実行テストをしてください。

  ```
  $ vagrant provision web1
  ```

  vagrantを残したままPCをシャットダウンするなどした場合、MySQLのpidが残ったまま、次回移行正常に起動できない
  事象が確認されています。provisionコマンドを打つことで復旧できますので、積極的に実行します。

  なお、仮想環境においてはdatabaseの初期化およびseed処理(DBにランダムなテストデータを入れる)ことがprovisionすることで
  走ります。そのため、入力したデータなどはprovisionすることで初期化され元に戻ります。



### 仮想環境の終了(削除)

  何かシステムに問題が起こるなどした場合は、destroyを実行します。
  Virtualbox環境が削除され、まっさらの状態になります。
  システム開発において内部のインフラ構成だけ保存されないまま進むこともありますので、
  開発中も適宜 vagrant destroyを実行し、ゼロからシステム構築が出来るか常に確認することをオススメします。

  ```
  $ vagrant destroy web1
  ```


### 設定注意点

  IPで直接アクセスで基本的に動作します。
  ブログ(wordpress)のみURLが固定で指定されているため、
  完全なサイトを再現するためには上記のIPをwww.rakuichi-rakuza.jpをhostsとして設定してください。





本番のデプロイ方法
============================================================


## 現状の構成
  2014/5/1の現状は以下の通り


### アプリケーション(Web)
  サーバにログインし、/deploy/rakuichi-rakuza配下でgit fetchを行う

  ```
  $ cd /deploy/rakuichi-rakuza
  $ git pull origin master
  ```

### インフラ

  chef経由のみで適応する(サーバにログインし、手動で作業しない)
  ローカル環境でknife経由から実行する。これにより、cookbookとrecipeとして登録されているものが
  全て適応される。何度実行しても問題ない。

  ```
  $ knife solo cook 192.168.4.204
  ```

  なお、今の所は自分のローカルPCにknife環境が準備されており、
  knife専用のサーバなどは無い状態。



## Chefの新規設定方法


### 設定例(Macローカルから)

  192.168.4.243という仮想サーバを新規で立てたとしてchef経由のインストール手順を記載します。
  前提として以下2点を準備します。

  - ローカル環境にknifeおよびchef-soloがインストール済み
  - 公開鍵が対象サーバ向けに設定されている


  まずprepareコマンドで対象サーバをchef受け入れ可能にします。

  ```sh
  $ cd /vagrant
  $ knife solo prepare 192.168.4.243
  ```

  vagrant/nodes配下にjsonファイルが生成されます

  ```sh
  /vagrant/nodes/192.168.4.243.json
  ```

  Webサーバ設定のrun_listを他のマシンから参照してコピーします

  ```
  {
    "host_name" : "(自分で設定する)",
    "mysqld" : {
      "server_id": "(自分で設定する)"
    },
    "run_list":[
      "recipe[base]",
      "recipe[nameserver]",
      "recipe[httpd-php]",
      "recipe[composer]",
      "recipe[mysql-server]",
      "recipe[memcached]",
      "recipe[selinux::disabled]",
      "recipe[rakuichi-rakuza::database]",
      "recipe[rakuichi-rakuza::production]",
      "recipe[keepalived::client-rakuichi-production]"
    ]
  }
  ```


  あとはcookbookを実行します。

  ```
  $ knife solo cook 192.168.4.243
  ```

  特にエラーがでなければ最後まで終了します。何か一箇所でも詰まりがあった場合はそこでChefが終了します。
  エラーログがサーバ上にも配置されるので、確認します。

  基本的にchefは冪等性(何回実行してもOK)を担保するスクリプトなので、エラーが発生しても修正して
  再度cookコマンドを実行します。




データバックアップ体制
============================================================

## 社内バックアップスクリプト

  - 以下の社内サーバで朝5時に起動して動かしている。
  - 内容物としてはmysqldump rakuichi_rakuza のフルデータベースDump。

  ```
  192.168.101.251:/deploy/rakuichi-rakuza-dbbackup/backup_rakuichi_rakuza_local.sh
  ```

### TODO
  - 社内のサーバがベースとなっているので、データセンタに移動をしたい。
  - gitlabで正常に管理させたい





ソースコード説明
============================================================


## MySQL データベース

### スキーマの作成方法(MySQLWorkbench)

  - データベースのER図の完全体はmwbファイルとして保存されています。

  ```
  /db/rakuichi_rakuza.mwb
  /db/rakuichi_rakuza.sql
  ```

  mysqlworkbenchのファイルを開き、Exportしたものが同居しているrakuichi_rakuza.sqlとなります。
  vagrantでローカルにprovisionする際に、上記のパスのsqlファイルを自動で読み込みます。
  そのためスキーマ変更などをmwb上で行った場合は合わせて必ずsqlファイルを作成しコミットをします。(重要)


  今の所リリース後のスキーマ変更対応がないので未対応ですが、今後は変更があった場合は
  alterのsqlなどがあっても良いかもしれません。



### Master/Slave構成

  - スケールアウトすることを想定し、admin(書き込み権限あり)とreadonly(読み込みのみ)の2つのタイプのユーザが存在。
  - デフォルトのソースコードではreadonlyユーザを利用し、書き込み時に明示的にmasterのDBを指定する必要があります。


  ```php
   $db = Database_Connection::instance();
  ```

  のように引数なしだと slave 側に接続してしまうため、master へのトランザクションをはるときなどは、

  ```php
   $db = Database_Connection::instance('master');
  ```

  のように明示的に指定してください。




やり残した点 (2015/5/1)
============================================================


## Lsyncd未実装

  lsyncdが出来なかったため、下記のcrontabを設定して稼働させている。(Webサーバ)

  ```
  * * * * * /deploy/rakuichi-rakuza/bin/uploadfiles_sync.sh 192.168.4.204 >>/var/log/sync.$(date "+\%Y\%m\%d") 2>&1
  ```

  なおこの設定も手動でやっているので、どちらにせよchefに移動が必要


## crontabのcookbookの未作成

  多分すぐ終わると思います。
  crontabの設置のみ、現在、手動でやっています。

  ```
  cp [WORKSPACE]/fuel/app/tasks/cron.d/production/* /etc/cron.d/
  ```

  chefで書けるので移動したい。


## MySQLのマスタースレーブ未構築

  単体稼働なので、障害に弱いです。
  せめてロードバランスしなくてもslaveマシンを準備して常にデータを飛ばしたい。


## ロードバランサー未構築

  単体稼働中です。本番リリース日前日に設定したところ、謎に全てのWeightが0になる現象が発生し、
  一旦LVS設置は延期となりました。

  恐らくLVSが原因ではなく、死活監視として設定していたトップページに何か問題あるのでは？というのが現状の推測の領域で
  完全な問題点などは判明していない状態。

  今までの社内の実績からKeeplivedを利用しようと思ったが、このようなただのWeb用途の場合はHAProxyが事実上の
  デファクトスタンダードらしいので、次回LVSを設定する際にはL7LBであるHAProxyの稼働を行う。

[ ![Codeship Status for iro-dori/rakuichi-rakuza](https://www.codeship.io/projects/33d576d0-034f-0132-a472-36c68e7f0ae3/status)](https://www.codeship.io/projects/30407)
