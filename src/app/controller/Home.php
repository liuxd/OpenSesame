<?php
namespace controller;

class Home extends Base
{
    public function exec()
    {
        $this->outputType = 'json';
        return ['title' => 'liuxd'];
    }

    protected function getBody()
    {
        return 'Home';
    }
}

# end of this file
