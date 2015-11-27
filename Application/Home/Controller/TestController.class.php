<?php
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller {

    public function _initialize()
    {
        #
    }

    public function index()
    {
        header("location:?s=home/test/ueditTest");
    }

    public function test(){
        $this->display();
    }

    //图片上传测试
    public function test01()
    {
    	//echo "111111";
    	//图片上传
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728 ;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->autoSub = false;
        $upload->savePath = './Test/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload->saveName = $fileName;
        //上传文件
        $info = $upload->upload();
        if($info){
        	$data = 1;
        	$dataArr = json_encode($data);
        	echo $dataArr;
        }else{
        	$data = 0;
        	$dataArr = json_encode($data);
        	echo $dataArr;
        }
    }

    // uedit测试
    public function ueditTest()
    {
    	W('Category/lists', array(41, true));
        $this->display();
    }

    //更改homeuser style
    public function test02()
    {
        /*$sql = "SELECT * FROM wft_project GROUP BY pid";
        $uids = M()->query($sql);
        $x = 1;
        M()->startTrans();
        foreach ($uids as $key => $value) {
            $x = $x*(M('homeuser')->where("id='$value[pid]'")->save(array('style'=>1)));
        }
        if($x==1){
            M()->commit();
        }else{
            M()->rollback();
        }
        /////////////
        $uids = M('investor')->select();
        $x = 1;
        M()->startTrans();
        foreach ($uids as $key => $value) {
            $x = $x*(M('homeuser')->where("id='$value[uid]'")->save(array('style'=>2)));
        }
        if($x==1){
            M()->commit();
        }else{
            M()->rollback();
        }*/
    }
}