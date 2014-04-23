
# todo: IPアドレスを外部に出したい
# todo: 毎回iptablesをflushするので、影響あり。何か冪等性を担保できる方法で良いものを検討したい

execute "Flush all iptables rules & assign prerouting vip in thit server" do
  command <<-EOH
    /sbin/iptables -F
    for i in $( iptables -t nat --line-numbers -L | grep ^[0-9] | awk '{ print $1 }' | tac ); do iptables -t nat -D PREROUTING $i; done
    service iptables save
    /sbin/iptables -t nat -A PREROUTING -d 192.168.33.5 -j REDIRECT
    service iptables save
  EOH
end

service "iptables" do
  action [:restart, :enable]
end

