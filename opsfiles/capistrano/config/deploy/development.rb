role :app, %w{vagrant@rakuichi-rakuza.vagrant}
server 'rakuichi-rakuza.vagrant', user: 'vagrant', roles: %w{app}
