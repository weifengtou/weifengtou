<?php
namespace Test\Controller;
use Think\Controller;
use Common\Api;
class IndexController extends Controller {

	public function _initialize()
	{
		#
	}

	public function index()
	{
		// echo C('WEB_URL').U('test13');
		header("location:".U('test13'));
	}

	//日期控件
	public function test1()
	{
		layout('Layout/l1');
		$this->display();
	}

	//富文本编辑器uedit
	public function test2()
	{
		layout('Layout/l1');
		if (IS_POST) {
			yc_vp($_POST);
		}
		$this->display();
	}

	//文本编辑器ckeditor
	public function test3()
	{
		echo "ckeditor";
	}

	//文本编辑器kindeditor
	public function test4()
	{
		layout('Layout/l1');
		if (IS_POST) {
			yc_vp($_POST);
		}
		$this->display();
	}

	//行业分类
	public function test5()
	{
		layout('Layout/l1');
		$this->display();
	}

	//email激活
	public function test6()
	{
		$this->display();
	}

	//thinkphp 防注入
	public function test7()
	{
		layout('Layout/l1');
		$this->display();
	}

	//dl dt dd
	public function test8()
	{
		$this->display();
	}

	//图片上传重复限制
	public function test9()
	{
		$upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 1024*1024*2 ;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->autoSub = false;
        $upload->savePath = './Investor/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload->saveName = $fileName;
        $info = $upload->upload();
        // 上传文件
        if ($info) {
            $savename = $info[upImg][savename];
            $oldname = $info[upImg][name];
            $image = new \Think\Image(); 
            $image->open('./Uploads/Investor/'.$info[upImg][savename]);
            $thumbname = "thumb_".$savename;
            $image->thumb(220,220)->save('./Uploads/Investor/'.$thumbname);
            $data[name] = $info[upImg][savename];
            $data[thumbname] = $thumbname;
        	return $data;
        }else{
            $upload->getError();
        }
		layout('Layout/l1');
		$this->display();
	}

	//lazyload 插件
	public function test10()
	{
		$this->assign('images',M('primages')->select());
		layout('Layout/l1');
		$this->display();
	}

	//ezsyload 插件
	public function test11()
	{
		layout('Layout/l1');
		$this->display();
	}

	// 微博测试
	public function test12()
	{
		echo "string";
	}

	// 递归
	public function test13()
	{
		// file_put_contents(filename, json_encode(M('')))
	}

	// email_url
	public function test14()
	{
		yc_vp("gasdf",1);
		echo getemailurl('xxx@foxmail.com');
	}
}