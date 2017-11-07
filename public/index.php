<?php
/**
 * Created by PhpStorm.
 * User: jincon
 * Date: 2016/12/27
 * Time: 上午8:50
 */

// 定义 PUBLIC_PATH

define('PUBLIC_PATH', __DIR__);

header("Content-Type:text/html;charset='utf-8'");

// 启动器
require PUBLIC_PATH.'/../bootstrap.php';

// 路由配置、开始处理

require BASE_PATH.'/config/routes.php';
