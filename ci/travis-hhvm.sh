#!/bin/sh
# https://github.com/facebook/hhvm/wiki/fastcgi

# Configure apache virtual hosts
sudo cp -f tests/ci/travis-hhvm-vhost /etc/apache2/sites-available/default

# Run HHVM
hhvm -m daemon -vServer.Type=fastcgi -vServer.Port=9000 -vServer.FixPathInfo=true