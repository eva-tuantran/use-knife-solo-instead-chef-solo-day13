%w{mysql mysql-server}.each do |name|
  package name do
    action :install
  end
end
template "/etc/my.cnf" do
  source "my.cnf.erb"
end
service "mysqld" do
  action [:start, :enable]
end
