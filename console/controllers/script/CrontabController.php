<?php
/**
 * Message: php定时执行crontab   执行方式 php yii /crontab/base/index
 * 该脚本每分钟执行一次
 * User: jzc
 * Date: 2018/12/12
 * Time: 2:58 PM
 * Return:
 */

namespace console\controllers\script;

use yii\base\Controller;
use common\lib\Config;
use Yii;

class CrontabController extends Controller
{
    const MAX_PROC = 128;//最大进程数
    const CMD_PHP = 'php';//php脚本
    const CMD_SH = '/bin/sh';//shell脚本

    const SELF_CLI_URL = '/script/crontab/index';
    const CLI_INDEX_PATH = 'yii';

    private $proc_running = array();//正在运行的任务 k => 脚本类型-脚本名称-进程总数-进程编号-版本号 v => PID
    private $proc_plan = array();//计划运行的任务 k => 同上 v => 计划运行时间

    public function actionIndex()
    {
        //只允许一个Monitor运行
        if ($this->checkSelfRunning()) {
            Yii::info("Crontab Booter Has Runing, Exited", CATEGORIES_CONSOLE);
            exit();
        }
        Yii::info("Crontab Booter Begin.", CATEGORIES_CONSOLE);

        //构建正在运行的任务列表
        $this->buildProcRunning();

        //构建计划运行的任务列表
        $this->buildProcPlan();

        //杀死不在计划列表里的进程
        Yii::info("Kill Useless Task:", CATEGORIES_CONSOLE);
        foreach ($this->proc_running as $proc_name => $pid) {
            if (!isset($this->proc_plan[$proc_name])) {
                $this->killProc($pid);
                Yii::warning("Kill $proc_name, pid=$pid .", CATEGORIES_CONSOLE);
            }
        }

        //启动在计划列表里, 且时间符合要求, 且未运行的任务.
        Yii::info("Starting Task:", CATEGORIES_CONSOLE);
        $t_now = time();
        $t_now_month = date("n", $t_now); // 没有前导0
        $t_now_day = date("j", $t_now); // 没有前导0
        $t_now_hour = date("G", $t_now);
        $t_now_minute = date("i", $t_now);
        $t_now_week = date("w", $t_now); // w 0~6, 0:sunday  6:saturday
        foreach ($this->proc_plan as $proc_name => $start_time) {
            list($type, $path, $proc_total, $proc_no, $version) = explode("-", $proc_name);
            list($t_minute, $t_hour, $t_day, $t_month, $t_week) = explode(" ", $start_time);
            //检查启动时间是否符合条件
            if (!($this->checkTime($t_now_week, $t_week, 7, 0) &&
                $this->checkTime($t_now_month, $t_month, 12, 1) &&
                $this->checkTime($t_now_day, $t_day, 31, 1) &&
                $this->checkTime($t_now_hour, $t_hour, 24) &&
                $this->checkTime($t_now_minute, $t_minute, 60)
            )) {
                Yii::info("$proc_name, TIME SKIPPED.", CATEGORIES_CONSOLE);
                continue;
            }

            //检查是否正在运行
            if (isset($this->proc_running[$proc_name])) {
                Yii::info("$proc_name, RUNNING.", CATEGORIES_CONSOLE);
                continue;
            }

            //启动
            $this->startProc($type, $path, $proc_total, $proc_no,  $version);
            Yii::info("$proc_name, STARTED.", CATEGORIES_CONSOLE);

        }

        Yii::info("Crontab Booter End.", CATEGORIES_CONSOLE);
    }

    /**
     * 检查自身运行状态
     * @return bool
     */
    private function checkSelfRunning()
    {
        $cmd = "ps -ef | grep -v 'sudo' | grep -v 'grep' | grep '" . self::SELF_CLI_URL . "' | grep -v \"/bin/sh \\-c \" | wc -l";
        $pp = @popen($cmd, 'r');
        $num = intval(trim(@fread($pp, 512)));
        @pclose($pp);

        if ($num > 2) {
            return true;
        }

        return false;
    }

    /**
     * 获取正在运行的进程
     */
    private  function buildProcRunning()
    {
        $cmd = "ps -ef | grep -v 'sudo' | grep -v 'grep' |grep -E '".self::CLI_INDEX_PATH . "'|awk -F  ' ' '{print $2,$8,$9,$10,$11,$12,$13}' ";
        $pp = @popen($cmd, 'r');

        while(!feof($pp)) {
            //8482 /sbin/php /www/wallet/src/App/Console/cli/index.php --uri=/reward/send_reward 1 1 1.0
            $line = trim(fgets($pp));

            if(empty($line)) continue;
            list($pid, $type, $path, $uri,$proc_total, $proc_no, $version) = explode(" ", $line);


            if ($type == self::CMD_PHP) {
                $type = 'php';
            } else if ($type == self::CMD_SH) {
                $type = 'sh';
            } else {
                continue;
            }

            //$uri = str_replace('--uri=','',$uri);

            if ($uri == self::SELF_CLI_URL) continue;

            $proc_name = $this->buildProcName($type, $uri, $proc_total, $proc_no, $version);

            $this->proc_running[$proc_name] = $pid;
        }
        @pclose($pp);
    }

    /**
     * 构建计划队列
     */
    private  function buildProcPlan()
    {
        $config = (new Config())->getEnv('crontab');

        if (!empty($config) && is_array($config)) {
            foreach ($config as $item) {
                $item = trim($item);
                $item = preg_replace ( "/\s(?=\s)/","\\1", $item ); //去除重复空格
                list($t_minute, $t_hour, $t_day, $t_month, $t_week, $type, $uri, $proc_total, $version) = explode(" ", $item);

                //最多限制128个进程
                $proc_total = $proc_total > self::MAX_PROC ? self::MAX_PROC: $proc_total;

                for ($proc_no = 1; $proc_no <= $proc_total; $proc_no++) {
                    $proc_name = $this->buildProcName($type, $uri, $proc_total, $proc_no, $version);
                    $this->proc_plan[$proc_name] = "$t_minute $t_hour $t_day $t_month $t_week";
                }
            }
        }
    }

    /**
     * 按规则拼接名称
     * @param $type
     * @param $uri
     * @param $proc_total
     * @param $proc_no
     * @param $version
     * @return string
     */
    private function buildProcName($type, $uri, $proc_total, $proc_no, $version)
    {
        return "$type-$uri-$proc_total-$proc_no-$version";
    }

    /**
     * 检查时间匹配
     * @param $current  //当前时间
     * @param $boot  //待检查时间
     * @param $max  //待检查时间最大值
     * @param int $start  //待检查时间开始值
     * @return bool
     */
    private static function checkTime($current, $boot, $max, $start = 0)
    {
        if (strpos($boot, ',') !== false) {
            $weekArray = explode(',', $boot);
            if (in_array($current, $weekArray))
                return true;
            return false;
        }

        $array = explode('/', $boot);
        $end = $start + $max - 1;
        if (isset($array[1])) {
            if ($array[1] > $max)
                return false;
            $tmps = explode('-', $array[0]);
            if (isset($tmps[1])) {
                if ($tmps[0] < 0 || $end < $tmps[1])
                    return false;
                $start = $tmps[0];
                $end = $tmps[1];
            } else {
                if ($tmps[0] != '*')
                    return false;
            }
            if (0 == (($current - $start) % $array[1]))
                return true;
            return false;
        }
        $tmps = explode('-', $array[0]);
        if (isset($tmps[1])) {
            if ($tmps[0] < 0 || $end < $tmps[1])
                return false;
            if ($current >= $tmps[0] && $current <= $tmps[1])
                return true;
            return false;
        } else {
            if ($tmps[0] == '*' || $tmps[0] == $current)
                return true;
            return false;
        }
    }

    private function startProc($type, $uri, $proc_total, $proc_no, $version)
    {
        if ($type == "php") {
            $cmd =  self::CMD_PHP . " " . self::CLI_INDEX_PATH. " ".$uri." ".$proc_total." ".$proc_no . " ". $version ." > /dev/null &";
        } else if ($type == 'sh') {
            $cmd = self::CMD_SH . " " . self::CLI_INDEX_PATH. " ".$uri." ".$proc_total." ".$proc_no . " ". $version ." > /dev/null &";
        } else {
            return false;
        }

        $pp = @popen($cmd, 'r');
        @pclose($pp);
        return true;
    }

    private function killProc($pid)
    {
        $pid = intval($pid);
        return posix_kill($pid, 9);
    }
}