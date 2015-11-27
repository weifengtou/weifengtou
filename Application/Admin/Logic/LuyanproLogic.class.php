<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Logic;

/**
 * 文档模型子模型 - 文章模型
 */
class LuyanproLogic extends BaseLogic{

	/* 自动验证规则 */
	protected $_validate = array(
		array('luyan_riqi' , 'check_riqi','该路演日期不存在！', self::MUST_VALIDATE , 'callback', self::MODEL_BOTH ),
		array('prid','check_prid','该项目不存在！', self::MUST_VALIDATE , 'callback', self::MODEL_BOTH ),
		// array('content', 'getContent', '内容不能为空！', self::MUST_VALIDATE , 'callback', self::MODEL_BOTH),
	);

	/* 自动完成规则 */
	protected $_auto = array();

	/**
	 * 新增或添加一条文章详情
	 * @param  number $id 文章ID
	 * @return boolean    true-操作成功，false-操作失败
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function update($id = 0){
		/* 获取文章数据 */
		$data = $this->create();
		if($data === false){
			return false;
		}

		/* 添加或更新数据 */
		if(empty($data['id'])){//新增数据
			$data['id'] = $id;
			$id = $this->add($data);
			if(!$id){
				$this->error = '新增详细内容失败！';
				return false;
			}
		} else { //更新数据
			$status = $this->save($data);
			if(false === $status){
				$this->error = '更新详细内容失败！';
				return false;
			}
		}

		return true;
	}

	/**
	 * 检查路演日期是否存在
	 * @return boolean 
	 * @author wodrow <wodrow451611cv@gmail.com>
	 */
	protected function check_riqi()
	{
		$type = I('post.type');
		$content = I('post.luyan_riqi');
		if (empty($content)) {
			return false;
		}
		$riqis = M('Document_luyan')->where("riqi='$content'")->limit("1")->select();
		if (!$riqis) {
			return false;
		}
		return true;
	}

	/**
	 * 检查项目id是否存在
	 * @return boolean [description]
	 * @author wodrow <wodrow451611cv@gmail.com>
	 */
	protected function check_prid()
	{
		$type = I('post.type');
		$content = I('post.prid');
		if (empty($content)) {
			return false;
		}
		$prids = M('Project')->where("id='$content'")->limit("1")->select();
		if (!$prids) {
			return false;
		}
		return true;
	}

	/**
	 * 保存为草稿
	 * @return true 成功， false 保存出错
	 * @author huajie <banhuajie@163.com>
	 */
	public function autoSave($id = 0){
		$this->_validate = array();

		/* 获取文章数据 */
		$data = $this->create();
		if(!$data){
			return false;
		}

		/* 添加或更新数据 */
		if(empty($data['id'])){//新增数据
			$data['id'] = $id;
			$id = $this->add($data);
			if(!$id){
				$this->error = '新增详细内容失败！';
				return false;
			}
		} else { //更新数据
			$status = $this->save($data);
			if(false === $status){
				$this->error = '更新详细内容失败！';
				return false;
			}
		}

		return true;
	}

}
