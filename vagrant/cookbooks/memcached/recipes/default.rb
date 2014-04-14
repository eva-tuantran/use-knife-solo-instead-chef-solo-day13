%w{php-pecl-memcached memcached}.each do |name|
  package name do
    action :install
  end
end
service "memcached" do
  action [:start, :enable]
end

# template "/etc/php.d/memcache.ini" do
  # source "memcache.ini.erb"
# end

service "httpd" do
  action [:restart]
end
