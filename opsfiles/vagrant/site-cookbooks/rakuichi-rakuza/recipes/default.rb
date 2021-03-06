
[ '/srv', '/srv/www', '/srv/www/rakuichi-rakuza' ].each do |dir|
  directory dir do
    user      node[:deploy][:group]
    group     node[:deploy][:group]
    mode      00755
    action    [ :create ]
  end
end

directory '/srv/www/rakuichi-rakuza/shared' do
  user      node[:deploy][:group]
  group     node[:deploy][:group]
  mode      00775
  action    [ :create ]
end

directory '/var/log/rakuichi-rakuza' do
  user      'apache'
  group     'apache'
  mode      00775
  action    [ :create ]
end

[ 'id_rsa_gitlab', 'config' ].each do |f|
  cookbook_file "/home/#{node[:deploy][:user]}/.ssh/#{f}" do
    source  f
    user    node[:deploy][:user]
    group   node[:deploy][:group]
    mode    0600
    action  [ :create ]
  end
end
