<?php

namespace controller;

use core as c;

class Base implements c\IController
{
    public $outputType = c\Output::TYPE_HTML;

    public function handle()
    {
        $aData['data'] = $this->exec();

        if ($this->outputType === c\Output::TYPE_HTML) {
            $aData[c\Output::TYPE_HTML] = [
                    'header' => $this->getHeader(),
                    'body' => $this->getBody(),
                    'footer' => $this->getFooter(),
            ];
        }

        return $aData;
    }

    public function getOutputType()
    {
        return $this->outputType;
    }

    public function before()
    {
        // @todo
    }

    public function after()
    {
        return true;
    }

    private function getHeader()
    {
        return 'Header';
    }

    private function getFooter()
    {
        return 'Footer';
    }
}

# end of this file
