#
# Cookbook Name:: rakuichi-httpd
# Recipe:: default
#
# 楽市楽座のWebサーバの基本的な設定をコピーします
#
#
# Copyright 2014, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

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

directory "/deploy" do
  mode "0755"
  action :create
end

#todo: 外部ファイル化
case node[:platform]
  when "centos"
    template "/root/.ssh/config" do
    source "ssh/config.erb"
    owner "root"
    group "root"
    mode "0644"
  end
else
end
log "deploy httpd.conf"
cookbook_file "/etc/httpd/conf.d/www.rakuichi-rakuza.jp.conf" do
 source "www.rakuichi-rakuza.jp.conf"
 owner "root"
 group "root"
end

directory "/etc/httpd/ssl" do
  mode "0755"
  action :create
end

log "ssl crtificate file copy"
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


# execute "git clone rakuichi production files" do
  # command "cd /deploy; git clone "
# end


# todo: db系は本番で上書きしないようにするなど、要設定
# execute "import rakuichi-rakuza database" do
  # command "mysql -uroot </deploy/rakuichi-rakuza/db/rakuichi-rakuza.sql"
# end

# execute "seed rakuichi-rakuza database" do
  # command "cd /deploy/rakuichi-rakuza; php composer.phar update; php oil refine seed;"
# end

# execute "grant readonly user" do
  # command "echo 'grant select on *.* to readonly@localhost;' | mysql -uroot"
# end

