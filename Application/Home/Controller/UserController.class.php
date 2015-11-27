<?php 

namespace Home\Controller;
use Think\Controller;


class UserController extends HomeController{

	public $loginStyle; //登录人身份 0未登录 1项目人 2投资人 3未注册成功

	public function _initialize()
	{
		$homeuser = M('Homeuser');
		if ($_SESSION[wft_home][userinfo][id]) {
			$this->uid = $map[id] = $_SESSION[wft_home][userinfo][id];
		}
	}

	public function index(){
		// yc_vp($_SESSION);
	}

	/* 验证码，用于登录和注册 */
	public function verify(){
		$verify = new \Think\Verify(array('length' => 4, 'imageH'=>40,'imageW'=>150,'fontSize'=>20));
		$verify->entry(1);
	}
	public function checkVerify(){
		if ($_POST[code]) {
			$code = $_POST[code];
			$id = $_POST[codeid]?$_POST[codeid]:1;
			$verify = new \Think\Verify();
			echo $verify->check($code, 1);
		}
	}

	//用户注册页面
	public function register(){		
		if (session('userinfo')) {
			$this->success("注册成功！","index.php?s=home/investor/choose");
		}else{
			C("SEO_TITLE","注册");
			$this->display();
		}
	}
	//用户注册	
	public function add(){	
		if (IS_POST) {
			$Homeuser = M('Homeuser');
			$map[username] = I('post.username','','htmlspecialchars');
			$res = $Homeuser->where($map)->find();
			$resemail = $Homeuser->where("email='$_POST[email]'")->find();
			if($resemail){
				$result = -1;
				echo $resultArr = json_encode($result);
			}elseif($res){
				$result = 0;
				echo $resultArr = json_encode($result);
			}else{
				if ($_POST[qqopenid]) {
					$data[qqopenid] = $_POST[qqopenid];
				}
				$data[email] = $_POST[email];
				$data[checkemail] = md5($data[email].rand(100,999));
				$data[username] = I('post.username','','htmlspecialchars');
				$data[password] = md5($_POST[password]);
				$data[reg_time] = time();
				$data[update_time] = time();
				$weixin_img_url = "http://http://www.weifengtou.com/Public/static/images/weixin.jpg";
				if (sendMail($data[email],'欢迎使用微风投','尊敬的'.$data[username].',您好！感谢你的使用微风投。<br>请点击下面的链接激活您的帐号，享受微风投各项服务<br><strong><a style="color:#ff0099;" href="'.C('WEB_URL').'index.php?s=Home/User/active&email='.$data[email].'&active='.$data[checkemail].'">'.C('WEB_URL').'index.php?s=Home/User/active&email='.$data[email].'&active='.$data[checkemail].'</a>(激活)</strong><br>(如果无法点击该URL链接地址，请将它复制并粘帖到浏览器的地址输入框，然后单击回车即可。该链接使用后将立即失效。)<br><hr>微风投商业模式是一款定位于小微企业中长期融资需求的金融创新产品，即“好项目+投资人+创业者+监管方”的全产业链的多方共赢的商业组合，该组合专注于小微实体企业，让价值链的每一个环节都成为赢家！<br>如果您还有任何疑问，可以通过在线客服联系我们的客服人员，或者拨打400-400-8998进行咨询，我们的客服人员会尽快为您解答！<br><span style="text-algin:right;">微风投客服中心</span><br>关注微风投官方微信(中国微风投)，了解更多融金融咨询。<br>',$data[username])==1) {
					$result = $Homeuser->add($data);
					if ($result) {
						echo "1";
					}else{
						yc_vp($result);
					}
				}else{
					echo "2";
				}
			}		
		}
		exit;
	}
	//激活账号
	public function active()
	{
		if ($_GET[active]&&$_GET[email]) {
			$has_checked= M('homeuser')->where("email='$_GET[email]'")->field("checkemail")->find();
			if ($has_checked[checkemail]== '') {
				session('userinfo',M('homeuser')->where("email='$_GET[email]'")->find());
				$this->success("账号已经激活！","index.php?s=Home/User/membercenter");
			}elseif ($has_checked[checkemail]== $_GET[active]) {
				$data[checkemail] = '';
				$is_emailchecked = M('homeuser')->where("email='$_GET[email]'")->save($data);
				if ($is_emailchecked) {
					// header("location:index.php?s=Home/User/login");
					session('userinfo',M('homeuser')->where("email='$_GET[email]'")->find());
					$this->success("账号已经激活！","index.php?s=home/investor/choose");
				}
			}else{
				$this->error("激活失败！");
			}
		}else{
			$this->error("非法访问！");
		}
		exit;
	}
	public function login($username="",$password=""){	//用户登录页面
		C("SEO_TITLE","登录");
		$this->display();
	}

	//忘记密码 重置密码
	public function forgetpd01()
	{
		//过滤 发送邮箱验证信息
		if (IS_POST) {
			if ($x = M("homeuser")->where("email='$_POST[email]'")->find()) {
				//缓存有效期24个小时
				C('SESSION_OPTIONS.SESSION_EXPIRE',3600);
				session('uppd'.$x[id],rand(10000000,99999999));
				if (sendMail($x[email],'欢迎使用微风投','尊敬的'.$x[username].',您好！谢谢你的使用微风投。<br>你的验证码为：'.session('uppd'.$x[id]).'<br>请拷贝上面的的验证码或直接点击<a href="'.C('WEB_URL').'index.php?s=Home/User/forgetpd03&email='.$x[email].'&upcode='.session('uppd'.$x[id]).'">修改密码</a>')==1) {
					echo $x[email];
				}else{
					echo "2";
				}
			}else{
				echo "0";
			}
			exit;
		}
		C("SEO_TITLE","忘记密码--填写账户信息");
		$this->display();
	}
	public function forgetpd02()
	{
		if (!$_GET[email]) {
			$this->error("非法访问！");
		}
		C("SEO_TITLE","忘记密码--填写验证码");
		$this->display();
	}
	public function forgetpd03()
	{
		if (IS_POST) {
			$data[password] = md5($_POST[password]);
			$data[update_time] = time();
			if (M("homeuser")->where("email='$_POST[email]'")->save($data)) {
				$this->success("密码重置成功","index.php?s=Home/User/login");
			}else{
				$this->error("未更改或密码重置失败！");
			}
			exit;
		}
		if ($_GET[upcode]&&$_GET[email]) {
			$x = M("homeuser")->where("email='$_GET[email]'")->find();
			if ($_GET[upcode]==session('uppd'.$x[id])) {
				C("SEO_TITLE","忘记密码--重置密码");
				$this->display();
			}else{
				$this->error("验证码错误！");
			}
		}else{
			$this->error("非法访问！");
		}
	}

	//用户激活状态ajax验证
	public function checkActive() 
	{
		$data[username] = $_POST[username];
		$data[password] = md5($_POST[password]);
		$user = M('homeuser');
		$result = $user->where("username='$data[username]' OR email='$data[username]'")->find();
        if(isset($result)&&$result[checkemail]!=''){
        	return false;
        }else{
        	return true;
        }
	}
	//用户登录ajax验证
	public function checkAccount() 
	{
		$data[username] = $_POST[username];
		$data[password] = md5($_POST[password]);
		$user = M('homeuser');
		$result = $user->where("username='$data[username]' OR email='$data[username]'")->find();
        if(!$result){
        	return false;
        }else if($result[password]!=$data[password]){
        	return false;
        }else{
        	return true;
        }
	}
	//用户登录
	public function denglu(){   	
		$data[username] = $_POST[username];
		$data[password] = md5($_POST[password]);
		$user = M('homeuser');
		$result = $user->where("username='$data[username]' OR email='$data[username]'")->find();
        if(!$result){
        	echo $data = 0; //不存在
        }else if($result[password]!=$data[password]){
        	echo $data = 1; //密码错误
        }else{
        	if ($result[checkemail]=='') {
	        	session('userinfo',$result);
	        	$Project = M('Project');
	        	$map[pid] = $result[id];
	        	$prresult = $Project->where($map)->select();
	        	$Investor = M('Investor');
	        	$inmap[uid] = $result[id];
	        	$inresult = $Investor->where($inmap)->select();
	        	if($prresult){        //进入项目中心
	        		echo $data = 2;
	        	}else if($inresult){	//进入个人中心
	        		echo $data = 3;
	        	}else{        			//进入选择页
	        		echo $data = 4;
	        	}
        	}else{
        		echo $data = 5; //未激活邮箱
        	}
        }
        exit;     
	}

	// qq登陆
	public function qqlogin()
	{
		$this->display();
	}
	public function checkqqopenid()
	{
		if (IS_POST) {
			$_s_id = M('Homeuser')->field("id")->where("qqopenid='$_POST[openId]'")->limit("1")->select();
			if ($_s_id) {
				echo json_encode($_s_id);
			}else{
				echo "0";
			}
		}
		exit();
	}
	public function qqregister()
	{
		if ($_GET[openId]) {
			$data[qqopenid] = $_GET[openId];
			$this->display("User/register");
		}else{
			$this->error("非法访问！");
		}
	}
	public function checkqquser()
	{
		if ($_GET[id]&&$_GET[openId]) {
			$_s_user = M('Homeuser')->where("id='$_GET[id]' AND qqopenid='$_GET[openId]'")->limit("1")->select();
			if (!$_s_user[0][email]) {
				$this->error("你还没完成注册信息！","index.php?s=Home/User/qqregister&openId=".$_GET[openId]."&nickname=".$_GET[nickname]);
			}else{
				if ($_s_user[0][checkemail]!='') {
					$email_url = getemailurl($_s_user[0][email]);
					// header("location:".$email_url);
					$this->error("你还没完成邮箱验证！",$email_url);
				}else{
					session('userinfo',$_s_user[0]);
					$this->success("登录成功！","index.php");
				}
			}
		}else{
			$this->error("非法访问！");
		}
		exit();
	}

	// 微博登陆
	public function weibologin()
	{
		// if ($_GET[code]) {
		// 	yc_vp($_GET[code]);
		// }
		$this->display();
	}

	/*修改密码*/
	public function newpass()
	{
		if (IS_POST) {
			if (md5($_POST[obj][oldpass])==$_SESSION[wft_home][userinfo][password]) {
				$data[password] = md5($_POST[obj][newpass]);
				$x = M('Homeuser')->where("id='$this->uid'")->save($data);
				if ($x) {
					$_SESSION[wft_home][userinfo][password] = $data[password];
					exit("1");
				}else{
					exit('2');
				}
			}else{
				exit('0');
			}
		}
		exit();
	}
	
	/* 退出登录 */
	public function logout(){
		if(is_denglu()){
			D('Homeuser')->tuichu();
			$this->display('login');
		} else {
			$this->redirect('User/login');
		}
	}
	
	/* 会员中心 */
	public function membercenter(){
		$this->loginStyle();
		if($this->loginStyle == 1){
			header("Location:index.php?s=Home/Prcenter/baseinfo");
		}else if($this->loginStyle == 2){
			header("Location:index.php?s=Home/Invcenter/jibenxinxi");
		}else if($this->loginStyle == 3){
			$this->error("未选择身份","index.php?s=home/investor/choose");
		}
	}

	//判断登录身份
	public function loginStyle()
	{
		$homeuser = M('Homeuser');
		$this->uid = $map[id] = $_SESSION[wft_home][userinfo][id];
		$style = $homeuser->where($map)->field('wft_homeuser.style')->find();
		if ($style) {
			$this->loginStyle = $style[style];
		}else{
			$this->loginStyle = 0;
		}
		$this->assign('uid',$this->uid);
		$this->assign('loginStyle',$this->loginStyle);
	}

	//pos登录人style
	public function showLoginStyle()
	{
		$this->loginStyle();
		if (IS_POST) {
			echo $this->loginStyle;
		}
	}

	//判断登录用户是否有权限进入已创建项目页
	public function power(){
		$homeuser = M('Homeuser');
		$map[id] = $_SESSION[wft_home][userinfo][id];
		$style = $homeuser->where($map)->field('style')->find();
		$arr = json_encode($style);
		echo $arr;
	}
} 