<?php
/**
 * Controller Base.
 */
namespace core;

class Controller implements IController
{
    public $sOutputType = Output::TYPE_HTML;

    public function handle()
    {
        $aData['data'] = $this->run();
        $sOutputType = $this->getOutputType();

        if ($this->get('gm_type') === Output::TYPE_PJAX) {
            $this->setOutputType(Output::TYPE_PJAX);
        }

        if ($sOutputType === Output::TYPE_HTML) {
            $aData[Output::TYPE_HTML] = [
                'header' => $this->getHeader(),
                'body' => $this->getBody(),
                'footer' => $this->getFooter(),
            ];
        }

        if ($sOutputType === Output::TYPE_PJAX) {
            $aData[Output::TYPE_PJAX] = $this->getBody();
        }

        if ($this->get('debug')) {
            see($aData);
            die;
        }

        return $aData;
    }

    /**
     * Get HTTP parameter by GET.
     * @param string sName The parameter's name.
     * @param string sDefault The default value if there is no value for the name.
     * @return string
     */
    protected function get($sName, $sDefault = null)
    {
        return isset($_GET[$sName]) ? trim($_GET[$sName]) : $sDefault;
    }

    /**
     * Get HTTP parameter by POST.
     * @param string sName The parameter's name.
     * @param unknown mDefault The default value if there is no value for the name.
     * @return unknow
     */
    protected function post($sName, $mDefault = null)
    {
        return isset($_POST[$sName]) ? $_POST[$sName] : $mDefault;
    }

    /**
     * The pre interceptor.It will run before your controller's run().
     */
    public function before()
    {
        return true;
    }

    /**
     * The after interceptor.It will run after your controller's run().
     */
    public function after()
    {
        return true;
    }

    /**
     * Getter for sOutputType
     * @return string
     */
    public function getOutputType()
    {
        return $this->sOutputType;
    }

    /**
     * Setter for outpurType
     * @param string $sValue the value.
     */
    public function setOutputType($sValue)
    {
        $this->sOutputType;
    }

    /**
     * Get the header file.no need for the extension.
     * @return string
     */
    protected function getHeader()
    {
        return 'Header';
    }

    /**
     * Get the footer file.no need for the extension.
     * @return string
     */
    protected function getFooter()
    {
        return 'Footer';
    }
}

# end of this file
