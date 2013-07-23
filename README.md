# Open Seseame #

<img src="www/img/web.png" />

It's my __PSE__ —— __P__assword __S__earch __E__ngine.

## Dependence ##
+ OS
    + *nix
+ WebServer
    + any
+ PHP
    + Version：5.3+
    + Extension：zlib

## Install ##

* Step 1:
```
cd $document_root
git clone git@bitbucket.org:liuxd/open-sesame.git
cd open-sesame/res/ini/
cp web.ini.sample web.ini
```

* Step 2:
```
Configure the [db] section in web.ini.
Make sure the path is writable.
```

## Tech ##
* [PHP](http://php.net/)
* [Twitter Bootstrap](http://twitter.github.io/bootstrap/)
* [jQuery](http://jquery.com/)
* [keypress.js](http://dmauro.github.io/Keypress/)
* [Google Font API](http://www.google.com/fonts/)
* [Gravatar](http://cn.gravatar.com/)
