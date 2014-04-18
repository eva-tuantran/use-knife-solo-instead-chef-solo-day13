execute "import rakuichi-rakuza database" do
  command "mysql -uroot </deploy/rakuichi-rakuza/db/rakuichi-rakuza.sql"
end

execute "seed rakuichi-rakuza database" do
  command "cd /deploy/rakuichi-rakuza; php oil refine seed;"
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

##
#
#cookbook_file "/etc/httpd/ssl/20240414.self-signed-certificate.crt" do
#    source "20240414.self-signed-certificate.crt"
#    owner "root"
#    group "root"
#    action :create_if_missing
#end
#
#cookbook_file "/etc/httpd/ssl/20240414.self-signed-certificate.key" do
#    source "20240414.self-signed-certificate.key"
#    owner "root"
#    group "root"
#    action :create_if_missing
#end
#



service "httpd" do
  action [:restart]
end

