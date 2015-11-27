$(document).ready(function(){
	$('#login').on('click',function(){
		$('#loginform').ajaxSubmit({
			beforeSubmit:function(){
				if($('#username').val().length==0){
					layer.tips('用户名不能为空！','#username',{time:3,guide:1});
					// $('#usernamecue').html("<font color='red'>'用户名不能为空！'<font>");
					// $('#usernamecue').show();
					return false;
				}else{
					// $('#usernamecue').hide();
				}
				if($('#password').val().length==0){
					layer.tips('密码不能为空！','#password',{time:3,guide:1});
					// $('#passwordcue').html("<font color='red'>'密码不能为空！'<font>");
					// $('#passwordcue').show();
					return false;
				}else{
					// $('#passwordcue').hide();
				}
			},
			success:function(data){
				if(data==0){
					layer.tips('用户名不存在！','#username',{time:3,guide:1});
					// $('#usernamecue').html('用户名不存在！');
					// $('#usernamecue').show();
				}else if(data==5){
					layer.tips('用户未激活！','#username',{time:3,guide:1});
					// $('#usernamecue').html('用户未激活！');
					// $('#usernamecue').show();
				}else if(data==1){
					layer.tips('密码错误！','#password',{time:3,guide:1});
					// $('#passwordcue').html('密码错误！');
					// $('#passwordcue').show();
				}else if(data==2){
					window.location.href = '?s=home/prcenter/baseinfo';
					if($('input#rememberusername').attr('checked')=='checked'){
						setcookie('username',$('#username').val(),86400)
						setcookie('password',$('#password').val(),86400)
					}
				}else if(data==3){
					window.location.href = '?s=home/investor';
				}else if(data==4){
					window.location.href = '?s=home/investor/choose';
				}
			}
		});
		return false;
	});
});