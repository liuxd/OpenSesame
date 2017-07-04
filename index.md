[Open Sesame](http://liuxd.github.io/OpenSesame)
============

## Feature
+ Two files : Programme file, Data file.
+ Two modes : Web Page, Command Line.
+ Security : Every deployment has its own secret key. It means even the code is open source and the data file is lost, the private data is also safe.

## Requirements
+ PHP 5.4+
  + mbstring
  + mcrypt
  + zlib

## Installation

    git clone git@github.com:open-sesame/OpenSesame.git
    cp dev/config.ini.sample src/config.ini # 根据自己需求修改 src/config.ini
    cd open-sesame/dev
    php phar-packer.php --name=os --path=../src/
    nohup php -S 0.0.0.0:8000 os.phar > /dev/null &

Then visit <http://localhost:8000>.

## Usage
Two modes : `Web Page`、`Command Line`

+ __Web Page__ - As you can see.
+ __Command Line__ - As followed :

[![asciicast](https://asciinema.org/a/b0rkuneybbvfwjjptv8yj9aor.png)](https://asciinema.org/a/b0rkuneybbvfwjjptv8yj9aor)

## Development

#### - Debug mode -
+ Method : add certain parameter on URL : `debug`.
+ Function : Show the server data and template file.
+ Example : <http://localhost:8000?debug=1>

#### - Code Style -
+ Rule : `PSR-1`、`PSR-2`
+ Installation : In the `dev/`folder, run `composer.phar install` to install the sanning tool.
+ Run : `./code-sniffer.sh`

#### - Aided Tools -
+ Create a new command controller : `php index.php createCmd {$command_name}`
+ Create a new normal controller : `php index.php createController {$controller_name}`

#### - Deployment -
+ Requirements : Set `phar.readonly` as `Off` in `php.ini`.
+ Package : Run `dev/phar-packer.php`
+ Example : `./phar-packer.php --name=opensesame --path=../src`

#### - Release -
+ Tool : `dev/release.sh`
+ Example : `./release.sh v5.0.1`
