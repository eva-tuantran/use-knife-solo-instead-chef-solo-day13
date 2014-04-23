%w{ipvsadm iproute curl keepalived}.each do |name|
  package name do
    action :install
  end
end
service "keepalived" do
  action [:start, :enable]
end

template "/etc/sysctl.conf" do
  source "sysctl.conf.erb"
end

execute "Reload /etc/sysctl.conf" do
  command "sysctl -p"
  action :nothing
end

template "/etc/keepalived/keepalived.conf" do
  source "rakuichi-development/keepalived.conf.erb"
end

template "/etc/keepalived/rakuichi_web.conf" do
  source "rakuichi-development/rakuichi_web.conf.erb"
end

service "network" do
  action [:restart]
end

