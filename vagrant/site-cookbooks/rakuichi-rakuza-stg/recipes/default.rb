execute "import rakuichi-rakuza database" do
  command "mysql -uroot </deploy/rakuichi-rakuza/db/rakuichi-rakuza.sql"
end

execute "seed rakuichi-rakuza database" do
  command "cd /deploy/rakuichi-rakuza; php composer.phar update; php oil refine seed;"
end

execute "grant readonly user" do
  command "echo 'grant select on *.* to readonly@localhost;' | mysql -uroot"
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

