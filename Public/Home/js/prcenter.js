
$(document).ready(function(){
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
    $('#province02').on('change', function() {
        var areaid = $(this).val();
        var areaurl = '?s=Home/entrepre/province&areaid=' + areaid;
        $.get(areaurl, function(data) {
            $("#city02").empty();
            var t = JSON.parse(data);
            $.each(t, function(key, obj) {
                $('#city02').append('<option value=' + obj.id + '>' + obj.name + '</option><br />');
            });
        });
    });
    //加载所有县
    $('#city02').on('change', function() {
        var areaid = $(this).val();
        var areaurl = '?s=Home/entrepre/city&areaid=' + areaid;
        $.get(areaurl, function(data) {
            $("#town02").empty();
            var t = JSON.parse(data);
            $.each(t, function(key, obj) {
                $('#town02').append('<option value=' + obj.id + '>' + obj.name + '</option><br />');
            });
        });
    });
    //加载二级行业
    $('#grand02').on('change', function() {
        var code = $(this).val();
        var industryurl = '?s=Home/entrepre/grand&code=' + code;
        $.get(industryurl, function(data) {
            $("#father02").empty();
            var t = JSON.parse(data);
            $.each(t, function(key, obj) {
                $('#father02').append('<option value=' + obj.fullcode + '>' + obj.fulldescription + '</option><br />');
            });
        });
    });
    //加载三级行业
    $('#father02').on('change', function() {
        var code = $(this).val();
        var industryurl = '?s=Home/entrepre/father&code=' + code;
        $.get(industryurl, function(data) {
            $("#full02").empty();
            var t = JSON.parse(data);
            $.each(t, function(key, obj) {
                $('#full02').append('<option value=' + obj.fullcode + '>' + obj.fulldescription + '</option><br />');
            });
        });
    });
	//显示项目基本资料编辑信息
	$('#edit01').on('click', function() {
		var prid = $('#prid').val();
 	 	var editurl = '?s=Home/prcenter/prbaseedit';
 	 	$.get(editurl,{prid:prid}, function(data) {
 	 		var t = JSON.parse(data);
 	 		var provinceid = t.provinceid;
 	 		var stageid = t.stageid;
 	 		var cityid = t.cityid;
 	 		var townid = t.townid;
 	 		var grandindustryid = t.grandindustryid;
 	 		var imageaddress = './Uploads/Album/' + t.logo;
 	 		$('#prname02').val(t.pjname);
 	 		$('#printroduce02').val(t.pjintroduce);
 	 		$('#logo02').attr('src', imageaddress);
 	 		//$('#prlogo13').val(t12.oldname);
 	 		var provinceObj = document.getElementById('province02');
 	 		jsSelectItemByValue(provinceObj, provinceid);
 	 		var city = document.getElementById('city02');
 	 		city.options.add(new Option(t.city, t.cityid));
 	 		var town = document.getElementById('town02');
 	 		town.options.add(new Option(t.town, t.townid));
 	 		var grandObj = document.getElementById('grand02');
 	 		jsSelectItemByValue(grandObj, grandindustryid);
 	 		var father = document.getElementById('father02');
 	 		father.options.add(new Option(t.fatherindustryname, t.fatherindustryid));
 	 		var full = document.getElementById('full02');
 	 		full.options.add(new Option(t.fullindustryname, t.fullindustryid));
 	 		var prstageObj = document.getElementById('prstage02');
 	 		jsSelectItemByValue(prstageObj, stageid);
 	 	});
 	 	$('#pr01').hide();
 	 	$('#pr02').show();
 	 	$('#logoerror02').hide();
	});
	//项目基本资料信息更新
    $('#save02').on('click', function() {
        $('#prform02').ajaxSubmit({
            beforeSubmit: function() {
                var namemaxlength = 15;
                var intrmaxlength = 30;
                var filename = $('#prlogo02').val();
                var start = filename.lastIndexOf('.'); //获取最后“.”的位置
                var c = filename.substring(start + 1); //截取字符串
                var province = $('#province02').val();
                if ($.trim($("#prname02").val()).length < 2 || $.trim($("#prname02").val()).length > namemaxlength) {
                    layer.tips('字数在2~15','#prname02',{time:3,guide:1});
                    $('#prnameright02').hide();
                    return false;
                } else if ($.trim($("#prname02").val()).length > 1 && $.trim($("#prname02").val()).length <= namemaxlength) {
                    $('#prnameright02').show();
                    $('#prnameerror02').hide();
                }
                if ($.trim($('#printroduce02').val()).length < 2 || $.trim($('#printroduce02').val()).length > intrmaxlength) {
                    //$('#printroduceerror02').show();
                    layer.tips('字数在2~30','#printroduce02',{time:3,guide:1});
                    $('#printroduceright02').hide();
                    return false;
                } else if ($.trim($('#printroduce02').val()).length > 1 && $.trim($('#printroduce02').val()).length <= intrmaxlength) {
                    $('#printroduceright02').show();
                    $('#printroduceerror02').hide();
                }
                if ($('#prstage02').val() == null) {
                    //$('#prstageerror02').show();
                    layer.tips('请选择','#prstage02',{time:3,guide:1});
                    $('#prstageright02').hide();
                    return false;
                } else {
                    $('#prstageright02').show();
                    $('#prstageerror02').hide();
                }
                if ($('#province02').val() == null || $('#city02').val() == null || $('#town02').val() == null) {
                    //$('#prareaerror02').show();
                    layer.tips('请选择','#town02',{time:3,guide:1});
                    $('#prarearight02').hide();
                    return false;
                } else if ($('#province02').val() != null || $('#city02').val() != null) {
                    $('#prarearight02').show();
                    $('#prareaerror02').hide();
                }
                if ($('#grand02').val() == null || $('#father02').val() == null || $('#full02').val() == null) {
                    //$('#prindustryerror02').show();
                    layer.tips('请选择','#full02',{time:3,guide:1});
                    $('#prindustryright02').hide();
                    return false;
                } else if ($('#grand02').val() != null && $('#father02').val() != null && $('#full02').val() != null) {
                    $('#prindustryright02').show();
                    $('#prindustryerror02').hide();
                }
                if ($('#prlogo02').val() == '') {
                    //$('#logoerror02').html('请选择上传logo');
                    layer.tips('请选择上传logo','#prlogo02',{time:3,guide:2});
                    return false;
                } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
                    //$('#logoerror02').html('请选择上传文件正确格式');
                    layer.tips('请选择上传logo正确格式','#prlogo02',{time:3,guide:2});
                    return false;
                } else {
                    return true;
                }
            },
            success: function(data) {
                var t = JSON.parse(data);
                var imgaddress = './Uploads/Album/' + t.logo;
                $('#prname01').html(t.pjname);
                $('#printroduce01').html(t.pjintroduce);
                if (t.town == null) {
                    $('#prarea01').html(t.province + t.city);
                } else if (t.town != '') {
                    $('#prarea01').html(t.province + t.city + t.town);
                }
                $('#prindustry01').html(t.grandindustryname + t.fatherindustryname + t.fullindustryname);
                $('#logo01').attr('src', imgaddress);
                if (t.stageid == 1) {
                    $('#prstage01').html('起步阶段');
                } else if (t.stageid == 2) {
                    $('#prstage01').html('盈利阶段');
                } else if (t.stageid == 3) {
                    $('#prstage01').html('亏损阶段');
                }
                $('#pr02').hide();
                $('#pr01').show();
                $('#prform02').clearForm();
            }
        });
        return false;
    });
	//显示项目简介编辑信息
    $('#edit11').on('click', function() {
        var prid = $('#prid').val();
        var editurl = '?s=Home/entrepre/edit22&prid=' + prid;
        $.get(editurl, function(data) {
            var t = JSON.parse(data);
            $('#prdescription12').html(t.pjdescription);
        });
        $('#pr11').hide();
        $('#pr12').show();
    });
    //
    $('#createprojecta').click(function(){
        $("#createprojecta").addClass("prcenleft");
    });
})
//取消基本资料信息修改
function back02() {
    $('#prform02')[0].reset();
    $('#pr02').hide();
    $('#pr01').show();
}




	
 



