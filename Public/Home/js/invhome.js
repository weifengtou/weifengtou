
//关注
function attention (iid) {
	$.post('?s=home/user/showLoginStyle', {iid: iid}, function(data, textStatus, xhr) {
		if (data==0) {
			minilogin()
		}
		if (data==1||data==2) {
            $.post('?s=home/invhome/attention',{ iid: iid}, function(data, textStatus, xhr) {
            	/*optional stuff to do after success */
            	if (data=="关注成功！") {
            		layer.alert(data,1)
            		$("#ygzD").html('<a id="ygz" href="javascript:delatt('+iid+');"><img id="ygzI" src="./Public/Home/images/investor/invdisplay/guanzhu02.gif" width="125" height="44" alt="guanzhu02" /></a>')
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

function attention2 (iid) {
    $.post('?s=home/user/showLoginStyle', {iid: iid}, function(data, textStatus, xhr) {
        if (data==0) {
            minilogin()
        }
        if (data==1||data==2) {
            $.post('?s=home/invhome/attention',{ iid: iid}, function(data, textStatus, xhr) {
                /*optional stuff to do after success */
                if (data=="关注成功！") {
                    layer.alert(data,1)
                }
                if (data=="不能关注自己！") {
                    alert(data)
                }
                if (data=="已关注！") {
                    layer.alert(data,1)
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
		$("#ygz").html('<img id="qxgzI" src="./Public/Home/images/investor/invdisplay/guanzhu03.gif" width="125" height="44" alt="guanzhu03" />')
	});	
	$(".grjj_r").on('mouseout','#qxgzI' ,function(event) {
		event.preventDefault();
		$("#ygz").html('<img id="ygzI" src="./Public/Home/images/investor/invdisplay/guanzhu02.gif" width="125" height="44" alt="guanzhu02" />')
	});
});
function delatt (iid) {
	$.post('?s=Home/Invhome/delAtt',{iid:iid}, function(data, textStatus, xhr) { 
		if(data){
			$("#ygzD").html('<a id="gz" href="javascript:attention('+iid+');"><img src="./Public/Home/images/investor/invdisplay/guanzhu01.gif" width="125" height="44" alt="guanzhu01" /></a>')
		    layer.alert("取消关注成功！",1)
        }else{
            layer.alert("取消关注失败！",8)
        }
	});
}

//站内信
function webMsg (iid) {
	$.post('?s=home/user/showLoginStyle', {iid: iid}, function(data, textStatus, xhr) {
		if (data==0) {
        	minilogin()
        }
        if (data==1||data==2) {
        	$.post('?s=Home/Invhome/isWebMsgYou',{iid:iid}, function(data, textStatus, xhr) {
        		if (data=="不能对自己发送！") {
        			alert(data)
        			return;
        		}
	            layer.prompt({
					type: 3, 
					title: '站内信'
				}, function(val, index, elem){
				    if (val=='') {
				    	layer.alert("不能为空！",8)
				    	return;
				    }
				    $.post('?s=home/invhome/webMsg', {iid:iid,val:val}, function(data, textStatus, xhr) {
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

//投递项目
function proDelivery (iid) { //iid 投递的项目人
	$.post('index.php?s=home/user/showLoginStyle', {iid:iid}, function(data, textStatus, xhr) {
		if (data==0) {
        	minilogin()
        }
        if (data==1) {
        	$.post('index.php?s=home/project/isdeli', {iid:iid}, function(data, textStatus, xhr) {
        		// alert(data)
        		if (data=='1') {
        			layer.alert("对每个投资者你最多可以投递一个项目！<br/>你已经向他投递过项目",8)
        			return;
        		}
        		$.layer({
				    type: 2,
				    shadeClose: true,
				    title: '请选择项目',
				    shade: [0.8, '#000'],
				    border: [0],
				    offset: ['20px',''],
				    area: ['730px', ($(window).height() - 50) +'px'],
				    iframe: {src: 'index.php?s=home/project/deliveryPro&iid='+iid}
				}); 
        	});
        }
        if (data==2) {
        	layer.alert("你并不是项目创建人，无法投递项目！<br/>你可以申请一个项目创建人账号提交你的项目。",8)
        }
        if (data==3) {
            layer.alert("你尚未注册完成！",8)
        }
	});
}

//评论
function pinglun (iid) {
	var pingjia = $('#pingjia').val()
	$.post('?s=home/user/showLoginStyle', {iid:iid}, function(data, textStatus, xhr) {
        if (data==0) {
            minilogin()
        }
        if (data==1||data==2) {
            if (pingjia=='') {
                layer.alert("请输入评价内容！",8)
                return false
            }
            $.post('?s=home/invhome/pingLun', {iid:iid,pingjia:pingjia}, function(data, textStatus, xhr) {
            	if (data==1) {
            		layer.alert("评论成功！",1)
            		$('#pingjia').val('')
            		location.reload() 
            	}
            	if (data==0) {
            		layer.alert("评论失败！",8)
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
function huifu (to) {
    var cmtmsg = $("textarea[to="+to+"]").val()
    var cmtedid = $("textarea[to="+to+"]").attr('pid')
    var cmtid = $("textarea[to="+to+"]").attr('from')
    var cmteduid = $("textarea[to="+to+"]").attr('to')
    if (!cmtmsg) {
        layer.alert("请输入内容！",8)
        return false
    }
    $.post('index.php?s=Home/Project/huiFu',{cmtid:cmtid,cmtmsg:cmtmsg,cmtedid:cmtedid,cmteduid:cmteduid}, function(data, textStatus, xhr) {
        if (data==1) {
            layer.alert("回复成功！",1)
            $("textarea[to="+to+"]").val('')
            location.reload() 
        }
        if (data==0) {
            layer.alert("回复失败！")
        }
    });
}


// ************************************曹超2014-12-15*********************************************
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