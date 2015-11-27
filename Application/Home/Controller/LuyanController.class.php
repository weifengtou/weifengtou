<?php

namespace Home\Controller;
use Think\Controller;

class LuyanController extends Controller{

    //进入项目创建首页
    public function _initialize()
    {
        // yc_vp("luyanluyanluyanluyan",1);
    }

    //路演报名
    public function luyansignup(){
        $today = date("Y-m-d",time());
        $luyan = M('Document_luyan')->where("riqi>'$today'")->limit("1")->select();
        if (!$luyan) {
            $this->error("暂没有制定路演活动！");
        }
        $info = D("Document")->detail($luyan[0][id]);
        $this->assign('info',$info);
        C("SEO_TITLE",$info[title]);
        $this->display();
    }
    //报名信息保存
    public function addLuyanPeople(){
        $data[realname] = $_POST[realname];
        $data[telnumber] = $_POST[telnumber];
        $data[leavemsg] = $_POST[leavemsg];
        $data[status] = $_POST[identify];
        $data[signuptime] = date( "Y-m-d");
        $Luyansignup = M('Luyansignup');
        $result = $Luyansignup->add($data);
        echo $result;
    }
    // =============================================
    //路演汇总
    public function luyanzhuanti(){
        //获取路演信息
        $today = date("Y-m-d",time());
        if ($_GET[riqi]) {
            $luyan = M('Document_luyan')->where("riqi='$_GET[riqi]'")->select();
        }else{
            $luyan = M('Document_luyan')->where("riqi<'$today'")->order("id DESC")->limit("1")->select();
        }
        if (!$luyan) {
            $this->error("暂无路演！");
        }
        // yc_vp(M()->getlastsql());
        $info = D("Document")->detail($luyan[0][id]);
        $this->assign('info',$info);
        C("SEO_TITLE",$info[title]);
        $this->display();
    }

    //往期路演链接
    /*public function pastLuyan(){
        $this->display();
    }
    public function past02(){
        $this->display();
    }
    public function past03(){
        $this->display();
    }
    public function past04(){
        $this->display();
    }
    public function past05(){
        $this->display();
    }*/
}
?>