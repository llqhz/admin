<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING'  =>array(
        //'__PUBLIC__' => '/Common', // 更改默认的/Public 替换规则
        //'__JS__'     => '/Public/JS/', // 增加新的JS类库路径替换规则
        '__UPLOAD__' => '/Uploads', // 增加新的上传路径替换规则
        '../vendors' => '/Public/vendors',
        '../build' => '/Public/build',
        //'="image'  => '="/Public/production/image'
    ),

    /* 数据库设置 */
    'DB_TYPE'                => 'mysql', // 数据库类型
    'DB_HOST'                => '119.29.119.219', // 服务器地址
    'DB_NAME'                => 'wckj', // 数据库名
    'DB_USER'                => 'llqhz', // 用户名
    'DB_PWD'                 => 'llqhz', // 密码
    'DB_PORT'                => '3306', // 端口
    'DB_PREFIX'              => 'wckj_', // 数据库表前缀

    'upload_dir'             => 'Public/upload/',  //'图片目录'
    'news_dir'               => 'Public/news/',    // 新闻html目录
    'data_dir'               => 'Public/data/',    // 数据目录

);