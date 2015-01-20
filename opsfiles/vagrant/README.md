



## knife-soloによるプロビジョニング

```
bundle install
bundle exec knife solo bootstrap vagrant@127.0.0.1 -p 2201 -i .vagrant/machines/rakuichi-rakuza.vagrant/virtualbox/private_key
```

## 現状認識しているchefの問題点 (2014/4/22)


  1. Gitlabのclone時に初回コケる

      knownhostsにgitlab.aucfan.comが登録されていないため、yesボタンを押すタイミングでエラーが出てコケる
      手動で一度gitlabにsshでアクセスすれば、know_hostsに登録されるため大丈夫となる


  2. recipe[cookbook]のethtoolでコケる

      VMを立ち上げたあと、一度rebootをする必要がある
      Cannot set device rx-checksumming settings: Operation not supported


## 残りのタスク

  - lsyncdのcookbook設定(画像ファイルのsync設定をする)
  - gitのsubmoduleのupdate --init
  - crontab系の設置作業


## 残りの手動作業

  1. DBのインポート作業
