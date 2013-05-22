<?php
/**
 * 单元测试工具。用法类似phpunit。
 * 用法：测试用例继承本类，每个测试方法以"test_"为前缀。实例化测试用例即可。
 */
class Unit {

    public $test_sum = 0;
    public $assert_sum = 0;
    public $error_sum = 0;
    public $pass_sum = 0;
    public $error_method = '';

    public function __construct() {
        $methods = get_class_methods($this);
        $test_methods = array();

        foreach ($methods as $v) {
            if (substr($v, 0, 5) === 'test_') {
                $test_methods[] = $v;
            }
        }

        foreach ($test_methods as $v) {
            $this->test_sum++;
            $this->current_method = $v;
            $this->$v();
        }

        $this->myecho();
    }

    public function equal($a, $b) {
        $r = TRUE;

        if ($a !== $b) {
            $r = FALSE;
        }

        $this->handle($r, __METHOD__);
    }

    public function bigger($a, $b) {
        $r = TRUE;

        if ($a <= $b) {
            $r = FALSE;
        }

        $this->handle($r, __METHOD__);
    }

    public function smaller($a, $b) {
        $r = TRUE;

        if ($a >= $b) {
            $r = FALSE;
        }

        $this->handle($r, __METHOD__);
    }

    public function be_int($v) {
        $this->handle(is_int($v), __METHOD__);
    }

    public function be_array($v) {
        $this->handle(is_array($v), __METHOD__);
    }

    public function be_TRUE($v) {
        $r = TRUE;

        if ($v !== TRUE) {
            $r = FALSE;
        }

        $this->handle($r, __METHOD__);
    }

    public function be_FALSE($v) {
        $r = TRUE;

        if ($a !== FALSE) {
            $r = FALSE;
        }

        $this->handle($r, __METHOD__);
    }

    public function not_empty($v) {
        $this->handle(!empty($v), __METHOD__);
    }

    public function str_maxlen($str, $len) {
        $r = TRUE;

        if (isset($str{$len})) {
            $r = FALSE;
        }

        $this->handle($r, __METHOD__);
    }

    public function str_minlen($str, $len) {
        $r = TRUE;

        if (mb_strlen($str, 'utf8') < $len) {
            $r = FALSE;
        }

        $this->handle($r, __METHOD__);
    }

    protected function myecho() {
        $t = $this;
        $result = function($r) use ($t) {
                    $color = ($r) ? 'green' : 'darkred';
                    $limiter = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo "<style type='text/css'>.unit{background:" . $color . ";color:white;padding:10px;margin:5px;font-weight:bold;font-family:arial}</style>";
                    echo '<div class="unit">测试方法：' . $t->test_sum . $limiter;
                    echo '测试断言：' . $t->assert_sum . $limiter;
                    echo '通过断言：' . $t->pass_sum . $limiter;
                    echo '错误断言：' . $t->error_sum . '</div>';

                    if ($t->error_method) {
                        echo '<div class="unit">出错方法：' . $t->error_method . $limiter;
                        echo '出错断言：' . $t->error_assert . '</div>';
                    }
                };

        if ($this->error_sum === 0) {
            $result(TRUE);
        } else {
            $result(FALSE);
        }

        exit;
    }

    protected function handle($r, $assert) {
        $this->assert_sum++;

        if ($r) {
            $this->pass_sum++;
        } else {
            $tmp = explode('::', $assert);
            $this->error_sum++;
            $this->error_method = $this->current_method;
            $this->error_assert = end($tmp);
            $this->myecho();
        }
    }

}

# end of this file