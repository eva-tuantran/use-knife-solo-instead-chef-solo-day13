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

##本番環境で動作不具合によりコメントアウト中
##なお、恒久的なオフロード設定は以下では出来ないので編集する必要あり
##execute "Nic Offload" do
##  command "ethtool -K eth0 rx off tx off tso off gso off gro off"
##  command "ethtool -K eth1 rx off tx off tso off gso off gro off"
##  action :run
##end

#template "/etc/keepalived/keepalived.conf" do
#  source "keepalived.conf.erb"
#end

service "network" do
  action [:restart]
end

