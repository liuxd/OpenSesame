<?php
/**
 * 设置自定义类加载器
 */
namespace system;

class ClassLoader
{

    public function __construct()
    {
        spl_autoload_register([__CLASS__, 'utility']);
        spl_autoload_register([__CLASS__, 'model']);
    }

    /**
     * 加载框架工具类。
     */
    private function utility($class)
    {
        list($namespace, $classname) = explode('\\', $class);

        if ($namespace !== 'utility') {
            return false;
        }

        $class_filename = UTIL_PATH . $classname . DS . $classname . '.class.php';

        if (file_exists($class_filename)) {
            require $class_filename;
        } else {
            return false;
        }
    }

    /**
     * 加载应用业务相关的model。
     */
    private function model($class)
    {
        list($namespace, $classname) = explode('\\', $class);

        if ($namespace !== 'model') {
            return false;
        }

        $class_filename = APP_PATH . DEFAULT_APP . DS . 'model' . DS . $classname . '.class.php';

        if (file_exists($class_filename)) {
            require $class_filename;
        } else {
            return false;
        }
    }
}

# end of this file
