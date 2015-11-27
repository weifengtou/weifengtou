// jQuery(".full-slide").hover(
//   function() {
//     jQuery(this).find(".prev,.next").stop(true, true).fadeTo("show", 0.5)
//   },
//   function() {
//     jQuery(this).find(".prev,.next").fadeOut()
//   }
// );
// jQuery(".full-slide").slide({
//   titCell: ".hd ul",
//   mainCell: ".bd ul",
//   effect: "fold",
//   autoPlay: true,
//   autoPage: true,
//   trigger: "click",
//   startFun: function(i) {
//     var curLi = jQuery(".full-slide .bd li").eq(i);
//     if ( !! curLi.attr("_src")) {
//       curLi.css("background-image", curLi.attr("_src")).removeAttr("_src")
//     }
//   }
// });
//投递项目
/*function proDelivery (iid) { //iid 投递的项目人
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
}*/

function createproject(){
  $.ajax({
    url: 'index.php?s=home/index/createproject',
    success:function(data){
      if(data==-1){                               //进入登录页
        // window.location.href = 'index.php?s=home/user/login';
        minilogin()
      }else if(data==0){                          //进入身份选择页
        window.location.href = 'index.php?s=home/investor/choose';
      }else if(data==1){                          //进入项目中心           
        window.location.href = 'index.php?s=home/prcenter/createproject';
      }else if(data==2){                          //进入身份选择页
        layer.alert('尊敬的用户您好，您已是'+'<font color="red">'+'投资人'+'</font>'+'身份，无法创建项目！');
      }
    }
  });
}
function becomeinvestor(){
  $.ajax({
    url: 'index.php?s=home/index/becomeinvestor',
    success:function(data){
      if(data==-1){                               //进入登陆页
        // window.location.href = 'index.php?s=home/user/login';
        minilogin()
      }else if(data==0){                          //进入身份选择页
        window.location.href = 'index.php?s=home/investor/choose';
      }else if(data==1){                          //进入投资人资料填写
        window.location.href = 'index.php?s=home/investor/';
      }else if(data==2){                          //进入投资人资料审核中
        window.location.href = 'index.php?s=home/investor/shenhe1';
      }else if(data==3){                          //进入投资人资料审核失败
        window.location.href = 'index.php?s=home/investor/shenhe0';
      }else if(data==4){                          //进入投资人中心
        window.location.href = 'index.php?s=home/invcenter/index';
      }else if(data==5){                          //进入身份选择页
        layer.alert('尊敬的用户您好，您已是'+'<font color="red">'+'项目创建人'+'</font>'+'身份，无法成为投资人！');
      }
    }
  });
}