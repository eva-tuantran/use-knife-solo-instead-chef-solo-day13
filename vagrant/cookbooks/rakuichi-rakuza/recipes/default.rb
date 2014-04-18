execute "import rakuichi-rakuza database" do
  command "mysql -uroot </var/www/html/db/rakuichi-rakuza.sql"
end

execute "seed rakuichi-rakuza database" do
  command "cd /var/www/html/; php oil refine seed;"
end

execute "grant readonly user" do
  command "echo 'grant select on *.* to readonly@localhost;' | mysql -uroot"
end

execute "create index" do
  command "mysql -uroot rakuichi-rakuza < /var/www/html/db/rakuichi-rakuza.index.sql"
end
