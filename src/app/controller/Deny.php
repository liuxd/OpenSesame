<?php

namespace controller;

class Deny extends Base
{
    public $bAuth = false;

    public function run()
    {
        return ['page_title' => '禁止入内'];
    }

    protected function getBody()
    {
        return 'Deny';
    }
}

# end of this file
