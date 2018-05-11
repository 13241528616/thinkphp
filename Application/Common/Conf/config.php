<?php
return array(
	 //'配置项'=>'配置值'
    'DB_TYPE'=> 'mysql',          // 数据库类型
    'DB_HOST'=> 'localhost', // 数据库服务器地址
    'DB_NAME'=>'myblog',  // 数据库名称
    'DB_USER'=>'root', // 数据库用户名
    'DB_PWD'=>'Xiongw2013#', // 数据库密码
    'DB_PORT'=>'3306', // 数据库端口
    'DB_PREFIX'=>'my_', // 数据表前缀
    'DB_CASE_LOWER'=>true,


    'TOKEN_ON' => true,// 开启令牌验证
    'TOKEN_NAME' => '__hash__',
    'TOKEN_TYPE' => 'md5',
    'TOKEN_RESET' => true,

    'URL_ROUTER_ON'   => true, 
);