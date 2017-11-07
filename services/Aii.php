<?php
/**
 * Created by PhpStorm.
 * User: jincon
 * Date: 2017/11/4
 * Time: 下午4:56
 */

namespace Aiiphp;


class Aii
{
    /**
     * 对象注册表
     *
     * @var array
     */
    private static $_objects = array();


    function __construct(){

    }


    /**
     * @desc：启动核心
     * @param：
     * @author：
     */
    public static function run(){
        //初始化
        self::init();
    }


    private static function init(){
        // 定义常量
        define('APP_PATH', BASE_PATH.'/app');
        define('CORE_PATH', BASE_PATH.'/services');
        define('RUNTIME_PATH', BASE_PATH.'/runtime');
        define('CACHE_PATH', BASE_PATH.'/runtime/cache');
        define('COMMON_PATH', BASE_PATH.'/common');
        define('CONFIG_PATH', BASE_PATH.'/config');
        define('REQUEST_METHOD',$_SERVER['REQUEST_METHOD']);
        define('IS_GET',        REQUEST_METHOD =='GET' ? true : false);
        define('IS_POST',       REQUEST_METHOD =='POST' ? true : false);
        define('IS_AJAX',       ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) ? true : false);
        define('IS_WEIXIN', strpos( $_SERVER['HTTP_USER_AGENT'], 'MicroMessenger' ) !== FALSE );
        define('__HISTORY__', isset( $_SERVER["HTTP_REFERER"] ) ? $_SERVER["HTTP_REFERER"] : '' );
        define('__ROOT__', trim( 'http://' . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['SCRIPT_NAME'] ), '/\\' )."/" );
        define('__URL__', trim( 'http://' . $_SERVER['HTTP_HOST'] . '/' . trim( $_SERVER['REQUEST_URI'], '/\\' ), '/' )."/" );
        define('VERSION','2.0.0');
        //end

    }
    /**
     * 返回唯一的实例(单例模式)
     *
     * 程序开发中,model,module, widget, 或其它类在实例化的时候,将类名登记到doitPHP注册表数组($_objects)中,当程序再次实例化时,直接从注册表数组中返回所要的对象.
     * 若在注册表数组中没有查询到相关的实例化对象,则进行实例化,并将所实例化的对象登记在注册表数组中.此功能等同于类的单例模式.
     *
     * 注:本方法只支持实例化无须参数的类.如$object = new pagelist(); 不支持实例化含有参数的.
     * 如:$object = new pgelist($total_list, $page);
     *
     * <code>
     * $object = Aii::singleton('pagelist');
     * </code>
     *
     * @access public
     * @param string $className  要获取的对象的类名字
     * @return object 返回对象实例
     *
     * 注意，此单例加载仅仅对已经加载的文件目录下的类有效，如：class目录，core目录等
     */
    public static function singleton($className,$initArr='') {

        //参数分析
        if (!$className) {
            return false;
        }

        $className = trim($className);

        if (isset(self::$_objects[$className])) {
            return self::$_objects[$className];
        }

        return self::$_objects[$className] = new $className($initArr);
    }
}