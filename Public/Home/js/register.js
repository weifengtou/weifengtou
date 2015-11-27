/*$(document).ready(function(){
	$('#register').on('click',function(){
		if (!$("#agreement").attr('checked')) {
			layer.alert("未同意协议!")
			return false;
		}
		var code = $("input[name=code]").val()
		$.post('?s=Home/User/checkVerify', {code:code}, function(data, textStatus, xhr) {
			if (data) {
				$('#registerform').ajaxSubmit({
					beforeSubmit:function(){
						var usernamelen = 10;
						var passwordlen = 20; 
						var r=/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/ ; 	//邮箱正则表达式
						if($('#email').val().length==''){
							$('#emailcue2').html("<font color='red'>邮箱不能为空！请重新输入！</font>");
							$('#emailcue').hide();
							return false;
						}else if(!r.test($('#email').val())){
							$('#emailcue2').html("<font color='red'>邮箱格式不正确！请重新输入！</font>");
							$('#emailcue').hide();
							return false;	
						}else if(r.test($('#email').val())){
							$('#emailcue').show();
							$('#emailcue2').hide();
						}
						if($.trim($('#username').val()).length==0){
							$('#usernamecue2').html("<font color='red'>用户名不能为空！请输入！</font>");
							$('#usernamecue').hide();
							return false;
						}else if($.trim($('#username').val()).length>usernamelen){
							$('#usernamecue2').html("<font color='red'>用户名不正确！请重新输入！</font>");
							$('#usernamecue').hide();
							return false;
						}else if($.trim($('#username').val()).length>0&&$.trim($('#username').val()).length<usernamelen){
							$('#usernamecue').show();
							$('#usernamecue2').hide();
						}
						if($('#password').val().length==''){
							$('#passwordcue2').html("<font color='red'>密码不能为空！请输入！</font>");
							$('#passwordcue').hide();
							return false;
						}else if($('#password').val().length<6||$('#password').val().length>passwordlen){
							$('#passwordcue2').html("<font color='red'>密码不符合要求！请重新输入！</font>");
							$('#passwordcue').hide();
							return false;
						}else if($('#password').val().length>0&&$('#password').val().length<passwordlen){
							$('#passwordcue2').hide();
							$('#passwordcue').show();
						}
						if($('#repassword').val().length==''){
							$('#repasscue2').html("<font color='red'>请输入确认密码！</font>");
							$('#repasscue').hide();
							return false;
						}else if($('#repassword').val()!=$('#password').val()){
							$('#repasscue2').html("<font color='red'>密码不一致！请重新输入！</font>");
							$('#repasscue').hide();
							return false;
						}else if($('#repassword').val().length>0&&$('#repassword').val()==$('#password').val()){
							$('#repasscue2').hide();
							$('#repasscue').show();
						} 
						// if($('#agreement').val() == ''){
							
						// }
					},
					success:function(data){
						// alert(data);
						if(data==-1){
							$('#emailcue2').html("<font color='red'>邮箱已存在！请重新输入！</font>");
							$('#emailcue').hide();
							$('#emailcue2').show();
						}else if(data==0){
							$('#usernamecue2').html("<font color='red'>用户名已存在！请重新输入！</font>");
							$('#usernamecue').hide();
							$('#usernamecue2').show();
						}else if(data==1){
							var url =$("input[name=email]").val().split('@')[1]; 
							layer.alert('已注册，请登录邮箱验证！成功后请刷新本页面', 9,function(){
								var hash={ 
									'qq.com': 'http://mail.qq.com', 
									'gmail.com': 'http://mail.google.com', 
									'sina.com': 'http://mail.sina.com.cn', 
									'163.com': 'http://mail.163.com', 
									'126.com': 'http://mail.126.com', 
									'yeah.net': 'http://www.yeah.net/', 
									'sohu.com': 'http://mail.sohu.com/', 
									'tom.com': 'http://mail.tom.com/', 
									'sogou.com': 'http://mail.sogou.com/', 
									'139.com': 'http://mail.10086.cn/', 
									'hotmail.com': 'http://www.hotmail.com', 
									'live.com': 'http://login.live.com/', 
									'live.cn': 'http://login.live.cn/', 
									'live.com.cn': 'http://login.live.com.cn', 
									'189.com': 'http://webmail16.189.cn/webmail/', 
									'yahoo.com.cn': 'http://mail.cn.yahoo.com/', 
									'yahoo.cn': 'http://mail.cn.yahoo.com/', 
									'eyou.com': 'http://www.eyou.com/', 
									'21cn.com': 'http://mail.21cn.com/', 
									'188.com': 'http://www.188.com/', 
									'foxmail.com': 'http://www.foxmail.com' 
								};
								layer.closeAll()
								window.open (hash[url], 'newwindow', 'height=768px, width=1024px, scrollbars=yes, resizable=yes')
							}); 
						}else if(data==2){
							layer.alert('邮箱验证失败！',9) //邮箱验证失败！
						}else{
							alert(data)
						}
						$('#registerform').clearForm();
					}
				});
			}else{
				layer.alert("验证码错误")
				$(".update_varifyimg").trigger('click')
			}
		});
		return false;
	});
});
*/