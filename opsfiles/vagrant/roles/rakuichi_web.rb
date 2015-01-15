#-*- coding: utf-8 -*-

name        "rakuichi_web"
description "rakuichi Web Server"
run_list    [
  'yum::epel',
  'recipe[common_web::default]',
  "recipe[chef-td-agent::default]",
  "recipe[munin::client]",
  'recipe[rakuichi_web::default]',
  'recipe[mysql::client]',
]

default_attributes(
  fluentd: {
    name: "app",
  }
)

override_attributes(
)
