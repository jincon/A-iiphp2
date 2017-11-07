<?php
/**
 * Created by PhpStorm.
 * User: jincon
 * Date: 2016/12/27
 * Time: 上午9:05
 */

namespace Aiiphp;

use Illuminate\Database\Capsule\Manager as Capsule;


define('BASE_PATH', __DIR__);

// Autoload 自动载入
require BASE_PATH.'/vendor/autoload.php';

Aii::run(); //启动。

//加载配置文件
require CONFIG_PATH.'/config.php';

//加载核心函数库
require COMMON_PATH.'/function.php';

//加载common下文件：
foreach(glob(COMMON_PATH.'/*.php') as $file){
    if(substr($file,-12) != 'function.php'){
        require_cache($file);
    }
}
//end

// Eloquent ORM
$capsule = new Capsule;
$capsule->addConnection(require BASE_PATH.'/config/database.php');
$capsule->setAsGlobal(); //设为全局 important
$capsule->bootEloquent();

// whoops 错误提示
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();