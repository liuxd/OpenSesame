<?php
namespace controller;

use core as c;
use model as m;

class Update extends Base
{
    public function run()
    {
        $sFieldName = $this->post('field_name');
        $sFieldValue = $this->post('field_value');
        $iRowID = $this->post('field_id');
        $iAccountID = $this->post('account_id');

        (new m\Account)->updateField($sFieldName, $sFieldValue, $iRowID);
        c\Router::redirect(c\Router::genURL('Detail', ['id' => $iAccountID]));
    }
}

# end of this file
