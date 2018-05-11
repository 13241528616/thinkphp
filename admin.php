<?php
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 绑定Home模块到当前入口文件
define('BIND_MODULE','Admin');
//define('BUILD_MODEL_LIST','Index,Article,Category');
//扩展配置类型
//define('CONF_EXT','.json');

define('APP_PATH','./Application/');
require './ThinkPHP/ThinkPHP.php';