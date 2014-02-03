楽市楽座Project v2
============================================================


### ステージング環境構築クイックスタート


  ```sh
  $ git clone root@192.168.101.11:/var/git/rakuichi-rakuza.git
  $ cd rakuichi-rakuza/vagrant
  $ vagrant up
  $ php composer.phar update
  ```
  - http://192.168.33.101 にアクセスすることで楽市楽座のステージング環境にアクセス可能です。
  - Vagrant/Virtualboxを事前のインストールすること


### 基本設計

  - FuelPHPを基本フレームワークとする
  - 必ずテストコードの作成
  - 効率よりも移植しやすさを重視
      - UNIX哲学: http://ja.wikipedia.org/wiki/UNIX%E5%93%B2%E5%AD%A6
      - フォルダ丸ごとコピーすればどこでも動く状態
      - 極力ネームベースの処理をせず、IPアドレスのまま動くように相対的なPATHで構築する

### システム運用方針

  - Git branching modelの採用
      - 解説: http://keijinsonyaban.blogspot.jp/2010/10/successful-git-branching-model.html
      - masterからdevelopを分岐、さらにdevelopからfeature/nameでブランチを切り開発を進める
      - 取り急ぎ、master, develop, feature/~~の3種類があればOK (hotfix等は考えない)
  - Vagrant + Chefをリポジトリに含め、環境構築含めて全てソースコードに残す
      - vagrant upするだけで誰でもすぐに完全な状態で開発可能となる
  - Github(Gitlab)用のフォルダ構成を標準化する
      - プロジェクトRootにREADME.mdを作成
  - Jenkinsによるコードカバレッジの調査(気合があれば...)

