<?php 

namespace Home\Controller;
use Think\Controller;

class PrcenterController extends UserController{

	public $userinfo; //登录人homeuser详细信息
	public $pruser; //项目创建者详细
	public $pros; //项目
	public $atts; //关注

	/**
	 *  初始化详细信息 并注入模板 
	 */
	public function _initialize()
	{
		parent::loginStyle();
		if (!session('userinfo')) {
            header("location:?s=Home/User/login");
        }
        $userinfo = $this->userinfo = session('userinfo');
        // $this->uid = $userinfo[id];
        $this->assign('userinfo',$userinfo); //登录人homeuser详细信息

        $sql = "SELECT
			wft_homeuser.email,
			wft_pruser.face_img,
			wft_pruser.realname,
			wft_pruser.phone,
			wft_pruser.sex,
			wft_pruser.sheng,
			wft_pruser.shi,
			wft_pruser.qu,
			wft_pruser.shengid,
			wft_pruser.shiid,
			wft_pruser.quid,
			wft_pruser.qq,
			wft_pruser.weibo
			FROM
			wft_pruser
			INNER JOIN wft_homeuser ON wft_pruser.uid = wft_homeuser.id
			WHERE 
			uid='$this->uid'";
        $pruser = $this->pruser = M()->query($sql);
        $this->assign('pruser',$pruser); //项目创建者详细

        $sql = "SELECT
			wft_attention.atted_id,
			wft_attention.atted_childid,
			wft_attention.att_time,
			'投资人' AS attd_style_name,
			wft_homeuser.username AS name,
			concat('./Uploads/Investor/',wft_investor.face_img) AS img,
			concat('?s=Home/Invhome/invDisplay&uid=',wft_homeuser.id) AS url
			FROM
			wft_attention
			LEFT JOIN wft_homeuser ON wft_attention.atted_id = wft_homeuser.id
			INNER JOIN wft_investor ON wft_attention.atted_childid = wft_investor.id
			WHERE 
			wft_attention.uid='$this->uid' AND attd_style=2
			UNION 
			SELECT
			wft_attention.atted_id,
			wft_attention.atted_childid,
			wft_attention.att_time,
			'项目' AS attd_style_name,
			wft_project.pjname AS name,
			concat('./Uploads/Album/',wft_project.logo) AS img,
			concat('?s=Home/project/prdetail&pid=',wft_project.id) AS url
			FROM
			wft_attention
			INNER JOIN wft_project ON wft_attention.atted_childid = wft_project.id
			WHERE 
			wft_attention.uid='$this->uid' AND wft_attention.attd_style = 1";
		$this->assign('atts',M()->query($sql)); //关注

		$sql = "SELECT
			wft_attention.uid,
			-- wft_attention.att_style,
			-- wft_investor.id,
			-- wft_investor.face_img,
			-- wft_homeuser.username,
			wft_attention.att_time
			FROM
			wft_attention
			-- LEFT JOIN wft_homeuser ON wft_attention.uid = wft_homeuser.id
			-- LEFT JOIN wft_investor ON wft_attention.uid = wft_investor.uid
			WHERE
			wft_attention.atted_id='$this->uid' 
			GROUP BY 
			wft_attention.uid";
		$this->assign('fans',M()->query($sql)); //粉丝

        $toudis = M("prodelivery")->where("p_uid='".$this->uid."'")->select();
		$this->assign("toudis",$toudis); //投递

		/*$sql = "SELECT
			wft_comment.id,
			wft_comment.cmtid,
			wft_comment.cmt_style,
			wft_comment.cmteduid,
			wft_comment.cmtd_style,
			wft_comment.cmtedid,
			wft_comment.cmtmsg,
			wft_comment.cmt_time,
			wft_homeuser.username,
			concat('./Uploads/Investor/',wft_investor.face_img) AS img,
			concat('?s=Home/Invhome/invDisplay&uid=',wft_homeuser.id) AS url
			FROM
			wft_comment
			LEFT JOIN wft_homeuser ON wft_comment.cmteduid = wft_homeuser.id
			LEFT JOIN wft_investor ON wft_comment.cmtedid = wft_investor.id
			WHERE  
			wft_comment.cmtid='$this->uid' 
			AND 
			wft_comment.cmtd_style=2 
			UNION 
			SELECT 
			wft_comment.id,
			wft_comment.cmtid,
			wft_comment.cmt_style,
			wft_comment.cmteduid,
			wft_comment.cmtd_style,
			wft_comment.cmtedid,
			wft_comment.cmtmsg,
			wft_comment.cmt_time,
			wft_homeuser.username,
			concat('./Uploads/Album/',wft_project.logo) AS img,
			concat('?s=Home/project/prdetail&pid=',wft_project.id) AS url
			FROM
			wft_comment
			LEFT JOIN wft_homeuser ON wft_comment.cmteduid = wft_homeuser.id
			LEFT JOIN wft_project ON wft_comment.cmtedid = wft_project.id
			WHERE  
			wft_comment.cmtid='$this->uid' 
			AND 
			wft_comment.cmtd_style=1 ";
		$this->assign('cmts',M()->query($sql)); //评论*/
		$this->assign('cmtedids',M('Comment')->field("cmtedid,cmtd_style")->where("cmtid='$this->uid'")->group("cmtedid")->select());//评论

		$sql = "SELECT
			CASE wft_webmsg.sendid 
				WHEN '$this->uid' THEN wft_webmsg.receiveuid 
			ELSE wft_webmsg.sendid END AS other,

			CASE wft_webmsg.sendid 
				WHEN '$this->uid' THEN wft_webmsg.ytd_style
			ELSE wft_webmsg.yt_style END AS other_style
			FROM `wft_webmsg`
			WHERE 
			sendid = '$this->uid' OR receiveuid = '$this->uid'
			GROUP BY other";
		$this->assign('yt_count_user',$this->yt_count_user = M()->query($sql));//注入约谈人数
		// echo M()->getlastsql();
		
        $sql = "SELECT
			wft_project.id,
			wft_project.pjname,
			wft_project.pjintroduce,
			wft_project.stageid,
			wft_financingneeds.budget,
			sum(wft_financing.money) AS money,
			wft_project.logo
			-- atts.att_count
			FROM
			wft_project 
			LEFT JOIN
			wft_financingneeds ON  wft_project.id = wft_financingneeds.prid 
			LEFT JOIN
			wft_financing ON wft_project.id = wft_financing.prid
			-- LEFT JOIN
			-- (SELECT
			-- 	count(id) AS att_count,
			-- 	wft_attention.atted_childid
			-- 	FROM `wft_attention`
			-- 	GROUP BY
			-- 	wft_attention.atted_childid)
			-- AS atts ON wft_project.id = atts.atted_childid
			WHERE
			wft_project.pid='$this->uid'
			GROUP BY
			wft_project.id 
		";
		$this->pros = M()->query($sql);
		$this->assign('pros',$this->pros); //项目
	}

	/**
	 *  首页 
	 */
	public function index()
	{
		header("location:?s=home/prcenter/baseinfo");
	}
	/**
	 *  基本信息 
	 */
	public function baseinfo(){		
		$this->display();
	}
	/**
	 *  动态 
	 */
	public function dongtai(){		
		$this->display();
	}

	/**
	 *  创建项目 
	 */
	public function createproject(){	
		$this->display();
	}

	/**
	 *  已创建项目 
	 */
	public function createdproject(){  
		$this->display();
	}

	/**
	 *  还款提醒 
	 */
	public function huankuangtixing()
	{
		$this->display();
	}

	/**
	 *  投递记录 
	 */
	public function touDi()
	{
		$this->display();
	}

	/**
	 *  评论 
	 */
	public function pinglun(){	
		$sql = "";	
		$this->display();
	}

	/**
	 *  约谈 
	 */
	public function webMsg()
	{
		$sql = "SELECT
			wft_webmsg.id,

			CASE wft_webmsg.sendid 
				WHEN '$this->uid' THEN '1'
			ELSE '-1' END AS send_style,

			CASE wft_webmsg.sendid 
				WHEN '$this->uid' THEN wft_webmsg.sendid 
			ELSE wft_webmsg.receiveuid END AS you,

			CASE wft_webmsg.sendid 
				WHEN '$this->uid' THEN wft_webmsg.receiveuid 
			ELSE wft_webmsg.sendid END AS other,

			CASE wft_webmsg.sendid 
				WHEN '$this->uid' THEN wft_webmsg.ytd_style
			ELSE wft_webmsg.yt_style END AS other_style,

			wft_webmsg.webmsg,
			wft_webmsg.sendtime
			FROM `wft_webmsg`
			WHERE 
			sendid = '$this->uid' OR receiveuid = '$this->uid'";
		$this->assign('yts',M()->query($sql));//注入约谈
		$this->display();
	}
	public function quickreply()
	{
		if (IS_POST) {
			$data[sendid] = $this->uid;
			$data[yt_style] = 1;
			$data[receiveuid] = $_POST[receiveuid];
			$data[ytd_style] = $_POST[ytd_style];
			$data[webmsg] = I('post.webmsg',''.'htmlspecialchars');
			$data[sendtime] = time();
			// yc_vp($data,1);
			if (M("webmsg")->data($data)->add()) {
				echo "回复成功";
			}else{
				echo "回复失败";
			}
		}
		exit;
	}
	/**
	 *  关注 
	 */
	public function guanzhu(){		
		$this->display();
	}
	/**
	 *  粉丝 
	 */
	public function fans(){		
		$this->display();
	}

	/**
	 *  编辑 
	 */
	public function bianJi()
	{
		if (IS_POST) {
			// *********************************************************
			//获取省
            $Province = M('China');
            $pmap['id'] = $_POST['sheng'];
            $pres = $Province->where($pmap)->select();
            //获取市
            $City = M('China');
            $cmap['id'] = $_POST['shi'];
            $cres = $City->where($cmap)->select();
            //获取县
            $Town = M('China');
            $tmap['id'] = $_POST['qu'];
            $tres = $Town->where($tmap)->select();
            $data[shengid] = $_POST['sheng'];   //省、自治区id
            $data[sheng] = $pres[0][name];     //省、自治区名
            $data[shiid] = $_POST['shi'];       //市id
            $data[shi] = $cres[0][name];         //市名
            $data[quid] = $_POST['qu'];          //县区
            $data[qu] = $tres[0][name];         //县、区名
            // **********************************************************
			$data[face_img] = $_POST[face_img];
			$data[phone] = $_POST[phone];
			$data[realname] = I('post.realname','','htmlspecialchars');
			$data[sex] = $_POST[sex];
			$data[qq] = $_POST[qq];
			$data[weibo] = $_POST[weibo];
			$userinfo = $this->userinfo;
			$map[uid] = $this->uid;
			$issave = M('pruser')->where($map)->save($data);
			if (!$issave) {
				$issave = M('pruser')->where($map)->select();
				if ($issave) {
					echo "没有更改信息！";
					exit;
				}
				$data[uid] = $this->uid;
				$issave = M('pruser')->data($data)->add();
			}
			// exit;
			if ($issave) {
				echo "修改成功";
				exit;
			}else{
				exit("修改失败");
			}
		}
		$this->province();
		$this->trade();
		$this->display();
	}

	/**
	 *  上传图片 
	 */
	public function upImg()
    {
    	$upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 1024*1024*2 ;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->autoSub = false;
        $upload->savePath = './Album/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload->saveName = $fileName;
        $info = $upload->upload();
        // 上传文件
        if ($info) {
            $savename = $info[upImg][savename];
            $oldname = $info[upImg][name];
            $image = new \Think\Image(); 
            $image->open('./Uploads/Album/'.$info[upImg][savename]);
            $thumbname = "thumb_".$savename;
            $image->thumb(220,220)->save('./Uploads/Album/'.$thumbname);
            $data[name] = $info[upImg][savename];
            $data[thumbname] = $thumbname;
        	return $data;
        }else{
            $upload->getError();
        }
    }

    /**
     *  更换图片并显示 
     */
	public function txup()
	{
		if (IS_POST) {
			$info = $this->upImg();
			$data[face_img] = $info[thumbname];
			echo $data[face_img] ;
	        exit;
		}
	}
	/**
	 *  编辑已创建项目 
	 */
	public function predit01(){
		$prid = $_GET[prid];
		$map[id] = $prid;
		$Project = M('Project');						//获取基本资料
		$prresult = $Project->where($map)->find();
		$this->assign(prid,$prresult[id]);
        $this->assign(name,$prresult[pjname]);
        $this->assign(linkman,$prresult[linkman]);
        $this->assign(phone,$prresult[prphone]);
        $this->assign(introduce,$prresult[pjintroduce]);
        $this->assign(videoweb,$prresult[videoweb]);
        if($prresult[stageid]==1){
            $this->assign(stage,'起步阶段');
        }else if($prresult[stageid]==2){
            $this->assign(stage,'盈利阶段');
        }else if($prresult[stageid]==3){
            $this->assign(stage,'亏损阶段');
        }
        $this->assign(area,$prresult[province].'&nbsp;-&nbsp'.$prresult[city].'&nbsp;-&nbsp'.$prresult[town]);
        $this->assign(industry,$prresult[fathertrade].'&nbsp;-&nbsp'.$prresult[fulltrade]);
        $this->assign(logo,$prresult[logo]);
        $this->assign(about,$prresult[prabout]);
        $this->assign(whysupport,$prresult[prwhysupport]);
        $this->assign(promise,$prresult[prpromise]);
        $this->assign(danger,$prresult[prdanger]);
       
        $Prmember = M('Prmember');						//获取团队成员
        $mem[prid] = $_GET[prid];
        $memberresult = $Prmember->where($mem)->select();
        $this->assign('memberresult',$memberresult);
        $this->assign('member',$memberresult);
        $this->province();
        $this->trade();
		$this->display();
	}
	/**
	 *  获取一级省市 
	 */
	public function province(){
		$area = M('China');								
        $province = $area->where('pid=0')->select();
        $this->assign('province',$province);
	}
	/**
	 *  获取所有一级分类 
	 */
	public function trade(){
		$trade = M('Trade');                //获取所有一级分类
        $tradeone = $trade->where('pid=0')->select();
        $this->assign('alltradeone',$tradeone);
	} 
	/**
	 *  进入下一页资料审核页 
	 */
	public function next01(){
		$prid = $_GET[prid];
        $Project = M('Project');
        $map[id] = $prid;
        $result = $Project->where($map)->find();
        if($result){
            if($result[pjdescription]!=''){
                $data[project] = 1;
            }else{
                $data[project] = 0;
            }
        }else{
            $data[project] = 0;
        }
        $Prmember = M('Prmember');
        $map02[prid] = $prid;
        $result02 = $Prmember->where($map02)->count();
        $data[prmember] = $result02;
        $dataArr = json_encode($data);
        echo $dataArr;
	}
	public function predit02(){
		$prid = $_GET[prid];
		$this->assign('prid',$prid);
        $Companydata = M('Companydata');
        $map[prid] = $prid;
        $result = $Companydata->where($map)->find();
        $this->assign('companyid',$result[id]);
        $this->assign('fornt',$result[fornt]);
        $this->assign('rear',$result[rear]);
        $this->assign('legalperson',$result[legalperson]);
        $this->assign('businesslicence',$result[businesslicence]);
        $this->assign('taxcertificate',$result[taxcertificate]);
        $this->assign('companyimg',$result[companyimg]);
        $this->display();
	}
	public function predit03(){
		$prid = $_GET[prid];
        $companyid = $_GET[companyid];
        $this->assign('prid',$prid);
        $this->assign('companyid',$companyid);
        $Financingneeds = M('Financingneeds');
        $map[prid] = $prid;
        $result = $Financingneeds->where($map)->find();
        $this->assign('result',$result);
        $this->assign('investid',$result[id]);
        $this->assign('budget',$result[budget]);
        $this->assign('singleinvest',$result[singleinvest]);
        $this->assign('extras',$result[extras]);
        $this->assign('purpose',$result[purpose]);
        $this->assign('businessplan',$result[businessplan]);
        $this->assign('oldname',$result[oldname]);
        $this->assign('privacy',$result[privacyset]);
        $this->assign('addinfo',$result[addinfo]);
        $this->display();
	}
	public function predit04(){
		$map[prid] = $_GET[prid];
        $imgs = M('primages')->where($map)->order("id desc")->select();
         // yc_vp($imgs);
        $this->assign('imgs',$imgs);
        $this->assign('prid',$_GET[prid]);
        $this->display();
	}
	//项目描述页
	public function predit05(){
		$this->assign('prid',$_GET[prid]);
		$map[prid] = $_GET[prid];
		$prdescription = M('Prdescription');
		$result = $prdescription->where($map)->find();
		$this->assign('prdes',$result[prdescription]);
		$this->display();
	}
}

?>