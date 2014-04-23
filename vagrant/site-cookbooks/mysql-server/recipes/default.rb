%w{mysql mysql-server}.each do |name|
  package name do
    action :install
  end
end
template "/etc/my.cnf" do
  source "my.cnf.erb"
  variables({
    :server_id => node[:mysqld][:server_id] # node ファイルで指定した値が入る
  })
end
service "mysqld" do
  action [:start, :enable]
end
