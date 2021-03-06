include_recipe 'database::mysql'

mysql_connection_info = {
  host:     'localhost',
  username: 'root',
  password: '',
}

# 楽市楽座メイン用
mysql_database "rakuichi_rakuza" do
  connection mysql_connection_info
  action :create
end

# 楽市楽座wordpress用
mysql_database "rakuichi_rakuza_wp" do
  connection mysql_connection_info
  action :create
end

mysql_database_user "rr_readonly" do
  connection mysql_connection_info
  password "6bd369abc23fc87abf191566348a69798d85092e"
  database_name "rakuichi_rakuza"
  host       "localhost"
  privileges [:select]
  action [:create, :grant]
end

mysql_database_user "rr_readonly" do
  connection mysql_connection_info
  password "6bd369abc23fc87abf191566348a69798d85092e"
  database_name "rakuichi_rakuza"
  host       "192.168.%"
  privileges [:select]
  action [:create, :grant]
end

mysql_database_user "rr_admin" do
  connection mysql_connection_info
  password "f8f4316c0ad0ce4939fd2966b9aff60e271ffe68"
  database_name "rakuichi_rakuza"
  host       "localhost"
  privileges [:all]
  action [:create, :grant]
end

mysql_database_user "rr_admin" do
  connection mysql_connection_info
  password "f8f4316c0ad0ce4939fd2966b9aff60e271ffe68"
  database_name "rakuichi_rakuza"
  host       "192.168.%"
  privileges [:all]
  action [:create, :grant]
end

mysql_database_user "rrwp_admin" do
  connection mysql_connection_info
  password "4803828f4577cc7ac17797a2b81ed6d6a13ff227"
  database_name "rakuichi_rakuza_wp"
  host       "localhost"
  privileges [:all]
  action [:create, :grant]
end

mysql_database_user "rrwp_admin" do
  connection mysql_connection_info
  password "4803828f4577cc7ac17797a2b81ed6d6a13ff227"
  database_name "rakuichi_rakuza_wp"
  host       "192.168.%"
  privileges [:all]
  action [:create, :grant]
end

mysql_database_user "repl" do
  connection mysql_connection_info
  password "ea9d51c2d383902c3c549f196686a3c14dc76a08"
  host       "192.168.%"
  privileges [:all]
  action [:create, :grant]
end

# Query a database
mysql_database 'flush the privileges' do
  connection mysql_connection_info
  sql        'flush privileges'
  action     :query
end
