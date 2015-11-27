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
	<link rel="stylesheet"  href="/Public/Home/css/index.css" type="text/css" />
	<link rel="stylesheet" href="/Public/static/jPages/css/jPages.css" /> 
	<!-- ========================悬浮区css============================================== -->
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/xuanfu.css">
	<script src="/Public/static/jPages/js/jPages.min.js"></script>
  	<script type="text/javascript" src="/Public/Home/js/superslide.2.1.js"></script>
	<script type="text/javascript" src="/Public/Home/js/index.js"></script>
	<!-- ========================悬浮区js============================================== -->
	<script type="text/javascript" src="/Public/Home/js/scrolltotop.js"></script>

	<script type="text/javascript" src="/Public/Home/js/invhome.js"></script>
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
	
<style>
    map area{cursor: pointer;background: #000}
</style>
	<!-- ==========================================幻灯片================================================== -->
	<header style="position:relative; z-index:1">
	    <div class="full-slide">
	        <div class="bd">
	            <ul>
	            	<li _src="url(/Public/Home/images/index/wft8.jpg)" style="background:center 0 no-repeat; cursor:pointer" onclick="jacascript:link2wutonghui();"></li>
	                <li _src="url(/Public/Home/images/index/wft9.jpg)" style="background:center 0 no-repeat;">
	                	<p class="imgbtn" onclick="javascript:openHelpServe();" imgw="1920" imgh="500" x1v="840" y1v="378" x2v="1081" y2v="420"></p>
	                </li>
	                <li _src="url(/Public/Home/images/index/wft10.jpg)" style="background:center 0 no-repeat;">
	                	<p class="imgbtn" onclick="javascript:createproject();" imgw="1920" imgh="500" x1v="956" y1v="314" x2v="1116" y2v="365"></p>
	                	<p class="imgbtn" onclick="javascript:becomeinvestor();" imgw="1920" imgh="500" x1v="956" y1v="375" x2v="1116" y2v="416"></p>
	                </li>
	                <li _src="url(/Public/Home/images/index/wft11.jpg)" style="background:center 0 no-repeat;">
	                	<p class="imgbtn" onclick="javascript:createproject();" imgw="1920" imgh="500" x1v="484" y1v="352" x2v="643" y2v="394"></p>
	                </li>
	                <li _src="url(/Public/Home/images/index/wft12.jpg)" style="background:center 0 no-repeat;">
	                	<p class="imgbtn" onclick="javascript:becomeinvestor();" imgw="1920" imgh="500" x1v="880" y1v="398" x2v="1040" y2v="440"></p>
	                </li>
	                <li _src="url(/Public/Home/images/index/wft13.jpg)" style="background:center 0 no-repeat;"></li>
	            </ul>
	            <a id="helpServe" style="display:none;" href="<?php echo U('Help/serve');?>" target="_blank"></a>
	            <a id="wutonghui" style="display:none;" href="<?php echo U('Help/wutonghui');?>" target="_blank"></a>
	            <script type="text/javascript">
	            function link2wutonghui () {
	            	$("#wutonghui")[0].click();
	            }
	            function openHelpServe () {
	            	$("#helpServe")[0].click();
	            }
            	function imgbtnshow () {
	            	$(".imgbtn").each(function (e) {
	            		var x1 = $(this).attr("x1v");
	            		var y1 = $(this).attr("y1v");
	            		var x2 = $(this).attr("x2v");
	            		var y2 = $(this).attr("y2v");
	            		var w = $(this).attr("imgw");
	            		var h = $(this).attr("imgh");
	            		var p_w = $(this).parent().width();
	            		var width = x2 - x1;
	            		var height = y2 - y1;
	            		if (eval(w)>eval(p_w)) {
	            			var m_l = x1 - (w - p_w)/2
	            		}else{
	            			var m_l = x1 + (p_w - w)/2
	            		}
	            		m_t = y1;
	            		if ($(this).prev().attr("class")=="imgbtn") {
	            			m_t = $(this).prev().attr("y2v");
	            			m_t = y1 - m_t;
	            		}
	            		$(this).css({
	            			// "background":"#000",
	            			"cursor":"pointer",
		            		"width":width,
		            		"height":height,
		            		"margin-left":m_l+"px",
		            		"margin-top":m_t+"px"
	            		})
	            	})
            	}
	            jQuery(document).ready(function($) {
	            	imgbtnshow();
	            	window.onresize=imgbtnshow;
	            });
	            </script>
	        </div>
	        <div class="hd">
	            <ul></ul>
	        </div>
	        <span class="prev"></span>
	        <span class="next"></span>
	    </div>
	    <script type="text/javascript">
	    jQuery(".full-slide").hover(
	        function() {
	          jQuery(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
	        },
	        function() {
	          jQuery(this).find(".prev,.next").fadeOut()
	        }
	    ); 
	    jQuery(".full-slide").slide({
	        titCell:".hd ul",
	        mainCell:".bd ul",
	        effect:"fold",
	        autoPlay:true,
	        autoPage:true,
	        trigger:"click",
	        startFun: function(i){
	          var curLi=jQuery(".full-slide .bd li").eq(i);
	          if (!!curLi.attr("_src")){
	             curLi.css("background-image",curLi.attr("_src")).removeAttr("_src")
	          }
	        }
	    });
	    jQuery(document).ready(function($) {
	    	// $(".bd ul").attr('style', 'position: relative; width: 1100px; height: 595px;');
	    	// $(".bd ul").addClass('width_1100')
	    });
	    </script>
	    <div class="allmain"></div>
	</header>
	<!-- ==============================================js特效 二维码 建议 客服================================================= -->
	

<!-- ================================客服========================================= -->
<!-- <script src="/welive/welive.js"></script>
-->
<!-- <script src="http://kefu.qycn.com/vclient/state.php?webid=99267" language="javascript" type="text/javascript"></script> -->
<!-- ================================特效========================================= -->
<div class="xuanfu" style="display:none;">
    <div class="every">
        <a href="http://kefu.qycn.com/vclient/chat/?websiteid=99267&clienturl=http%3A%2F%2Fwww.weifengtou.com" target="_blank">
            <div class="erery_e">
            </div>
        </a>
    </div>
    <div class="every">
        <div class="erery_a">
            <div class="everyc_ewm">
                <img src="/Public/Home/images/fuchuang/gtel.png">
            </div>
        </div>
    </div>
    <div class="every">
        <div class="erery_c">
            <div class="everyc_ewm">
                <img src="/Public/Home/images/fuchuang/gewm.png">
            </div>
        </div>
    </div>
    <div class="every">
        <a href="index.php?s=Home/Help/wwwsuggest" target="_black">
            <div class="erery_b"></div>
        </a>
    </div>

    <div class="every" id="topcontrol" class="z_index999" style="display:none;z-index:999;">
        <div class="erery_d" style="z-index:999;"></div>
    </div>
</div>
<script>
    $(function(){   
        if (window.screen.width<800) {
            
        }else{
            $(".xuanfu").show()
            scrolltotop.offset(18,88);
            scrolltotop.init(); 
            // $(".xuanfu").show()
        }
    }); 
</script>
<!-- ================================================================================================ -->

	<!-- =================================================================================================== -->

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
        
	
	<div class="all">

		<!--浮动结束-->
		<!--总-->
		<div class="allmain">
			
			
	<div class="newin_bt">
    	<div class="newin_bta">
        大型路演会
        	<font>
组织融资方和投资人进行线下见面，增加双方的了解和信任，同时对项目可投资性进行一次真实的考验。
            </font>
        </div>
    </div>

<!-- 路演 -->		
<?php  $today = date("Y-m-d"); $luyans = M("Document_luyan")->order("riqi DESC")->limit("5")->select(); ?>
<div class="lyh">
	<div class="lyhm">
		<?php foreach ($luyans as $key => $value): ?>
			<?php  $info = D("Document")->where("status = 1")->detail($value[id]); $zero1=strtotime(date("Y-m-d")); $zero2=strtotime($info[riqi]); if ($zero1<$zero2) { $url = "index.php?s=Home/Luyan/luyansignup"; }else{ $url = "index.php?s=Home/Luyan/luyanzhuanti&riqi=".$info[riqi]; } ?>
			<ul>
				<!-- 图片 -->		
				<div class="lyhm_l">
					<a href="<?php echo ($url); ?>" target="_blank">
						<?php $cover_info = get_cover($info['cover_id']) ?>
						<img src="./<?php echo ($cover_info['path']); ?>" style="width:480;height:260px;" />		
					</a>
				</div>
				<!-- 介绍 -->		
				<div class="lyhm_r">
					<div class="lyhms">
						<h2>
							<a href="<?php echo ($url); ?>" target="_blank"><?php echo ($info[title]); ?></a>
						</h2>
						<p>
							会议时间：<?php echo ($info[starttime]); ?> &nbsp;&nbsp; &nbsp; 联系人：<?php echo ($info[lianxiren]); ?>&nbsp;&nbsp;&nbsp;    联系电话：<?php echo ($info[dianhua]); ?>
						</p>
						<p>会议地点：<?php echo ($info[dizhi]); ?></p>
					</div>
					<div class="lyhmz">
						<p>
							<?php echo ($info[shuoming]); ?>
						</p>
					</div>
					<!-- 报名 -->		
					<div class="lyhmx">
						<?php  if($zero1<$zero2): ?>		
						<a href="index.php?s=Home/Luyan/luyansignup">
							<!-- 路演报名 -->		
							<img src="/Public/Home/images/index/lyhbm.gif" width="142" height="36" alt="报名路演" />		
						</a>
						<?php else : ?>		
						<img src="/Public/Home/images/index/bmjz.gif" width="142" height="36" alt="报名截止" />		
						<?php endif ?></div>
				</div>
			</ul>
		<?php endforeach; ?>
	</div>

	<div class="lyhn">
		<ul>
			<?php foreach ($luyans as $key => $value): ?>
				<?php  $info = D("Document")->detail($value[id]); $zero1=strtotime(date("Y-m-d")); $zero2=strtotime($info[riqi]); if ($zero1<$zero2) { $url = "index.php?s=Home/Luyan/luyansignup"; }else{ $url = "index.php?s=Home/Luyan/luyanzhuanti&riqi=".$info[riqi]; } ?>
				<li>
					<a href="<?php echo ($url); ?>" target="_blank">
						<span><?php echo ($info[riqi]); ?>路演</span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="clear"></div>
	</div>

	<div class="clear"></div>
</div>

<script type="text/javascript">jQuery(".lyh").slide({autoPlay:true});</script>


			
			<!--融资中的项目-->
<div>
    <div class="newin_bt">
        <div class="newin_bta">
            融资中的项目
            <font>
            这些项目是微风投正在融资的项目，抓紧抢投，获得超额利润。
            </font>
        </div>
    </div>

    <!--改动后-->
    <div id="rzs">
        <?php foreach ($rzs as $key => $v1): ?>
        

        			<div class="xm_new">
                        <div class="xmnewa">
                            <a href="index.php?s=home/project/prdetail&pid=<?php echo ($v1[id]); ?>" target="_blank">
                                <?php if (!$v1[logo]): ?>
			                    <img src="/Public/Home/images/index/item01.gif" width="317" height="175"  />
			                    <?php else: ?>
			                    <img onclick='location.href("index.php?s=home/project/prdetail&pid=<?php echo ($v1[id]); ?>")' src="./Uploads/Album/<?php echo ($v1[logo]); ?>" style="max-width:368px;max-height:220px;" />
			                    <?php endif; ?>
                                <div class="xmnewb"> <strong><?php echo ($v1[pjname]); ?></strong>
                                    <br>
                                    <p><?php echo ($v1[pjintroduce]); ?></p>
                                </div>
                            </a>
                        </div>

                        <div style="padding:15px 0 0 0"></div>

                        <div class="xmnewb">
                            <div class="xmnewc">
                                ¥
                                <span><?php echo number_format($v1[budget]);?></span>
                                元融资金额
                            </div>
                            <div class="clear"></div>
                            <!--百分比-->
                            <div class="xmnewd">
                                <div class="xmnewbft">
                                <?php if($v1[money] > $v1[budget]){ $ec = 100; $attrleft = 0; }else{ $ec = round($v1[money]/$v1[budget]*100,2); if ($ec<20) { $attrleft = 1; }else{ $attrleft = 0; } } ?>
                                    <div class="xmnewbft_l" style="width:<?php echo ($ec); ?>%"></div>
                                    <div class="clear"></div>
                                </div>
                            </div>

                            <!--融资额度-->
                            <div>
                                <div class="xmnewmo xmnewc">
                                    已融资：
                                    <span>¥<?php echo number_format($v1[money]); ?></span>
                                    元
                                </div>
                                <div class="xmnewc">
                                    已融资：
                                    <span><?php echo ($ec); ?></span>
                                    %
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>

        <?php endforeach; ?>

        <div class="clear"></div>
        <script>
            jQuery(document).ready(function($) {
                $('#rzs :nth-child(3n)').css({"margin-right":"0"})
            });
        </script>
    </div>

    <!--更多-->
    <div class="xmmore">
        <div class="xmmorea">
            <a href="index.php?s=home/project/project&prrateid=<?php echo ($rzs[0][prrate]); ?>" target="_blank"><img src="/Public/Home/images/index/newmore.gif"></a>
        </div>
    </div>

</div>


<!--预热中的项目-->

<div>
    <div class="newin_bt">
        <div class="newin_bta">
            预热中的项目
            <font>
            这些项目是微风投优选项目，提前预约，先人一步把握投资机会。
            </font>
        </div>
    </div>

    <!--改动后-->
    <div id="yrs">

        <?php foreach ($yrs as $key => $v2): ?>
        				<div class="xm_new">
                            <div class="xmnewa">
                                <a href="index.php?s=home/project/prdetail&pid=<?php echo ($v2[id]); ?>" target="_blank">
                                    <?php if (!$v2[logo]): ?>
    			                    <img src="/Public/Home/images/index/item01.gif" width="317" height="175"  />
    			                    <?php else: ?>
    			                    <img onclick='location.href("index.php?s=home/project/prdetail&pid=<?php echo ($v2[id]); ?>")' src="./Uploads/Album/<?php echo ($v2[logo]); ?>" style="max-width:368px;max-height:220px;" />
    			                    <?php endif; ?>
                                    <div class="xmnewb"> <strong><?php echo ($v2[pjname]); ?></strong>
                                        <br>
                                        <p><?php echo ($v2[pjintroduce]); ?></p>
                                    </div>
                                </a>
                            </div>

                            <div style="padding:15px 0 0 0"></div>

                            <div class="xmnewb">
                                <div class="xmnewc">
                                    ¥
                                    <span><?php echo number_format($v2[budget]);?></span>
                                    元融资金额
                                </div>
                                <div class="clear"></div>
                                <!--百分比-->
                                <div class="xmnewd">
                                    <div class="xmnewbft">
                                    <?php if($v2[money] > $v2[budget]){ $ec = 100; $attrleft = 0; }else{ $ec = round($v2[money]/$v2[budget]*100,2); if ($ec<20) { $attrleft = 1; }else{ $attrleft = 0; } } ?>
                                        <div class="xmnewbft_l" style="width:<?php echo ($ec); ?>%"></div>
                                        <div class="clear"></div>
                                    </div>
                                </div>

                                <!--融资额度-->
                                <div>
                                    <div class="xmnewmo xmnewc">
                                        已融资：
                                        <span>¥<?php echo number_format($v2[money]); ?></span>
                                        元
                                    </div>
                                    <div class="xmnewc">
                                        已融资：
                                        <span><?php echo ($ec); ?></span>
                                        %
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>

        <?php endforeach; ?>

        <div class="clear"></div>

        <script>
            jQuery(document).ready(function($) {
                $('#yrs :nth-child(3n)').css({"margin-right":"0"})
            });
        </script>

    </div>

    <!--更多-->
    <div class="xmmore">
        <div class="xmmorea">
            <a href="index.php?s=home/project/project&prrateid=<?php echo ($yrs[0][prrate]); ?>" target="_blank"><img src="/Public/Home/images/index/newmore.gif"></a>
        </div>
    </div>
</div>

<!--融资成功的项目-->
<div>
    <div class="newin_bt">
        <div class="newin_bta">
            融资成功的项目
            <font>
            这些项目是在微风投已经融资成功的项目，融钱融人，分享成功经验。
            </font>
        </div>
    </div>

    <!--改动后-->
    <div id="oks">

        <?php foreach ($oks as $key => $v3): ?>
        				<div class="xm_new">
                            <div class="xmnewa">
                                <a href="index.php?s=home/project/prdetail&pid=<?php echo ($v3[id]); ?>" target="_blank">
                                    <?php if (!$v3[logo]): ?>
    			                    <img src="/Public/Home/images/index/item01.gif" width="317" height="175"  />
    			                    <?php else: ?>
    			                    <img onclick='location.href("index.php?s=home/project/prdetail&pid=<?php echo ($v3[id]); ?>")' src="./Uploads/Album/<?php echo ($v3[logo]); ?>" style="max-width:368px;max-height:220px;" />
    			                    <?php endif; ?>
                                    <div class="xmnewb"> <strong><?php echo ($v3[pjname]); ?></strong>
                                        <br>
                                        <p><?php echo ($v3[pjintroduce]); ?></p>
                                    </div>
                                </a>
                            </div>

                            <div style="padding:15px 0 0 0"></div>

                            <div class="xmnewb">
                                <div class="xmnewc">
                                    ¥
                                    <span><?php echo number_format($v3[budget]);?></span>
                                    元融资金额
                                </div>
                                <div class="clear"></div>
                                <!--百分比-->
                                <div class="xmnewd">
                                    <div class="xmnewbft">
                                    <?php if($v3[money] > $v3[budget]){ $ec = 100; $attrleft = 0; }else{ $ec = round($v3[money]/$v3[budget]*100,2); if ($ec<20) { $attrleft = 1; }else{ $attrleft = 0; } } ?>
                                        <div class="xmnewbft_l" style="width:<?php echo ($ec); ?>%"></div>
                                        <div class="clear"></div>
                                    </div>
                                </div>

                                <!--融资额度-->
                                <div>
                                    <div class="xmnewmo xmnewc">
                                        已融资：
                                        <span>¥<?php echo number_format($v3[money]); ?></span>
                                        元
                                    </div>
                                    <div class="xmnewc">
                                        已融资：
                                        <span><?php echo ($ec); ?></span>
                                        %
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>

        <?php endforeach; ?>

        <div class="clear"></div>

        <script>
            jQuery(document).ready(function($) {
                $('#oks :nth-child(3n)').css({"margin-right":"0"})
            });
        </script>

    </div>

    

    <script>
        jQuery(document).ready(function($) {
            $(".yddiiy").each(function(index, val) {
                if ($(this).attr("attrleft") == 1) {
                    $(this).children(".ddiiy-fo").animate({left: "+=40px"})
                }
            });
        });
    </script>

    <!--更多-->
    <div class="xmmore">
        <div class="xmmorea">
            <a href="index.php?s=home/project/project&prrateid=<?php echo ($oks[0][prrate]); ?>" target="_blank"><img src="/Public/Home/images/index/newmore.gif"></a>
        </div>
    </div>
</div>



			<!--微风投认证投资人-->

<div class="newin_bt">
    <div class="newin_bta">
        认证投资人
        <font>
        以诚待人，信守承诺。
        </font>
    </div>
</div>

<div id="tzrs">
	<?php foreach ($tzrs as $key => $v4): ?>
	<?php  $v4info = get_child_detail($v4[id],2); ?>
	<div class="tzr_new">
        <div class="tzrnew_l">
            <a href="<?php echo ($v4info[0][url]); ?>" target="_blank">
                <img src="<?php echo ($v4info[0][face_img]); ?>"></a>
        </div>

        <div class="tzrnew_r">
            <div class="tzrnewra">
                <a href="<?php echo ($v4info[0][url]); ?>" target="_blank" style="float:left"><?php echo ($v4info[0][showname]); ?></a>
                <div class="tzrnewrb">
                    <a onclick="javascript:proDelivery(<?php echo ($v4info[0][id]); ?>);">投递项目</a>
                </div>
                <div class="clear"></div>
            </div>
            <div style="padding:9px 0 0 0; border-top:#ccc solid 1px"></div>
            <div class="tzrnewrc">
                <p>投资意向：<?php  $trade = explode('&nbsp;',$v4info[0][intentionname]); if(count($trade) > 2){ echo $trade[0].'&nbsp;'.$trade[1].'&nbsp;'.'<font color="#00f;" style="position:relative;" id="more'.$v4info[0][uid].'" onmouseover="mouseover('.$v4info[0][uid].')" onmouseout="mouseout('.$v4info[0][uid].')">••••<span style="display:none;position:absolute;width:200px;right:-220px;top:-10px;color:#fff;background:#8e5700;font-size:12px;padding:10px; z-index:20" id="moretrade'.$v4info[0][uid].'">'.$v4info[0][intentionname].'</span></font>'; }else{ echo $v4info[0][intentionname]; } ?></p>
            </div>
            <script type="text/javascript">
            function mouseover(id){
            	var moretradeid = 'moretrade'+id;
            	$("#"+moretradeid).show();
            }
            function mouseout(id){
            	var moretradeid = 'moretrade'+id;
            	$("#"+moretradeid).hide();
            }
            </script>

            <div class="tzrnewrc">
                <p>投资金额：￥<?php echo number_format($v4info[0][min_maney]); ?>—￥<?php echo number_format($v4info[0][max_maney]); ?></p>
            </div>
            <div>
                <div class="tzrnewrd tzrnewrd_f">粉丝：<?php echo count(M('attention')->where("atted_id='".$v4info[0][uid]."'")->select()); ?></div>

                <div class="tzrnewrd tzrnewrd_y">约谈：<?php echo count(M()->query("SELECT
						CASE wft_webmsg.sendid 
							WHEN '".$v4info[0][uid]."' THEN wft_webmsg.receiveuid 
						ELSE wft_webmsg.sendid END AS other
						FROM `wft_webmsg`
						WHERE 
						sendid = '".$v4info[0][uid]."' OR receiveuid = '".$v4info[0][uid]."'
						GROUP BY other")); ?></div>

                <div class="tzrnewrd tzrnewrd_t" style="margin-right:0">投资：<?php echo count(M("financing")->where("pid='".$v4info[0][uid]."'")->select()); ?></div>
            </div>
        </div>

        <div class="clear"></div>
    </div>
	<?php endforeach; ?>

	<script>$("#tzrs div.tzr_new:even").css({"float":"right"})</script>

	<div class="clear"></div>

</div>

<!--更多-->
<div class="xmmore">
    <div class="xmmorea">
        <a href="index.php?s=home/invhome/investors" target="_blank"><img src="/Public/Home/images/index/newmore.gif"></a>
    </div>
</div>

			<!--微风投头条-->

<div class="newin_bt">
    <div class="newin_bta">
        微风投头条
        <font>
        微风投头条结汇与此。
        </font>
    </div>
</div>

<div class="newss">
	
	<!--图片轮播-->
	<div class="newss_l">
		<style type="text/css">
		#banner_news { position: relative; width: 570px; height: 300px; overflow: hidden; }
		#banner_list img { border: 0px; width:570px; height:300px;}
		#banner_bg { position: absolute; bottom: 0; background-color: #000; height: 60px; filter: Alpha(Opacity=30); opacity: 0.8; z-index: 1000; cursor: pointer; width: 570px; }
		#banner_info { position: absolute; bottom: 0; left: 5px; height:50px; color: #fff; z-index: 1001; cursor: pointer; font-size:16px}
		#banner_text { position: absolute; width: 120px; z-index: 1002; right: 3px; bottom: 3px;}
		#banner_news ul { position: absolute; list-style-type: none; filter: Alpha(Opacity=80); opacity: 1; z-index: 1002; margin: 0; padding: 0; bottom: 3px; right: 5px; }
		#banner_news ul li { padding: 0px 8px; float: left; display: block; color:#f39c11 !important; background: #fff; cursor: pointer; border: 1px solid #333;}
		#banner_news ul li.on { background-color:#ffe7c5; color:#7b7b7b !important;}
		#banner_list a { position: absolute; }
		<!--
		让四张图片都可以重叠在一起-->
		</style>

		<script type="text/javascript">
		var t = n =0, count;
		$(document).ready(function(){ 
		count=$("#banner_list a").length;
		$("#banner_list a:not(:first-child)").hide();
		$("#banner_info").html($("#banner_list a:first-child").find("img").attr('alt'));
		$("#banner_info").click(function(){window.open($("#banner_list a:first-child").attr('href'), "_blank")});
		$("#banner_news li").click(function() {
		var i = $(this).text() -1;//获取Li元素内的值，即1，2，3，4
		n = i;
		if (i >= count) return;
		$("#banner_info").html($("#banner_list a").eq(i).find("img").attr('alt'));
		$("#banner_info").unbind().click(function(){window.open($("#banner_list a").eq(i).attr('href'), "_blank")})
		$("#banner_list a").filter(":visible").fadeOut(500).parent().children().eq(i).fadeIn(1000);
		document.getElementById("banner_news").style.background="";
		$(this).toggleClass("on");
		$(this).siblings().removeAttr("class");
		});
		t = setInterval("showAuto()", 4000);
		$("#banner_news").hover(function(){clearInterval(t)}, function(){t = setInterval("showAuto()", 4000);});
		})

		function showAuto()
		{
		n = n >=(count -1) ?0 : ++n;
		$("#banner_news li").eq(n).trigger('click');
		}
		</script>
		<div id="banner_news">
			<div id="banner_bg"></div>
			<!--标题背景-->
			<div id="banner_info"></div>
			<!--标题-->
			<ul>
				<li class="on">1</li>
				<li>2</li>
				<li>3</li>
				<li>4</li>
			</ul>
			<div id="banner_list">
				<?php $category=D('Category')->getChildrenId(news); $__LIST__ = D('Document')->where("position>3")->lists($category, '`level` DESC,`id` DESC', 1,true); if(is_array($__LIST__)): $i = 0; if( count($__LIST__)==0 ) : echo "" ; else: foreach($__LIST__ as $key=>$article): $mod = ($i % 2 ); ++$i; if ($article[position]>3): ?>
					<?php $info = D('Document')->detail($article[id]); ?>
					<a class="index_news_img" href="<?php echo U('Article/detail?id='.$article['id']);?>" target="_blank">
						<?php $index_image = M('picture')->where("id='$info[index_image]'")->find(); ?>
						<?php if ($index_image[path]): ?>
						<img src=".<?php echo ($index_image[path]); ?>" title="<?php echo ($article[title]); ?>" alt="<?php echo ($article[title]); ?>" />
						<?php else: ?>
						<img src="/Public/static/images/nop.gif" titele="<?php echo ($article[title]); ?>" alt="<?php echo ($article[title]); ?>" />
						<?php endif; ?>
					</a>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
			<script>
				$(".index_news_img:gt(3)").remove()
			</script>
		</div>
	</div>
	<div class="newss_r">
		<?php $category=D('Category')->getChildrenId(news); $__LIST__ = D('Document')->where("position>3")->lists($category, '`level` DESC,`id` DESC', 1,true); if(is_array($__LIST__)): $i = 0; if( count($__LIST__)==0 ) : echo "" ; else: foreach($__LIST__ as $key=>$article): $mod = ($i % 2 ); ++$i; if ($article[position]>3): ?>
			<div class="newz">
				<div class="newz_l">
					<a href="<?php echo U('Article/detail?id='.$article['id']);?>" target="_blank"><?php echo ($article["title"]); ?></a>
				</div>
				<div class="newz_r"><?php echo (date('Y.m.d',$article["create_time"])); ?></div>
				<div class="clear"></div>
			</div>
		<?php endif; endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<script>
	$(".newz:gt(5)").remove()
	</script>
	<div class="clear"></div>

</div>

	<!--更多-->
    <div class="xmmore">
        <div class="xmmorea">
            <a href="<?php echo U('Article/lists?category=news');?>" target="_blank"><img src="/Public/Home/images/index/newmore.gif"></a>
        </div>
    </div>

			<div>
				<div class="why">

					<h2>
						<img src="/Public/Home/images/index/whybt1.gif" width="220" height="40" />
					</h2>
					<p>
						微风投专注小微实体企业融资，线下实地考察，精选优质项目，独创分期模式确保投资人资金安全，操作模式安全透明、流程完善;让价值链的每一个环节都成为赢家。
					</p>
				</div>
				<div class="why rightt">
					<h2>
						<img src="/Public/Home/images/index/whybt2.gif" width="415" height="40" />
					</h2>
					<p>投资去向透明化：资金使用情况短信通知，投资人清楚资金去向。</p>
					<p>运营项目透明化：项目运营数据定期反馈，投资人清晰项目运营状况。</p>
					<p>监管过程透明化：项目运营监管，定期经营数据反馈，确保投资安心。</p>
				</div>

				<div class="clear"></div>

			</div>

			<div>
				<div class="why">

					<h2>
						<img src="/Public/Home/images/index/whybt3.gif" width="415" height="40" />
					</h2>
					<p>资金来自于多位投资人，融资更高效。</p>
					<p>超长周期化整为零，减轻资金压力，化解经营风险。</p>
					<p>以时间换空间，增加企业估值，打好发展基础。</p>
					<p>整合企业资源，对接多方渠道，助推企业增长。</p>
					<p>风险有效控制，资金快速流转，投资多方受益。</p>
				</div>

				<div class="why rightt">
					<h2>
						<img src="/Public/Home/images/index/whybt4.gif" width="415" height="40" />
					</h2>
					<div class="why_l">
						<div class="why_ll">
							<img src="/Public/static/images/weixin1.gif" width="100" height="100" alt="微风投官方微信" />
							<p>关注微风投微信</p>

						</div>
						<div class="why_ll">
							<img src="/Public/static/images/xinlang1.gif" width="100" height="100" alt="微风投新浪微博" />
							<p>关注微风投博客</p>

						</div>
						<div class="clear"></div>
					</div>

					<div class="why_r">
						<ul>
							<li>
								<p>官方服务热线：400-700-8998</p>
							</li>
							<li>
								<p>官方在线咨询：QQ 3206590986</p>
							</li>
							<li>
								<p>官方投诉电话：15036658123</p>
							</li>
							<li>
								<p>官方在线投诉：QQ 3206590986</p>
							</li>
						</ul>
					</div>
					<div class="clear"></div>
				</div>

				<div class="clear"></div>
			</div>

		</div>

	</div>

	<style type="text/css">
    .mainright{width:330px; margin:0 auto}
	.deluu{ width:287px; height:38px; font-size:18px; margin-top:25px; background:#ec6f00; line-height:38px; color:#fff; text-align:center; margin-left:20px}
	.mansec{ padding:20px 10px 10px 20px;}
	.man{ width:222px; height:30px; padding:5px 10px 5px 55px;; background:url(/Public/Home/images/public/minilogin/man.gif);}
	.man input{ width:220px; height:30px; border:0; color:#444;font-family:"微软雅黑"; line-height:30px;}
	.man input placeholder{ color:#ccc}
	.sec{ width:222px; height:30px; padding:5px 10px 5px 55px;; background:url(/Public/Home/images/public/minilogin/sec.gif); margin:20px 0}
	.sec input{ width:220px; height:30px; border:0; color:#444;font-family:"微软雅黑"; line-height:30px;}
	.sec input placeholder{ color:#ccc}
	.rem{color:#8f8f8f; font-size:14px; font-family:"微软雅黑";}
	.rem span.rember{ margin-right:120px;}
	.rem a{ color:#0697da !important}
	.rem a:hover{ color:#0fb3ff}
	.lgoinin{width:165px; height:40px; margin:50px 0 20px 60px;}
	.lgoword{ display:block; text-align:center; font-size:12px; margin-top:30px; color:#8f8f8f}
	.lgoword a{color:#0697da !important}
	.lgoword a:hover{ color:#0fb3ff}
	.qier{background:url(/Public/Home/images/public/minilogin/linesd.gif) top no-repeat; padding:30px 0px 10px 22px;}
	.qier span{ font-size:12px; color:#aeacad; display:block; float:left; line-height:26px; margin-right:80px; display:inline}
	.qier a{ display:block; float:left;}
	.qier .partner-qq{ float:left;margin-right:20px; display:inline}
	.qier .partner-weibo{ float:left}
	.qier .partner-qq a{ background:url(/Public/Home/images/public/minilogin/anqq.gif); width:20px; height:24px;}
	.qier .partner-qq a:hover{ background:url(/Public/Home/images/public/minilogin/liangqq.gif); width:20px; height:24px;}
	.qier .partner-weibo a{ background:url(/Public/Home/images/public/minilogin/anxl.gif); width:29px; height:24px;}
	.qier .partner-weibo a:hover{ background:url(/Public/Home/images/public/minilogin/xinxl.gif); width:29px; height:24px;}

	/*----------------------底部-------------------------*/

</style>

<!--表单插件-->
<script src="/Public/static/jquery.form.js"></script>
<!--验证插件-->
<script src="/Public/static/jQueryValidation/lib/jquery.validate.js"></script>
<script src="/Public/static/jQueryValidation/lib/jquery.metadata.js"></script>
<script src="/Public/static/jQueryValidation/lib/jquery.validate.messages_cn.js"></script>
<style type="text/css">
/*错误样式*/
input.error { border: 1px dashed red;background:yellow; padding:2px; }
select.error { border: 1px dashed red; background:yellow; padding:::::;}
.error {
    float: left;
    height: 30px;
    line-height: 30px;
    padding-left: 16px;
    margin-left: 2px;
    color:red;
    /*背景图片（校验未通过的’×’图标）*/
    /*background: url(unchecked.gif) no-repeat 0px 0px;*/
    font-family:Verdana, Geneva, sans-serif;
    font-size:13px;
}
</style>

<div id="minilogin" style="display:none">
	<form id="miniloginfun" action="?s=Home/User/denglu" method="post">
		<div class="mainright">
			<!--请先登录-->
		     
			<div class="deluu">登录</div>

			<div class="mansec">
				<div class="man">
					<input type="text" placeholder="请输入用户名/邮箱" name="username" />
				</div>
				<div class="sec">
					<input type="password" placeholder="请输入密码" name="password" />
				</div>
				<div class="rem">
					<span class="yesme" style="background-position: 0px -33px;">
						<input type="checkbox" checked="checked"></span>
					<span class="rember">记住用户名</span>
					<a class="forgot" href="?s=Home/User/forgetpd01">忘记密码</a>
				</div>

				<div class="lgoinin">
					<a class="intom" href="javascript:miniloginfun();">
						<img src="/Public/Home/images/public/minilogin/lgoinin.gif" />
					</a>
				</div>
				<div class="lgoword">
					没有账号？
					<a href="?s=Home/User/register">免费注册</a>
				</div>

			</div>
			<div class="qier">
				<span>您还可以使用合作账号登录</span>
				<div class="partner-qq" id="_qqLoginBtn">
					<a ></a>
				</div>
				<div class="partner-weibo">
					<a onclick="javascript:hasnofun();"></a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" charset="utf-8"></script>

<script type="text/javascript">
    $("#_qqLoginBtn").on('click', function(event) {
    	QC.Login.showPopup({
		   appId:"<?php echo C('QQ_APP_ID');?>",
		   redirectURI:'<?php echo C("WEB_URL");?>' + "/index.php?s=Home/User/qqlogin"
		});
    });
</script>

<script>
	function miniloginfun () {
		$("#miniloginfun").trigger('submit')
	}
	$("#miniloginfun").ajaxForm(function (e) {
		if (e==2||e==3||e==4) {
			location.reload()
		}else if(e==5){
			alert("用户未激活")
		}else if(e==0||e==1){
			alert("用户名或密码错误")
		}
	})
</script>
	
	<a href="index.php?s=home/Help/knowYou" style=" background:#eceaea" target="_black">
		<div class="bekone">
			<div class="bekonee">
				<img src="/Public/Home/images/index/beknow1.jpg" />
			</div>
		</div>
	</a>

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