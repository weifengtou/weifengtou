<?php
namespace Home\Model;
use Think\Model;
use Think\Model\RelationModel;

class InvestorModel extends RelationModel{
// 	protected $dbName = 'weifengtou';
// 	protected $trueTableName = 'wft_investor';
	
	//字段映射
	protected $map = array();
	
	//所有的关联定义都统一记录在模型类的$_link里面
	protected $_link = array(
			'Homeuser'=>array( //关联的表名
					'mapping_type' =>self::BELONGS_TO, //关联类型
// 					'parent_key' => 'pid' //自引用关联的关联字段 默认为parent_id 自引用关联是一种比较特殊的关联，也就是关联表就是当前表。
					'class_mame' =>'Homeuser', //需要关联的模型类名
					'mapping_name'=>'Homeuser', //关联的映射名称，用于获取数据用
					'foreign_key' =>'uid', //关联的外键名称
// 					'condition' => 'Investor.uid = Homeuser.id',
// 					'mapping_fields'=>'email,username', //关联要查询的字段
					'as_fields' =>'email,username', //直接把关联的字段值映射成数据对象中的某个字段
				),
			'InvCase'=>array(
					'mapping_type' =>self::HAS_MANY, //关联类型
					'class_mame' =>'InvCase', //需要关联的模型类名
					'foreign_key' =>'inv_id', //关联的外键名称
					'mapping_name'=>'cases', //关联的映射名称，用于获取数据用
					'mapping_fields'=>'id,pname,purl,pdetail', //关联要查询的字段
				),
			'Invdenymsg'=>array(
					'mapping_type' =>self::HAS_MANY, //关联类型
					'class_mame' =>'Invdenymsg', //需要关联的模型类名
					'foreign_key' =>'iid', //关联的外键名称
					'mapping_name'=>'deny', //关联的映射名称，用于获取数据用
					'mapping_fields'=>'time,denymsg', //关联要查询的字段
				),
			'Invmember'=>array(
					'mapping_type' => self::HAS_MANY,
					'class_mame' =>'Invmember', //需要关联的模型类名
					'foreign_key' =>'iid', //关联的外键名称
					'mapping_name'=>'cys', //关联的映射名称，用于获取数据用
					'mapping_fields'=>'cyname,cydetail', //关联要查询的字段
				),
		);
}