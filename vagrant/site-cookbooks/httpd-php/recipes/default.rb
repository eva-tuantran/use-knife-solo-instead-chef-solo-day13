%w{php php-mbstring php-pdo php-mysql php-xml php-gd php-pecl-apc}.each do |name|
  package name do
    action :install
  end
end
template "/etc/php.d/php.local.ini" do
  source "php.local.ini.erb"
  owner "root"
  group "root"
  variables(
    :php => node['php']
  )
end

%w{httpd mod_ssl}.each do |name|
  package name do
    action :install
  end
end

file "/etc/httpd/conf.d/welcome.conf" do
  action :delete
end

template "/etc/httpd/conf/httpd.conf" do
  source "httpd.conf.erb"
end
template "/etc/httpd/conf.d/ssl.conf" do
  source "ssl.conf.erb"
end
service "httpd" do
  action [:start, :enable]
end

