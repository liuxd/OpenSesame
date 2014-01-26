#!/bin/bash
phpcs ../src/application --standard=PSR1
phpcs ../src/system --standard=PSR1
phpcs ../src/utility --standard=PSR1
phpcs ../src/index.php --standard=PSR1

phpcs ../src/application --standard=PSR2
phpcs ../src/system --standard=PSR2
phpcs ../src/utility --standard=PSR2
phpcs ../src/index.php --standard=PSR2
