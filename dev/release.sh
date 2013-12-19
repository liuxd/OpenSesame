#!/bin/bash

cd /Users/liuxd/Documents/github.com/phar-packer
php phar-packer.php --name=open-sesame --path=/Users/liuxd/Documents/github.com/open-sesame/src --init=index.php
mv open-sesame.phar /Users/liuxd/Documents/web/
