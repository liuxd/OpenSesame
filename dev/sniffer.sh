#!/bin/bash
phpcs ../src/app --standard=PSR1
phpcs ../src/core --standard=PSR1
phpcs ../src/util --standard=PSR1
phpcs ../src/index.php --standard=PSR1

phpcs ../src/app --standard=PSR2
phpcs ../src/core --standard=PSR2
phpcs ../src/util --standard=PSR2
phpcs ../src/index.php --standard=PSR2
