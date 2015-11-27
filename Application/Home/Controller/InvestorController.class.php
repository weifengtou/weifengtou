<?php

namespace Home\Controller;
use Think\Controller;

class InvestorController extends Controller{

	private $uid; //会员id
	private $iid; //成为申请人id
    private $datainfo; //申请人详细信息
    private $iden_status; //审核状态

     public function _initialize()
    {
        $user_auth = session('userinfo');
        if (!$user_auth) {
            header("location:index.php?s=Home/user/login");
        }
        $this->uid = $user_auth[id];
        $__detail = M('Investor')->where("uid = '$this->uid'")->limit("1")->select();
        $this->iid = $__detail[0][id] ;
        $this->iden_status = $__detail[0][iden_status] ;
        $count = count(M()->query($sql));
        if ($count>0) {
            $this ->datainfo = $__detail;
            $this->assign('info',$this ->datainfo);//注入注册信息
            $this->assign('user',M('homeuser')->where("id='$this->uid'")->select());
        }
        if ($this->iden_status>1){
            header("location:index.php?s=Home/Invcenter");
        }
    }

    public function index()
    {
        if (!$this->iden_status) {
            $save[style] = 2;
            $rows = M('homeuser')->where("id='$this->uid'")->save($save);
        }
        if ($this->iden_status==1) {
            header("location:index.php?s=Home/Investor/shenhe1");
        }
        if ($this->iden_status==0) {
            header("location:index.php?s=Home/Investor/investor01");
        }
        if ($this->iden_status==-1){
            header("location:index.php?s=Home/Investor/shenhe0");
        }
    }

    //审核中页面
    public function shenhe1()
    {
        $cases = M('inv_case')->where("inv_id='$this->iid'")->select();
        $this->assign('cases',$cases); //注入案例信息
        $cys = M('invmember')->where("iid='$this->iid'")->select();
        $this->assign('cys',$cys); //注入成员信息
        $this->display();
    }

    //审核不通过页面
    public function shenhe0()
    {
        $invdenymsg = M('invdenymsg')->where("iid='$this->iid'")->select();
        $this->assign('invdenymsg',$invdenymsg[0][denymsg]); //注入拒绝信息
        $cases = M('inv_case')->where("inv_id='$this->iid'")->select();
        $this->assign('cases',$cases); //注入案例信息
        $cys = M('invmember')->where("iid='$this->iid'")->select();
        $this->assign('cys',$cys); //注入成员信息
        $this->display();
    }

    //注册页面1
    public function investor01()
    {
        $this->area();              //获取地区
        if (IS_POST) {  
            // *****************************地区******************************************
            //获取省
            $Province = M('China');
            $map[id] = $_POST[sheng];
            $pres = $Province->where($map)->select();
            //获取市
            $City = M('China');
            $map[id] = $_POST[shi];
            $cres = $City->where($map)->select();
            //获取县
            $Town = M('China');
            $map[id] = $_POST[qu];
            $tres = $Town->where($map)->select();
            $data[shengid] = $_POST[sheng];   //省、自治区id
            $data[sheng] = $pres[0][name];     //省、自治区名
            $data[shiid] = $_POST[shi];       //市id
            $data[shi] = $cres[0][name];         //市名
            $data[quid] = $_POST[qu];          //县区
            $data[qu] = $tres[0][name];         //县、区名
            // **************************************************************************
            $data[type] = $_POST[type];
            $data[phone] = $_POST[phone];
            $data[realname] = I('post.realname');
            $data[introduce] = I('post.introduce');
            $data[sex] = $_POST[sex];
            $data[company] = I('post.company');
            $data[privacy] =  I('post.privacy');
            $data[iden_status] = 0;
            $data[uid] = $this->uid; 
            if ($this->iid) {
                $data[update_time] = time();
                M('investor')->where("id='$this->iid'")->save($data);
            }else{
                $data[add_time] = $data[update_time] = time();
                //第一次添加homeuser style=1
                // M()->startTrans();
                // $createid = M('investor')->data($data)->add();
                // $save[style] = 2;
                // $rows = M('homeuser')->where("id='$this->uid'")->save($save);
                // if ($createid&&$rows) {
                //     M()->commit();
                // }else{
                //     M()->rollback();
                // }
            }
            // header("location:index.php?s=home/investor/investor02");
            $xxx = 1;
            $xxxArr = json_encode($xxx);
            echo $xxxArr;
            exit();
        }
        $this->casesDisplay();
        $this->display();
    }

    //机构信息
    public function investorjigou()
    {
        if (IS_POST) {
            $data[id] = $this->iid;
            $data[jieduan] = $_POST[jieduan];
            $data[xingzhi] = $_POST[xingzhi];
            $data[leibie] = $_POST[leibie];
            $data[tdurl] = $_POST[tdurl];
            $data[tddetail] = $_POST[tddetail];
            if (M('Investor')->save($data)) {
                echo "1";
            }elseif(M('Investor')->where($data)->select()){
                echo "1";
            }else{
                $this->getError();
            }
            exit();
        }
        $this->assign('cys',M("Invmember")->where("iid = '$this->iid'")->select());
        $this->display();
    }

    //添加团队成员
    public function addcy()
    {
        if (IS_POST) {
            $data[iid] = $this->iid;
            $data[cyname] = $_POST[cyname];
            $data[cydetail] = $_POST[cydetail];
            $cy_id = M("Invmember")->data($data)->add();
            if ($cy_id) {
                $cyArr = M('Invmember')->where("id='$cy_id'")->select();
                echo json_encode($cyArr[0]);
            }
        }
        exit();
    }

    //删除团队成员
    public function delcy()
    {
        if (IS_POST) {
            $id = $_POST[cy_id];
            $isdel = M('Invmember')->delete($id);
            if ($isdel) {
                exit("1");
            }else{
                exit("删除失败!");
            }
        }
    }

    //注册页面2
    public function investor02()
    {
    	if (IS_POST) {
            $tradeid = $_POST[trade];
            foreach ($tradeid as $key=>$value) {
                $trade = M('Trade');
                $map[id] = $value;
                $result = $trade->where($map)->find();
                $tradeRes[$key] = $result[trade];
            }
            $data[intentionname] = implode('&nbsp;', $tradeRes);
            $data[tzidea] = I('post.tzidea');
            $data[intention] = implode(',',$_POST[trade]);
            $data[tz_num] = I('post.tz_num');
    		$data[income] = I('post.income');
    		$data[min_maney] = I('post.min_maney');
    		$data[max_maney] = I('post.max_maney');
    		M('investor')->where("uid='$this->uid'")->save($data);
    		// header("location:index.php?s=home/investor/investor03");
            $xxx = 1;
            $xxxArr = json_encode($xxx);
            echo $xxxArr;
            exit();

    	}
        $this->trade();
    	$this->display();
    }

    //注册页面3
    public function investor03()
    {
    	$this->display();
    }

    //上传图片
    public function upImg()
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
    }

    //名片 资料
    public function infoUp()
    {
        $dat = $this->upImg();
    	$data[inv_info] = $dat[thumbname];
    	M('investor')->where("id='$this->iid'")->save($data);
    	$dataArr = json_encode($data);
        echo $dataArr;
        exit;
    }

    //身份证正面
    public function fUp()
    {
    	$dat = $this->upImg();
    	$data[f_image] = $dat[thumbname];
    	M('investor')->where("id='$this->iid'")->save($data);
    	$dataArr = json_encode($data);
        echo $dataArr;
        exit;
    }

    //身份证反面
    public function bUp()
    {
    	$dat = $this->upImg();
    	$data[b_image] = $dat[thumbname];
    	M('investor')->where("id='$this->iid'")->save($data);
    	$dataArr = json_encode($data);
        echo $dataArr;
        exit;
    }

    //添加营业执照
    public function zhizhaoUp()
    {
        $dat = $this->upImg();
        $data[zhizhao] = $dat[thumbname];
        M('investor')->where("id='$this->iid'")->save($data);
        $dataArr = json_encode($data);
        echo $dataArr;
        exit;
    }

    //添加案例
    public function addCase()
    {
    	if (IS_POST) {
    		$sql = "SELECT id FROM __INVESTOR__ WHERE uid = '$this->uid'";
    		$count = count(M()->query($sql));
    		if ($count>0) {
    			$is_has_iid = M()->query($sql);
    			$this->iid = $is_has_iid[0][id];
    		}else{
                $userinfo = session('userinfo');
    			$is_has_iid[uid] = $userinfo[id];
                $is_has_iid[add_time] = $is_has_iid[update_time] = time();
                //第一次添加homeuser style=1
                M()->startTrans();
    			$this->iid = M('investor')->data($is_has_iid)->add();
                $save[style] = 2;
                $rows = M('homeuser')->where("id='$is_has_iid[uid]'")->save($save);
                if ($this->iid&&$rows) {
                    M()->commit();
                }else{
                    M()->rollback();
                }
    		}
    		$data[pname] = I('post.pname');
    		$data[purl] = I('post.purl');
    		$data[pdetail] = I('post.pdetail');
    		$data[inv_id] = $this->iid;
    		$case_id = M('inv_case')->data($data)->add();
    		if ($case_id) {
    			$caseArr = M('inv_case')->where("id='$case_id'")->select();
                echo json_encode($caseArr[0]);
                exit;
    		}else{
    			echo "error";
                exit;
    		}
    	}
    }

    //编辑案例
    public function editCase()
    {
        if (I('post.case_id')) {
            $id = I('post.case_id');
            $data[pname] = I('post.pname');
            $data[purl] = I('post.purl');
            $data[pdetail] = I('post.pdetail');
            if (M('inv_case')->where("id='$id'")->save($data)) {
                exit("修改成功");
            }else{
                exit("未修改");
            }
        }
    }

    //删除案例
    public function delCase()
    {
        if (IS_POST) {
            $id = $_POST[case_id];
            $isdel = M('inv_case')->delete($id);
            if ($isdel) {
                exit("1");
            }else{
                exit("删除失败!");
            }
        }
    }

    public function invApply()
    {
        if ($_POST) {
            $data[iden_status] = $_POST[iden_status];
            M('investor')->where("id='$this->iid'")->save($data);
            submit_remind(C('KEFU_EMAIL'),2,M('investor')->where("id='$this->iid'")->find());
        }
    }

    public function casesDisplay()
    {
        $cases = M('inv_case')->where("inv_id='$this->iid'")->select();
        $this->assign('cases',$cases);
    }
    public function choose(){
        $this->display();
    }
    //***********************地区2014-12-10***************************************************** 
    // 获取数据库地区
    //获取所有省
    public function area(){
        $area = M('China');                             
        $province = $area->where('pid=0')->select();
        //$this->assign('province',$province);
        $this->assign('allprovince',$province);
    }
    //获取所有二级城市
    public function province(){
        $id = $_GET[areaid]; 
        $area = M('China'); 
        $map[pid] = $id;
        $result = $area->where($map)->order('id')->select();
        $resultArr = json_encode($result);
        echo($resultArr);
    }  
    //获取所有三级城市
    public function city(){
        $id = $_GET[areaid]; 
        $area = M('China'); 
        $map[pid] = $id;
        $result = $area->where($map)->select();
        $resultArr = json_encode($result);
        echo($resultArr);
    } 
    //获取所有一级行业
    public function trade(){
        $trade = M('Trade');
        $fathertrade = $trade->where('pid=0')->select();
        $this->assign('alltrade',$fathertrade); 
    }
    //***************************************************************************** 
}

?>