#execute "Update timezone" do
#  command "cp -a /usr/share/zoneinfo/#{node[:timezone][:tz]} /etc/localtime"
#end

# execute "Flush all iptables rules" do
  # command "/sbin/iptables -F"
# end
# service "iptables" do
  # action [:disable, :stop]
# end
#

# authorized_keys_for 'root'

execute "Install yum epel repository" do
  command "rpm -ivh http://ftp.riken.jp/Linux/fedora/epel/6/i386/epel-release-6-8.noarch.rpm"
  not_if "rpm -qa | grep -q 'epel-release'"
end

%w{git vim-enhanced tig telnet sendmail mailx}.each do |name|
  package name do
    action :install
  end
end

package "ntp" do
  action :install
end
service "ntpd" do
  action [:start, :enable]
end

service "sendmail" do
  action [:start, :enable]
end


template "/root/.vimrc" do
  source ".vimrc"
  owner "root"
  group "root"
end


template "/etc/hosts" do
    source "hosts.erb"
    owner "root"
    group "root"
    mode 0644
    variables({
        :hostname => node[:host_name] # node ファイルで指定した値が入る
    })
end

group 'upuser' do
  group_name 'upuser'
  gid        403
  action     [:create]
end

user 'upuser' do
  comment  'upuser'
  uid      403
  group    'upuser'
  password nil
  supports :manage_home => true
  action   [:create, :manage]
end

