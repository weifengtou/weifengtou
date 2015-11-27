<?php
namespace Home\Controller;
use Think\Controller;
/**
* 投资人home页面
*/
class InvhomeController extends UserController
{
	private $invs; //列出投资人
	private $homeuser; //用户信息
	private $investor; //投资人信息

	private $userinfo; //登录人
	
	public function _initialize()
	{
		parent::loginStyle();
		if ($this->loginStyle==1||$this->loginStyle==2) {
			$this->assign('loginInfo',get_homeuser_detail($this->uid)); //注入登录人详细信息
			$this->userinfo = session('userinfo');
			$this->assign('userinfo',$this->userinfo); //登录人
		}
		$x1 = M()->query('SELECT COUNT(*) AS c FROM wft_investor WHERE wft_investor.iden_status > 1 AND type = 1');
		$x2 = M()->query('SELECT COUNT(*) AS c FROM wft_investor WHERE wft_investor.iden_status > 1 AND type = 2');
		$this->assign('x1',$x1[0][c]); //注入个人投资者数目
		$this->assign('x2',$x2[0][c]); //注入机构投资者数目
	}

	//列出投资人
	public function getInvs($where)
	{
		if (!$where):
			$sql = "SELECT
	            wft_investor.id
	            FROM
	            wft_investor
	            WHERE 
	            wft_investor.iden_status > 1
	            ORDER BY 
	            face_img DESC , wft_investor.iden_status DESC , id DESC";
		else:
			$sql = "SELECT
	            wft_investor.id
	            FROM
	            wft_investor
	            WHERE ".$where."
	            AND wft_investor.iden_status > 1
	            ORDER BY 
	            wft_investor.iden_status DESC , id DESC";
		endif;
		$invs = $this->invs = M()->query($sql);
		$this->assign('invs',$invs);
	}

	//获得投资人详细资料
	public function getInvInfo($uid)
	{
		// $homeuser = $this->homeuser = M('homeuser')->where("id='$uid'")->select();
		$homeuser = $this->homeuser = get_homeuser_detail($uid);
		$investor = $this->investor = M('investor')->where("uid='$uid'")->select();
		// $investor = $this->investor = get_child_detail($investor[0][id],2);
		$this->assign('homeuser',$this->homeuser);
		$this->assign('investor',$this->investor); 
		// 查询已投项目数
		$financing = M('Financing');
		$numpr = $financing->where("pid = '$uid'")->field('prid')->group('prid')->select();
		$this->assign('numpr',count($numpr));
		//	查询投资总额
		$allmoney = $financing->where("pid = '$uid'")->sum('money');
		$m = number_format($allmoney);  //通过千位分组来格式化数字
		$this->assign('allmoney',$m);

		$this->getPostInf($investor[0][id]);
		$this->assign('cmts',M('Comment')->where("cmtedid='".$investor[0][id]."' AND cmtid!='$this->POS_uid'")->group("cmtid")->select()); //注入评价
		// yc_vp(M()->getlastsql());
		$this->assign('inv_cases',M('inv_case')->where("inv_id='".$investor[0][id]."'")->select()); //注入案例
		//注入关注信息
	}

	private function getPostInf($iid)
	{
		$POS_invinfo = $this->POS_invinfo = M('investor')->where("id='$iid'")->select();
		$this->POS_uid = $POS_invinfo[0][uid];
	}

	public function index()
	{
		#
	}

	//展示所有投资人
	public function investors()
	{
		C("TITLE","投资人_天使投资人-微风投");
        C("KEYWORDS","投资人,投资,天使投资,天使投资人，项目投资");
        C('DESCRIPTION',"微风投是中国首家专注于小微实体企业融资的创业服务平台。微风投聚集了大量的优秀投资人及资源丰富的天使投资人，他们是行业精英，是业内翘楚，成为投资人，与他们一起共享行业资源，获取他们背后的经验、资源、智慧。投资找项目、项目找资金就上微风投！");
        if ($_GET[type]) {
        	$where = "type='$_GET[type]'";
        }
		$this->getInvs($where);
		
		$this->display();
	}

	//显示投资人信息
	public function invDisplay()
	{
		C("SEO_TITLE","投资人详情");
		if (!$_GET[uid]) {
			$this->error("非法访问！");
		}else{
			$this->getInvInfo($_GET[uid]);
		}
		if (APP_DEBUG) {
			$this->display("Invhome1/tzxq");
		}else{
			$this->display("Invhome1/tzxq");
			// $this->display();
		}
	}

	//关注
	public function attention()
	{
		if (IS_POST) {
			$iid = $_POST[iid];
			$this->getPostInf($_POST[iid]);
			$type = $_POST[type];
			$userinfo = session('userinfo');
			$uid = $userinfo[id];
			//已经关注判断
			$isHas = M('attention')->where("uid='$uid' AND atted_id='$this->POS_uid' AND atted_childid='$iid'")->select();
			if ($isHas) {
				echo "已关注！";
				exit;
			}
			//关注自身判断
			if ($this->POS_uid==$uid) {
				echo "不能关注自己！";
				exit;
			}
			//关注
			$data[uid] = $uid;
			$data[att_style] = $this->loginStyle;
			$data[atted_id] = $this->POS_uid;
			$data[attd_style] = 2;
			$data[atted_childid] = $iid;
			$data[att_time] = time();
			$attId = M('attention')->data($data)->add();
			if ($attId) {
				echo "关注成功！";
			}else{
				echo "失败！";
			}
			exit;
		}
	}
	//取消关注
	public function delAtt()
	{
		if ($iid = I('post.iid')) {
			$x = M('attention')->where("uid='$this->uid' AND atted_childid='$iid'")->delete();
			echo M()->getlastsql();
			exit($x);
		}
	}

	//站内信
	public function isWebMsgYou()
	{
		if (IS_POST) {
			$this->getPostInf($_POST[iid]);
			$userinfo = session('userinfo');
			$data[sendid] = $userinfo[id];
			//判断发送人是否是自己
			if ($data[sendid]==$this->POS_uid) {
				echo "不能对自己发送！";
				exit;
			}
		}
	}
	public function webMsg()
	{
		if (IS_POST) {
			$this->getPostInf($_POST[iid]);
			$userinfo = session('userinfo');
			$data[sendid] = $userinfo[id];
			$data[yt_style] = $this->loginStyle;
			$data[receiveid] = $_POST[iid];
			$data[ytd_style] = 2;
			$data[receiveuid] = $this->POS_uid;
			$data[webmsg] = I('post.val','','htmlspecialchars');
			$data[sendtime] = time();
			//判断发送人是否是自己
			if ($data[sendid]==$this->POS_uid) {
				echo "不能对自己发送！";
				exit;
			}
			$webmsgId = M('webmsg')->data($data)->add();
			if ($webmsgId) {
				echo "发送成功！";
			}else{
				echo "发送失败！";
			}
			exit;
		}
	}

	//评论
	public function pingLun()
	{
		$userinfo = $this->userinfo;
		if (IS_POST) {
			$this->getPostInf($_POST[iid]);
			$data[cmtid] = $userinfo[id];
			$data[cmt_style] = $this->loginStyle;
			$data[cmtedid] = $_POST[iid];
			$data[cmtd_style] = 2;
			$data[cmteduid] = $this->POS_uid;
			$data[cmtmsg] = I('post.pingjia','','htmlspecialchars');
			$data[cmt_time] = time();
			if ($data[cmtid]==$data[cmteduid]) {
				exit("2");
			}
			$isPingLun = M('comment')->data($data)->add();
			if ($isPingLun) {
				exit("1");
			}else{
				exit("0");
			}
		}
	}

	//回复
	public function huifu(){
		if ($_POST) {
			$data[cmtid] = $_POST[cmtid];
			$data[cmteduid] = $_POST[cmteduid];
			$data[cmtedid] = $_POST[cmtedid];
			$data[cmtd_style] = 2;
			$data[cmtmsg] = I('post.cmtmsg','','htmlspecialchars');
			$data[cmt_time] = time();
			$id = M('comment')->data($data)->add();
			if ($id) {
				echo "1";
			}else{
				echo "0";
			}
		}
	}

	// ****************************2014-12-17************************************
	// 热门行业地区筛选
	public function selectResult(){
		C("SEO_TITLE","投资人");
		if(empty($_GET[trade])&&!empty($_GET[area])){		//热门地区的所有行业
			$sql = "SELECT
            wft_investor.id
            FROM
            wft_investor
            WHERE 
            wft_investor.iden_status > 1 AND wft_investor.shiid = '$_GET[area]'";
		}else if(!empty($_GET[trade])&&empty($_GET[area])){		//所有地区的热门行业
			$sql = "SELECT
            wft_investor.id
            FROM
            wft_investor
            WHERE 
            wft_investor.iden_status > 1 AND wft_investor.intention LIKE '%$_GET[trade]%'";
           
		}else if(empty($_GET[trade])&&empty($_GET[area])){ 		//所有地区的所有行业
			$sql = "SELECT
            wft_investor.id
            FROM
            wft_investor
            WHERE 
            wft_investor.iden_status > 1";
		}else{											//热门地区的热门行业
			$sql = "SELECT
            wft_investor.id
            FROM
            wft_investor
            WHERE 
            wft_investor.iden_status > 1 AND wft_investor.shiid = '$_GET[area]' AND wft_investor.intention LIKE '%$_GET[trade]%'";
		}

		$this->assign('area',$_GET[area]);
		$this->assign('trade',$_GET[trade]);
		$invs = $this->invs = M()->query($sql);
		$this->assign('invs',$invs);
		$this->display('investors');
	}
	// ****************************************************************************************
}