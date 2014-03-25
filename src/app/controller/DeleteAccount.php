<?php
namespace controller;

use core as c;
use model as m;

class DeleteAccount extends Base
{
    public function run()
    {
        $iID = $this->post('id');
        (new m\Account)->del($iID);
        c\Router::redirect(c\Router::genURL('Home'));
    }
}

# end of this file
