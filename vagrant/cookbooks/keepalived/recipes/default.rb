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

execute "Nic Offload" do
  command "ethtool -K eth0 rx off tx off tso off gso off gro off"
  command "ethtool -K eth1 rx off tx off tso off gso off gro off"
  action :run
end

#template "/etc/keepalived/keepalived.conf" do
#  source "keepalived.conf.erb"
#end

service "network" do
  action [:restart]
end

