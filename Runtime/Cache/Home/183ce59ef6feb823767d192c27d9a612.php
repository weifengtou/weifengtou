<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta charset="UTF-8">
<meta name='renderer' content='webkit' />
<meta name="author" content="wodrow451611cv@gmail.com">
<meta http-equiv="content－Type" content="text/html; charset=utf8">

<link rel="shortcut icon" href="/Public/static/images/wft.png">


<link href="/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<!-- <link href="/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="/Public/static/bootstrap/css/docs.css" rel="stylesheet">
<link href="/Public/static/bootstrap/css/onethink.css" rel="stylesheet"> -->

<link rel="stylesheet" type="text/css" href="/Public/Home/css/headfooter.css">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
<![endif]--><!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
<!-- <script type="text/javascript" src="/Public/Home/js/jquery.mousewheel.js"></script> -->
<!--<![endif]-->

<!--兼容插件-->
<!-- <script src="/Public/static/jquery-migrate-1.2.1.min.js"></script> -->
<!-- <script>
	$(function () {
	    var rtype = /(open|close)/i, getData = function (dt) {
	        var parentDl = dt.data('parent_dl') || dt.parent(), minHeight = dt.data('min_height') || dt.height(), maxHeight = dt.data('max_height') || parentDl.height();
	        if (!dt.data('parent_dl')) { dt.data('parent_dl', parentDl); dt.data('min_height', minHeight); dt.data('max_height', maxHeight); }
	        return { parentDl: parentDl, minHeight: minHeight, maxHeight: maxHeight };
	    }, maxLength = 13, rchs = /[^\u0000-\u00ff]/g, shell = $('.category_slider');
	    shell.click(function (e) {
	        var isOpen, data, tar = e.target, dt = $(tar).parent();
	        if (rtype.test(tar.className) && dt[0].nodeName.toUpperCase() === 'DT') { isOpen = RegExp.$1.toLowerCase() === 'close'; (data = getData(dt)).parentDl.animate({ height: isOpen ? data.minHeight : data.maxHeight }); tar.className = isOpen ? 'open' : 'close'; e.preventDefault(); }
	    });
	});
</script> -->

<!-- 添加 -->
<!--jquery兼容插件-->
<script src="/Public/static/jquery-migrate-1.2.1.min.js"></script>

<!-- 云适配 -->
<!-- <script id="allmobilize" charset="utf-8" src="http://a.yunshipei.com/353f49a64bc882918ddef00b32872e96 /allmobilize.min.js"></script><meta http-equiv="Cache-Control" content="no-siteapp" /><link rel="alternate" media="handheld" href="#" />  -->



<!-- 百度统计 -->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?5120fa4bf3e83b5a2c0553990c80325e";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

<!-- qq登陆 -->
<meta property="qc:admins" content="1533320576675165674756375" />
<!-- <script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" charset="utf-8" data-callback="true"></script> -->

<!-- 微博登录 -->
<meta property="wb:webmaster" content="b1628fb33d28a7bf" />

<!-- 手机端 -->
<?php if ($_GET['machine']!="pc"): ?>
	<script>
	if (navigator.userAgent.match(/mobile/i)){
		location.href = "http://wap.weifengtou.com"
	}
	</script>
<?php endif; ?>

<!-- ==========================layer插件==================================== -->
<script type="text/javascript" src="/Public/static/layer/layer.min.js"></script>
<script type="text/javascript" src="/Public/static/layer/extend/layer.ext.js"></script>

<script type="text/javascript" src="/Public/static/common.js"></script>

<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/register.css">
	<link rel="stylesheet"  href="/Public/Home/css/wwwexplan.css" type="text/css" />
	<!-- ========================悬浮区css============================================== -->
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/xuanfu.css">
	<!-- ========================我们的服务css========================================== -->
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/serve.css">
	<!-- ========================懂你落地页css========================================== -->
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/knowYou.css">
	<!-- ========================建议页css============================================== -->
	<script type="text/javascript" src="/Public/static/jquery.form.js" language="javascript"></script>
	<script type="text/javascript" src="/Public/Home/js/json2.js" language="javascript"></script>
    <script type="text/javascript" src="/Public/Home/js/register.js" language="javascript"></script>
    <!-- ========================悬浮区js============================================== -->
	<script type="text/javascript" src="/Public/Home/js/scrolltotop.js"></script>  
	<!-- ========================网站说明页小登录窗口 -->
	<script type="text/javascript" src="/Public/Home/js/index.js"></script>
</head>
<body>
	<!-- 头部 -->
	<!-- 导航条
================================================== -->
<div class="wftbg" style=" position:relative; z-index:10">
    <div class="wftt">
        <div class="wftl">
            <div class="shouye_l">
                <a class="brand" href="<?php echo U('Index/index');?>">
                    <img src="/Public/Home/images/handf/wftlogo.jpg" alt="让创业者跑得更快" height="55" width="445" />
                </a>
            </div>
            <div class="shouye_r">
                <div class="sy">
                    <a href="<?php echo U('Index/index');?>">
                        <img src="/Public/Home/images/handf/wftsy.gif" width="120" height="40" alt="网站首页" />
                    </a>
                </div>
                <div class="sy">
                    <a href="<?php echo U('Project/project');?>">
                        <img src="/Public/Home/images/handf/wftxm.gif" width="120" height="40" alt="好项目" />
                    </a>
                </div>
                <div class="sy">
                    <a href="<?php echo U('Invhome/investors');?>">
                        <img src="/Public/Home/images/handf/wfttzr.gif" width="120" height="40" alt="投资人" />
                    </a>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="dlzc">
            <!-- ==========================================会员中心下拉菜单========================================================= -->
            <div class="dlzc_l">
                <?php if(is_denglu()): ?><div class="afdl">
                        <li class="afdl_w dropdown" onmouseover="downmenu()" onmouseout="upmenu()">

                            <a href="<?php echo U('User/membercenter');?>" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:0;padding-right:0" >会员中心</a>
                            <ul class="dropdownmem-menu dropdown-menu" style="display:none; position:absolute; z-index:10000">
                                <li>
                                    <a href="javascript:power01();">已创建项目</a>
                                </li>
                                <li>
                                    <a href="javascript:power02();">创建项目</a>
                                </li>
                                <li>
                                    <a href="javascript:power03();">已投项目</a>
                                </li>
                                <li>
                                    <a onclick="javascript:shezhi();">账号设置</a>
                                </li>
                                <li>
                                    <a href="<?php echo U('User/logout');?>">安全退出</a>
                                </li>
                            </ul>
                        </li>

                    </div>
                    <?php else: ?>
                    <div style="margin-right:0">
                        <div class="dlz">
                            <a href="<?php echo U('User/login');?>">登录</a>
                        </div>
                        <div class="dlz">
                            <a href="<?php echo U('User/register');?>" style="padding-left:0;padding-right:0; color:#e41b23 !important">注册</a>
                        </div>
                    </div><?php endif; ?>
            </div>
            <!-- ===========================================服务中心下拉菜单============================================================ -->
            <div class="dlzc_r" style="position:relative;" onmouseover="downservemenu()" onmouseout="upservemenu()">
                <a>服务中心</a>
                <ul class="dropdownserve-menu dropdown-menu" style="display:none; position:absolute; z-index:10000">
                    <li>
                        <a href="<?php echo U('Luyan/luyanzhuanti');?>">路演专题</a>
                    </li>
                    <li>
                        <a href="<?php echo U('Weivideo/videoFir');?>">微风投电影</a>
                    </li>
                    <li>
                        <a href="<?php echo U('Article/lists?category=news');?>">新闻中心</a>
                    </li>
                    <li>
                        <a href="<?php echo U('Help/serve');?>">我们的服务</a>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
// ==============================会员中心下拉菜单========================================================
function downmenu(){
    $('.dropdownmem-menu').show();
}
function upmenu(){
    $('.dropdownmem-menu').hide();
}
// ===============================服务中心下拉菜单========================================================
function downservemenu(){
    $('.dropdownserve-menu').show();
}
function upservemenu(){
    $('.dropdownserve-menu').hide();
}
// ==============================会员下拉菜单操作权限判断==================================================
// =========进入以创建项目页======================
function power01(){
    $.ajax({
        url:"?s=home/user/power",
        success:function(data){
            var t = $.parseJSON(data);
            if(t.style == 1){
                window.location.href="?s=home/prcenter/createdproject";
            }else if(t.style == 2){
                layer.alert('投资人对此无操作权限',8);
            }else if(t.style == 3){
                layer.alert('请先选择身份',8);
            }
        }
    });
}
// =========进入创建项目页========================
function power02(){
    $.ajax({
        url:"?s=home/user/power",
        success:function(data){
            var t = $.parseJSON(data);
            if(t.style == 1){
                window.location.href="?s=home/prcenter/createproject";
            }else if(t.style == 2){
                layer.alert('投资人对此无操作权限',8);
            }else if(t.style == 3){
                layer.alert('请先选择身份',8);
            }
        }
    });
}
// =========进入已投项目页========================
function power03(){
    $.ajax({
        url:"?s=home/user/power",
        success:function(data){
            var t = $.parseJSON(data);
            if(t.style == 1){
                layer.alert('项目方对此无操作权限',8);
            }else if(t.style == 2){
                window.location.href="?s=home/Invcenter/entrepre";
            }else if(t.style == 3){
                layer.alert('请先选择身份',8);
            }
        }
    });
}
</script>
	<!-- /头部 -->
	
	<!-- 主体 -->
	
	<header>
	</header>

<div id="main-container" class="container">
    <div class="row">
        <!--  -->
        <!-- 左侧 nav
        ================================================== -->
            <!-- <div class="span3 bs-docs-sidebar">
                
                <ul class="nav nav-list bs-docs-sidenav">
                    <?php echo W('Category/lists', array($category['id'], ACTION_NAME == 'index'));?>
                </ul>
            </div>
         -->
        
	<div>

		<div class="beknowa_a">
			<div class="beknowa_b">
				<div class="beknowa_c"></div>
			</div>
		</div>

		<div class="beknowb_a">
			<div class="beknowb_b">
				<div class="beknowb_c"></div>
			</div>
		</div>

		<div class="beknowc_a">
			<div class="beknowc_b">
				<div class="beknowc_c"></div>
			</div>
		</div>

		<div class="beknowd_a">
			<div class="beknowd_b">
				<div class="beknowd_c"></div>
			</div>
		</div>

		<div class="beknowe_a">
			<div class="beknowe_b">
				<div class="beknowe_c"></div>
			</div>
		</div>

		<div class="beknowf_a">
			<div class="beknowf_b">
				<div class="beknowf_c"></div>
			</div>
		</div>

		<div class="beknowg_a">
			<div class="beknowg_b">
				<div class="beknowg_c"></div>
			</div>
		</div>

		<div class="beknowh_a">
			<div class="beknowh_b">
				<div class="beknowh_c"></div>
			</div>
		</div>

		<div class="beknowi_a">
			<div class="beknowi_b">
				<div class="beknowi_c"></div>
			</div>
		</div>

		<div class="beknowj_a">
			<div class="beknowj_b">
				<div class="beknowj_c"></div>
			</div>
		</div>

		<div class="beknowk_a">
			<div class="beknowk_b">
				<div class="beknowk_c"></div>
			</div>
		</div>

		<div class="beknowl_a">
			<div class="beknowl_b">
				<div class="beknowl_c"></div>
			</div>
		</div>

		<div class="beknowm_a">
			<div class="beknowm_b">
				<div class="beknowm_c"></div>
			</div>
		</div>

		<div class="beknown_a">
			<div class="beknown_b">
				<div class="beknown_c"></div>
			</div>
		</div>

		<div class="beknowo_a">
			<div class="beknowo_b">
				<div class="beknowo_c"></div>
			</div>
		</div>

		<div class="beknowp_a">
			<div class="beknowp_b">
				<div class="beknowp_c"></div>
			</div>
		</div>

		<div class="beknowq_a">
			<div class="beknowq_b">
				<div class="beknowq_c"></div>
			</div>
		</div>

		<div class="beknowr_a">
			<div class="beknowr_b">
				<div class="beknowr_c"></div>
			</div>
		</div>

		<div class="beknows_a">
			<div class="beknows_b">
				<div class="beknows_c"></div>
			</div>
		</div>

		<div class="beknowt_a">
			<div class="beknowt_b">
				<div class="beknowt_c"></div>
			</div>
		</div>

		<div class="beknowu_a">
			<div class="beknowu_b">
				<div class="beknowu_c"></div>
			</div>
		</div>

		<div class="beknowv_a">
			<div class="beknowv_b">
				<div class="beknowv_c"></div>
			</div>
		</div>

		<div class="beknoww_a">
			<div class="beknoww_b">
				<div class="beknoww_c"></div>
			</div>
		</div>

		<div class="beknowx_a">
			<div class="beknowx_b">
				<div class="beknowx_c"></div>
			</div>
		</div>

		<div class="beknowy_a">
			<div class="beknowy_b">
				<div class="beknowy_c"></div>
			</div>
		</div>

		<div class="beknowz_a">
			<div class="beknowz_b">
				<div class="beknowz_c"></div>
			</div>
		</div>

		<div class="beknowaa_a">
			<div class="beknowaa_b">
				<div class="beknowaa_c"></div>
			</div>
		</div>

		<div class="beknowab_a">
			<div class="beknowab_b">
				<div class="beknowab_c"></div>
			</div>
		</div>

		<div class="beknowac_a">
			<div class="beknowac_b">
				<div class="beknowac_c"></div>
			</div>
		</div>

		<div class="beknowad_a">
			<div class="beknowad_b">
				<div class="beknowad_c"></div>
			</div>
		</div>

		<div class="beknowae_a">
			<div class="beknowae_b">
				<div class="beknowae_c"></div>
			</div>
		</div>

		<div class="beknowaf_a">
			<div class="beknowaf_b">
				<div class="beknowaf_c">
					<div class="beknowaf_d"><a href="?s=home/user/register"></a></div>
				</div>
			</div>
		</div>

		<div class="beknowag_a">
			<div class="beknowag_b">
				<div class="beknowag_c"></div>
			</div>
		</div>

	</div>

    </div>
</div>

<!--<script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    })
</script>-->
	<!-- /主体 -->

	<!-- 底部 -->
	<!-- 底部
================================================== -->
<title><?php echo C('TITLE');?></title>
<meta name="KEYWORDS" content="<?php echo C('keywords');?>">
<meta name="DESCRIPTION" content="<?php echo C('description');?>" />

<div class="ttt">

    <div class="ttte">

        <?php $category=D('Category')-> getChildrenId(bottom_helps); $_vars = explode(',',$category); $j = 1; for ($i=0; $i < count($_vars); $i++) { ?>
            <ul id="ul<?php echo ($i); ?>">
                <?php $catInfo = M("category")-> where("id='".$_vars[$i]."'")->find(); if(empty($catInfo[name])){ $this->error('没有指定文档分类！'); } $cat2 = D('Category')->info($catInfo[name]); if($cat2 && 1 == $cat2['status']){ switch ($cat2['display']) { case 0: $this->error('该分类禁止显示！'); break; } } else { $this->error('分类不存在或被禁用！'); } $_list = D('Document')->lists($_vars[$i], '`level` DESC,`id` DESC', 1,true); ?>
                <li id="li<?php echo ($i); ?>"><?php echo ($catInfo[title]); ?></li>
                <?php foreach ($_list as $key => $value): ?>
                <li id="sli<?php echo ($j++); ?>">
                    <a attrtitle="<?php echo ($value[title]); ?>" href="<?php echo U('Article/detail?id='.$value['id']);?>" target="_black"><?php echo ($value[title]); ?></a>
                </li>
                <?php endforeach; ?></ul>
            <?php }?>
            <script>
                $("a[attrtitle='媒体报道']").attr({"href":"index.php?s=/Home/Article/lists/category/media_show","target":"_black"})
                $("a[attrtitle='网站说明']").attr({"href":"index.php?s=/Home/Help/wwwexplan","target":"_black"})
                $("a[attrtitle='新手须知']").attr({"href":"index.php?s=/Home/Help/serve","target":"_black"})
                $("a[attrtitle='新浪微博']").attr({'href':'http://weibo.com/u/3936877309',"target":"_black"})
                $("a[attrtitle='微信']").removeAttr('href')
                $("a[attrtitle='意见反馈']").attr({'href':'index.php?s=Home/Help/wwwsuggest',"target":"_black"})
                $(".article_rd ul li").each(function(){
                    if ($(this).children("a").text()=="新手须知") {
                        $(this).children("a").attr({"href":"index.php?s=/Home/Help/serve","target":"_black"})
                    };
                    if ($(this).children("a").text()=="意见反馈") {
                        $(this).children("a").attr({'href':'index.php?s=Home/Help/wwwsuggest',"target":"_black"})
                    };
                })
                $("a[attrtitle='平台公告']").parent('li').remove()
                $("a[attrtitle='招贤纳士']").parent('li').remove()
                $("a[attrtitle='注册流程']").attr({"href":"index.php?s=/Home/Help/xinshou","target":"_black"})
                $("a[attrtitle='我要投资']").attr({"href":"index.php?s=/Home/Help/xinshou","target":"_black"})
                $("a[attrtitle='我要融资']").attr({"href":"index.php?s=/Home/Help/xinshou","target":"_black"})
                $("a[attrtitle='资金保障']").attr({"href":"index.php?s=/Home/Help/baozhang","target":"_black"})
                $("a[attrtitle='风控保障']").attr({"href":"index.php?s=/Home/Help/baozhang","target":"_black"})
                $("a[attrtitle='法律保障']").attr({"href":"index.php?s=/Home/Help/baozhang","target":"_black"})
            </script>
            <script type="text/javascript">
            jQuery(document).ready(function($) {
                $("a[attrtitle='微信']").on('click',function(){
                    // alert('11');
                    var pageii = $.layer({
                        type: 1,
                        title: false,
                        area: ['460px', '380px'],
                        border: [0], //去掉默认边框
                        // shade: [0], //去掉遮罩
                        shade: [0.5, '#000'],
                        closeBtn: [0, true], //去掉默认关闭按钮
                        shift: 'top', //从左动画弹出
                        page: {
                            html: '<div style="width:460px; height:380px; border:1px solid #ccc; background-color:#fff;"><\div style="width:440px; height:45px; background:url(..\/public\/home\/images\/handf\/weix1.gif) 0 0 repeat-x; padding-left:20px; font-size:16px; font-weight:bold; line-height:45px; color:#000">关注微风投官方微信</div><\div style="width:160px; height:190px; font-size:14px; text-align:center; line-height:30px; margin:40px 150px 60px 150px"><\img src="/Public/static\/images\/weixin1.gif" />【微风投】微信订阅号<\/div><\div style="width:460px; height:44px; text-align:center; line-height:45px; color:#006576; font-size:14px;">打开微信，使用“扫一扫”即可关注微风投官方微信<\/div></div>'
                            // html: '<\div style="width:460px; height:380px; margin:30px auto; background:#fff; border:#ccc solid 1px;">
                            //         <\div style="width:440px; height:45px; background:url(..\/images\/handf\/weix1.gif) 0 0 repeat-x; padding-left:20px; font-size:16px; font-weight:bold; line-height:45px; color:#000">
                            //             关注微风投官方微信
                            //         </div>
                            //         <\div style="width:160px; height:190px; font-size:14px; text-align:center; line-height:30px; margin:40px 150px 60px 150px">
                            //             <\img src="/Public/Home\/images\/handf\/weix2.gif" />
                            //             【微风投】微信订阅号
                            //         <\/div>
                            //         <\div style="width:460px; height:44px; text-align:center; line-height:45px; color:#006576; font-size:14px;">
                            //         打开微信，使用“扫一扫”即可关注微风投官方微信
                            //         <\/div>
                            //     <\/div>'
                        }
                    });
                });
            });
                
            </script>

            <div class="clear"></div>

        </div>

    </div>

    <footer class="footer">
        <div class="dfoot">

            <div class="dfootn">

                <!-- <div class="lianfo">
                <ul>
                    <li>
                        <a>
                            <img src="/Public/Home/images/handf/wljc.gif" width="120" height="50" alt="wljc" />
                        </a>
                    </li>
                    <li>
                        <a>
                            <img src="/Public/Home/images/handf/bawz.gif" alt="bawz" width="139" height="50" />
                        </a>
                    </li>
                    <li>
                        <a>
                            <img src="/Public/Home/images/handf/wlgs.gif" alt="wlgs" width="120" height="50" />
                        </a>
                    </li>
                    <li>
                        <a>
                            <img src="/Public/Home/images/handf/xylm.gif" alt="zylm" height="50" width="120" />
                        </a>
                    </li>
                    <li>
                        <a>
                            <img src="/Public/Home/images/handf/sfyz.gif" width="139" height="50" alt="sfyz" />
                        </a>
                    </li>
                </ul>
            </div>
            -->
            <div class="dfootw">
                客服热线 400-700-8998 &nbsp;&nbsp; 客服邮箱 kefu@weifengtou.com
                <br />
                COPYRIGHT©2011-2016 www.weifengtou.com 豫ICP备11020081号-2 版权所有 微风投
                <?php if ($_GET['machine']=="pc"): ?>
                	<br>
	                <a style="color:#fff" href="http://wap.weifengtou.com">返回手机版</a>
	            <?php endif; ?>
            </div>
            <div class="clear"></div>
            

        </div>
        <div class="clear"></div>

    </div>
</footer>

<!-- ===========================================账号设置============================================================ -->
<style type="text/css">
* { margin: 0; padding: 0; }
body {font: 14px; color: #444; background:#f6f6f6; font-family:"微软雅黑" }
img { border: 0; vertical-align: bottom; }
ul, li, dt { margin: 0; padding: 0; list-style: none; }
a { text-decoration: none; }
a:link { color: #000000; text-decoration: none; }
a:hover {  cursor: pointer; color:#FF0099; text-decoration: none;}
a.underline { text-decoration: underline; }
a:visited { color: #000000; text-decoration: none; }
form, ul, li, p, h1, h2, h3, h4, h5, h6 { padding:0; margin:0}
.clear { clear: both; line-height:0px;height:1px;overflow:hidden;*display:inline; }
.xiuchang{ width:450px; height:283px; background:url(/Public/Home/images/public/shezhi/xiugbg1.gif) 0 0 repeat}
.xiuchang_a{ width:435px; height:44px; background:url(/Public/Home/images/public/shezhi/xiugbg2.gif) 0 0 repeat; padding-left:15px; color:#fff; font-size:16px; line-height:44px}
.xiuchang_b{ width:444px; height:196px; background:#fff; margin:0 auto; padding-top:40px}
.xiuchang_l{ float:left; width:125px; text-align:right; font-size:12px; height:20px; line-height:20px; color:#555}
.xiuchang_r{ float:right; font-size:12px; height:20px; line-height:20px; width:315px;}
.xiuchang_r input{ width:205px; height:20px; line-height:20px; border:#7e9db9 solid 1px; padding:0 10px; color:#444; font-size:12px; line-height:20px}
.xiuchang_rr{ float:right; width:315px;}
.xiuchang_rr img{ margin-right:25px; cursor:pointer; width:88px; height:29px}
</style>
<div id="shezhi" style="display:none;">
    <!--修改密码开始-->
    <div class="xiuchang">
        <div class="xiuchang_a">修改我的密码</div>
        <div class="xiuchang_b">
            <div style="margin:15px 0">
                <div class="xiuchang_l">旧密码：</div>
                <div class="xiuchang_r">
                    <input type="password" name="oldpass" placeholder="请输入旧密码" />
                </div>
                <div class="clear"></div>
            </div>
            <div style="margin:15px 0">
                <div class="xiuchang_l">新密码：</div>
                <div class="xiuchang_r">
                    <input type="password" name="newpass" placeholder="请输入新密码" />
                </div>
                <div class="clear"></div>
            </div>
            <div style="margin:15px 0">
                <div class="xiuchang_l">确认新密码：</div>
                <div class="xiuchang_r">
                    <input type="password" name="repass" placeholder="请再次输入新密码" />
                </div>
                <div class="clear"></div>
            </div>
            <div style="margin-top:25px">
                <div class="xiuchang_rr">
                    <img src="/Public/Home/images/public/shezhi/xiugbc1.gif" onclick="newpassok()" />
                    <img src="/Public/Home/images/public/shezhi/xiugbc2.gif" onclick="newpassno()" />
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<script>
    function newpassok () {
        var obj = {
            'oldpass':$('input[name=oldpass]').val(),
            'newpass':$('input[name=newpass]').val(),
        }
        if (obj.newpass=='') {
            layer.alert("密码不能为空！请输入！",8)
            return false;
        }
        if ($.trim(obj.newpass).length>20||$.trim(obj.newpass).length<6) {
            layer.alert("密码长度不符合要求！请重新输入！",8)
            return false;
        }
        if (obj.oldpass==obj.newpass) {
            layer.alert("新密码与初始密码不能相同！",8)
            return false;
        }
        if (obj.newpass!=$('input[name=repass]').val()) {
            layer.alert("确认新密码不一致！",8)
            return false;
        }
        $.post('index.php?s=Home/User/newpass', {obj:obj}, function(data, textStatus, xhr) {
            if (data=='2') {
                layer.alert("未知异常！",8)
            }else if(data=='1'){
                layer.alert("修改密码成功！",1)
                layer.closeAll()
            }else{
                layer.alert("原密码输入错误！",8)
            }
        });
    }
    function newpassno () {
        layer.closeAll()
    }
</script>
<script>
    function shezhi () {
        shezhimima()
    }
</script>
<!-- ===========================================账号设置============================================================ -->

<!-- cncc 统计 -->
<script src="http://s11.cnzz.com/z_stat.php?id=1254172912&web_id=1254172912" language="JavaScript"></script>
<script>$("a[title=站长统计]").hide()</script>

<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "", //当前网站地址
		"APP"    : "/index.php?s=", //当前项目地址
		"PUBLIC" : "/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>

<!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden">
    <!-- 用于加载统计代码等隐藏元素 -->
    
</div>
	<!-- /底部 -->
</body>
</html>