<?php
namespace Home\Controller;
use Think\Controller;
class InvcenterController extends UserController {

	public $homeuser;
	public $investor;

	//初始化
	public function  _initialize()
	{
		parent::loginStyle();
    	$homeuser = $this->homeuser = M('homeuser')->where("id='$this->uid'")->select();
    	$investor = $this->investor = M('investor')->where("uid='$this->uid'")->select();
    	$this->assign('homeuser',$homeuser);
    	$this->assign('investor',$investor);

    	$sql = "SELECT
			wft_chuzi.id,
			wft_chuzi.iid,
			wft_chuzi.pid,
			wft_chuzi.prid,
			wft_chuzi.cz_maney,
			wft_chuzi.cz_msg,
			wft_chuzi.cz_time,
			wft_chuzi.cz_status,
			wft_project.pjname,
			wft_project.logo,
			wft_homeuser.username
			FROM
			wft_chuzi
			LEFT JOIN wft_project ON wft_chuzi.prid = wft_project.id
			LEFT JOIN wft_homeuser ON wft_chuzi.pid = wft_homeuser.id
			WHERE 
			iid='".$investor[0][id]."'
		";
		$this->assign("chuzis",M()->query($sql)); //出资意向
		$sql = "SELECT
			wft_financing.money,
			wft_financing.pid,
			wft_financing.prid,
			wft_project.pjname,
			wft_project.stageid,
			wft_financingneeds.budget,
			wft_project.logo,
			concat('?s=Home/Project/prdetail&pid=',wft_financing.prid) AS url
			FROM
			wft_financing
			LEFT JOIN wft_project ON wft_financing.prid = wft_project.id
			LEFT JOIN wft_financingneeds ON wft_project.id = wft_financingneeds.prid
			WHERE 
			wft_financing.pid='$this->uid'";
		$this->assign("tzxms",M()->query($sql)); //已投项目	
    	$prodeliverys = M('prodelivery')->where("iid='".$investor[0][id]."'")->select();
		$this->assign('prodeliverys',$prodeliverys);//项目申请
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
			wft_attention.att_time
			FROM
			wft_attention
			WHERE
			wft_attention.atted_id='$this->uid' 
			GROUP BY 
			wft_attention.uid";
		$this->assign('fans',M()->query($sql)); //粉丝
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
			wft_financing.id,
			wft_project.pjname,
			wft_project.stageid,
			wft_financing.money
			FROM
			wft_financing
			LEFT JOIN wft_project ON wft_financing.prid = wft_project.id 
			WHERE 
			wft_financing.pid = '$this->uid'";
		$this->assign('pros',M()->query($sql));//注入投资列表
	}

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

	public function index()
	{
		header("location:?s=home/invcenter/jibenxinxi");
	}

	//基本信息
	public function jiBenXinXi()
	{
		$this->display();
	}

	//编辑
	public function bianJi()
	{
		if (IS_POST) {
			// yc_vp($_POST,1);
			// ***********************************************************
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

            $tradeid = $_POST[trade];
            foreach ($tradeid as $key=>$value) {
                $trade = M('Trade');
                $trademap[id] = $value;
                $result = $trade->where($trademap)->find();
                $tradeRes[$key] = $result[trade];
            }
            $data[intentionname] = implode('&nbsp;', $tradeRes);
            $data['intention'] = implode(',',$_POST[trade]);
            // *********************************************************
            $data[type] = $_POST[type];
			$data[face_img] = $_POST[face_img];
			$data[privacy] = $_POST[privacy];
			$data[phone] = $_POST[phone];
			$data[realname] = I('post.realname','','htmlspecialchars');
			$data[company] = I('post.company','','htmlspecialchars');
			$data[postion] = I('post.postion','','htmlspecialchars');
			$data[income] = $_POST[income];
			$data[min_maney] = $_POST[min_maney];
			$data[max_maney] = $_POST[max_maney];
			$data[sex] = $_POST[sex];
			$data[qq] = $_POST[qq];
			$data[weibo] = $_POST[weibo];
			$data[tzidea] = $_POST[tzidea];
			$map[uid] = $this->uid;
			$issave = M('investor')->where($map)->save($data);
			if ($issave) {
				exit("修改成功");
			}else{
				exit("没有更改信息！");
			}
		}
		$this->province();
		$this->trade();
		$this->display();
	}

	//编辑机构信息
	public function editjigou()
	{
		if (IS_POST) {
			$data[jieduan] = $_POST[jieduan];
			$data[xingzhi] = $_POST[xingzhi];
			$data[leibie] = $_POST[leibie];
			$data[tddetail] = $_POST[tddetail];
			$data[tdurl] = $_POST[tdurl];
			$map[uid] = $this->uid;
			$issave = M('investor')->where($map)->save($data);
			if ($issave) {
				exit("修改成功");
			}else{
				exit("没有更改信息！");
			}
		}
		$this->display();
	}
// **************************曹超(2014-12-12)************************************************
	public function province(){
		$area = M('China');								//获取一级省市
        $province = $area->where('pid=0')->select();
        $this->assign('allprovince',$province);
	}
	public function trade(){
		$trade = M('Trade');                //获取所有一级分类
        $tradeone = $trade->where('pid=0')->select();
        $this->assign('alltrade',$tradeone);
	}
// **************************************************************************
	//动态
	public function dongTai()
	{
		$this->display();
	}

	//项目申请
	public function tiJiao()
	{
		$this->display();
	}

	//已投项目
	public function entrepre()
	{
		$this->display();
	}

	//出资意向
	public function chuZi()
	{
		$this->display();
	}

	//粉丝
	public function fans()
	{
		//新fans
		$sql = "";
		$this->display();
	}

	//关注
	public function guanZhu()
	{
		$this->display();
	}

	//评论
	public function pingLun()
	{
		$this->display();
	}

	//约谈
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
			$data[yt_style] = 2;
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

	//理财
	public function liCai()
	{
		echo "没有模板";
	}

	//更换图片并显示
	public function txup()
	{
		if (IS_POST) {
			$info = $this->upImg();
			$data[face_img] = $info[thumbname];
			echo $data[face_img] ;
	        exit;
		}
	}
}