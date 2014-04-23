#-*- coding: utf-8 -*-

name        "common"
description "Common configurations for all servers"
run_list    [
  "recipe[sysctl::default]",
  "recipe[ntp::default]",
  "recipe[openssh::default]",
  "recipe[common::default]",
  "recipe[sudo::default]"
]

default_attributes(
  ruby: {
    version: "1.9.3-p448"
  }
)

override_attributes(
)
