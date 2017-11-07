<?php
/**
 * Created by PhpStorm.
 * User: jincon
 * Date: 2016/12/27
 * Time: 上午11:29
 */

/*
 * 基控制器。
 *
 * */

namespace Aiiphp;



class Controller
{
    protected $view;
    public $segments = '';
    public $getData = '';

    public function __construct()
    {

    }

    //设置数据和获取数据
    public function setGetData($segments){
        $this->getData = $segments;
    }
    public function get(){
        return  $this->getData;
    }
    //end


    /**
     * 导入app目录 class 下的等文件，类是不进行实例化的。
     * function，已经系统自动加载了
     * @param $path
     * @param string $initArr
     * @return mixed
     * @throws newexception
     */
    function import($path){
        self::require_cache(APP_PATH.'/load/'.$path.'.class.php');
    }


    /**
     * 加载 app class 下的等文件，类会实例化。
     * common目录下function改为自动加载了
     * @param $path
     * @param string $initArr
     * @return mixed
     * @throws newexception
     */
    function load($path,$initArr = ''){
        $this->import($path);
        return Aii::singleton($path,$initArr);
    }


    /**
     * 成功提示页面
     *
     * @param string $message   错误信息
     * @param string $jumpUrl   跳转地址
     * @param int $waitSecond   延时跳转的时间
     */
    protected function success($message='',$jumpUrl='',$waitSecond=3){
        //如果启用了模板
        $jumpUrl = isset($jumpUrl) && !empty($jumpUrl) ? $jumpUrl : (__HISTORY__?__HISTORY__:__ROOT__);
        $tplfile = CORE_PATH.'/tpl/message.php';
        include($tplfile);
        exit;
    }


    /**
     * 失败提示页面
     *
     * @param string $error    错误信息
     * @param string $jumpUrl  调整地址
     * @param int $waitSecond  延时跳转的时间
     */
    protected function error($error='',$jumpUrl='',$waitSecond=3){
        //如果启用了模板
        $jumpUrl = isset($jumpUrl) && !empty($jumpUrl) ? $jumpUrl : (__HISTORY__?__HISTORY__:__ROOT__);
        $tplfile = CORE_PATH.'/tpl/message.php';

        include($tplfile);
        exit;
    }

    /**
     * 显示404错误
     *
     * @param：
     */
    public static function show_404(){
        self::require_cache(CORE_PATH.'/tpl/404.php');
        die();
    }


    /**
     * 显示403错误
     *
     * @param：
     */
    public static function show_403(){
        self::require_cache(CORE_PATH.'/tpl/403.php');
        die();
    }


    /**
     * Action跳转(URL重定向） 支持指定模块和延时跳转
     * @param string $url 跳转的URL表达式
     * @param array $params 其它URL参数
     * @param integer $delay 延时跳转的时间 单位为秒
     * @param string $msg 跳转提示信息
     * @return void
     */
    protected function redirect($url,$delay=0,$msg='') {
       redirect($url,$delay,$msg);
    }


    /**
     * 优化的require_once
     * @param string $filename 文件地址
     * @return boolean/mixed
     */
    public static function require_cache($filename,$isreturn = 0) {
        static $_importFiles = array();
        if (!isset($_importFiles[$filename])) {
            if (is_file($filename)) {
                $_t = require $filename;
                $_importFiles[$filename] = $isreturn ? $_t : true;
                unset($_t);
            } else {
                $_importFiles[$filename] = false;
                throw new newexception('不存在的文件路径：'.$filename);
            }
        }
        return $_importFiles[$filename];
    }

    public function __destruct()
    {
        $view = $this->view;
        if ( $view instanceof View ) {
            extract($view->data);
            require $view->view;
        }

    }

}