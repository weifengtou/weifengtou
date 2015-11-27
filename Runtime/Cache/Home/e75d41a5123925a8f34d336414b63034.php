<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
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

	<!--兼容插件-->
	<!-- <script src="/Public/static/jquery-migrate-1.2.1.min.js"></script> -->

	<!--表单插件-->
	<script src="/Public/static/jquery.form.js"></script>

	<!--日历插件-->
	<script src="/Public/static/jQueryValidation/lib/jquery.validate.js"></script>
	<script src="/Public/static/jQueryValidation/lib/jquery.metadata.js"></script>
	<script src="/Public/static/jQueryValidation/lib/jquery.validate.messages_cn.js"></script>

	<!--分页插件-->
	<link rel="stylesheet" href="/Public/static/jPages/css/jPages.css" />
	<script src="/Public/static/jPages/js/jPages.min.js"></script>

	<!-- 自定义 -->
	<link rel="stylesheet"  href="/Public/Home/css/article.css" type="text/css" />
	<script type="text/javascript">
	$(function() {
		var sWidth = $("#focus").width(); //获取焦点图的宽度（显示面积）
		var len = $("#focus ul li").length; //获取焦点图个数
		var index = 0;
		var picTimer;
		
		//以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
		var btn = "<div class='bttnBg'></div><div class='bttn'>";
		for(var i=0; i < len; i++) {
			btn += "<span></span>";
		}
		btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
		$("#focus").append(btn);
		$("#focus .bttnBg").css("opacity",0.5);

		//为小按钮添加鼠标滑入事件，以显示相应的内容
		$("#focus .bttn span").css("opacity",0.4).mouseenter(function() {
			index = $("#focus .bttn span").index(this);
			showPics(index);
		}).eq(0).trigger("mouseenter");

		//上一页、下一页按钮透明度处理
		$("#focus .preNext").css("opacity",0.2).hover(function() {
			$(this).stop(true,false).animate({"opacity":"0.5"},300);
		},function() {
			$(this).stop(true,false).animate({"opacity":"0.2"},300);
		});

		//上一页按钮
		$("#focus .pre").click(function() {
			index -= 1;
			if(index == -1) {index = len - 1;}
			showPics(index);
		});

		//下一页按钮
		$("#focus .next").click(function() {
			index += 1;
			if(index == len) {index = 0;}
			showPics(index);
		});

		//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
		$("#focus ul").css("width",sWidth * (len));
		
		//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
		$("#focus").hover(function() {
			clearInterval(picTimer);
		},function() {
			picTimer = setInterval(function() {
				showPics(index);
				index++;
				if(index == len) {index = 0;}
			},4000); //此4000代表自动播放的间隔，单位：毫秒
		}).trigger("mouseleave");
		
		//显示图片函数，根据接收的index值显示相应的内容
		function showPics(index) { //普通切换
			var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
			$("#focus ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
			//$("#focus .bttn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
			$("#focus .bttn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
		}
	});

</script>
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
	

<?php  C('TITLE',$info[title]."—微风投"); C("KEYWORDS",$info[keywords]); C('DESCRIPTION',mb_substr($info[description] , 0 , 150)); ?>
	<div class="all">

		<!--总-->

		<div class="allmain">

			<div class="biaotii">
					
					<a href="index.php?s=home">微风投</a><span> > <a href="index.php?s=/Home/Article/lists/category/news.html">新闻中心</a> > <a href="<?php echo U('Article/lists?category='.get_category_name($info[category_id]));?>"><?php echo get_category($info[category_id],'title');?></a> > <?php echo ($info[title]); ?></span>
				
			</div>

			<div class="fen"></div>

			<!--主体-->
			<div class="article">

				<div class="article_r">
					<?php echo W('Category/lists', array(41, true));?>
				</div>


				<div class="article_lll">

					<div class="article_l">

						<div class="article_ls">
							<h2><?php echo ($info["title"]); ?></h2>

							<p style="text-align:center">
								作者：<?php echo (get_username($info["uid"])); ?> &nbsp;&nbsp;&nbsp;&nbsp;
                                           发布时间：<?php echo (date('Y-m-d H:i',$info["create_time"])); ?>
							</p>

						</div>

						<div class="content">

							<?php echo ($info["content"]); ?>

						</div>

						<div class="preene">
							<?php  $pv = M()->query("select * from __DOCUMENT_ARTICLE__ where id<'$_GET[id]' order by id DESC LIMIT 1"); $pv_title = M('Document')->where("id=".$pv[0][id])->find(); $pv_title = $pv_title[title]; $nt = M()->query("select * from __DOCUMENT_ARTICLE__ where id>'$_GET[id]' order by id ASC LIMIT 1"); $nt_title = M('Document')->where("id=".$nt[0][id])->find(); $nt_title = $nt_title[title]; ?>
							<p>上一篇： <?php if($pv): ?>
											<a href="<?php echo U('?id='.$pv[0][id]);?>"><?php echo ($pv_title); ?></a>
										<?php else: ?>
											没有了
										<?php endif; ?>	
							</p>
							<p>下一篇：	<?php if($nt): ?>
											<a href="<?php echo U('?id='.$nt[0][id]);?>"><?php echo ($nt_title); ?></a>
										<?php else: ?>
											没有了
										<?php endif; ?>
							</p>
						</div>

					</div>

				</div>

				
				<div class="clear"></div>

			</div>

		</div>

	</div>


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