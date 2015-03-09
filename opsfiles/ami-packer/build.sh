#!/bin/sh
packer build -var-file=credentials.json rakuichi-rakuza-eb-ami.json
