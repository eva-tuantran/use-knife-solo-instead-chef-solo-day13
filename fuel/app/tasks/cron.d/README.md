crontabの運用メモ 2014/05/02 11:32:21
============================================================


crontabを変更し、本番に適応させるためには以下に行くこと

```
rakuichi-rakuza/vagrant/site-cookbooks/rakuichi-rakuza/templates/default/rakuichi-rakuza.crontab
```

このディレクトリ配下のcron.dは個別に動作検証する用途のもの。
最終的には削除してもよいかもしれない。
