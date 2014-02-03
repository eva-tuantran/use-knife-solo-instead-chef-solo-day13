楽市楽座Project v2
============================================================


## #1. ステージング環境構築クイックスタート

### 1. インストール

  ```sh
  $ git clone git@gitlab.aucfan.com:devs/rakuichi-rakuza.git
  $ cd rakuichi-rakuza/vagrant
  $ vagrant up
  ```
  - http://192.168.33.101 にアクセスすることで楽市楽座の仮想ローカルステージング環境にアクセス可能です。
  - cloneしたworkspaceとファイルが連携しており、ローカルの編集がそのまま仮想サーバに反映されます
  - vagrant/virtualboxを事前にインストールする必要あります


### 2. 仮想マシンへのログイン

  ```sh
  $ vagrant ssh
  $ php composer.phar update
  ```

  - ``vagrant ssh``コマンドを叩くことで、仮想サーバへログイン出来ます。(192.168.33.101のIPでもSSHコマンドでログイン出来ます)
  - ``password: vagrant``にてrootユーザになることが可能です


### 3. 仮想マシンの終了

  停止させます。マシンの負荷が高い時や、OSを再起動したいときに実施します。

  ```sh
  $ vagrant halt
  ```

  仮想マシンを破壊します。


  ```sh
  $ vagrant destroy
  ```

  システム開発では定期的に``vagrant destroy``を行って下さい。理由として、常に``vagrant up``での0から環境構築した際にステージング環境が完璧な状態での動作保証を確認するためです。




## #2. 基本設計

  - FuelPHPを基本フレームワークとする
  - 必ずテストコードの作成
  - 効率よりも移植しやすさを重視
      - UNIX哲学: http://ja.wikipedia.org/wiki/UNIX%E5%93%B2%E5%AD%A6
      - フォルダ丸ごとコピーすればどこでも動く状態
      - 極力ネームベースの処理をせず、IPアドレスのまま動くように相対的なPATHで構築する



## #3. システム運用方針

  - Git branching modelの採用
      - 解説: http://keijinsonyaban.blogspot.jp/2010/10/successful-git-branching-model.html
      - masterからdevelopを分岐、さらにdevelopからfeature/nameでブランチを切り開発を進める
      - 取り急ぎ、master, develop, feature/~~の3種類があればOK (hotfix等は考えない)
  - Vagrant + Chefをリポジトリに含め、環境構築含めて全てソースコードに残す
      - vagrant upするだけで誰でもすぐに完全な状態で開発可能となる
  - Github(Gitlab)用のフォルダ構成を標準化する
      - プロジェクトRootにREADME.mdを作成
  - Jenkinsによるコードカバレッジの調査(気合があれば...)

