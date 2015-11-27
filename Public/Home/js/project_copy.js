//省
function select_large (lid) {
	$.post('?s=home/invhome/china_space',{'lid':lid}, function(data, textStatus, xhr) {
		$('#larges').hide()
		var datas = jQuery.parseJSON(data)
		$('#smalls').html('').show()
		$.each(datas, function(index, val) {
			$('#smalls').append("<ul><li><a href='javascript:select_small("+val.id+");'>"+val.name+"</a></li></ul>")
		});
		$('#smalls').prepend("<ul><li><a href='javascript:getLarges();'>返回</a></li></ul>")
	});
}

//市
function select_small (sid) {
	alert(sid)
}

//获取市
function getLarges () {
	$('#larges').show()
	$('#smalls').hide()
}

//关注
function attention (pid) {
    $.post('?s=home/user/showloginStyle', {pid: pid}, function(data, textStatus, xhr) {
        if (data==0) {
        	minilogin()
        }
        if (data==1||data==2) {
            $.post('?s=home/project/attention',{ pid: pid}, function(data, textStatus, xhr) {
            	/*optional stuff to do after success */
            	if (data=="关注成功！") {
                    layer.alert(data,1)
                    $("#ygzD").html('<a id="ygz" href="javascript:delatt('+pid+');"><img id="ygzI" src="./Public/Home/images/investor/invdisplay/guanzhu02.gif" width="125" height="44" alt="guanzhu02" /></a>')
                }
                if (data=="不能关注自己！") {
                    alert(data)
                }
            });
        }
        if (data==3) {
            layer.alert("你尚未注册完成！",8)
        }
    });
}
//取消关注
jQuery(document).ready(function($) {
    $(".grjj_r").on('mouseenter','#ygzI' ,function(event) {
        event.preventDefault();
        /* Act on the event */
        $("#ygz").html('<img id="qxgzI" src="./Public/Home/images/investor/invdisplay/guanzhu03.gif" width="125" height="44" alt="guanzhu03" />')
    }); 
    $(".grjj_r").on('mouseout','#qxgzI' ,function(event) {
        event.preventDefault();
        /* Act on the event */
        $("#ygz").html('<img id="ygzI" src="./Public/Home/images/investor/invdisplay/guanzhu02.gif" width="125" height="44" alt="guanzhu02" />')
    });
});
function delatt (pid) {
    $.post('?s=Home/Project/delAtt',{pid:pid}, function(data, textStatus, xhr) {
        /*optional stuff to do after success */
        if(data=="取消成功!"){
            $("#ygzD").html('<a id="gz" href="javascript:attention('+pid+');"><img src="./Public/Home/images/investor/invdisplay/guanzhu01.gif" width="125" height="44" alt="guanzhu01" /></a>')
        }
        alert(data)
    });
}

//站内信
function webMsg (pid) {
    $.post('?s=home/user/showloginStyle',{pid:pid}, function(data, textStatus, xhr) {
        if (data==0) {
            minilogin()
        }
        if (data==1||data==2) {
            $.post('?s=Home/Project/isWebMsgYou',{pid:pid}, function(data, textStatus, xhr) {
                if (data=="不能对自己发送！") {
                    alert(data)
                    return;
                }
                layer.prompt({
                    type: 3, 
                    title: '站内信',
                }, function(val, index, elem){
                    if (val=='') {
                        alert("不能为空！")
                        return;
                    }
                    $.post('?s=home/project/webMsg', {pid:pid,val:val}, function(data, textStatus, xhr) {
                        alert(data)
                        $(".xubox_close").trigger('click')
                    });
                })
            });
        }
        if (data==3) {
            layer.alert("你尚未注册完成！",8)
        }
    });
}

//评论
function pinglun (pid) {
    var pingJia = $("#pingJia").val()
    $.post('?s=home/user/showloginstyle', {pid:pid}, function(data, textStatus, xhr) {
        // alert(data)
        if (data==0) {
            minilogin()
        }
        if (data==1||data==2) {
            if (pingJia=='') {
                layer.alert("请输入评价内容！",8)
                return;
            }
            $.post('?s=home/project/pingLun', {pid:pid,pingJia:pingJia}, function(data, textStatus, xhr) {
                // alert(data)
                if (data==1) {
                    alert("评论成功！")
                    $('#pingJia').val('')
                    location.reload() 
                }
                if (data==0) {
                   layer. alert("评论失败！",8)
                }
                if (data==2) {
                    layer.alert("不能向自己评论！",8)
                }
            });
        }
        if (data==3) {
            layer.alert("你尚未注册完成！",8)
        }
    });
}

//回复
function huiFu (cmtid,i) {
    var repmsg = $("#hf"+i).val()
    var repid = $("#repid"+i).val()
    var repedid = $("#repedid"+i).val()
    if (!repmsg) {
        layer.alert("请输入内容！",8)
        return;
    }
    $.post('?s=home/invhome/huiFu',{cmtid:cmtid,repmsg:repmsg,repid:repid,repedid:repedid}, function(data, textStatus, xhr) {
        if (data==1) {
            alert("回复成功！")
            $('#pingJia').val('')
            location.reload() 
        }
        if (data==0) {
            layer.alert("回复失败！")
        }
    });
}

//预约出资
function chuzi () {
    $.post('?s=Home/User/showloginstyle', {}, function(data, textStatus, xhr) {
        if (data==0) {
            minilogin()
        }else{
            var pagei = $.layer({
                type: 1,   //0-4的选择,
                title: "请输入出资金额",
                border: [0],
                shadeClose: true,
                area: ['460px', '280px'],
                page: {
                    dom: '#mini_yycz' //此处放了防止html被解析，用了\转义，实际使用时可去掉
                }
            });
        }
    });
}
function czok () {
    var pid = $("#cz_pid").val()
    var prid = $("#cz_prid").val()
    var cz_maney = $("#cz_maney").val()
    var cz_msg = $("#cz_msg").val()
    if(cz_maney!=''&&$.isNumeric(cz_maney)){
        
    }else{
        layer.alert("请输入数字！",8)
        return;
    }
    if (cz_msg=='') {
        layer.alert("请输入留言！",8)
        return;
    }
    $.post('?s=home/user/showloginstyle', {pid:pid,prid:prid,cz_msg:cz_msg,cz_maney:cz_maney}, function(data, textStatus, xhr) {
        if (data==0) {
            minilogin()
        }
        if (data==1) {
            layer.alert("你并不是项目投资人，无法出资<br>你可以重新注册一个投资人账号来出资")
        }
        if (data==2) {
            $.post('?s=home/project/chuzi', {pid:pid,prid:prid,cz_msg:cz_msg,cz_maney:cz_maney}, function(data, textStatus, xhr) {
                
                if (data==1) {
                    alert("出资成功！")
                }
                if (data==0) {
                   layer. alert("出资失败！",8)
                }
                if (data==2) {
                   layer. alert("出资成功！",8)
                }
            });
        }
        if (data==3) {
            layer.alert("你尚未注册完成！",8)
        }
    });
    $(".xubox_close").trigger('click')
}
// ************************************曹超2014-12-10*********************************************
$(document).ready(function() {
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
    //加载所有市     
    $('#tradeone').on('change', function() {
        var tradeid = $(this).val();
        var time = new Date();
        var time2 = time.getTime();
        var tradeurl = '?s=home/entrepre/trade&tradeid=' + tradeid + '&time=' + time2;
        $.get(tradeurl, function(data) {
            $("#tradetwo").empty();
            var t = JSON.parse(data);
            $('#tradetwo').append('<option value="">全部</option><br />');
            $.each(t, function(key, obj) {
                $('#tradetwo').append('<option value=' + obj.id + '>' + obj.trade + '</option><br />');
            });
        });
    });
    $('#areasubmit').on('click',function(){
        $('#areaForm').trigger('submit');
    });
});
// ******************************************************************************************