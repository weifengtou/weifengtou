<?php
return array(
	//'配置项'=>'配置值'
	/* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
        '__HOME__'   => __ROOT__ . '/Public/home', 
        '__BUSINESSPLAN__' => __ROOT__.'/Uploads/Businessplan',
        '__ALBUM__'  => __ROOT__ . '/Uploads/Album',
        '__PORTRAIT__' => __ROOT__ . '/Uploads/Portrait',
    ),
);