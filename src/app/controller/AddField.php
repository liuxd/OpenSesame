<?php
namespace controller;

use core as c;
use model as m;

class AddField extends Base
{
    public function run()
    {
        $sFieldName = $this->post('field_name');
        $sFieldValue = $this->post('field_value');
        $iAccountID = $this->post('account_id');
        (new m\Account)->addField($sFieldName, $sFieldValue, $iAccountID);
        c\Router::redirect(c\Router::genURL('Detail', ['id' => $iAccountID]));
    }
}

# end of this file
