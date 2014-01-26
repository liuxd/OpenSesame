<?php
/**
 * 设置自定义类加载器
 */
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
        $class_filename = UTIL_PATH . $class . DS . $class . '.class.php';

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
        $app = isset($_GET['app']) ? $_GET['app'] : DEFAULT_APP;
        $class_filename = APP_PATH . $app . DS . 'model' . DS . $class . '.class.php';

        if (file_exists($class_filename)) {
            require $class_filename;
        } else {
            return false;
        }
    }

}

new ClassLoader;

# end of this file
