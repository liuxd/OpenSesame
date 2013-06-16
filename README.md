# Open Seseame #

<div>
<img src="https://github.com/liuxd/open-sasame/blob/master/www/img/web.png" width=90 height=90 style="display:block;float:left" />
<p style="float:left;padding: 30px;font-size: 14px">
It's my <b>PSE</b> —— <b>P</b>assword <b>S</b>earch <b>E</b>ngine.
</p>
<div style="clear:both"></div>
</div>

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