<?php
namespace controller;

use core as c;
use model as m;

class AddAccount extends Base
{
    public function run()
    {
        $sName = $this->post('name');
        $sURL = $this->post('url');
        (new m\Account)->addAccount($sName, $sURL);
        c\Router::redirect(c\Router::genURL('Home'));
    }
}

# end of this file
