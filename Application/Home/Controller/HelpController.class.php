<?php
namespace Home\Controller;
use Think\Controller;
class HelpController extends Controller {

	public function _initialize()
	{
		#
	}

	public function index()
	{
		# code...
	}

	//融资模型演示
	public function rzmx()
	{
		$this->display();
	}

	//收益计算器
	public function syjs()
	{
		if (IS_POST) {
			$money = $_POST[js1]; //总额
			$data[b2] = $_POST[js2]; //回本期
			$data[b7] = $_POST[js3]; //收益期
			$yield = $_POST[js4]; //收益率
			$data[b3] = $_POST[js5]; //开始时间
			$data[b4] = cal_time($data[b3],$data[b2]);
			$data[b5] = intval($money/$data[b2]);
			$data[b8] = cal_time($data[b4],0);
			$data[b9] = cal_time($data[b8],$data[b7]);
			$data[ba] = intval($money*$yield/1000);
			$data[bb] = $data[ba]*$data[b7];
			echo json_encode($data);
		}
		exit;
	}

	//用户注册服务协议
	public function yonghu()
	{
		$this->display();
	}

	//投资人协议及风险提示书
	public function touziren()
	{
		$this->display();
	}

	//融资项目发起人服务协议
	public function rongzi()
	{
		$this->display();
	}
	// ===========================网站说明========================================
	public function wwwexplan(){
		$this->display();
	}
	public function wwwexplan02(){
		$this->display();
	}
	public function wwwexplan03(){
		$this->display();
	}
	public function wwwexplan04(){
		$this->display();
	}
	// ==========================落地页============================================
	public function knowYou(){
		$this->display();
	}
	// ==========================建议页============================================
	public function wwwsuggest(){
		$this->display();
	}
	public function suggestInsert(){
		$suggest = M('Wwwsuggest');
		$data[suggestText] = $_POST[suggest];
		$data[contantType] = $_POST[contant];
		if($_POST[contant] == 1){
			$data[contant] = $_POST[email];
		}else if($_POST[contant] == 2){
			$data[contant] = $_POST[phone];
		}
		$data[subTime] = date('Y-m-d H:i:s',time());
		$result = $suggest->add($data);
		echo $resArr = json_encode($result);
	}
	public function successSuggest(){
		$this->display();
	}

	public function xinshou()
	{
		$this->display('Article:helps/beginer/xinshou');
	}

	public function baozhang()
	{
		$this->display('Article:helps/sucerity/baozhang');
	}

	//我们的服务
	public function serve()
	{
		$this->display();
	}

	//评审
	public function pingshen()
	{
		$this->display('Help:pingshen');
	}

	//梧桐会
	public function wutonghui()
	{
		header("location:".C('WEB_URL')."/public/wutonghui/index.html");
	}

}