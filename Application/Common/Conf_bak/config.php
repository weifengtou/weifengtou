<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /*网站url*/
    'WEB_URL' =>'http://127.0.0.1/weifengtou/',
    // 'WEB_URL' =>'http://116.255.217.235/',
    /*网站ip地址*/
    'WEB_IP_ADDRESS' => '127.0.0.1',
    // 'WEB_IP_ADDRESS' => '116.255.217.235',
    /*营业执照*/
    'BUSINESS_LICENSE' => '410100000104771',
    /*网站公共title*/
    'TITLE' => '微风投',
    "KEYWORDS" => '微风投',
    'DESCRIPTION' => '微风投',
    
    // /* 模块相关配置 */
    // 'AUTOLOAD_NAMESPACE' => array('Addons' => ONETHINK_ADDON_PATH), //扩展模块列表
    // 'DEFAULT_MODULE'     => 'Home',
    // 'MODULE_DENY_LIST'   => array('Common','User','Admin','Install'),
    // //'MODULE_ALLOW_LIST'  => array('Home','Admin'),
     /* 模块相关配置 */
    'AUTOLOAD_NAMESPACE' => array('Addons' => ONETHINK_ADDON_PATH), //扩展模块列表
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common','User','Admin','Install'),
    //'MODULE_ALLOW_LIST'  => array('Home','Admin'),
    // 'MODULE_ALLOW_LIST'  => array('Home'),  //  默认模块，可以省去模块名输入

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => 'zDsWnc([RH/=E%Y,Xdv&u.t|fNbePJ^84#@KQ)*k', //默认数据加密KEY

    /* 调试配置 */
    'SHOW_PAGE_TRACE' => true,

    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 3, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

    /* 数据库配置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    // 'DB_HOST'   => '127.0.0.1', // 服务器地址
    // 'DB_USER'   => 'root', // 用户名
    // 'DB_PWD'    => 'root',  // 密码
    'DB_HOST'   => '116.255.217.235', // 服务器地址
    'DB_USER'   => 'wft_open', // 用户名
    'DB_PWD'    => 'WeiFengTou2015',  // 密码
    'DB_NAME'   => 'weifengtou', // 数据库名
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'wft_', // 数据库表前缀
    'BASIC_LIB_TABLES' => 'mysql://root:root@192.168.1.12:3306/basic_lib_tables',

    /* 文档模型配置 (文档模型核心配置，请勿更改) */
    'DOCUMENT_MODEL_TYPE' => array(2 => '主题', 1 => '目录', 3 => '段落'),

    // 配置邮件发送服务器
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_HOST' =>'smtp.163.com', //邮件发送SMTP服务器
    'MAIL_CHARSET' =>'UTF-8', //字符集
    'MAIL_ENCODING' =>'base64', //编码方式
    'MAIL_PORT' =>25, //邮件发送端口
    'MAIL_SMTPAUTH' =>TRUE,
    'MAIL_USERNAME' =>'wtsjwft@163.com', //SMTP服务器登陆用户名
    'MAIL_FROM' =>'wtsjwft@163.com', //发件人地址（也就是你的邮箱）
    'MAIL_FROMNAME' =>'wodrow', //发件人姓名
    'MAIL_PASSWORD' =>'wtsjwftYC163', //SMTP服务器登陆密码
    // 'MAIL_SECURE' =>'tls',
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件

    // 配置qq登陆
    'QQ_APP_ID' => '101192185',
    'QQ_APP_KEY' => 'da6b0c50cdebd68faaaa0b86a424cba5',

    // 配置微博登陆
    'WEIBO_APP_ID' => '2051215982',
    'WEIBO_APP_SERCET' => '76dc5b6afc9603b2497c920a675fbcd6',

    // 客服邮箱
    'KEFU_EMAIL' => '3206590986@qq.com',
);
