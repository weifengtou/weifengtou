//公司/机构 投资人类别
var ji_gou_tou_zi_ren_lei_bie = {
	'0':'VC',
	"1":"投资银行",
	"2":"证券",
	"3":"基金",
	"4":"保险",
	"5":"期货",
	"6":"金融资产管理公司",
	"7":"财务公司",
	"8":"信托",
	"9":"其他"
}

//公司/机构性质
var ji_gou_tou_zi_ren_xing_zhi = {
	'1':'中资',
	"2":"外资",
	"3":"中外合资"
}

//投资阶段
var tou_zi_jie_duan = {
	'1':'初创期',
	"2":"扩长期",
	"3":"成熟期"
}

//小号登陆窗口
function minilogin () {
    $.layer({
        type : 1,
        title : false,
        offset:['150px' , ''],
        border : false,
        area : ['330px','450px'],
        page : {dom : '#minilogin'}
    });
}

//设置密码
function shezhimima () {
	$.layer({
        type : 1,
        title : false,
        offset:['150px' , ''],
        border : false,
        area : ['450px','280px'],
        page : {dom : '#shezhi'}
    });
}

//cookie操作
function setCookie(name,value,time)
{
    var exp = new Date();
    exp.setTime(exp.getTime() + time);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
    var strsec = getsec(time);
    var exp = new Date();
    exp.setTime(exp.getTime() + strsec*1);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
//读取cookies
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return (unescape(arr[2]));
    else
        return null;
}
//删除cookies
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

//暂无功能
function hasnofun () {
    alert("暂无开通此功能，请谅解");
}