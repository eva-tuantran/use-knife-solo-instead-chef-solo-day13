# Vagrant向けの設定
role :app, %w{dev.www.rakuichi.rakuza.jp}
server 'dev.www.rakuichi.rakuza.jp', user: 'vagrant', roles: %w{app}
set :branch,        'develop'
