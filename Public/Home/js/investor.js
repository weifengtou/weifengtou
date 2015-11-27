// --------------------------------------------reg1--------------------------------------------------------------
jQuery(document).ready(function($) {
    // ************************************************************************************************
    //地区js(曹超2014-12-10)
    function jsSelectItemByValue(objSelect, value) {
		//判断是否存在
		var isExit = false;
		for (var i = 0; i < objSelect.options.length; i++) {
			if (objSelect.options[i].value == value) {
				objSelect.options[i].selected = true;
				isExit = true;
				break;
			}
		}
	}
	//加载所有市     
	$('#province').on('change', function() {
		var areaid = $(this).val();
		var time = new Date();
		var time2 = time.getTime();
		var areaurl = '?s=home/investor/province&areaid=' + areaid + '&time=' + time2;
		$.get(areaurl, function(data) {
			$("#city").empty();
			$("#town").empty();
			var t = JSON.parse(data);
			$('#city').append('<option value="">城市</option><br />');
			$('#town').append('<option value="">县区</option><br />');
			$.each(t, function(key, obj) {
				$('#city').append('<option value=' + obj.id + '>' + obj.name + '</option><br />');
			});
		});
	});
	//加载所有县
	$('#city').on('change', function() {
		var areaid = $(this).val();
		var time = new Date();
		var time2 = time.getTime();
		var areaurl = '?s=home/investor/city&areaid=' + areaid + '&time=' + time2;
		$.get(areaurl, function(data) {
			$("#town").empty();
			var t = JSON.parse(data);
			$('#town').append('<option value="">县区</option><br />');
			$.each(t, function(key, obj) {
				$('#town').append('<option value=' + obj.id + '>' + obj.name + '</option><br />');
			});
		});
	});
	// ***************************************************************************************************

	// ***********************************基本信息操作**************************************
	$('#sub1').on('click',function(){
		if (!$("#isaccess").attr('checked')) {
			layer.alert("未同意协议，不能进行下一步")
			return false;
		}
		// 判断是否有案例填写
		if ($("input[name=pname].addpname").val()==''&&$("input[name=purl].addpurl").val()==''&&$("textarea[name=pdetail].addpdetail").val()=='') {
			// 
		}else{
			layer.alert("请先保存案例！",8)
			location.href = "#addcase"; 
			return false;
		}
		$('#reg1').ajaxSubmit({
			beforeSubmit:function(){
				var r = /^(13[0-9]|15[0|1|2|3|5|6|7|8|9]|17[7|8]|18[0-9])\d{8}$/;			//手机号正则表达式
				var sex = $("input[name='sex']").filter(':checked');
				var privacy = $("input[name='privacy']").filter(':checked');
				if($.trim($('#phone').val()).length == 0){
					layer.tips('手机号码不能为空！','#phone',{time:3,guide:1});
					location.href = "#baseinfo"; 
					return false;
				}else if(!r.test($('#phone').val())){
					layer.tips('手机号码不正确！','#phone',{time:3,guide:1});
					location.href = "#baseinfo";
					return false;
				}
				if($.trim($('#realname').val()).length == 0){
					layer.tips('真实姓名不能为空！','#realname',{time:3,guide:1});
					location.href = "#baseinfo";
					return false;
				}else if($.trim($('#realname').val()).length < 2 || $.trim($('#realname').val()).length > 8){
					layer.tips('字数在2-8之间','#realname',{time:3,guide:1});
					location.href = "#baseinfo";
					return false;
				}
				if(sex.length == 0){
					layer.tips('请选择','#sex',{time:3,guide:1});
					location.hreft = "#baseinfo";
					return false;
				}
				if($.trim($('#company').val()).length == 0){
					layer.tips('所在公司不能为空','#company',{time:3,guide:1});
					location.href = "#baseinfo";
					return false;
				}else if($.trim($('#company').val()).length < 2 || $.trim($('#company').val()).length > 15){
					layer.tips('字数在2-15之间','#company',{time:3,guide:1});
					location.href = "#baseinfo";
					return false;
				}
				if ($.trim($('#province').val()).length == 0 || $.trim($('#city').val()).length == 0 || $.trim($('#town').val()).length == 0) {
					layer.tips('请选择','#town',{time:3,guide:1});
					location.href = "#baseinfo";
					return false;
				}
				if(privacy.length == 0){
					layer.tips('请选择','#privacy',{time:3,guide:1});
					location.href = "#baseinfo";
					return false;
				}else{
					return true;
				}
			},
			success:function(data){
				if (data == 1 ){
					if ($('input[name="type"]:checked').val()==2) {
						window.location.href = 'index.php?s=home/investor/investorjigou';
					}else{
						window.location.href = 'index.php?s=home/investor/investor02';
					}
				}
				$('#reg1').clearForm();
			}
		});
		return false;
	});	
});
// ==================案例操作==========================================================
jQuery(document).ready(function($) {
	$("#caseadd").on('click', function(e) {
		$('#addcase').ajaxSubmit({
			beforeSubmit:function(){
				var urlcheck = /(\w+):\/\/([^\/:]+)(:\d*)?([^#]*)/
				if ($.trim($('#pname').val()).length == 0) {
					layer.tips('项目名不能为空！','#pname',{time:3,guide:1})
					return false
				}
				if (!$.trim($('#purl').val()).length == 0&&!urlcheck.test($('#purl').val())) {
					layer.tips('网站地址错误！','#purl',{time:3,guide:1})
					return false
				}
			},
			success:function (e) {
				layer.alert("添加成功！",1)
				var data = jQuery.parseJSON(e)
				showaddcase (data) 
				$('.addpname').val('')
				$('.addpurl').val('')
				$('.addpdetail').val('')
			}
		})
	});
});
function showaddcase (data) {
	var divCase = "<form class='editcase' action='?s=Home/investor/editcase' id='editcase"+data.id+"' attrid='"+data.id+"' method='post'>" +
		"<div id='case"+data.id+"'>" +
			"<input type='hidden' name='case_id' value='"+data.id+"'>" +
			"<div class='chsoe'>" +
				"<div class='woss'>" +
					"<font style='color:#f00'>*</font>" +
					"项目名称" +
				"</div>" +
				"<div class='kuang'>" +
					"<input type='text'  class='ldd' id='pname"+data.id+"' name='pname' placeholder='未填写' disabled='disabled' value='"+data.pname+"'>" +
				"</div>" +
				"<div class='clear'></div>" +
			"</div>" +
			"<div class='chsoe' style='margin:20px 0'>" +
				"<div class='woss'>" +
					"网站地址" +
				"</div>" +
				"<span class='kuang'>"+
					"<input type='text'  class='ldd' id='purl"+data.id+"' name='purl' placeholder='未填写' disabled='disabled' value='"+data.purl+"'>" +
				"</span>" +
				"<div class='kuang'></div>" +
				"<div class='clear'></div>" +
			"</div>" +
			"<div class='chsoe' style='margin:20px 0'>" +
				"<div class='woss'>" +
					"项目描述" +
				"</div>" +
				"<div class='kuang' style='width:855px'>"+
					"<textarea class='lss' id='pdetail"+data.id+"' name='pdetail' cols='30' rows='10' placeholder='未填写' disabled='disabled'>"+data.pdetail+"</textarea>" +
				"</div>" +
				"<div class='clear'></div>" +
			"</div>" +
			"<div style=' margin:20px 0 20px 88px;'>" +
				"<div style=' float:left;'>" +
					"<a href='javascript:delcase("+data.id+")'>" +
						"<img src='./Public/Home/images/investor/investor/shanc.gif' width='55' height='30' alt='删除' />" +
					"</a>" +
				"</div>" +
				"<div class='clear'></div>" +
			"</div>" +
			"<div class='linsss' style=' margin-left:88px'></div>" +
		"</div>" +
	"</form>";
	$("#choses").append(divCase)
	
}
function delcase (id) {
	$.post('?s=home/Investor/delcase', {case_id: id}, function(data, textStatus, xhr) {
		if (data=='1') {
			$("#case"+id).remove()
			layer.alert("删除成功！",1)
		}else{
			alert(data)
		}
	});
}
/*------------------------------------------reg1------------------------------------------------------------------------*/

/*----------------------------------------------jigou--------------------------------------------------------------------*/
/*机构信息添加*/
jQuery(document).ready(function($) {
	$("#subjigou").on('click', function(event) {
		$("#jigou").ajaxSubmit({
			beforeSubmit:function () {
				if ($.trim($('#cyname').val())||$.trim($('#cydetail').val())) {
					layer.alert("请先保存团队信息",8)
					return false;
				}
				if (!$.trim($('#tddetail').val())) {
					layer.tips('团队简介必填！','#tddetail',{time:3,guide:1});
					location.href = "#baseinfo";
					return false;
				}
				if ($.trim($('#tdurl').val())&&!/(\w+):\/\/([^\/:]+)(:\d*)?([^#]*)/.test($('#tdurl').val())) {
					layer.tips('相关网址错误！','#tdurl',{time:3,guide:1});
					location.href = "#baseinfo";
					return false;
				}
			},
			success:function(data){
				if (data) {
					window.location.href = 'index.php?s=home/investor/investor02';
				}else{
					layer.alert(data,8)
				}
			}
		})
	});
});
/*机构成员添加*/
jQuery(document).ready(function($) {
	$("#cyadd").on('click', function(event) {
		$("#addcy").ajaxSubmit({
			beforeSubmit:function () {
				if (!$.trim($('#cyname').val())) {
					layer.tips('成员简介必填！','#cyname',{time:3,guide:1});
					return false;
				}
			},
			success:function(data){
				if (data) {
					var data = jQuery.parseJSON(data)
					showaddcy (data) 
					$('#addcy').clearForm();
					layer.alert("添加成功！",1)
				}else{
					layer.alert("添加失败！",8)
				}
			}
		})
	});
});
function showaddcy (data) {
	var divcy = "<form class='editcy' action='index.php?s=Home/investor/editcy' id='editcy"+data.id+"' attrid='"+data.id+"' method='post'>" +
		"<div id='cy"+data.id+"'>" +
			"<input type='hidden' name='cy_id' value='"+data.id+"'>" +
			"<div class='chsoe'>" +
				"<div class='woss'>" +
					"<font style='color:#f00'>*</font>" +
					"成员姓名" +
				"</div>" +
				"<div class='kuang'>" +
					"<input type='text'  class='ldd' id='cyname"+data.id+"' name='cyname' placeholder='未填写' disabled='disabled' value='"+data.cyname+"'>" +
				"</div>" +
				"<div class='clear'></div>" +
			"</div>" +
			"<div class='chsoe' style='margin:20px 0'>" +
				"<div class='woss'>" +
					"成员简介" +
				"</div>" +
				"<div class='kuang' style='width:855px'>"+
					"<textarea class='lss' id='cydetail"+data.id+"' name='cydetail' cols='30' rows='10' placeholder='未填写' disabled='disabled'>"+data.cydetail+"</textarea>" +
				"</div>" +
				"<div class='clear'></div>" +
			"</div>" +
			"<div style=' margin:20px 0 20px 88px;'>" +
				"<div style=' float:left;'>" +
					"<a href='javascript:delcy("+data.id+")'>" +
						"<img src='./Public/Home/images/investor/investor/shanc.gif' width='55' height='30' alt='删除' />" +
					"</a>" +
				"</div>" +
				"<div class='clear'></div>" +
			"</div>" +
			"<div class='linsss' style=' margin-left:88px'></div>" +
		"</div>" +
	"</form>";
	$("#choses").append(divcy)
}
/*机构成员删除*/
function delcy (id) {
	$.post('?s=home/Investor/delcy', {cy_id: id}, function(data, textStatus, xhr) {
		if (data=='1') {
			$("#cy"+id).remove()
			layer.alert("删除成功！",1)
		}else{
			alert(data)
		}
	});
}
/*----------------------------------------------jigou--------------------------------------------------------------------*/

/*----------------------------------------------reg2--------------------------------------------------------------------*/
jQuery(document).ready(function($) {
	$('#sub2').on('click',function(){
		$('#reg2').ajaxSubmit({
			beforeSubmit:function(){
				var r = /^[0-9]*[1-9][0-9]*$/; //判断正整数 
				var trade = $('input[type="checkbox"]').filter(':checked');
				var min_maney = $("input[name=min_maney]").val()
				var max_maney = $("input[name=max_maney]").val()
				if($.trim($('#tzidea').val()).length < 2 || $.trim($('#tzidea').val()).length > 200){
					layer.tips('字数在2-200之间','#tzidea',{time:3,guide:1});
					location.href = '#tz';
					return false;
				}
				if(trade.length == 0){
					layer.tips('请选择','#trade',{time:3,guide:1});
					location.href = '#tz';
					return false;
				}
				if(!r.test($.trim($('#income').val()))){
					layer.tips('请输入正整数','#income',{time:3,guide:1});
					return false;
				}else if($.trim($('#income').val()).length > 9){
					layer.tips('请输入小于9位的正整数','#income',{time:3,guide:1});
                    return false;
				}
				if(!r.test($.trim($('#min_maney').val()))){
					layer.tips('请输入正整数','#min_maney',{time:3,guide:1});
					return false;
				}else if($.trim($('#min_maney').val()).length > 9){
					layer.tips('请输入小于9位的正整数','#min_maney',{time:3,guide:1});
                    return false;
                }
                if(!r.test($.trim($('#max_maney').val()))){
					layer.tips('请输入正整数','#max_maney',{time:3,guide:1});
					return false;
				}else if($.trim($('#max_maney').val()).length > 9){
					layer.tips('请输入小于9位的正整数','#max_maney',{time:3,guide:1});
                    return false;
                }
                
				if (eval(min_maney)>eval(max_maney)) {
					alert("最大投资金额应该大于最小投资金额")
					return false;
				}else{
					return true;
				}
			},
			success:function(data){
				if (data == 1 ){
					window.location.href = 'index.php?s=home/investor/investor03';
				}
				$('#reg2').clearForm();
			}
		});
		return false;
	});
});
/*reg2*/

/*reg3*/
jQuery(document).ready(function($) {
	$('#info').ajaxForm(function  (e) {
		var data = jQuery.parseJSON(e);
		$("#imginfo").html("<img src='./Uploads/Investor/"+data.inv_info+"' />")
	})
	$('#fup').ajaxForm(function  (e) {
		var data = jQuery.parseJSON(e);
		$("#imgfup").html("<img src='./Uploads/Investor/"+data.f_image+"' />")
	})
	$('#bup').ajaxForm(function  (e) {
		var data = jQuery.parseJSON(e);
		$("#imgbup").html("<img src='./Uploads/Investor/"+data.b_image+"' />")
	})
	$("#zzform").ajaxForm(function (e) {
		var data = jQuery.parseJSON(e);
		$("#zhizhao").html("<img src='./Uploads/Investor/"+data.zhizhao+"' />")
	})
});
function sub3 () {
	if ($('.isUp3').size()>0) {
		alert("图片必须上传")
		return;
	}
	$.post('?s=home/investor/invApply', {'iden_status':'1'}, function(data, textStatus, xhr) {
		alert("申请成功 请等待审核！")
		window.location.href="?s=home/investor";
	});
}
function infoup () {
	$('#info').trigger('submit')
}
function fup () {
	$('#fup').trigger('submit')
}
function bup () {
	$('#bup').trigger('submit')
}
function zhizhaoUp () {
	$("#zzform").trigger('submit')
}
/*reg3*/