#-*- coding: utf-8 -*-

name        "rakuichi_common"
description "rakuichi Common"
run_list    [
]

default_attributes(

  # ----------------------------------------------------------------------
  # Application specific configurations
  # ----------------------------------------------------------------------

  # target application
  application: {
    name: "rakuichi"
  },

  stage: "production",

  # hostname/ip-address mappings of servers for this services
  service_hosts: {
    "rakuichi.web01" => "",
    "rakuichi.web02" => "",
    "rakuichi.lvs01" => "",
    "rakuichi.lvs02" => "",
  },

  munin: {
    server: ''
  },

  ## haproxy configurations
  #haproxy: {
  #  local_db_port: '13307'
  #},

  # MySQL configurations
  mysqld: {
    database:     "rakuichi_production",
    username:     "rakuichi",
    password:     "",
    master_db_ip: "",
    slave_db_ip:  "",

    replication: {
      username:       "repl",
      password:       "",
      port:           "13306",
      retry_connect:  "5",
      pair:           {
        "" => "",
        "" => "",
        ""   => "",
        ""  => "",
      }
    }
  }
)

override_attributes(
)
