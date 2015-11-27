<?php

namespace Home\Controller;
use Think\Controller;

class ProjectController extends UserController{

	private $pros; //项目列
	private $homeuser; //用户信息
	private $pruser; //用户详细
	private $proInfo; //项目详情

	private $userinfo; //登录人

	//初始化 获取$pros
	public function _initialize(){
		// yc_vp(1,1);
		parent::loginStyle();
		if ($this->loginStyle==1||$this->loginStyle==2) {
			$this->assign('loginInfo',get_homeuser_detail($this->uid)); //注入登录人详细信息
			$this->userinfo = session('userinfo');
			$this->assign('userinfo',$this->userinfo); //登录人
		}	
		$Project = M('Project');

		if (I("get.renzheng")=="other") {
			$this->where = "wft_project.prrate = 1";
		}else{
			$this->where = "wft_project.prrate > 1";
		}
		$sql = "SELECT
			wft_project.id,
			wft_project.pjname,
			wft_project.pjintroduce,
			wft_project.stageid,
			wft_project.prrate,
			wft_financingneeds.budget,
			sum(wft_financing.money) AS money,
			wft_financingneeds.privacyset,
			wft_project.logo,
			wft_prrate.prrateimg
			FROM
			wft_project 
			LEFT JOIN
			wft_financingneeds ON  wft_project.id = wft_financingneeds.prid 
			LEFT JOIN
			wft_financing ON wft_project.id = wft_financing.prid
			LEFT JOIN 
			wft_prrate ON wft_project.prrate = wft_prrate.prrateid
			WHERE 
			".$this->where." AND wft_project.status > 0
			GROUP BY
			wft_project.id 
			ORDER BY 
			wft_project.review_time DESC";
			/* wft_project.order_id,wft_project.id DESC"; */
		$this->pros = $Project->query($sql); //注入项目列
		//注入项目进度表
		$this->assign('prrates',M('prrate')->select());
		//注入数量
		$c3 = $c4 = $c5 = 0;
        foreach ($this->pros as $key => $value) {
            if ($value[prrate]==2) {
                $c3 = $c3 + 1;
            }
            if ($value[prrate]==3) {
                $c4 = $c4 + 1;
            }
            if ($value[prrate]==4) {
                $c5 = $c5 + 1;
            }
        }
        $cs[t] = count($this->pros);
        $cs[3] = $c3;
        $cs[4] = $c4;
        $cs[5] = $c5;
        $this->assign('cs',$cs);
	}

    //进入项目首页
	public function project(){
		C("TITLE","创业好项目_实体项目_项目融资_小微实体企业融资-微风投");
        C("KEYWORDS","好项目、投资好项目、项目融资、融资、企业融资,中小企业融资");
        C('DESCRIPTION',"微风投是中国首家专注于小微实体企业融资的创业服务平台。微风投好项目都是微风投专业团队经过线下实地考察、精心筛选、严格审核的优质好项目，最大化保障投资人利益。项目融资、小微实体企业融资就上微风投！ ");
		//根据进度筛选项目
		if ($_GET[prrateid]) {
			$sql = "SELECT
				wft_project.id,
				wft_project.pjname,
				wft_project.pjintroduce,
				wft_project.stageid,
				wft_project.prrate,
				wft_financingneeds.budget,
				sum(wft_financing.money) AS money,
				wft_financingneeds.privacyset,
				wft_project.logo,
				wft_prrate.prrateimg
				FROM 
				wft_project 
				LEFT JOIN 
				wft_financingneeds ON  wft_project.id = wft_financingneeds.prid 
				LEFT JOIN 
				wft_financing ON wft_project.id = wft_financing.prid
				LEFT JOIN 
				wft_prrate ON wft_project.prrate = wft_prrate.prrateid
				WHERE 
				wft_project.prrate > 1 AND wft_project.prrate = '$_GET[prrateid]' AND wft_project.status > 0
				GROUP BY
				wft_project.id
				ORDER BY 
				wft_project.order_id,wft_project.id DESC";
			$this->pros = M()->query($sql); //注入项目列
		}
		foreach ($this->pros as $key => $value) {         //获取进度条宽度
			$widths[$key][width] = round($value[money]/$value[budget]*317);
		}
		$arr = array();
		foreach ($this->pros as $key => $r) {
		 	$arr[] = array_merge($r,$widths[$key]);
		}
		$this->assign('prrateid',$_GET[prrateid]);
		$this->assign('project',$arr);
		// $this->display("Project1/xmxq");
		$this->display();
	}

	//项目详细页
	public function prdetail(){
		C("SEO_TITLE","项目详情");
		if ($_GET[pid]) {
			// $proInfo = M('project')->where("id='$_GET[pid]'")->select();
			$proInfo = get_child_detail($_GET[pid],1);
			$this->assign('proInfo',$proInfo);//项目详细
			$this->getUserInfo($proInfo[0][pid]);
			$companyInfo = M('companydata')->where("prid='$_GET[pid]'")->select();
			$this->assign('companyInfo',$companyInfo); //公司详细
			$primages = M("primages")->where("prid='$_GET[pid]'")->select();
			$this->assign('primages',$primages);//项目图片
			// $this->getPostInf($_GET[pid]);
			if (APP_DEBUG) {
				$this->assign('cmts',M('Comment')->where("cmtedid='$_GET[pid]'")->select()); //注入评价
			}else{
				$this->assign('cmts',M('Comment')->where("cmtedid='$_GET[pid]' AND cmtid!='$this->POS_uid'")->group("cmtid")->select()); //注入评价
			}
			// yc_vp(M()->getlastsql());
			$attentions = M("attention")->where("atted_childid='$_GET[pid]'")->select();
			$this->assign('attentions',$attentions);//关注
			$webmsgs = M('webmsg')->where("receiveid='$_GET[pid]'")->select();
			$this->assign('webmsgs',$webmsgs);//约谈
			$prmembers = M('prmember')->where("prid='$_GET[pid]'")->order('id')->select();
			$this->assign('prmembers',$prmembers); //团队成员
			$prcreater = M('prmember')->where("prid='$_GET[pid]' && memberroleid = 0")->order('id')->select();
			$this->assign('prcreater',$prcreater); //项目创建人
			$fin_needs = M('financingneeds')->where("prid='$_GET[pid]'")->limit("1")->select();
			$this->assign('fin_needs',$fin_needs); // 融资需求信息
			$fins = M('financing')->where("prid='$_GET[pid]'")->select();
			$this->assign('fins',$fins); //注入融资列
			if (APP_DEBUG) {
				$this->display("Project1/xmxq");
				// $this->display();
			}else{
				$this->display("Project1/xmxq");
				// $this->display();
			}
		}
	}

	//获取用户详细
	public function getUserInfo($pid)
	{
		$homeuser = $this->homeuser = M('homeuser')->where("id='$pid'")->select();
		$pruser = $this->pruser = M('pruser')->where("uid='".$homeuser[0][id]."'")->select();
		$this->assign('homeuser',$homeuser);//项目人
		$this->assign('pruser',$pruser);//项目人详细
	}

	private function getPostInf($pid)
	{
		$POS_proinfo = $this->POS_proinfo = M('Project')->where("id='$pid'")->select();
		$this->POS_uid = $POS_proinfo[0][pid];
		$this->POS_pruser = M('Pruser')->where("uid='$this->POS_uid'")->select();
	}

	//关注
	public function attention()
	{
		if (IS_POST) {
			$pid = $_POST[pid];
			$this->getPostInf($pid);
			$type = $_POST[type];
			$userinfo = session('userinfo');
			$uid = $this->uid;
			//已经关注判断
			$isHas = M('attention')->where("uid='$uid' AND atted_id='$this->POS_uid' AND atted_childid='$pid'")->select();
			// $isHas = M('attention')->where("uid='$uid' AND atted_id='$this->POS_uid'")->select();
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
			$data[attd_style] = 1;
			$data[atted_childid] = $pid;
			$data[att_time] = time();
			$attId = M('attention')->data($data)->add();
			if ($attId) {
				echo "关注成功！";
			}else{
				echo "失败！";
			}
		}
	}
	//取消关注
	public function delAtt()
	{
		if ($pid = I('post.pid')) {
			$x = M('attention')->where("uid='$this->uid' AND atted_childid='$pid'")->delete();
			if ($x==1) {
				echo "取消成功!";
			}else{
				echo "取消失败!";
			}
		}
	}

	//站内信
	public function isWebMsgYou()
	{
		if (IS_POST) {
			$userinfo = session('userinfo');
			$this->getPostInf($_POST[pid]);
			$data[sendid] = $this->uid;
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
			$userinfo = session('userinfo');
			$this->getPostInf($_POST[pid]);
			$data[sendid] = $this->uid;
			$data[yt_style] = $this->loginStyle;
			$data[receiveuid] = $this->POS_uid;
			$data[ytd_style] = 1;
			$data[receiveid] = $_POST[pid];
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

	//是否已经投递
	public function isDeli()
	{
		if (IS_POST) {
			$iid = $_POST[iid];
			$userinfo = $this->userinfo;
			$p_uid = $this->uid;
			$delis = M('prodelivery')->where("iid='$iid' AND p_uid='$p_uid'")->select();
			// echo M()->getlastsql();
			if(count($delis)>0){
				exit("1");
			}else{
				exit("0");
			}
		}
	}

	//投递项目
	public function deliveryPro()
	{
		$userinfo = $this->userinfo;
			$sql = "SELECT
			wft_project.id,
			wft_project.pjname,
			wft_project.pjintroduce,
			wft_project.stageid,
			wft_financingneeds.budget,
			sum(wft_financing.money) AS money,
			wft_financingneeds.privacyset,
			wft_project.logo
			FROM
			wft_project 
			LEFT JOIN
			wft_financingneeds ON  wft_project.id = wft_financingneeds.prid 
			LEFT JOIN
			wft_financing ON wft_project.id = wft_financing.prid
			WHERE
			wft_project.pid='$this->uid' AND wft_project.prrate > 1
			GROUP BY
			wft_project.id
			ORDER BY 
			wft_project.order_id,wft_project.id DESC
		";
		if (IS_POST) {
			$this->getPostInf($_POST[pid]);
			$data[iid] = $_POST[iid];
			$data[p_uid] = $this->uid;
			$data[pid] = $_POST[pid];
			$data[msg] = I('post.val','','htmlspecialchars');
			$data[create_time] = time();
			$data[status] = 1; //已提交
			M('prodelivery')->data($data)->add();
			exit("提交成功");
		}
		$userPros = M()->query($sql);
		$this->assign('userPros',$userPros);
		if ($_GET[iid]) {
			$this->assign('iid',$_GET[iid]);
			$this->display();
		}
	}

	//评论
	public function pingLun()
	{
		$userinfo = $this->userinfo;
		if (IS_POST) {
			$this->getPostInf($_POST[pid]);
			$data[cmtid] = $this->uid;
			$data[cmt_style] = $this->loginStyle;
			$data[cmtedid] = $_POST[pid];
			$data[cmtd_style] = 1;
			$POS_pruser = $this->POS_pruser;
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
			$data[cmtd_style] = 1;
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
	public function hui_fu()
	{
		if (IS_POST) {
			$data = $_POST[data];
			$data[cmtid] = $this->uid;
			$data[cmt_style] = $this->loginStyle;
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

	//预约出资
	public function chuZi(){
		$userinfo = $this->userinfo;
		$investor = M("investor")->where("uid='$this->uid'")->select();
		if (IS_POST) {
			if ($investor[0][iden_status]<2) {
				exit("2");
			}
			$this->getPostInf($_POST[pid]);
			$data[iid] = $investor[0][id];
			$data[pid] = $_POST[pid];
			$data[prid] = $_POST[prid];
			$data[cz_maney] = $_POST[cz_maney];
			$data[cz_msg] = I('post.cz_msg','','htmlspecialchars');
			$data[cz_time] = time();
			$data[cz_status] = 1;
			$isHas = M("chuzi")->where("iid='$data[iid]' AND prid='$data[prid]'")->select();
			if ($isHas) {
				$id = M("chuzi")->where("iid='$data[iid]' AND prid='$data[prid]'")->save($data);
				$id=$isHas;
			}else{
				$id = M("chuzi")->data($data)->add();
			}
			if ($id) {
				exit("1");
			}else{
				exit("0");
			}
		}
	}
	// ****************************2014-12-17************************************
	// 筛选
	public function selectResult(){
		C("SEO_TITLE","好项目");
		if (I("get.area")) {
			$this->area = I("get.area");
			$this->area = " AND wft_project.cityid = ".I("get.area");
		}else{
			$this->area = '';
		}
		if (I("get.trade")) {
			$this->trade = I("get.trade");
			$this->trade = " AND wft_project.fathertradeid = ".I("get.trade");
		}else{
			$this->trade = '';
		}
		$sql = "SELECT
			wft_project.id,
			wft_project.pjname,
			wft_project.pjintroduce,
			wft_project.stageid,
			wft_project.prrate,
			wft_financingneeds.budget,
			sum(wft_financing.money) AS money,
			wft_financingneeds.privacyset,
			wft_project.logo,
			wft_prrate.prrateimg
			FROM
			wft_project 
			LEFT JOIN
			wft_financingneeds ON  wft_project.id = wft_financingneeds.prid 
			LEFT JOIN
			wft_financing ON wft_project.id = wft_financing.prid
			LEFT JOIN 
			wft_prrate ON wft_project.prrate = wft_prrate.prrateid
			WHERE 
			".$this->where.$this->area.$this->trade." AND wft_project.status > 0
			GROUP BY
			wft_project.id
			ORDER BY 
			wft_project.order_id,wft_project.id DESC";
				
		$this->pros = M()->query($sql); //注入项目列
		foreach ($this->pros as $key => $value) {         //获取进度条宽度
			$widths[$key][width] = round($value[money]/$value[budget]*317);
		}
		$arr = array();
		foreach ($this->pros as $key => $r) {
		 	$arr[] = array_merge($r,$widths[$key]);
		}
		$this->assign('area',$_GET[area]);
		$this->assign('trade',$_GET[trade]);
		$this->assign('project',$arr);
		$this->display('project');
	}
	// **************************************************************************

}

?>