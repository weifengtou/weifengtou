$(document).ready(function() {
// ============地区行业加载=================================================================================================
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
	$('#province01').on('change', function() {
		var areaid = $(this).val();
		var time = new Date();
		var time2 = time.getTime();
		var areaurl = '?s=home/entrepre/province&areaid=' + areaid + '&time=' + time2;
		$.get(areaurl, function(data) {
			$("#city01").empty();
			$("#town01").empty();
			var t = JSON.parse(data);
			$('#city01').append('<option value="">城市</option><br />');
			$('#town01').append('<option value="">县区</option><br />');
			$.each(t, function(key, obj) {
				$('#city01').append('<option value=' + obj.id + '>' + obj.name + '</option><br />');
			});
		});
	});
	//加载所有县
	$('#city01').on('change', function() {
		var areaid = $(this).val();
		var time = new Date();
		var time2 = time.getTime();
		var areaurl = '?s=home/entrepre/city&areaid=' + areaid + '&time=' + time2;
		$.get(areaurl, function(data) {
			$("#town01").empty();
			var t = JSON.parse(data);
			$('#town01').append('<option value="">县区</option><br />');
			$.each(t, function(key, obj) {
				$('#town01').append('<option value=' + obj.id + '>' + obj.name + '</option><br />');
			});
		});
	});
	//加载所有市
	$('#province03').on('change', function() {
		var areaid = $(this).val();
		var time = new Date();
		var time2 = time.getTime();
		var areaurl = '?s=home/entrepre/province&areaid=' + areaid + '&time=' + time2;
		$.get(areaurl, function(data) {
			$("#city03").empty();
			$("#town03").empty();
			var t = JSON.parse(data);
			$('#city03').append('<option value="">城市</option><br />');
			$('#town03').append('<option value="">县区</option><br />');
			$.each(t, function(key, obj) {
				$('#city03').append('<option value=' + obj.id + '>' + obj.name + '</option><br />');
			});
		});
	});
	//加载所有县
	$('#city03').on('change', function() {
		var areaid = $(this).val();
		var time = new Date();
		var time2 = time.getTime();
		var areaurl = '?s=home/entrepre/city&areaid=' + areaid + '&time=' + time2;
		$.get(areaurl, function(data) {
			$("#town03").empty();
			var t = JSON.parse(data);
			$('#town03').append('<option value="">县区</option><br />');
			$.each(t, function(key, obj) {
				$('#town03').append('<option value=' + obj.id + '>' + obj.name + '</option><br />');
			});
		});
	});
	//加载二级行业
	$('#father01').on('change', function() {
		var tradeid = $(this).val();
		var time = new Date();
		var time2 = time.getTime();
		var tradeurl = '?s=home/entrepre/trade&tradeid=' + tradeid + '&time=' + time2;
		$.get(tradeurl, function(data) {
			$("#full01").empty();
			var t = JSON.parse(data);
			$('#full01').append('<option value="">全部</option><br />');
			$.each(t, function(key, obj) {
				$('#full01').append('<option value=' + obj.id + '>' + obj.trade + '</option><br />');
			});
		});
	});
	//加载二级行业
	$('#father03').on('change', function() {
		var tradeid = $(this).val();
		var time = new Date();
		var time2 = time.getTime();
		var tradeurl = '?s=home/entrepre/trade&tradeid=' + tradeid + '&time=' + time2;
		$.get(tradeurl, function(data) {
			$("#full03").empty();
			var t = JSON.parse(data);
			$('#full03').append('<option value="">全部</option><br />');
			$.each(t, function(key, obj) {
				$('#full03').append('<option value=' + obj.id + '>' + obj.trade + '</option><br />');
			});
		});
	});
// ==========================================================================================================================

// ==================项目基本表单============================================================================================
	// 项目封面图上传
	$('#prsurface01').on('change', function() {
		var filename = $('#prsurface01').val();
		var start = filename.lastIndexOf('.'); //获取最后“.”的位置
		var c = filename.substring(start + 1).toLowerCase(); //截取字符串(统一小写)
		if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
			layer.tips('请选择上传文件正确格式', '#prsurface01', {
				time: 3,
				guide: 2
			});
			return false;
		} else {
			$('#surfaceForm01').trigger('submit');
			return true;
		}
	});
	$('#surfaceForm01').ajaxForm(function(data){
		if(data == -1){
			layer.alert('提交失败，请登录', 8);
		}else if(data == 0){
			layer.tips('图片大小不应大于1024kb,请重传！', '#prsurface01', {
                time: 3,
                guide: 2
            });
		}else{
			$('#surfaceimg01').attr('src','./Uploads/Album/' + data);
			$('#surface01').val(data);
			$('#surfaceForm01').hide();
			$('#surfacediv01').show();
		}
	});
	//项目基本资料添加
	$('#save01').on('click', function() {
		$('#prform01').ajaxSubmit({
			beforeSubmit: function() {
				var reg1 = /(\d{2,5}-\d{7,8})$/; 		//座机号正则表达式:区号-机号
				var reg2 = /^(13[0-9]|15[0|1|2|3|5|6|7|8|9]|17[7|8]|18[0-9])\d{8}$/;    //手机号正则表达式
				if ($.trim($("#prname01").val()).length < 2 || $.trim($("#prname01").val()).length > 15) {
					$('#prnameright01').hide();
					layer.tips('字数在2~15之间','#prname01',{time:3,guide:1});
					return false;
				} 
				/*else if ($.trim($("#prname01").val()).length > 1 && $.trim($("#prname01").val()).length < 16) {
					$('#prnameright01').show();
				}*/
				if ($.trim($("#linkman01").val()).length < 2 || $.trim($("#linkman01").val()).length > 15) {
//					$('#prnameright01').hide();
					layer.tips('字数在2~15之间','#linkman01',{time:3,guide:1});
					return false;
				} 
				if($.trim($('#prphone01').val()).length == 0){
					layer.tips('联系方式不能为空！','#prphone01',{time:3,guide:1});
					return false;			 
				}else if(!reg1.test($('#prphone01').val()) && !reg2.test($('#prphone01').val())){
					layer.tips('联系方式不正确！','#prphone01',{time:3,guide:1});
					return false;
				}
				if ($.trim($('#printroduce01').val()).length < 2 || $.trim($('#printroduce01').val()).length > 50) {
//					$('#printroduceright01').hide();
					layer.tips('字数在2~50之间','#printroduce01',{time:3,guide:1});
					return false;
				} 
				/*else if ($.trim($('#printroduce01').val()).length > 1 && $.trim($('#printroduce01').val()).length < 51) {
					$('#printroduceright01').show();
				}*/
				if ($.trim($('#prstage01').val()).length == 0) {
//					$('#prstageright01').hide();
					layer.tips('请选择','#prstage01',{time:3,guide:1});
					return false;
				} 
				/*else {
					$('#prstageright01').show();
				}*/
				if ($.trim($('#father01').val()).length == 0 || $.trim($('#full01').val()).length == 0) {
//					$('#prindustryright01').hide();
					layer.tips('请选择','#full01',{time:3,guide:1});
					return false;
				} 
				/*else if ($.trim($('#father01').val()).length != 0 && $.trim($('#full01').val()).length != 0) {
					$('#prindustryright01').show();
				}*/
				if ($.trim($('#province01').val()).length == 0 || $.trim($('#city01').val()).length == 0 || $.trim($('#town01').val()).length == 0) {
//					$('#prarearight01').hide();
					layer.tips('请选择','#town01',{time:3,guide:1});
					return false;
				} 
				/*else if ($.trim($('#province01').val()).length != 0 && $.trim($('#city01').val()).length != 0 && $.trim($('#town01').val()).length != 0) {
					$('#prarearight01').show();
				}*/
				if ($.trim($('#surface01').val()).length == 0) {
					layer.tips('请选择上传封面图', '#prsurface01', {
						time: 3,
						guide: 2
					});
					return false;
				}
			},
			success: function(data) {
				var t = JSON.parse(data);
				var imgaddress = './Uploads/Album/' + t.logo;
				if(data == -1){
					layer.alert('提交失败，请登录', 8);
				}else if(t.prid>0){
					$('#prname02').html(t.pjname);
					$('#linkman02').html(t.linkman);
					$('#prphone02').html(t.prphone);
					$('#printroduce02').html(t.pjintroduce);
					$('#videoweb02').html(t.videoweb);
					if (t.town == null) {
						$('#prarea02').html(t.province + '&nbsp;-&nbsp;' + t.city);
					} else if (t.town != '') {
						$('#prarea02').html(t.province + '&nbsp;-&nbsp;' + t.city + '&nbsp;-&nbsp;' + t.town);
					}
					$('#prindustry02').html(t.fathertrade + '&nbsp;-&nbsp;' + t.fulltrade);
					$('#logo02').attr('src', imgaddress);
					$('.prid').val(t.prid);
					if (t.stageid == 1) {
						$('#prstage02').html('起步阶段');
					} else if (t.stageid == 2) {
						$('#prstage02').html('盈利阶段');
					} else if (t.stageid == 3) {
						$('#prstage02').html('亏损阶段');
					}
					$('#pr01').hide();
					$('#pr02').show();
					$('#pr01').clearForm();
				}	
			}
		});
		return false;
	});
	//表单重置
	$('#reset01').on('click',function(){
		$('#prform01')[0].reset();
		$('#surface01').val('');
		$('#father01').html('');
		$('#full01').html('');
		$('#city01').html('');
		$('#town01').html('');
		return false;
	});
	//显示项目基本资料编辑信息
	$('#edit02').on('click', function() {
		var prid = $('.prid').val();
		var editurl = 'index.php?s=home/entrepre/prbaseedit&prid=' + prid;
		$.get(editurl, function(data) {
			if(data == -1){
				layer.alert('编辑失败，请登录', 8);
			}else{
           		var t = JSON.parse(data);
           		var provinceid = t.provinceid;
           		var stageid = t.stageid;
           		var fathertradeid = t.fathertradeid;
           		var fulltradeid = t.fulltradeid;
           		var imageaddress02 = './Uploads/Album/' + t.logo;
           		$('#prname03').val(t.pjname);
           		$('#linkman03').val(t.linkman);
           		$('#prphone03').val(t.prphone);
           		$('#printroduce03').val(t.pjintroduce);
           		$('#videoweb03').val(t.videoweb);
           		$('#logo03').attr('src', imageaddress02);
           		var provinceObj = document.getElementById('province03');
           		jsSelectItemByValue(provinceObj, provinceid);
           		var city = document.getElementById('city03');
				city.options.add(new Option(t.city, t.cityid));
				var town = document.getElementById('town03');
				town.options.add(new Option(t.town, t.townid));
				var fatherObj = document.getElementById('father03');
				jsSelectItemByValue(fatherObj, fathertradeid);
				var full = document.getElementById('full03');
				full.options.add(new Option(t.fulltrade, t.fulltradeid));
				var prstageObj = document.getElementById('prstage03');
				jsSelectItemByValue(prstageObj, stageid);
				$('#pr02').hide();
				$('#pr03').show();
				$('#prnameright03').hide();
				$('#printroduceright03').hide();
				$('#prstageright03').hide();
				$('#prarearight03').hide();
				$('#prindustryright03').hide();
			}
		});
	});
	// 项目封面图更新
	$('#prsurface03').on('change', function() {
		var filename = $('#prsurface03').val();
		var start = filename.lastIndexOf('.'); //获取最后“.”的位置
		var c = filename.substring(start + 1).toLowerCase(); //截取字符串(统一小写)
		if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
			layer.tips('请选择上传文件正确格式', '#prsurface03', {
				time: 3,
				guide: 2
			});
			return false;
		} else {
			$('#surfaceForm03').trigger('submit');
			return true;
		}
	});
	$('#surfaceForm03').ajaxForm(function(data){
		if(data == -1){
			layer.alert('提交失败，请登录', 8);
		}else if(data == 0){
			layer.tips('图片大小不应大于1024kb,请重传！', '#prsurface03', {
                time: 3,
                guide: 2
            });
		}else{
			$('#surfaceimg03').attr('src','./Uploads/Album/' + data);
			$('#surface03').val(data);
			$('#surfaceForm03').hide();
			$('#surfacediv03').show();
		}
	});
	//项目基本资料信息更新
	$('#save03').on('click', function() {
		$('#prform03').ajaxSubmit({
			beforeSubmit: function() {
				var reg1 = /(\d{2,5}-\d{7,8})$/; 		//座机号正则表达式:区号-机号
				var reg2 = /^(13[0-9]|15[0|1|2|3|5|6|7|8|9]|17[7|8]|18[0-9])\d{8}$/;    //手机号正则表达式
				var province = $('#province03').val();
				if ($.trim($("#prname03").val()).length < 2 || $.trim($("#prname03").val()).length > 15) {
					layer.tips('字数在2~15之间','#prname03',{time:3,guide:1});
//					$('#prnameright03').hide();
					return false;
				}
				/*else if ($.trim($("#prname03").val()).length > 1 && $.trim($("#prname03").val()).length < 16) {
					$('#prnameright03').show();
				}*/
				if ($.trim($("#linkman03").val()).length < 2 || $.trim($("#linkman03").val()).length > 15) {
//					$('#prnameright01').hide();
					layer.tips('字数在2~15之间','#linkman03',{time:3,guide:1});
					return false;
				} 
				if($.trim($('#prphone03').val()).length == 0){
					layer.tips('联系方式不能为空！','#prphone03',{time:3,guide:1});
					return false;			 
				}else if(!reg1.test($('#prphone03').val()) && !reg2.test($('#prphone03').val())){
					layer.tips('联系方式不正确！','#prphone03',{time:3,guide:1});
					return false;
				}
				if ($.trim($('#printroduce03').val()).length < 2 || $.trim($('#printroduce03').val()).length > 50) {
					layer.tips('字数在2~50之间','#printroduce03',{time:3,guide:1});
//					$('#printroduceright03').hide();
					return false;
				} 
				/*else if ($.trim($('#printroduce03').val()).length > 1 && $.trim($('#printroduce03').val()).length < 51) {
					$('#printroduceright03').show();
				}*/
				if ($('#prstage03').val() == '') {
					layer.tips('请选择','#prstage03',{time:3,guide:1});
//					$('#prstageright03').hide();
					return false;
				}
				/*else {
					$('#prstageright03').show();
				}*/
				if ($.trim($('#father03').val()).length == 0 || $.trim($('#full03').val()).length == 0) {
					layer.tips('请选择','#full03',{time:3,guide:1});
//					$('#prindustryright03').hide();
					return false;
				}
				/*else if ($.trim($('#father03').val()).length != 0 && $.trim($('#full03').val()).length != 0) {
					$('#prindustryright03').show();
				}*/
				if ($.trim($('#province03').val()).length == 0 || $.trim($('#city03').val()).length == 0 || $.trim($('#town03').val()).length == 0) {
					layer.tips('请选择','#town03',{time:3,guide:1});
//					$('#prarearight03').hide();
					return false;
				} 
				/*else if ($.trim($('#province03').val()).length != 0 && $.trim($('#city03').val()).length != 0 && $.trim($('#town03').val()).length != 0) {
					$('#prarearight03').show();
				}*/	
			},
			success: function(data) {
				if(data==-1){
					layer.alert('保存失败，请登录', 8);
				}else{
					var t = JSON.parse(data);
					var imgaddress = './Uploads/Album/' + t.logo;
					$('#prname02').html(t.pjname);
					$('#linkman02').html(t.linkman);
					$('#prphone02').html(t.prphone);
					$('#printroduce02').html(t.pjintroduce);
					$('#videoweb02').html(t.videoweb);
					if (t.town == null) {
					$('#prarea02').html(t.province + t.city);
					} else if (t.town != '') {
						$('#prarea02').html(t.province + '&nbsp;-&nbsp;' + t.city + '&nbsp;-&nbsp;' + t.town);
					}
					$('#prindustry02').html(t.fathertrade + '&nbsp;-&nbsp;' + t.fulltrade);
					$('#logo02').attr('src', imgaddress);
					if (t.stageid == 1) {
						$('#prstage02').html('起步阶段');
					} else if (t.stageid == 2) {
						$('#prstage02').html('盈利阶段');
					} else if (t.stageid == 3) {
						$('#prstage02').html('亏损阶段');
					}
					$('#pr03').hide();
					$('#pr02').show();
					$('#prform03').clearForm();
				}	
			}
		});
		return false;
	});
// ===========================================================================================================================

// ===============关于我们表单================================================================================================
	//关于我们添加
	$("#save11").on('click', function() {
		$('#prform11').ajaxSubmit({
			beforeSubmit: function() {
				var prid = $('.prid').val();
				var desmaxlength = 500;
				if ($('.prid').val() == '') {
					layer.tips('请按顺序填写','#prabout11',{time:3,guide:1});
					return false;
				}
				if ($.trim($("#prabout11").val()).length < 2 || $.trim($("#prabout11").val()).length > desmaxlength) {
					layer.tips('字数在2~500之间','#prabout11',{time:3,guide:1});
					return false;
				} else {
					return true;
				}
			},
			success: function(data) {
				var t = JSON.parse(data);
				if(data == -1){
					layer.alert('提交失败，请登录', 8);
				}else{
					$('#prabout12').html(t.prabout);
					$('#pr11').hide();
					$('#pr12').show();
					$('#prform11').clearForm();
				}
			}
		});
		return false;
	});
	//表单重置
	$('#reset11').on('click',function(){
		$('#prform11')[0].reset();
		return false;
	});
	//显示关于我们编辑信息
	$('#edit12').on('click', function() {
		var prid = $('.prid').val();
		var editurl = '?s=home/entrepre/praboutedit&prid=' + prid;
		$.get(editurl, function(data) {
			if(data==-1){
				layer.alert('编辑失败，请登录', 8);
			}else{
				var t = JSON.parse(data);
				$('#prabout13').html(t.prabout);
				$('#pr12').hide();
				$('#pr13').show();
			}
		});	
	});
	//关于我们更新
	$('#save13').on('click', function() {
		$('#prform13').ajaxSubmit({
			beforeSubmit: function() {
				var desmaxlength = 500;
				if ($.trim($("#prabout13").val()).length < 2 || $.trim($("#prabout13").val()).length > desmaxlength) {
					layer.tips('字数在2~500之间','#prabout13',{time:3,guide:1});
					return false;
				} else {
					return true;
				}
			},
			success: function(data) {
				if(data==-1){
					layer.alert('编辑失败，请登录', 8);
				}else{
					var t = JSON.parse(data);
					$('#prabout12').html(t.prabout);
					$('#pr13').hide();
					$('#pr12').show();
				}
			}
		});
		return false;
	});
// ==========================================================================================================================

// ===============为什么支持我们表单=========================================================================================
	//为什么支持我们添加
	$("#save41").on('click', function() {
		$('#prform41').ajaxSubmit({
			beforeSubmit: function() {
				var prid = $('.prid').val();
				var desmaxlength = 500;
				if ($('.prid').val() == '') {
					layer.tips('请按顺序填写','#prwhysupport41',{time:3,guide:1});
					return false;
				}
				if ($.trim($("#prwhysupport41").val()).length < 2 || $.trim($("#prwhysupport41").val()).length > desmaxlength) {
					layer.tips('字数在2~200之间','#prwhysupport41',{time:3,guide:1});
					return false;
				} else {
					return true;
				}
			},
			success: function(data) {
				var t = JSON.parse(data);
				if(data == -1){
					layer.alert('提交失败，请登录', 8);
				}else{
					$('#prwhysupport42').html(t.prwhysupport);
					$('#pr41').hide();
					$('#pr42').show();
					$('#prform41').clearForm();
				}
			}
		});
		return false;
	});
	//表单重置
	$('#reset41').on('click',function(){
		$('#prform41')[0].reset();
		return false;
	});
	//显示为什么支持我们编辑信息
	$('#edit42').on('click', function() {
		var prid = $('.prid').val();
		var editurl = '?s=home/entrepre/prwhysupportedit&prid=' + prid;
		$.get(editurl, function(data) {
			if(data==-1){
				layer.alert('编辑失败，请登录', 8);
			}else{
				var t = JSON.parse(data);
				$('#prwhysupport43').html(t.prwhysupport);
				$('#pr42').hide();
				$('#pr43').show();
			}
		});	
	});
	//为什么支持我们更新
	$('#save43').on('click', function() {
		$('#prform43').ajaxSubmit({
			beforeSubmit: function() {
				var desmaxlength = 500;
				if ($.trim($("#prwhysupport43").val()).length < 2 || $.trim($("#prwhysupport43").val()).length > desmaxlength) {
					layer.tips('字数在2~500之间','#prwhysupport43',{time:3,guide:1});
					return false;
				} else {
					return true;
				}
			},
			success: function(data) {
				if(data==-1){
					layer.alert('编辑失败，请登录', 8);
				}else{
					var t = JSON.parse(data);
					$('#prwhysupport42').html(t.prwhysupport);
					$('#pr43').hide();
					$('#pr42').show();
				}
			}
		});
		return false;
	});
	//为什么支持我们取消修改
	$('#back43').on('click',function(){
		$('#pr43').hide();
		$('#pr42').show();
		return false;
	});
// ==========================================================================================================================

// ==============承诺表单====================================================================================================
	//承诺添加
	$("#save51").on('click', function() {
		$('#prform51').ajaxSubmit({
			beforeSubmit: function() {
				var prid = $('.prid').val();
				var desmaxlength = 500;
				if ($('.prid').val() == '') {
					layer.tips('请按顺序填写','#prpromise51',{time:3,guide:1});
					return false;
				}
				if ($.trim($("#prpromise51").val()).length < 2 || $.trim($("#prpromise51").val()).length > desmaxlength) {
					layer.tips('字数在2~500之间','#prpromise51',{time:3,guide:1});
					return false;
				} else {
					return true;
				}
			},
			success: function(data) {
				var t = JSON.parse(data);
				if(data == -1){
					layer.alert('提交失败，请登录', 8);
				}else{
					$('#prpromise52').html(t.prpromise);
					$('#pr51').hide();
					$('#pr52').show();
					$('#prform51').clearForm();
				}
			}
		});
		return false;
	});
	//表单重置
	$('#reset51').on('click',function(){
		$('#prform51')[0].reset();
		return false;
	});
	//承诺编辑信息
	$('#edit52').on('click', function() {
		var prid = $('.prid').val();
		var editurl = '?s=home/entrepre/prpromiseedit&prid=' + prid;
		$.get(editurl, function(data) {
			if(data==-1){
				layer.alert('编辑失败，请登录', 8);
			}else{
				var t = JSON.parse(data);
				$('#prpromise53').html(t.prpromise);
				$('#pr52').hide();
				$('#pr53').show();
			}
		});	
	});
	//承诺更新
	$('#save53').on('click', function() {
		$('#prform53').ajaxSubmit({
			beforeSubmit: function() {
				var desmaxlength = 500;
				if ($.trim($("#prpromise53").val()).length < 2 || $.trim($("#prpromise53").val()).length > desmaxlength) {
					layer.tips('字数在2~500之间','#prpromise53',{time:3,guide:1});
					return false;
				} else {
					return true;
				}
			},
			success: function(data) {
				if(data==-1){
					layer.alert('编辑失败，请登录', 8);
				}else{
					var t = JSON.parse(data);
					$('#prpromise52').html(t.prpromise);
					$('#pr53').hide();
					$('#pr52').show();
				}
			}
		});
		return false;
	});
	//承诺取消修改
	$('#back53').on('click',function(){
		$('#pr53').hide();
		$('#pr52').show();
		return false;
	});
// ==========================================================================================================================

//==============风险表单===================================================================================================== 
	//风险添加
	$("#save61").on('click', function() {
		$('#prform61').ajaxSubmit({
			beforeSubmit: function() {
				var prid = $('.prid').val();
				var desmaxlength = 500;
				if ($('.prid').val() == '') {
					layer.tips('请按顺序填写','#prdanger61',{time:3,guide:1});
					return false;
				}
				if ($.trim($("#prdanger61").val()).length < 2 || $.trim($("#prdanger61").val()).length > desmaxlength) {
					layer.tips('字数在2~500之间','#prdanger61',{time:3,guide:1});
					return false;
				} else {
					return true;
				}
			},
			success: function(data) {
				var t = JSON.parse(data);
				if(data == -1){
					layer.alert('提交失败，请登录', 8);
				}else{
					$('#prdanger62').html(t.prdanger);
					$('#pr61').hide();
					$('#pr62').show();
					$('#prform61').clearForm();
				}
			}
		});
		return false;
	});
	//表单重置
	$('#reset61').on('click',function(){
		$('#prform61')[0].reset();
		return false;
	});
	//风险编辑信息
	$('#edit62').on('click', function() {
		var prid = $('.prid').val();
		var editurl = '?s=home/entrepre/prdangeredit&prid=' + prid;
		$.get(editurl, function(data) {
			if(data==-1){
				layer.alert('编辑失败，请登录', 8);
			}else{
				var t = JSON.parse(data);
				$('#prdanger63').html(t.prdanger);
				$('#pr62').hide();
				$('#pr63').show();
			}
		});	
	});
	//风险更新
	$('#save63').on('click', function() {
		$('#prform63').ajaxSubmit({
			beforeSubmit: function() {
				var desmaxlength = 500;
				if ($.trim($("#prdanger63").val()).length < 2 || $.trim($("#prdanger63").val()).length > desmaxlength) {
					layer.tips('字数在2~500之间','#prdanger63',{time:3,guide:1});
					return false;
				} else {
					return true;
				}
			},
			success: function(data) {
				if(data==-1){
					layer.alert('编辑失败，请登录', 8);
				}else{
					var t = JSON.parse(data);
					$('#prdanger62').html(t.prdanger);
					$('#pr63').hide();
					$('#pr62').show();
				}
			}
		});
		return false;
	});
	//风险取消修改
	$('#back63').on('click',function(){
		$('#pr63').hide();
		$('#pr62').show();
		return false;
	});
// =========================================================================================================================

// =============项目成员表单================================================================================================
	//成员头像上传
	$('#photo21').on('change',function(){
		var filename = $('#photo21').val();
		var start = filename.lastIndexOf('.'); //获取最后“.”的位置
		var c = filename.substring(start + 1).toLowerCase(); //截取字符串
		if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
			$('#photoerror21').show();
			layer.tips('请选择上传文件正确格式', '#photo21', {
				time: 0,
				guide: 0
			});
			return false;
		} else {
			$('#photoForm21').trigger('submit');
            return true;
		}
	});
	$('#photoForm21').ajaxForm(function(data){
		if (data == -1) {
            layer.alert('上传失败，请登录', 8);
        } else if (data == 0) {
            layer.tips('图片大小不应大于1024kb,请重传！', '#photo21', {
                time: 1,
                guide: 0
            });
        } else {
        	$('#photoimg21').hide();
        	$('#photoimg22').show();
            $('#photoimg22').attr('src','./Uploads/Portrait/' + data);
            $('#headphoto21').val(data);
        }
	});
	//添加成员
	$('#save21').on('click', function() {
		$('#prform21').ajaxSubmit({
			beforeSubmit: function() {
				var prid = $('.prid').val();
				var role = $(".juese21").filter(':checked');
				// alert(role.length);
				var intrminlength = 10;
				var intrmaxlength = 200;
				if ($('.prid').val() == '') {
					layer.tips('请按顺序填写','#prform21',{time:3,guide:1});
					return false;
				}
				if ($.trim($('#headphoto21').val()).length == 0) {
					layer.tips('请选择上传头像!', '#photo21', {
						time: 3,
						guide: 0
					});
					return false;
				}
				if ($.trim($('#name21').val()).length < 2 || $.trim($('#name21').val()).length > 10) {
					layer.tips('字数在2~10之间','#name21',{time:3,guide:1});
					$('#nameright21').hide();
					return false;
				}
				//  else if ($.trim($('#name21').val()).length > 1 && $.trim($('#name21').val()).length < 11) {
				// 	$('#nameright21').show();
				// }
				if ($.trim($('#position21').val()).length < 2 || $.trim($('#position21').val()).length > 10) {
					layer.tips('字数在2~10之间','#position21',{time:3,guide:1});
					$('#positionright21').hide();
					return false;
				} 
				// else if ($.trim($('#position21').val()).length > 1 && $.trim($('#position21').val()).length < 11) {
				// 	$('#positionright21').show();
				// }
				if(role.length == 0){
					layer.tips('请选择','#role21',{time:3,guide:1});
					return false;
				}
				if ($.trim($('#introduce21').val()).length < intrminlength || $.trim($('#introduce21').val()).length > intrmaxlength) {
					layer.tips('字数在10~200之间','#introduce21',{time:3,guide:1});
					$('#introduceright21').hide();
					return false;
				}
				//  else if ($.trim($('#introduce21').val()).length >= intrminlength && $.trim($('#introduce21').val()).length < intrmaxlength+1) {
				// 	$('#introduceright21').show();
				// } 
				else {
					return true;
				}
			},
			success: function(data) {
				if(data == -1){
					layer.alert('提交失败，请登录', 8);
				}else{
					// var t = JSON.parse(data);
					var t = $.parseJSON(data);
					var photo = './Uploads/Portrait/' + t.photo;
					var position = '[' + t.memberposition + ']';
					var team1 = '<div class="lades" id="pr' + t.id + '">' + '<div class="leaeft">' + '<img src="' + photo + '" style="width:80px;height:80px;" id="photo' + t.id + '"/>' + '</div>' + '<div class="learht">' + '<div class="els">' + '<span id="name' + t.id + '">' + t.membername + '</span>' + '<span id="position' + t.id + '">' + position + '</span>' + '</div>' + '<div class="xel" id="role' + t.id + '">创建人</div>' + '<div class="clear"></div>' + '<div class="shuoming" id="introduce' + t.id + '">' + t.memberintroduce + '</div>' + '<input type ="hidden" name="memberid32" class="memberid' + t.id + '" value="' + t.id + '">' + '<div class="jjs">' + '<input type="image" src="public/home/images/entrepre/bianji.gif" id="edit32" onclick="javascript:doedit(' + t.id + ');" style="margin-right:6px;">' + '<input type="image" src="public/home/images/entrepre/sccr.gif" id="delete32" onclick="javascript:dodelete(' + t.id + ');">' + '</div>' + '</div>' + '<div class="clear"></div>' + '</div>';
					var team2 = '<div class="lades" id="pr' + t.id + '">' + '<div class="leaeft">' + '<img src="' + photo + '" style="width:80px;height:80px;" id="photo' + t.id + '"/>' + '</div>' + '<div class="learht">' + '<div class="els">' + '<span id="name' + t.id + '">' + t.membername + '</span>' + '<span id="position' + t.id + '">' + position + '</span>' + '</div>' + '<div class="xel" id="role' + t.id + '">其他成员</div>' + '<div class="clear"></div>' + '<div class="shuoming" id="introduce' + t.id + '">' + t.memberintroduce + '</div>' + '<input type ="hidden" name="memberid32" class="memberid' + t.id + '" value="' + t.id + '">' + '<div class="jjs">' + '<input type="image" src="public/home/images/entrepre/bianji.gif" id="edit32" onclick="javascript:doedit(' + t.id + ');" style="margin-right:6px;">' + '<input type="image" src="public/home/images/entrepre/sccr.gif" id="delete32" onclick="javascript:dodelete(' + t.id + ');">' + '</div>' + '</div>' + '<div class="clear"></div>' + '</div>';
					if(t.memberroleid == 0){
						$('#teamx').append(team1);
					}else if(t.memberroleid == 1){
						$('#teamx').append(team2);
					}
					$('#pr31').hide();
					$('#pr21').clearForm();
					$('#photoimg21').show();
					$('#photoimg22').hide();
					$('#headphoto21').val('');
					//$('#photoimg21').attr('src',__HOME__/images/entrepre/logg.gif);
					$('#nameright21').hide();
					$('#positionright21').hide();
					$('#introduceright21').hide();
				}	
			}
		});
		return false;
	});
	//表单重置
	$('#reset21').on('click',function(){
		$('#prform21')[0].reset();
		$('#headphoto21').val('');
		return false;
	});
	//头像更新上传
	$('#memberphoto23').on('change',function(){
		var filename = $('#memberphoto23').val();
		var start = filename.lastIndexOf('.'); //获取最后“.”的位置
		var c = filename.substring(start + 1).toLowerCase(); //截取字符串
		if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
			layer.tips('请选择上传头像正确格式', '#memberphoto23', {
				time: 3,
				guide: 0
			});
			return false;
		}else {
			$('#photoForm23').trigger('submit');
            return true;
		}
	});
	$('#photoForm23').ajaxForm(function(data){
		if (data == -1) {
            layer.alert('上传失败，请登录', 8);
        } else if (data == 0) {
            layer.tips('图片大小不应大于1024kb,请重传！', '#memberphoto23', {
                time: 3,
                guide: 0
            });
        } else {
        	$('#photoimg23').hide();
        	$('#photoimg24').show();
            $('#photoimg24').attr('src','./Uploads/Portrait/' + data);
            $('#headphoto23').val(data);
        }
	});
	//成员信息更新
	$('#save23').on('click', function() {
		$('#prform23').ajaxSubmit({
			beforeSubmit: function() {
				var memberid = $('#memberid23').val();
				var role = $(".juese23").filter(':checked');
				var intrminlength = 10;
				var intrmaxlength = 200;
				if ($.trim($('#name23').val()).length < 2 || $.trim($('#name23').val()).length > 10) {
					layer.tips('字数在2~10之间','#name23',{time:3,guide:1});
					$('#nameright23').hide();
					return false;
				} 
				// else if ($.trim($('#name23').val()).length > 1 && $.trim($('#name23').val()).length < 11) {
				// 	$('#nameright23').show();
				// }
				if ($.trim($('#position23').val()).length < 2 || $.trim($('#position23').val()).length > 10) {
					layer.tips('字数在2~10之间','#position23',{time:3,guide:1});
					$('#positionright23').hide();
					return false;
				} 
				// else if ($.trim($('#position23').val()).length >1 && $.trim($('#position23').val()).length < 11) {
				// 	$('#positionright23').show();
				// }
				if(role.length == 0){
					layer.tips('请选择','#role23',{time:3,guide:1});
					return false;
				}
				if ($.trim($('#introduce23').val()).length < intrminlength || $.trim($('#introduce23').val()).length > intrmaxlength) {
					layer.tips('字数在10~200之间','#introduce23',{time:3,guide:1});
					$('#introduceright23').hide();
					return false;
				} 
				// else if ($.trim($('#introduce23').val()).length >= intrminlength && $.trim($('#introduce23').val()).length < intrmaxlength+1) {
				// 	$('#introduceright23').show();
				// } 
				else {
					return true;
				}
			},
			success: function(data) {
				if(data==-1){
					layer.alert('编辑失败，请登录', 8);
				}else{
					var t = JSON.parse(data);
					var photo = './Uploads/Portrait/' + t.photo;
					var position = '[' + t.memberposition + ']';
					var photoid = 'photo' + t.id;
					var nameid = 'name' + t.id;
					var positionid = 'position' + t.id;
					var roleid = 'role' + t.id;
					var introduceid = 'introduce' + t.id;
					$("#" + photoid).attr('src', photo);
					$("#" + nameid).html(t.membername);
					$("#" + positionid).html(position);
					if(t.memberroleid == 0){
						$("#" +roleid).html('创建人');
					}else if(t.memberroleid == 1){
						$("#" +roleid).html('其他成员');
					}
					$("#" + introduceid).html(t.memberintroduce);
					$('#headphoto23').val('');
					$('#pr23').hide();
					$('#pr21').show();
				}	
			}
		});
		return false;
	});
// ========================================================================================================================

});

// ======================Tab区+下一步 判断=================================================================================
// 资料审核页 + 下一步
function li2() {
	var prid = $('.prid').val();
	var next01url = '?s=home/entrepre/next01&prid=' + prid;
	$.get(next01url, function(data) {
		var t = JSON.parse(data);
		if (t.project == 1 & t.prmember > 1) {
			window.location.href = '?s=home/entrepre/entrepre02';
		} else if(t.project!=1){
			layer.tips('基本资料必填项写完整','#tb_',{time:3,guide:2});
			return false;
		}else if(t.prmember < 2){
			layer.tips('团队成员至少2人','#tb_',{time:3,guide:2});
			return false;
		}
	});
}
//项目描述页
function li5() {
	var prid = $('.prid').val();
	var next01url = '?s=home/entrepre/next01&prid=' + prid;
	$.get(next01url, function(data) {
		var t = JSON.parse(data);
		if (t.project == 1 & t.prmember > 1) {
			window.location.href = '?s=home/entrepre/entrepre05';
		} else if(t.project!=1){
			layer.tips('基本资料必填项写完整','#tb_',{time:3,guide:2});
			return false;
		}else if(t.prmember < 2){
			layer.tips('团队成员至少2人','#tb_',{time:3,guide:2});
			return false;
		}
	});
}
// 融资需求页
function li3() {
	var prid = $('.prid').val();
	var next01url = '?s=home/entrepre/next01&prid=' + prid;
	$.get(next01url, function(data) {
		var tnext = JSON.parse(data);
		if (tnext.project == 1 & tnext.prmember > 1) {
			window.location.href = '?s=home/entrepre/entrepre03';
		} else if(tnext.project!=1){
			layer.tips('基本资料必填项写完整','#tb_',{time:3,guide:2});
			return false;
		}else if(tnext.prmember < 2){
			layer.tips('团队成员至少2人','#tb_',{time:3,guide:2});
			return false;
		}
	});
}
// 项目图片页
function li4() {
	var prid = $('.prid').val();
	var next01url = '?s=home/entrepre/next01&prid=' + prid;
	$.get(next01url, function(data) {
		var t = JSON.parse(data);
		if (t.project == 1 & t.prmember > 1) {
			window.location.href = '?s=home/entrepre/entrepre04';
		} else if(t.project!=1){
			layer.tips('基本资料必填项写完整','#tb_',{time:3,guide:2});
			return false;
		}else if(t.prmember < 2){
			layer.tips('团队成员至少2人','#tb_',{time:3,guide:2});
			return false;
		}
	});
}
// ========================================================================================================================

// ==================取消表单修改==========================================================================================
//取消基本资料信息修改
function back03() {
	$('#pr03').hide();
	$('#pr02').show();
}
//取消关于我们修改
function back13() {
	$('#pr13').hide();
	$('#pr12').show();
}
//取消成员信息修改
function back23() {
	$('#pr23').hide();
	$('#pr21').show();
}
// ======================================================================================================================

// =================项目成员信息编辑+删除================================================================================
//显示编辑成员信息
function doedit(id) {
	var memberid = id;
	var editurl = '?s=home/entrepre/prmemberedit22&memberid=' + memberid;
	$('#pr23').clearForm();
	$.get(editurl, function(data) {
		if(data==-1){
			layer.alert('编辑失败，请登录', 8);
		}else{
			var t = JSON.parse(data);
			var photo = './Uploads/Portrait/' + t.photo;
			$('#name23').val(t.membername);
			$('#position23').val(t.memberposition);
			if (t.memberroleid == 0) {
                $('#radio231').get(0).checked = true;
            } else if (t.memberroleid == 1) {
                $('#radio232').get(0).checked = true;
            }
			$('#introduce23').val(t.memberintroduce);
			$('#photoimg23').attr('src', photo);
			$('#memberid23').val(t.id);
			$('#pr21').hide();
			$('#pr23').show();
		}
	});
}
//删除成员
function dodelete(id) {
	var memberid = id;
	var prid = 'pr' + id;
	var deleteurl = '?s=home/entrepre/prmemberdelete22&memberid=' + memberid;
	$.get(deleteurl,function(data){
		if(data==-1){
			layer.alert('删除失败，请登录', 8);
		}else{
			$('#' + prid).remove();
		}
	});
}
// ================================================================================================================

// ================页面刷新========================================================================================
//页面刷新（所有表单置空）
	window.onload=function() {
        document.forms[0].reset();
        placeFocus();

    }
    function placeFocus() {
        document.forms[0].elements[0].focus(); // assuming the first element
        $('#prname01').val('');
        $('#prphone01').val('');
        $('#printroduce01').val('');
        $('#videoweb01').val('');
        $('#prstage01').val('');			//刷新时项目阶段返回默认值
        $('#province01').val('');		//刷新时项目地区返回默认值
        $('#father01').val('');			//刷新时行业返回默认值
        $('#province03').val('');
        $('#grand03').val('');
        $('#prabout11').val('');
        $('#prwhysupport41').val('');
        $('#prpromise51').val('');
        $('#prdanger61').val('');
        $('#name21').val('');
        $('#position21').val('');
        $('#introduce21').val('');
        $('#headphoto23').val('');
    }
// ==================================================================================================================



