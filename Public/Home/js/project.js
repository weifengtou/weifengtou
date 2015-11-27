
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
                    layer.alert(data)
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
        layer.alert(data)
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
                    layer.alert(data)
                    return;
                }
                layer.prompt({
                    type: 3, 
                    title: '站内信'
                }, function(val, index, elem){
                    if (val=='') {
                        layer.alert("不能为空！")
                        return;
                    }
                    $.post('?s=home/project/webMsg', {pid:pid,val:val}, function(data, textStatus, xhr) {
                        layer.alert(data,1)
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
    var pingjia = $("#pingjia").val()
    $.post('?s=home/user/showloginstyle', {pid:pid}, function(data, textStatus, xhr) {
        // alert(data)
        if (data==0) {
            minilogin()
        }
        if (data==1||data==2) {
            if (pingjia=='') {
                layer.alert("请输入评价内容！",8)
                return;
            }
            $.post('?s=home/project/pingLun', {pid:pid,pingjia:pingjia}, function(data, textStatus, xhr) {
                // alert(data)
                if (data==1) {
                    layer.alert("评论成功！",1)
                    $('#pingjia').val('')
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
                area: ['460px', '330px'],
                page: {
                    dom: '#mini_yycz' //此处放了防止html被解析，用了\转义，实际使用时可去掉
                }
            });
        }
    });
}

function czok (obj) {
    var cz_max = obj.cz_max
    var pid = obj.pid
    var prid = obj.prid
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
    if (eval(cz_maney)>eval(cz_max)) {
        layer.alert("金额错误！",8)
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
                    layer.alert("出资成功！",1)
                    // location.reload() 
                }
                if (data==0) {
                   layer. alert("出资失败！",8)
                }
                if (data==2) {
                   layer. alert("账号未验证成功！",8)
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
// 筛选
$(document).ready(function() {
    $("#select1 dd").click(function () {
        // alert('111');
        // siblings()取得一个包含匹配的元素集合中每一个元素的所有唯一同辈元素的元素集合。可以用可选的表达式进行筛选。
        $(this).addClass("selected").siblings().removeClass("selected");
        // hasClass()检查当前的元素是否含有某个特定的类，如果有，则返回true。
        if ($(this).hasClass("select-all")) {
            $("#selectA").remove();
        } 
        // $.cookie('class','selected');  
    });
    $("#select2 dd").click(function () {
        // alert('222');
        $(this).addClass("selected").siblings().removeClass("selected");
        if ($(this).hasClass("select-all")) {
            $("#selectB").remove();
        } 
    });
});
// ******************************************************************************************
function fa_bu_project () {
    $.post('?s=home/user/showloginStyle',{}, function(data, textStatus, xhr) {
        if (data==0) {
            minilogin()
        }
        if (data==2) {
            layer.alert("你并不是项目创建人，无法创建项目<br>你可以重新注册一个项目人账号")
        }
        if (data==1) {
           location.href = "index.php?s=/Home/Entrepre/entrepre"
        }
        if (data==3) {
            layer.alert("你尚未注册完成！",8)
        }
    })
}