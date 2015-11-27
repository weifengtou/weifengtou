<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends UserController {

	public function _initialize()
	{
        // yc_vp($_SESSION);
		// header("Content-type: text/html;charset=utf-8");
		// yc_vp(D('Investor')->where("realname='杨昌'")->relation(true)->limit("1")->select());
		// yc_vp(M()->getlastsql(),1);
		// yc_vp(get_child_detail(102,2,0));
	}

    //选择显示项目
    public function proSelect($x)
    {
        $sql = "SELECT
            wft_project.id,
            wft_project.pjname,
            wft_project.pjintroduce,
            wft_project.stageid,
            wft_project.prrate,
            wft_financingneeds.budget,
            wft_financingneeds.privacyset,
            sum(wft_financing.money) AS money,
            wft_project.logo,
            atts.att_count
            FROM
            wft_project 
            LEFT JOIN
            wft_financingneeds ON  wft_project.id = wft_financingneeds.prid 
            LEFT JOIN
            wft_financing ON wft_project.id = wft_financing.prid
            LEFT JOIN
            (SELECT
                count(id) AS att_count,
                wft_attention.atted_childid
                FROM `wft_attention`
                GROUP BY
                wft_attention.atted_childid)
            AS atts ON wft_project.id = atts.atted_childid
            WHERE 
            wft_project.prrate='$x' AND wft_project.status=2
            GROUP BY
            wft_project.id
            LIMIT 3
        ";
        return M()->query($sql);
    }
    
    //显示首页投资人
    public function invSelect()
    {
        $sql = "SELECT
            wft_investor.id
            FROM
            wft_investor
            WHERE 
            wft_investor.iden_status=3
            ORDER BY wft_investor.id DESC
            LIMIT 2
        ";
        return M()->query($sql);
    }

	//系统首页
    public function index(){
        C("TITLE","微风投-中国首家小微实体企业融资创业服务平台");
        C("KEYWORDS","微风投, 小微实体企业融资, 创业服务平台,投资人,创业项目，投资项目，投资理财，天使投资，网络贷款,小微企业贷款,中小企业贷款，小额贷款公司,短期贷款,中小企业融资");
        C('DESCRIPTION',"微风投是中国首家专注于小微实体企业融资的创业服务平台。微风投独创资金分期模式，实地考察好项目，旨在让投资人放心，让项目方融资省心；微风投聚集了大量的优秀投资人，及优质的创业投资项目，找资金、找项目就上微风投！");
        $category = D('Category')->getTree();
        $category = D('Category')->getTree();
        $lists    = D('Document')->lists(null);

        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表
        $this->assign('page',D('Document')->page);//分页
        $this->assign('rzs',$this->proSelect(3)); //融资中
        $this->assign('yrs',$this->proSelect(2)); //预热中
        $this->assign('oks',$this->proSelect(4)); //正式上线
        $this->assign('tzrs',$this->invSelect()); //微风投认证投资人
        $this->buildHtml("index",HTML_PATH.'/',"index",'utf8');
        $this->display();
    }

    //创建好项目
    public function createproject(){
        if($_SESSION[wft_home][userinfo][id]){
            $uid = $_SESSION[wft_home][userinfo][id];
            $Project = M('Project');
            $prmap[pid] = $uid;
            $prresult = $Project->where($prmap)->find();
            $Investor = M('Investor');
            $inmap[uid] = $uid;
            $inresult = $Investor->where($inmap)->find();
            if($prresult){
                echo 1;         //进入项目中心
            }else if($inresult){
                echo 2;         //判断是投资人        
            }else{
                echo 0;         //进入选择身份
            }
        }else{
            echo -1;            //进入登陆页
        }
    }
    //成为投资人
    public function becomeinvestor(){
        if($_SESSION[wft_home][userinfo][id]){
            $uid = $_SESSION[wft_home][userinfo][id];
            $Investor = M('Investor');
            $inmap[uid] = $uid;
            $inresult = $Investor->where($inmap)->find();
            //var_dump($result);
            $Project = M('Project');
            $prmap[pid] = $uid;
            $prresult = $Project->where($prmap)->find();
            if($inresult){
                if($result[iden_status]==0){
                    echo 1;     //进入投资人资料填写页
                }else if($result[iden_status]==1){
                    echo 2;     //进入资料审核中页
                }else if($result[iden_status]==-1){
                    echo 3;     //进入资料审核失败页
                }else if($result[iden_status] > 1){
                    echo 4;     //进入投资人中心
                }
            }else if($prresult){
                echo 5;         //判断是项目创建人身份
            }else{
                echo 0;         //进入选择身份
            }
        }else{
            echo -1;            //进入登录页
        }
    }
    
    // =============================================
}