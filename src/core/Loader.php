<?php
/**
 * 设置自定义类加载器
 */
namespace core;

class Loader
{

    public function __construct()
    {
        spl_autoload_register([__CLASS__, 'util']);
        spl_autoload_register([__CLASS__, 'model']);
    }

    /**
     * 加载框架工具类。
     */
    private function util($sClass)
    {
        list($sNameSpace, $sClassName) = explode('\\', $sClass);

        if ($sNameSpace !== 'util') {
            return false;
        }

        $sClassFile = UTIL_PATH . $sClassName . DS . $sClassName . '.php';

        if (file_exists($sClassFile)) {
            require $sClassFile;
        } else {
            return false;
        }
    }

    /**
     * 加载应用业务相关的model。
     */
    private function model($class)
    {
        list($sNameSpace, $sClassName) = explode('\\', $sClass);

        if ($sNameSpace !== 'model') {
            return false;
        }

        $sClassFile = APP_PATH . 'model' . DS . $sClassName . '.php';

        if (file_exists($sClassFile)) {
            require $sClassFile;
        } else {
            return false;
        }
    }
}

# end of this file
