<?php
/**
 * 配置信息数据库操作类。
 * 以JSON格式保存数据。
 * @author liuxd
 */
class ConfDB
{

    const ERR_TABLENAME_MUST_STRING = 1;
    const ERR_TABLE_NOT_EXISTS = 2;
    const ERR_KEY_NOT_EXISTS = 3;
    const ERR_NOT_EMPTY = 4;
    const ERR_INFO_NO_MODIFY = 5;
    const ERR_TABLENAME_NOT_EMPTY = 6;
    const ERR_DB_NOT_WRITE = 7;
    const ERR_NO_DB = 8;
    const MSG_CONNECT_SUCCESS = 9;

    //数据库文件列表。
    public static $dbList = null;
    //数据文件保存路径。
    public static $file_path = '';
    //数据库基本信息表的表名。
    public static $db_info = '数据库基本信息';
    //数据库程序版本。
    private static $version = '2.0';
    //记录查询数据结果。
    private static $result = '';

    /**
     * 获得配置信息。
     * @param string $table 数据表。
     * @param string $key 数据项的键。
     * @param boolen $table_list 是否只列出数据表。
     * @return array 形如：['stat' => true,'error' => '数据表不能为空','response' => 123];
     */
    public static function get($table = '', $key = '', $table_list = false)
    {
        $table = trim($table);
        $key = trim($key);

        //返回值初始化。格式固定。
        self::$result = ['stat' => false, 'error' => '', 'response' => ''];

        if (empty($table)) {
            $table = self::$db_info;
        }

        //验证数据表名参数是否是字符串。
        if (!is_string($table)) {
            self::$result['error'] = self::ERR_TABLENAME_MUST_STRING;
            return self::$result;
        }

        $r = self::getAll();

        if (!$r['stat']) {
            return $r;
        }

        $all = $r['response'];

        if ($table_list) {
            self::$result['response'] = array_keys($all);
            self::$result['stat'] = true;

            return self::$result;
        }

        //如果输入的数据表不存在则报错。
        if (!isset($all[$table])) {
            self::$result['error'] = self::ERR_TABLE_NOT_EXISTS;
            self::$result['response'] = [];

            return self::$result;
        }

        self::$result['response'] = $all[$table];

        //如果指定了具体的键名，则输出该键的值。
        if (!empty($key)) {
            if (!isset(self::$result['response'][$key])) {
                self::$result['error'] = self::ERR_KEY_NOT_EXISTS;
                return self::$result;
            }

            self::$result['response'] = self::$result['response'][$key];
        }

        self::$result['stat'] = true;

        return self::$result;
    }

    /**
     * 修改配置信息。如果存在就修改，不存在就添加。
     * @param string $table 数据表。
     * @param string $key 数据项的键。
     * @param string $value 数据项的值。
     * @return array
     */
    public static function up($table, $key, $value)
    {
        $table = trim($table);
        $key = trim($key);
        $result = ['stat' => false, 'error' => ''];

        if (empty($table) || empty($key) || empty($value)) {
            $result['error'] = self::ERR_NOT_EMPTY;
            return $result;
        }

        if ($table === self::$db_info) {
            $result['error'] = self::ERR_INFO_NO_MODIFY;
            return $result;
        }

        $tmp = self::getAll();

        if (!$tmp['stat']) {
            unset($tmp['response']);
            return $tmp;
        }

        $all = $tmp['response'];
        $all[$table][$key] = $value;
        $r = self::write($all);
        $result['stat'] = ($r) ? true : false;

        if (!$r) {
            $result['error'] = self::ERR_DB_NOT_WRITE;
        }

        return $result;
    }

    /**
     * 删除数据。
     * @param string $table 数据表。
     * @param string $key 数据项的键。
     * @return array
     */
    public static function del($table, $key = '')
    {
        $table = trim($table);
        $key = trim($key);

        $result = ['stat' => false, 'error' => ''];

        if (empty($table)) {
            $result['error'] = self::ERR_TABLENAME_NOT_EMPTY;
            return $result;
        }

        if ($table === self::$db_info) {
            $result['error'] = self::ERR_INFO_NO_MODIFY;
            return $result;
        }

        $tmp = self::getAll();

        if (!$tmp['stat']) {
            unset($tmp['response']);
            return $tmp;
        }

        $all = $tmp['response'];

        if (!isset($all[$table])) {
            $result['error'] = self::ERR_TABLE_NOT_EXISTS;
            return $result;
        }

        if (!empty($key) && !isset($all[$table][$key])) {
            $result['error'] = self::ERR_KEY_NOT_EXISTS;
            return $result;
        }

        if (empty($key)) {
            unset($all[$table]);
        } else {
            unset($all[$table][$key]);
        }

        $r = self::write($all);
        $result['stat'] = ($r) ? true : false;

        return $result;
    }

    /**
     * 获得数据库列表。
     * @param string $db_path 数据库文件所在路径。
     * @return array
     */
    public static function dbList($db_path)
    {
        if (self::$dbList === null) {
            self::$dbList = glob($db_path . '*.db');
        }

        return self::$dbList;
    }

    /**
     * 连接数据库。
     * @param string $db_file 数据库绝对路径。
     * @return array
     */
    public static function connect($db_file = '')
    {
        $ret = [
            'result' => false,
            'msg' => '',
        ];

        if ($db_file) {
            self::$file_path = $db_file;

            if (is_writable($db_file)) {
                $ret['result'] = true;
                $ret['msg'] = self::MSG_CONNECT_SUCCESS;
            } else {
                if (file_exists($db_file)) {
                    $ret['msg'] = self::ERR_DB_NOT_WRITE;
                } else {
                    $r = self::create();

                    if ($r) {
                        $ret['result'] = true;
                    } else {
                        $ret['msg'] = self::ERR_DB_NOT_WRITE;
                    }
                }
            }
        } else {
            if (!empty(self::$dbList) && is_writable(self::$dbList[0])) {
                self::$file_path = self::$dbList[0];
                $ret['result'] = true;
                $ret['msg'] = self::MSG_CONNECT_SUCCESS;
            } else {
                $r = self::create();

                if (!$r) {
                    $ret['msg'] = self::ERR_NO_DB;
                } else {
                    $ret['result'] = true;
                }
            }
        }

        return $ret;
    }

    /**
     * 创建空数据库。
     * @return bool
     */
    public static function create()
    {
        $result = false;

        if (!file_exists(self::$file_path)) {
            $db_info = [
                self::$db_info => [
                    '创建时间' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
                    '版本信息' => self::$version,
                ],
            ];

            $result = self::write($db_info);
        }

        return $result;
    }

    /**
     * 查询数据全部信息。
     * @return array
     */
    private static function getAll()
    {
        $result = ['stat' => false, 'response' => ''];
        $result['response'] = self::read();
        $result['stat'] = true;

        return $result;
    }

    /**
     * 写入数据。
     * @param array $data
     * @return bool
     */
    private static function write($data)
    {
        if (is_writable(self::$file_path)) {
            $encode = json_encode($data);
            $compress = gzdeflate($encode, 9);
            file_put_contents(self::$file_path, $compress);

            return true;
        } elseif (!file_exists(self::$file_path)) {
            if (!is_writable(dirname(self::$file_path))) {
                return false;
            } else {
                $encode = json_encode($data);
                $compress = gzdeflate($encode, 9);
                file_put_contents(self::$file_path, $compress);

                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * 读数据全部。
     * @return array
     */
    private static function read()
    {
        if (is_writable(self::$file_path)) {
            $origin = file_get_contents(self::$file_path);
            $uncompress = gzinflate($origin);
            $decode = json_decode($uncompress, true);

            return $decode;
        }

        return [];
    }

}

# end of this file
