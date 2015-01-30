### Sample setup

Hosts

```
192.168.33.101   www.rakuichi-rakuza.vagrant
192.168.33.101   www.rakuichi-rakuza.capistrano

```


CUI

```sh
$ cd opsfiles
$ bundle install --path=vendor/bundle
$
$ cd vagrant
$ vagrant up
$ vagrant ssh-config >>~/.ssh/config
$ bundle exec knife solo prepare dev.www.rakuichi.rakuza.jp
$ bundle exec knife solo cook dev.www.rakuichi.rakuza.jp
$
$ cd ../capistrano
$ bundle exec cap dev deploy:check
$ bundle exec cap dev deploy
```
