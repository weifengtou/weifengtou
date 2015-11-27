//上传头像
function txup () {
    $('#update_tx').trigger('submit')
}
$('#update_tx').ajaxForm(function  (e) {
    $('#show_img').html("<img class='img_one' src='./Uploads/Investor/"+e+"' alt='touxiangshangchuan' width='220' height='220' />")
    $("#subImg").val(e);
})

jQuery(document).ready(function($) {
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
        var areaurl = '?s=home/entrepre/province&areaid=' + areaid + '&time=' + time2;
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
        var areaurl = '?s=home/entrepre/city&areaid=' + areaid + '&time=' + time2;
        $.get(areaurl, function(data) {
            $("#town").empty();
            var t = JSON.parse(data);
            $('#town').append('<option value="">县区</option><br />');
            $.each(t, function(key, obj) {
                $('#town').append('<option value=' + obj.id + '>' + obj.name + '</option><br />');
            });
        });
    }); 
});

//提交编辑
function bianjiSub () {
    $("#bianjiSub").ajaxSubmit({
        beforeSubmit:function () {
            var r = /^(13[0-9]|15[0|1|2|3|5|6|7|8|9]|17[7|8]|18[0-9])\d{8}$/;   //手机号正则表达式
            var qq = /^[1-9][0-9]{4,9}$/;           //qq号正则表达式
            if (!r.test($("#phone").val())) {
                layer.tips('手机号码错误！','#phone',{time:3,guide:1})
                location.href = "#phone"
                return false
            }
            if ($.trim($("#realname").val()).length==0) {
                layer.tips('真实名称不能为空！','#realname',{time:3,guide:1})
                location.href = "#realname"
                return false
            }
            if ($.trim($("#company").val()).length==0) {
                layer.tips('公司不能为空！','#company',{time:3,guide:1})
                location.href = "#company"
                return false
            }
            if (!/^[0-9]*[1-9][0-9]*$/.test($("#income").val())) {
                layer.tips('月收入不正确！','#income',{time:3,guide:1})
                location.href = "#income"
                return false
            }
            if (!/^[0-9]*[1-9][0-9]*$/.test($("#min_maney").val())) {
                layer.tips('最小投资金额不正确！','#min_maney',{time:3,guide:1})
                location.href = "#min_maney"
                return false
            }
            if (!/^[0-9]*[1-9][0-9]*$/.test($("#max_maney").val())) {
                layer.tips('最大投资金额不正确！','#max_maney',{time:3,guide:1})
                location.href = "#max_maney"
                return false
            }
            if (eval($("textarea[name=min_maney]").val())>eval($("textarea[name=max_maney]").val())) {
                alert("最大投资金额应该大于最小投资金额")
                return false
            } 
            if ($.trim($("#province").val()).length==0) {
                layer.tips('所在省不能为空！','#province',{time:3,guide:1})
                location.href = "#province"
                return false
            }
            if ($.trim($("#city").val()).length==0) {
                layer.tips('所在市不能为空！','#city',{time:3,guide:1})
                location.href = "#city"
                return false
            }
            if ($.trim($("#town").val()).length==0) {
                layer.tips('所在区不能为空！','#town',{time:3,guide:1})
                location.href = "#town"
                return false
            }
            if ($("input[name='trade[]']:checked").size()==0) {
                layer.tips('投资意向不能为空！','#trade',{time:3,guide:1})
                location.href = "#town"
                return false
            }
            if ($.trim($("#qq").val()).length > 0&&!qq.test($("#qq").val())) {
                layer.tips('qq不正确！','#qq',{time:3,guide:1})
                location.href = "#qq"
                return false
            }
        },
        success:function (e) {
            // alert(e)
            layer.alert(e,2,function(){window.location.href = '?s=home/Invcenter/jibenxinxi';});
        }
    })
}

//编辑机构
function editjigou () {
    $("#editjigou").ajaxSubmit({
        beforeSubmit:function () {
            if (!$.trim($('#tddetail').val())) {
                layer.tips('团队简介必填！','#tddetail',{time:3,guide:1})
                location.href = "#tddetail"
                return false
            }
            if ($.trim($('#tdurl').val())&&!/(\w+):\/\/([^\/:]+)(:\d*)?([^#]*)/.test($('#tdurl').val())) {
                layer.tips('相关网址错误！','#tdurl',{time:3,guide:1})
                location.href = "#tdurl"
                return false
            }
        },
        success:function (e) {
            // alert(e)
            layer.alert(e,2,function(){window.location.href = '?s=home/Invcenter/jibenxinxi';});
        }
    })
}