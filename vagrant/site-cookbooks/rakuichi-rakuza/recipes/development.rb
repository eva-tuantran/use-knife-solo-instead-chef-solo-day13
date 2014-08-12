#
# 楽市楽座のWebサーバの基本的な設定をコピーします
# - 色々力技で作業しているので、後々これらを分割して作業したい
#
# Copyright 2014, Aucfan.co.ltd.,
#
# All rights reserved - Do Not Redistribute
#


##------------------------------------------------------------ 
## Database設定
##------------------------------------------------------------ 
execute "import rakuichi-rakuza database" do
  command "mysql -uroot </deploy/rakuichi-rakuza/db/rakuichi_rakuza.sql"
end

execute "seed rakuichi-rakuza database" do
  command "cd /deploy/rakuichi-rakuza; php composer.phar update; php oil refine seed;"
end


##------------------------------------------------------------ 
## 各種Apache設定 (httpd.conf, ssl証明書)
##------------------------------------------------------------ 
log "deploy httpd.conf"
cookbook_file "/etc/httpd/conf.d/www.rakuichi-rakuza.jp.conf" do
  source "www.rakuichi-rakuza.jp.conf-development"
  owner "root"
  group "root"
end

directory "/etc/httpd/ssl" do
  mode "0755"
  action :create
end

log "crt copy"
%w{20240414.self-signed-certificate.crt 20240414.self-signed-certificate.key}.each do |name|
  cookbook_file "/etc/httpd/ssl/#{name}" do
    source "#{name}"
    owner "root"
    group "root"
    action :create_if_missing
  end
end

service "httpd" do
  action [:restart]
end


##------------------------------------------------------------ 
## 楽市楽座専用のcrontab設定
##------------------------------------------------------------ 

template "/etc/cron.d/rakucihi-rakuza.crontab" do
  source "rakuichi-rakuza.crontab.erb"
  owner "root"
  group "root"
  mode "0644"
  variables({
      :mode => "development"
  })
end

include_recipe 'database::mysql'
mysql_connection_info = {
  host:     'localhost',
  username: 'root',
  password: '',
}

# 楽市楽座テスト用
mysql_database "rakuichi_rakuza_test" do
  connection mysql_connection_info
  action    [ :create ]
end

