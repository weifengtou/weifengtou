$(document).ready(function() {
    //保存融资需求
    $('#saveinvest01').on('click', function() {
        $('#investform01').ajaxSubmit({
            beforeSubmit: function() {
                var extrasmaxlength = 50;
                var purposemaxlength = 15;
                var r = /^[0-9]*[1-9][0-9]*$/; //判断正整数 
                var radio = $("input[type='radio']").filter(':checked');
                if ($('#prid').val() == '') {
                    layer.tips('请按顺序填写','#investform01',{time:3,guide:0});
                    return false;
                }
                if(!r.test($.trim($('#budget01').val()))){
                    layer.tips('请输入正整数','#budget01',{time:3,guide:1});
                    $('#budgetright01').hide();
                    return false;
                }else if($.trim($('#budget01').val()).length > 7){
                    layer.tips('请输入小于7位的正整数','#budget01',{time:3,guide:1});
                    $('#budgetright01').hide();
                    return false;
                }
                /*else{
                    $('#budgetright01').show();
                }*/
                if(!r.test($.trim($('#singleinvest01').val()))){
                    layer.tips('请输入正整数','#singleinvest01',{time:3,guide:1});
                    $('#singleinvestright01').hide();
                    return false;
                }else if(eval($('#singleinvest01').val()) > eval($('#budget01').val())){
                    layer.tips('应小于预融资金额','#singleinvest01',{time:3,guide:1});
                    $('#singleinvestright01').hide();
                    return false;
                }
                /*else{
                    $('#singleinvestright01').show();
                }*/
                /*if ($.trim($('#extras01').val()).length > 1 && $.trim($('#extras01').val()).length <= extrasmaxlength) {
                    $('#extrasright01').show();
                } else */
                /*if ($.trim($('#extras01').val()).length < 2 || $.trim($('#extras01').val()).length > extrasmaxlength) {
                    layer.tips('字数在2~50之间','#extras01',{time:3,guide:1});
                    $('#extrasright01').hide();
                    return false;
                }*/
                if ($.trim($('#purpose01').val()).length < 2 || $.trim($('#purpose01').val()).length > purposemaxlength) {
                    layer.tips('字数在2~15之间','#purpose01',{time:3,guide:1});
                    $('#purposeright01').hide();
                    return false;
                }
                /*else if($.trim($('#purpose01').val()).length > 1 && $.trim($('#purpose01').val()).length <= purposemaxlength){
                    $('#purposeright01').show();
                }*/
                /*if ($.trim($('#businessplan01').val()).length == 0) {
                    layer.tips('请选择上传商业计划书','#upplan01',{time:3,guide:1});
                    return false;
                } */
                if (!radio.length) {
                    layer.tips('请选择','#privacyset01',{time:3,guide:1});
                    return false;
                } else {
                    return true;
                }
            },
            success: function(data) {
            	//alert(data);
                if(data==-1){
                    layer.alert('提交失败，请登录',8)
                }else{
                    var t = JSON.parse(data);
                    //alert(t);
                    var planurl = 'http://' + t.businessplan;
                    var planhref = './uploads/businessplan/' + t.businessplan;
                    $('#budget02').html(t.budget);
                    $('.investid').val(t.result);
                    $('#singleinvest02').html(t.singleinvest);
//                    $('#extras02').html(t.extras);
                    $('#purpose02').html(t.purpose);
                    /*$('#businessplan02').html(t.oldname);
                    $('#businessplanurl').html(planurl);
                    $('#businessplanurl').attr('href', planhref);*/
                    $('#addinfo02').html(t.addinfo);
                    if (t.privacyset == 1) {
                        $('#privacyset02').html('所有投资人可见');
                    } else {
                        $('#privacyset02').html('设为隐私');
                    }
                    $('#cd01').hide();
                    $('#cd02').show();
                    $('#investform01').clearForm();
                } 
            }
        });
        return false;
    });
    //编辑显示融资需求
    $('#editinvest').on('click', function() {
        var id = $('.investid').val();
        var editinvesturl = '?s=/Home/Entrepre/editinvest&id=' + id;
        $.get(editinvesturl, function(data) {
            if(data==-1){
                layer.alert('编辑失败，请登录',8);
            }else{
                var t = JSON.parse(data);
                $('#budget03').val(t.budget);
                $('#singleinvest03').val(t.singleinvest);
//                $('#extras03').val(t.extras);
                $('#purpose03').val(t.purpose);
                $('#addinfo03').val(t.addinfo);
               /* $('#planoldname03').html(t.oldname);
                $('#planoldname03').attr('href','./uploads/businessplan/'+t.businessplan);*/
                if (t.privacyset == 1) {
                    $('#privacyset031').get(0).checked = true;
                } else if (t.privacyset == 0) {
                    $('#privacyset032').get(0).checked = true;
                }
                $('#cd03').show();
                /*$('#upplan03').show();
                $('#upplan031').show();
                $('#upplan032').hide();*/
                $('#cd02').hide();
            }
        });
    });
    //更新融资需求
    $('#updateinvest01').on('click', function() {
        $('#investform03').ajaxSubmit({
            beforeSubmit: function() {
                var extrasmaxlength = 50;
                var purposemaxlength = 15;
                var r = /^[0-9]*[1-9][0-9]*$/; //判断正整数 
                var radio = $("input[type='radio']").filter(':checked');
                if(!r.test($.trim($('#budget03').val()))){
                    layer.tips('请输入正整数','#budget03',{time:3,guide:1});
                    $('#budgetright31').hide();
                    return false;
                }else if($.trim($('#budget03').val()).length > 7){
                    layer.tips('请输入小于7位的正整数','#budget03',{time:3,guide:1});
                    $('#budgetright01').hide();
                    return false;
                }
                /*else{
                    $('#budgetright31').show();
                }*/
                if(!r.test($.trim($('#singleinvest03').val()))){
                    layer.tips('请输入正整数','#singleinvest03',{time:3,guide:1});
                    $('#singleinvestright31').hide();
                    return false;
                }else if(eval($('#singleinvest03').val()) > eval($('#budget03').val())){
                    layer.tips('应小于预融资金额','#singleinvest03',{time:3,guide:1});
                    $('#singleinvestright31').hide();
                    return false;
                }
                /*else{
                    $('#singleinvestright31').show();
                }*/
                /*if ($.trim($('#extras03').val()).length > 1 && $.trim($('#extras03').val()).length <= extrasmaxlength) {
                    $('#extrasright31').show();
                } else if ($.trim($('#extras03').val()).length < 2 || $.trim($('#extras03').val()).length > extrasmaxlength) {
                    layer.tips('字数在2~50之间','#extras03',{time:3,guide:1});
                    $('#extrasright31').hide();
                    return false;
                }*/
                if ($.trim($('#purpose03').val()).length < 1 || $.trim($('#purpose03').val()).length > purposemaxlength) {
                    layer.tips('字数在2~15之间','#purpose03',{time:3,guide:1});
                    $('#purposeright31').hide();
                    return false;
                }
                /*else if ($.trim($('#purpose03').val()).length > 2 && $.trim($('#purpose03').val()).length <= purposemaxlength) {
                    $('#purposeright31').show();
                }*/
                if (!radio.length) {
                    $('#privacyseterror31').html('请选择隐私设置');
                    return false;
                } else {
                    return true;
                }
            },
            success: function(data) {
                if(data==-1){
                    layer.alert('提交失败，请登录',8)
                }else{
                    var t = JSON.parse(data);
                    var planurl = 'http://' + t.businessplan;
                    var planhref = './uploads/businessplan/' + t.businessplan;
                    $('#budget02').html(t.budget);
                    $('#singleinvest02').html(t.singleinvest);
//                    $('#extras02').html(t.extras);
                    $('#purpose02').html(t.purpose);
                    /*$('#businessplan02').html(t.oldname);
                    $('#businessplanurl02').html(planurl);
                    $('#businessplanurl02').attr('href', planhref);*/
                    $('#addinfo02').html(t.addinfo);
                    if (t.privacyset == 1) {
                        $('#privacyset02').html('所有投资人可见');
                    } else {
                        $('#privacyset02').html('设为隐私');
                    }
                    $('#cd03').hide();
                    $('#cd02').show();
                    $('#investform03').clearForm();
                }
                
            }
        });
        return false;
    });
    //表单重置
    $('#reset01').on('click',function(){
        $('#investform01')[0].reset();
        return false;
    });
});

// 取消修改
function backinvest() {
    $('#cd02').show();
    $('#cd03').hide();
}

//页面刷新（所有表单置空）
     window.onload=function() {
        document.forms[0].reset();
        placeFocus();
    }
    function placeFocus() {
        document.forms[0].elements[0].focus(); // assuming the first element
        $('#budget01').val('');
        $('#singleinvest01').val('');
//        $('#extras01').val('');
        $('#purpose01').val('');         //刷新时项目阶段返回默认值
        $('#addinfo01').val('');        //刷新时项目地区返回默认值
       // $('#businessplan01').val('');           //刷新时行业返回默认值
    }