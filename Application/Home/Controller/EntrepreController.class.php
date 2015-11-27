<?php

namespace Home\Controller;
use Think\Controller;

class EntrepreController extends Controller{
    /**
     *  进入项目创建首页 
     */
	public function entrepre(){
        // echo $_SESSION[wft_home][prid];
        // var_dump($_SESSION);
        
        $homeuser = M('Homeuser');              // 成为项目方
        $data[style] = 1;
        $homemap[id] = $_SESSION[wft_home][userinfo][id];
        $homeuser -> where($homemap) -> save($data);  

        $area = M('China');                             //获取所有省
        $province = $area->where('pid=0')->select();
        $this->assign('allprovince',$province);

        $trade = M('Trade');                //获取所有一级分类
        $tradeone = $trade->where('pid=0')->select();
        $this->assign('alltradeone',$tradeone);

        // 项目资料页查看项目信息
        if($_SESSION[wft_home][prid]){
            $Project=M('Project');
            $map[id] = $_SESSION[wft_home][prid];
            $result = $Project->where($map)->find();
            $this->assign('prid',$result[id]);
            $this->assign('logo',$result[logo]);
            $this->assign('prname',$result[pjname]);
            $this->assign('linkman',$result[linkman]);
            $this->assign('prphone',$result[prphone]);
            $this->assign('videoweb',$result[videoweb]);
            $this->assign('stageid',$result[stageid]);
            $this->assign('printroduce',$result[pjintroduce]);
            $this->assign('about',$result[prabout]);
            $this->assign('whysupport',$result[prwhysupport]);
            $this->assign('promise',$result[prpromise]);
            $this->assign('danger',$result[prdanger]);
            $this->assign('province',$result[province]);
            $this->assign('city',$result[city]);
            $this->assign('town',$result[town]);
            $this->assign('fathertrade',$result[fathertrade]);
            $this->assign('fulltrade',$result[fulltrade]);
            $Prmember = M('Prmember');
            $membermap[prid] = $_SESSION[wft_home][prid];
            $memberresult = $Prmember->where($membermap)->select();
            $this->assign('member',$memberresult);
            $this->assign('memberresult',$memberresult);
        }
		$this->display();
	}
// ===================基本资料页操作================================================================================================
    /**
     *  获取所有二级城市 
     */
    public function province(){
    	$id = $_GET[areaid]; 
        $area = M('China'); 
        $map[pid] = $id;
        $result = $area->where($map)->order('id')->select();
        $resultArr = json_encode($result);
        echo($resultArr);
    }
    /**
     *  获取所有三级城市 
     */
    public function city(){
        $id = $_GET[areaid]; 
        $area = M('China'); 
        $map[pid] = $id;
        $result = $area->where($map)->select();
        $resultArr = json_encode($result);
        echo($resultArr);
    }
    /**
     *  获取二级所有行业分类 
     */
    public function trade(){
        $id = $_GET[tradeid];
        $trade = M('Trade'); 
        $map[pid] = $id;
        $result = $trade->where($map)->select();
        $resultArr = json_encode($result);
        echo($resultArr);
    }
    
    /** 
     *  项目基本资料写入 
     */
    public function prinsert01(){
        if($_SESSION[wft_home][userinfo][id]){
            //获取省
            $Province = M('China');
            $map['id'] = $_POST['province01'];
            $pres = $Province->where($map)->select();
            //获取市
            $City = M('China');
            $map['id'] = $_POST['city01'];
            $cres = $City->where($map)->select();
            //获取县
            $Town = M('China');
            $map['id'] = $_POST['town01'];
            $tres = $Town->where($map)->select();
            //获取一级行业
            $father = M('Trade');
            $map['id'] = $_POST['father01'];
            $fares = $father->where($map)->select();
            // 获取二级行业
            $full = M('Trade');
            $map['id'] = $_POST['full01'];
            $fures = $full->where($map)->select();
            //保存信息
            $Project = M('Project');
            $prdata[pid] = $_SESSION[wft_home][userinfo][id];
            $prdata[logo] = $_POST[surface01];
            $prdata[pjname] = $_POST['prname01'];
            $prdata[linkman] = $_POST['linkman01'];
            $prdata[prphone] = $_POST['prphone01'];
            $prdata[pjintroduce] = $_POST['printroduce01'];
            $prdata[videoweb] = $_POST['videoweb01'];
            $prdata[stageid] = $_POST['prstage01'];
            $prdata[provinceid] = $_POST['province01'];
            $prdata[province] = $pres[0][name];     //省、自治区名
            $prdata[cityid] = $_POST['city01'];
            $prdata[city] = $cres[0][name];         //市名
            $prdata[townid] = $_POST['town01'];
            $prdata[town] = $tres[0][name];         //县、区名
            $prdata[fathertradeid] = $_POST[father01];
            $prdata[fathertrade] = $fares[0][trade];
            $prdata[fulltradeid] = $_POST[full01];
            $prdata[fulltrade] = $fures[0][trade];
            $prdata[submit_time] = date("Y-m-d h:i:sa");
            $result = $Project->add($prdata);

            $prid = $result;
            session('prid',$prid);          //项目id缓存
            $prdata[prid] = $prid;
            $prdataArr = json_encode($prdata);
            echo $prdataArr;
            // submit_remind(C('KEFU_EMAIL'),1,$prdata);
        }else{                                  //用户未登录
            echo -1;
        }    
        exit;    
    }
    /**
     *  项目基本资料获取 
     */
    public function prbaseedit(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project = M('Project');
            $map['id'] = $_GET['prid'];
            $prinfo = $Project->where($map)->select();
            $prinfoArr = json_encode($prinfo[0]);
            echo $prinfoArr;
        }else{
            echo -1;
        }
    }
    /**
     *  项目Surface图片上传 
     */
    public function uploadImg(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 1*1024*1024 ;// 设置附件上传大小1M
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->autoSub = false;
        $upload->savePath = './Album/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload->saveName = $fileName;
        // 上传文件
        return $info = $upload->upload();
    }
   /**
    *   项目Surface图保存 
    */
    public function upSurface(){
        if($_SESSION[wft_home][userinfo][id]){
            //图片上传
            $info = $this->uploadImg();
            if($info){
                echo $info['prsurface01']['savename'];
                exit();
            }else{
                echo 0;
                exit();
            }
        }
        else{
            echo -1;
        }
    }
    /**
     *  项目Surface图更新 
     */
    public function updateSurface(){
        if($_SESSION[wft_home][userinfo][id]){
            //图片上传
            $info = $this->uploadImg();
            if($info){
                echo $info['prsurface03']['savename'];
                exit();
            }else{
                echo 0;
                exit();
            }
        }
        else{
            echo -1;
        }
    }
    /**
     *  更新项目基本资料 
     */
    public function prbaseupdate(){
        if($_SESSION[wft_home][userinfo][id]){
            $Province = M('China');                     //获取省
            $map['id'] = $_POST['province03'];
            $pres = $Province->where($map)->select();                    
            $City = M('China');                         //获取市
            $map['id'] = $_POST['city03'];
            $cres = $City->where($map)->select();
            $Town = M('China');                         //获取县
            $map['id'] = $_POST['town03'];
            $tres = $Town->where($map)->select();
            //获取一级行业
            $father = M('Trade');
            $map['id'] = $_POST['father03'];
            $fares = $father->where($map)->select();
            // 获取二级行业
            $full = M('Trade');
            $map['id'] = $_POST['full03'];
            $fures = $full->where($map)->select();

            $Project = M('Project');                    //项目基本资料写入
            //判断是否有图片上传
            $surface03 = $_POST[surface03];
            if(empty($surface03)){
                $map[id] = $_POST[prid];
                $data[pjname] = $_POST[prname03];
                $data[linkman] = $_POST[linkman03];
                $data[prphone] = $_POST[prphone03];
                $data[pjintroduce] = $_POST[printroduce03];
                $data[videoweb] = $_POST[videoweb03];
                $data[stageid] = $_POST[prstage03];
                $data[provinceid] = $_POST[province03];
                $data[province] = $pres[0][name];
                $data[cityid] = $_POST[city03];
                $data[city] = $cres[0][name];
                $data[townid] = $_POST[town03];
                $data[town] = $tres[0][name];
                $data[fathertradeid] = $_POST[father03];
                $data[fathertrade] = $fares[0][trade];
                $data[fulltradeid] = $_POST[full03];   
                $data[fulltrade] = $fures[0][trade];
                $data[update_time] = date("Y-m-d h:i:sa");
                $prresult = $Project->where($map)->data($data)->save();
                if($prresult){
                    $Project031 = M('Project');
                    $result031 = $Project031->where($map)->find();
                    $result031Arr = json_encode($result031);
                    echo $result031Arr;
                    exit();
                }
            }else{
                $map[id] = $_POST[prid];
                $data[pjname] = $_POST[prname03];
                $data[linkman] = $_POST[linkman03];
                $data[prphone] = $_POST[prphone03];
                $data[pjintroduce] = $_POST[printroduce03];
                $data[videoweb] = $_POST[videoweb03];
                $data[stageid] = $_POST[prstage03];
                $data[provinceid] = $_POST[province03];
                $data[province] = $pres[0][name];
                $data[cityid] = $_POST[city03];
                $data[city] = $cres[0][name];
                $data[townid] = $_POST[town03];
                $data[town] = $tres[0][name];
                $data[fathertradeid] = $_POST[father03];
                $data[fathertrade] = $fares[0][trade];
                $data[fulltradeid] = $_POST[full03];   
                $data[fulltrade] = $fures[0][trade];
                $data[update_time] = date("Y-m-d h:i:sa");

                $data[logo] = $_POST['surface03'];
                $prresult = $Project->where($map)->data($data)->save();
                if($prresult){
                    $Project031 = M('Project');
                    $result031 = $Project031->where($map)->select();
                    $result031Arr = json_encode($result031[0]);
                    echo $result031Arr;
                    exit();
                }
            }
        }else{
            echo -1;
        }
    }
    /** 
     * 关于我们写入 
     */
    public function praboutinsert(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project = M('Project');
            $data[prabout] = $_POST['prabout11'];
            $map['id'] = $_POST['prid'];
            $result = $Project->where($map)->data($data)->save();
            $prArr = json_encode($data);
            echo $prArr;
        }else{
            echo -1;
        }    
    }
    /**
     *  关于我们获取 
     */
    public function praboutedit(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project = M('Project');
            $map[id] = $_GET['prid'];
            $result = $Project->where($map)->select();
            $resultArr = json_encode($result[0]);
            echo $resultArr;
        }else{
            echo -1;
        }
    }
    /**
     *  更新关于我们 
     */
    public function praboutupdate(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project13 = M('Project');
            $data[prabout] = $_POST[prabout13];
            $map13[id] = $_POST[prid];
            $result13 = $Project13->where($map13)->data($data)->save();
            if($result13){
                $Project131 = M('Project');
                $result131 = $Project131->where($map13)->select();
                $result131Arr = json_encode($result131[0]);
                echo $result131Arr;
            }
        }else{
            echo -1;
        }
    }
    /**
     *  为什么支持我们写入 
     *  */
    public function prwhysupportinsert(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project = M('Project');
            $data[prwhysupport] = $_POST['prwhysupport41'];
            $map[id] = $_POST[prid];
            $result = $Project->where($map)->data($data)->save();
            $prArr = json_encode($data);
            echo $prArr;
        }else{
            echo -1;
        }    
    }
    /**
     *  为什么支持我们获取 
     *  */
    public function prwhysupportedit(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project = M('Project');
            $map[id] = $_GET['prid'];
            $result = $Project->where($map)->select();
            $resultArr = json_encode($result[0]);
            echo $resultArr;
        }else{
            echo -1;
        }
    }
    /**
     *  更新为什们支持我们 
     *  */
    public function prwhysupportupdate(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project43 = M('Project');
            $data[prwhysupport] = $_POST[prwhysupport43];
            $map43[id] = $_POST[prid];
            $result43 = $Project43->where($map43)->data($data)->save();
            if($result43){
                $Project431 = M('Project');
                $result431 = $Project431->where($map43)->select();
                $result431Arr = json_encode($result431[0]);
                echo $result431Arr;
            }
        }else{
            echo -1;
        }
    }
    /**
     *  承诺写入 
     *  */
    public function prpromiseinsert(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project = M('Project');
            $data[prpromise] = $_POST['prpromise51'];
            $map[id] = $_POST[prid];
            $result = $Project->where($map)->data($data)->save();
            $prArr = json_encode($data);
            echo $prArr;
        }else{
            echo -1;
        }    
    }
    /**
     *  承诺获取 
     */
    public function prpromiseedit(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project = M('Project');
            $map[id] = $_GET['prid'];
            $result = $Project->where($map)->select();
            $resultArr = json_encode($result[0]);
            echo $resultArr;
        }else{
            echo -1;
        }
    }
    /**
     *  更新承诺 
     */
    public function prpromiseupdate(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project53 = M('Project');
            $data[prpromise] = $_POST[prpromise53];
            $map53[id] = $_POST[prid];
            $result53 = $Project53->where($map53)->data($data)->save();
            if($result53){
                $Project531 = M('Project');
                $result531 = $Project531->where($map53)->select();
                $result531Arr = json_encode($result531[0]);
                echo $result531Arr;
            }
        }else{
            echo -1;
        }
    }
    /**
     *  风险写入 
     */
    public function prdangerinsert(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project = M('Project');
            $data[prdanger] = $_POST['prdanger61'];
            $map[id] = $_POST[prid];
            $result = $Project->where($map)->data($data)->save();
            $prArr = json_encode($data);
            echo $prArr;
        }else{
            echo -1;
        }    
    }
    /**
     *  风险获取 
     */
    public function prdangeredit(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project = M('Project');
            $map[id] = $_GET['prid'];
            $result = $Project->where($map)->select();
            $resultArr = json_encode($result[0]);
            echo $resultArr;
        }else{
            echo -1;
        }
    }
    /**
     *  更新风险 
     */
    public function prdangerupdate(){
        if($_SESSION[wft_home][userinfo][id]){
            $Project63 = M('Project');
            $data[prdanger] = $_POST[prdanger63];
            $map63[id] = $_POST[prid];
            $result63 = $Project63->where($map63)->data($data)->save();
            if($result63){
                $Project631 = M('Project');
                $result631 = $Project631->where($map63)->select();
                $result631Arr = json_encode($result631[0]);
                echo $result631Arr;
            }
        }else{
            echo -1;
        }
    }
    /**
     *  头像上传 
     */
    public function uploadPhoto(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload ->maxSize = 1*1024*1024 ;// 设置附件上传大小1M
        $upload ->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload ->autoSub = false;
        $upload ->savePath = './Portrait/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload ->saveName = $fileName;
        // 上传文件
        return $info = $upload->upload();
    }
    /**
     *  成员头像保存 
     */
    public function upPhoto(){
        if($_SESSION[wft_home][userinfo][id]){
            //头像上传
            $info = $this->uploadPhoto();
            if($info){
                echo $info['photo21'][savename];
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  成员信息写入 
     */
    public function prmemberinsert21(){
        if($_SESSION[wft_home][userinfo][id]){
                $Prmember21 = M('Prmember');
                $data[prid] = $_POST['prid'];
                $data[membername] = $_POST['name21'];
                $data[memberposition] = $_POST['position21'];
                $data[memberroleid] = $_POST['radio21'];
                $data[memberintroduce] = $_POST['introduce21'];
                $data[photo] = $_POST['headphoto21'];
                $result = $Prmember21->add($data);
                if($result){
                    $Prmember211 = M('Prmember');
                    $map211[prid] = $_POST['prid'];
                    $map211[membername] = $_POST['name21'];
                    $map211[memberposition] = $_POST['position21'];
                    $result211 = $Prmember211->where($map211)->select();
                    $result211Arr = json_encode($result211[0]);
                    echo $result211Arr;
                    exit();
                } 
        }else{
            echo -1;
        }   
    }
    /**
     *  成员信息获取 
     */
    public function prmemberedit22(){
        if($_SESSION[wft_home][userinfo][id]){
            $Prmember = M('Prmember');
            $map[id] = $_GET['memberid'];
            $result = $Prmember->where($map)->select();
            $resultArr = json_encode($result[0]);
            echo $resultArr;
        }else{
            echo -1;
        }
    }
    /**
     *  删除成员信息 
     */
    public function prmemberdelete22(){
        if($_SESSION[wft_home][userinfo][id]){
            $Prmember = M('Prmember');
            $map[id] = $_GET['memberid'];
            $result = $Prmember->where($map)->delete();
            $resultArr = json_encode($result[0]);
            echo $resultArr;
        }else{
            echo -1;
        }
    }
    /**
     *  成员头像更新 
     */
    public function updatePhoto(){
        if($_SESSION[wft_home][userinfo][id]){
            //头像上传
            $info = $this->uploadPhoto();
            if ($info) {
                echo $info[memberphoto23][savename];
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  更新成员信息 
     */
    public function prmemberupdate23(){
        if($_SESSION[wft_home][userinfo][id]){
            $Prmember = M('Prmember');
            $map[id] = $_POST[memberid23];
            $data[membername] = $_POST[name23];
            $data[memberposition] = $_POST[position23];
            $data[memberroleid] = $_POST[radio23];
            $data[memberintroduce] = $_POST[introduce23];
            $headphoto23 = $_POST[headphoto23];
            //判断是否有图片上传
            if(empty($headphoto23)){
                $result = $Prmember->where($map)->data($data)->save();
                if($result){
                    $Prmember231 = M('Prmember');
                    $result231 = $Prmember231->where($map)->select();
                    $result231Arr = json_encode($result231[0]);
                    echo $result231Arr;
                }
            }else{
                $data[photo] = $_POST['headphoto23'];
                $result = $Prmember->where($map)->data($data)->save();
                if($result){
                    $Prmember231 = M('Prmember');
                    $result231 = $Prmember231->where($map)->select();
                    $result231Arr = json_encode($result231[0]);
                    echo $result231Arr;
                }
            }
        }else{
            echo -1;
        }    
    }
    /**
     *  资料审核页 + 下一步 
     */
    public function next01(){
        $prid = $_SESSION[wft_home][prid];
        $Project = M('Project');
        $map[id] = $prid;
        $result = $Project->where($map)->find();
        if($result){        //判断基本资料是否填写完整
            if($result[prabout]!=''&&$result[prwhysupport]!=''&&$result[prpromise]!=''&&$result[prdanger]!=''){
                $data[project] = 1;
            }else{
                $data[project] = 0;
            }
        }else{
            $data[project] = 0;
        }
        $Prmember = M('Prmember');
        $map02[prid] = $prid;
        $result02 = $Prmember->where($map02)->count();          //项目成员人数
        $data[prmember] = $result02;
        $dataArr = json_encode($data);
        echo $dataArr;
    }
// ===================资料审核页操作=============================================================================================
    /**
     *  进入资料审核页面 
     */
    public function entrepre02(){
        $prid = $_SESSION[wft_home][prid];
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
    /**
     *  资料审核图片上传 
     */
    public function uploadReview(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 1*1024*1024 ;// 设置附件上传大小1M
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->autoSub = false;
        $upload->savePath = './Company/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload->saveName = $fileName;
        // 上传文件
        return $info = $upload->upload();
    }
    /**
     *  保存身份证正面图片 
     */
    public function saveimg01(){
        if($_SESSION[wft_home][userinfo][id]){
            // 身份证正面上传
            $info = $this->uploadReview();
            if($info){
                $map[prid] = $_POST[prid];
                $Companydata = M('Companydata');
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[fornt] = $info[fornt][savename];
                    $res = $Companydata->where($map)->save();
                }else{
                    $data[prid]= $_POST[prid];
                    $data[fornt] = $info[fornt][savename];
                    $res = $Companydata->add($data);
                }
                $resultArr = json_encode($info[fornt][savename]);
                echo $resultArr;
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  更新身份证正面图片 
     */
    public function updateimg01(){
        if($_SESSION[wft_home][userinfo][id]){
            // 身份证正面更新上传
            $info = $this->uploadReview();
            if($info){
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[fornt] = $info[fornt02][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[fornt] = $info[fornt02][savename];
                    $res = $Companydata->add($data);
                }
                $resArr = json_encode($info[fornt02][savename]);
                echo $resArr;
                exit();
            }else {
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  保存身份证反面图片 
     */
    public function saveimg11(){
        if($_SESSION[wft_home][userinfo][id]){
            // 身份证反面上传
            $info = $this->uploadReview();
            if($info){
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[rear] = $info[rear11][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[rear] = $info[rear11][savename];
                    $res = $Companydata->add($data);
                }
                $dataArr = json_encode($info[rear11][savename]);
                echo $dataArr;
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  更新身份证反面图片 
     */
    public function updateimg11(){
        if($_SESSION[wft_home][userinfo][id]){ 
            // 身份证反面上传
            $info = $this->uploadReview();

            if($info){
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[rear] = $info[rear12][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[rear] = $info[rear12][savename];
                    $res = $Companydata->add($data);
                }
                $resultArr = json_encode($info[rear12][savename]);
                echo $resultArr;
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  保存法人证信报告图片 
     */
    public function saveimg21(){
        if($_SESSION[wft_home][userinfo][id]){
            // 法人证信报告上传
            $info = $this->uploadReview();
            if ($info) {
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[legalperson] = $info[legalperson21][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[legalperson] = $info[legalperson21][savename];
                    $res = $Companydata->add($data);
                }
                $dataArr = json_encode($info[legalperson21][savename]);
                echo $dataArr;
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  更新法人证信报告图片 
     */
    public function updateimg21(){
        if($_SESSION[wft_home][userinfo][id]){
            // 法人证信报告更新上传
            $info = $this->uploadReview();

            if($info){
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[legalperson] = $info[legalperson22][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[legalperson] = $info[legalperson22][savename];
                    $res = $Companydata->add($data);
                }
                $resultArr = json_encode($info[legalperson22][savename]);
                echo $resultArr;
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  保存营业执照图片 
     */
    public function saveimg31(){
        if($_SESSION[wft_home][userinfo][id]){
            // 营业执照上传
            $info = $this->uploadReview();

            if($info){
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[businesslicence] = $info[businesslicence31][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[businesslicence] = $info[businesslicence31][savename];
                    $res = $Companydata->add($data);
                }
                $dataArr = json_encode($info[businesslicence31][savename]);
                echo $dataArr;
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  更新营业执照图片 
     */
    public function updateimg31(){
        if($_SESSION[wft_home][userinfo][id]){
            // 营业执照更新上传
            $info = $this->uploadReview();

            if($info){
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[businesslicence] = $info[businesslicence32][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[businesslicence] = $info[businesslicence32][savename];
                    $res = $Companydata->add($data);
                }
                $resultArr = json_encode($info[businesslicence32][savename]);
                echo $resultArr;
                exit();
            }else{
                echo 0;
                exit();
            }
            
        }else{
            echo -1;
        }
    }
    /**
     *  保存税务登记证图片 
     */
    public function saveimg41(){
        if($_SESSION[wft_home][userinfo][id]){
            // 税务登记证上传
            $info = $this->uploadReview();

            if ($info) {
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[taxcertificate] = $info[taxcertificate41][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[taxcertificate] = $info[taxcertificate41][savename];
                    $res = $Companydata->add($data);
                }
                $resultArr = json_encode($info[taxcertificate41][savename]);
                echo $resultArr;
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  更新税务登记证图片 
     */
    public function updateimg41(){
        if($_SESSION[wft_home][userinfo][id]){
            // 税务登记证更新上传
            $info = $this->uploadReview();

            if ($info) {
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[taxcertificate] = $info[taxcertificate42][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[taxcertificate] = $info[taxcertificate42][savename];
                    $res = $Companydata->add($data);
                }
                $resultArr = json_encode($info[taxcertificate42][savename]);
                echo $resultArr;
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  保存公司图片 
     */
    public function saveimg51(){
        if($_SESSION[wft_home][userinfo][id]){
            // 公司图片上传
            $info = $this->uploadReview();

            if($info){
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[companyimg] = $info[companyimg51][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[companyimg] = $info[companyimg51][savename];
                    $res = $Companydata->add($data);
                }
                $resultArr = json_encode($info[companyimg51][savename]);
                echo $resultArr;
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
    /**
     *  更新公司图片 
     */
    public function updateimg51(){
        if($_SESSION[wft_home][userinfo][id]){
            // 公司图片更新上传
            $info = $this->uploadReview();

            if ($info) {
                $map[prid] = $_POST[prid];
                $Companydata = M(Companydata);
                $result = $Companydata->where($map)->find();      //判断是否有prid的记录
                if($result){
                    $data[companyimg] = $info[companyimg52][savename];
                    $res = $Companydata->where($map)->save($data);
                }else{
                    $data[prid]= $_POST[prid];
                    $data[companyimg] = $info[companyimg52][savename];
                    $res = $Companydata->add($data);
                }
                $resultArr = json_encode($info[companyimg52][savename]);
                echo $resultArr;
                exit();
            }else{
                echo 0;
                exit();
            }
        }else{
            echo -1;
        }
    }
// ==========================================================================================================================
	/** 
 	* 项目描述页面
 	*/
    public function entrepre05(){
    	$prid = $_SESSION[wft_home][prid];
    	$this->assign('prid',$prid);
    	$prdescription = M('Prdescription');
    	$map[prid] = $_SESSION[wft_home][prid];
    	if($_SESSION[wft_home][prid]){
    		$result = $prdescription->where($map)->find();
    		$this->assign('prdes',$result[prdescription]);
    	}
    	$this->display();
    }
    /**
     * 项目描述添加
     */
    public function saveprdes(){
     	if($_SESSION[wft_home][userinfo][id]){
     		$map[prid]=$_POST['prid'];
	      	//$prdesdata[prdescription] = I("editor");
     		$prdesdata[prdescription] = htmlspecialchars($_POST[editor]);
     		$prdesdata[deal_time] = date("Y-m-d H:i:s");
     		$result=M('Prdescription')->where($map)->find();
     		if($result){
     			M('Prdescription')->where($map)->save($prdesdata);	
     		}else{
     			$prdesdata[prid] = $_POST['prid'];
     			M('Prdescription')->add($prdesdata);
     		}
    		$dataArr=json_encode($prdesdata);
    		echo $dataArr;
    		exit();
     	}else{
     		echo -1;
     		exit();
     	}
    }
    
// ===================融资需求页操作=========================================================================================
    /**
     *  进入融资需求页面 
     */
    public function entrepre03(){
        $prid = $_SESSION[wft_home][prid];
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
//         $this->assign('extras',$result[extras]);
        $this->assign('purpose',$result[purpose]);
//         $this->assign('businessplan',$result[businessplan]);
        $this->assign('oldname',$result[oldname]);
        $this->assign('privacy',$result[privacyset]);
        $this->assign('addinfo',$result[addinfo]);
        $this->display();
    }
    /**
     *  上传商业计划书 
     */
    /* public function upplan(){
        if (!empty($_FILES)) {
            //商业计划书上传设置
            $config = array(   
                'maxSize'    =>    25*1024*1024,    // 设置附件上传大小10M
                'savePath'   =>    './Businessplan/',   // 设置附件上传目录
                'saveName'   =>    date('YmdHis',time()).'_'.rand(100,999), 
                'exts'       =>    array('doc'),  // 设置附件上传类型
                'autoSub'    =>    false,   //是否使用子目录保存上传文件 
            );
            $upload = new \Think\Upload($config);// 实例化上传类
            $info = $upload->upload();
            //判断是否有图
            if($info){
                $data[oldname] = $info[businessplan][name];
                $data[name] = $info[businessplan][savename];
                $dataArr = json_encode($data);
                //返回文件名给JS作回调用
                echo $dataArr;         //输出上传文件名
            }else{
                echo 0;         //上传失败
            }
            exit();
        }
    } */
    /**
     *  保存融资需求信息 
     */
    public function saveinvest(){
        if($_SESSION[wft_home][userinfo][id]){
            $Financingneeds = M('Financingneeds');
            $map[prid] = $_POST[prid];
            $data[budget] = $_POST[budget01];
            $data[singleinvest] = $_POST[singleinvest01];
//             $data[extras] = $_POST[extras01];
            $data[purpose] = $_POST[purpose01];
//             $data[businessplan] = $_POST[businessplan01];
            $data[privacyset] = $_POST[privacyset01];
            $data[addinfo] = $_POST[addinfo01];
//             $data[oldname] = $_POST[businessplanold01];
            $data[prid] = $_POST[prid];
            $result = $Financingneeds->add($data);
            $data[result] = $result;
            $dataArr = json_encode($data);
            $prdata = M('Project')->where("id='$_POST[prid]'")->find();
            submit_remind(C('KEFU_EMAIL'),1,$prdata);
            echo $dataArr;
            exit();
        }else{
            echo -1;
            exit();
        }
    }
    /**
     *  获取融资需求信息 
     */
    public function editinvest(){
        if($_SESSION[wft_home][userinfo][id]){
            $map[id] = $_GET[id];
            $Financingneeds = M('Financingneeds');
            $result = $Financingneeds->where($map)->find();
            $resultArr = json_encode($result);
            echo $resultArr;
            exit();
        }else{
            echo -1;
            exit();
        }
    }
    /**
     *  更新融资需求信息 
     */
    public function updateinvest(){
        if($_SESSION[wft_home][userinfo][id]){
            $Financingneeds = M('Financingneeds');
            $map[id] = $_POST[investid];
//             if($_POST[businessplan03]){
//                 $data[budget] = $_POST[budget03];
//                 $data[singleinvest] = $_POST[singleinvest03];
//                 $data[extras] = $_POST[extras03];
//                 $data[purpose] = $_POST[purpose03];
//                 $data[businessplan] = $_POST[businessplan03];
//                 $data[oldname] = $_POST[businessplanold03];
//                 $data[privacyset] = $_POST[privacyset03];
//                 $data[addinfo] = $_POST[addinfo03];
//                 $result = $Financingneeds->where($map)->save($data);
//                 $dataArr = json_encode($data);
//                 echo $dataArr;
//             }else{
                $data[budget] = $_POST[budget03];
                $data[singleinvest] = $_POST[singleinvest03];
//                 $data[extras] = $_POST[extras03];
                $data[purpose] = $_POST[purpose03];
                $data[privacyset] = $_POST[privacyset03];
                $data[addinfo] = $_POST[addinfo03];
                $result = $Financingneeds->where($map)->save($data);
                $dataArr = json_encode($data);
                echo $dataArr;
                exit();
//             }
        }else{
            echo -1;
            exit();
        }
    }
// =========================================================================================================================

// ================项目图片页操作===========================================================================================
    //项目图片页
    public function entrepre04(){   
        $map[prid] = $_SESSION[wft_home][prid];
        $imgs = M('primages')->where($map)->order("id asc")->select();
        $this->assign('imgs',$imgs);
        $this->assign('prid',$_GET[prid]);
        $this->display();
    }
    //项目图片上传
    public function upImg(){
       if($_SESSION[wft_home][userinfo][id]){
            /* 
            * 项目图片上传
            */
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 1*1024*1024 ;// 设置附件上传大小1M
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->autoSub = false;
            $upload->savePath = './PrImages/'; // 设置附件上传目录
            $fileName = date('YmdHis',time()).'_'.rand(100,999);
            $upload->saveName = $fileName;
            // 上传文件
            $info = $upload->upload();
            if($info){
                if($_POST[prid]){
                    $data[prid] = $_POST[prid];
                }else{
                    $data[prid] = $_SESSION[wft_home][prid];
                }
                $data[name] = $info[upImg][savename];
                $data[oldname] = $info[upImg][name];
                $image = new \Think\Image();        //图像操作
                $image -> open('./Uploads/PrImages/'.$info[upImg][savename]);          //打开图像文件
                $width = $image -> width();
                $height = $image -> height();
                $thumbname = 'thumb_'.$info[upImg][savename];               //生成的缩略图名
                $image -> thumb(245,157)->save('./Uploads/PrImages/'.$thumbname);   //生成245*157的缩略图并保存名为$thumbname
                $data[thumbname] = $thumbname;
                $Primages = M('Primages');          //图片名保存操作
                $result = $Primages->add($data);
                $data[id] = $result;
                $data[imgwidth] = $width;
                $data[imgheight] = $height;
                $dataArr = json_encode($data);
                echo $dataArr;
                exit();
            }else{          //上传不成功，图片大于1M
                echo 0;
                exit();
            }
        }else{
            echo -1;
        } 
    }
    // 项目图片删除
    public function imgDel(){
        if (IS_POST) {
            $id = $_POST['imgId'];
            $msg = M('primages')->delete($id);
            if ($msg) {
                echo "删除成功!";
            }else{
                echo "删除失败!";
            }
        }
    }
// =========================================================================================================================

    // public function next03(){
    //     $prid = $_GET[prid];
    //     $Primages = M('Primages');
    //     $map[prid] = $prid;
    //     $result = $Primages->where($map)->select();
    //     if($result){
    //         $resultArr = json_encode($result);
    //         echo $resultArr;
    //     }else{
    //         $data=1;
    //         $dataArr = json_encode($data);
    //         echo $dataArr;
    //     }
    // }
    //下一步进入融资需求页面
    // public function next02(){
    //     $companyid = $_GET[companyid];
    //     $Companydata = M('Companydata');
    //     $map[id] = $companyid;
    //     $result = $Companydata->where($map)->find();
    //     if($result){
    //         if($result[rear]!=''&&$result[legalperson]!=''&&$result[businesslicence]!=''&&$result[taxcertificate]!=''&&$result[companyimg]!=''){
    //             $data[company] = 1;
    //             $data[prid] = $result[prid];
    //         }else{
    //             $data[company] = 0;
    //         }
    //     }else{
    //         $data[company] = 0;
    //     }
    //     $dataArr = json_encode($data);
    //     echo $dataArr;
    // }
}

?>