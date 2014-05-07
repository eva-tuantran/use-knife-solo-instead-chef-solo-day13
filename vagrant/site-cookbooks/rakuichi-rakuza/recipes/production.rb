#
# 楽市楽座のWebサーバの基本的な設定をコピーします
# - DB等はまだ作成されておりません
# - 色々力技で作業しているので、後々これらを分割して作業したい
#
# Copyright 2014, Aucfan.co.ltd.,
#
# All rights reserved - Do Not Redistribute
#



##------------------------------------------------------------ 
## SSH公開鍵設定
##------------------------------------------------------------ 
log "copy ssh key"
%w{id_rsa_gitlab id_rsa_gitlab.pub}.each do |name|
  cookbook_file "/root/.ssh/#{name}" do
    source "#{name}"
    owner "root"
    group "root"
    mode  "0600"
    action :create_if_missing
  end
end

##------------------------------------------------------------ 
## SSH_config
##------------------------------------------------------------ 
case node[:platform]
  when "centos"
    template "/root/.ssh/config" do
    source "production/ssh/config.erb"
    owner "root"
    group "root"
    mode "0644"
  end
else
end


##------------------------------------------------------------ 
## アプリケーション配置
##------------------------------------------------------------ 
directory "/deploy" do
  mode "0755"
  action :create
end

execute "git clone rakuichi production files" do
  command "cd /deploy; git clone git@gitlab.aucfan.com:devs/rakuichi-rakuza.git; git submodule update --init"
  not_if { File.exists?("/deploy/rakuichi-rakuza") }
end


##------------------------------------------------------------ 
## 各種Apache設定 (httpd.conf, ssl証明書)
##------------------------------------------------------------ 
log "deploy httpd.conf"
cookbook_file "/etc/httpd/conf.d/www.rakuichi-rakuza.jp.conf" do
 source "www.rakuichi-rakuza.jp.conf-production"
 owner "root"
 group "root"
end

directory "/etc/httpd/ssl" do
  mode "0755"
  action :create
end

log "ssl crtificate file copy"
%w{20240414.self-signed-certificate.crt 20240414.self-signed-certificate.key 20141104.wildcard.rakuichi-rakuza.jp.chain.crt 20141104.wildcard.rakuichi-rakuza.jp.crt 20141104.wildcard.rakuichi-rakuza.jp.key.nopass}.each do |name|
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
      :mode => "production"
  })
end

