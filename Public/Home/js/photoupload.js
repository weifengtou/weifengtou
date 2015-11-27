jQuery(document).ready(function($) {
	// 项目图片上传
	$('#myFile').on('change',function(){
		var filename = $('#myFile').val();
		var start = filename.lastIndexOf('.'); //获取最后“.”的位置
		var c = filename.substring(start + 1).toLowerCase(); //截取字符串(统一小写)
		if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
			layer.tips('请选择上传文件正确格式', '#myFile', {
				time: 3,
				guide: 0
			});
			return false;
		} else {
			$('#upImgForm').trigger('submit');
			return true;
		}
	});
	$('#upImgForm').ajaxForm(function(data){
		// alert(data);
		var t = JSON.parse(data);
		if(data == -1){
			layer.alert('提交失败，请登录', 8);
		}else if(data == 0){
			layer.tips('图片大小不应大于1024kb,请重传！', '#myFile', {
                time: 3,
                guide: 0
            });
		}else{
			var id = t.id
			var name = t.name
			var thumbname = t.thumbname
			var div = "<div id='" + id + "' class='pies'>" +
				// "<img src='./Uploads/PrImages/" + thumbname + "'  name='"+ name +"' style='width:241px;height:157px;margin:0 0 8px;' onclick='yuantu(this)' alt=''/>" +
				"<img src='./Uploads/PrImages/" + thumbname + "' style='width:241px;height:157px;margin:0 0 8px;' onclick='yuantu("+id+")' alt=''/>" +
				"<img src='./Uploads/PrImages/" + name + "' id='thumb"+id+"' style='margin:0 auto;padding:10px;display:none;' alt=''/>" +
				"<div class='xinse'>" +
				"<a href='#' style='margin-right:30px'>" +
				"<img src='./Public/Home/images/Entrepre/lezuo.gif' />" +
				"</a>" +
				"<a href='#' style='margin-right:30px'>" +
				"<img src='./Public/Home/images/Entrepre/leyou.gif' />" +
				"</a>" +
				"<a href='javascript:;' onclick='imgDel(" + id + ")'>" +
				"<img src='./Public/Home/images/Entrepre/shanchu.gif' />" +
				"</a>" +
				"</div>" +
				"</div>";
			$('#imgDiv').prepend(div)
		} 
	});
});

//图片删除
function imgDel(i) {
	$.post(
		'?s=home/Entrepre/imgDel', {
			imgId: i
		},
		function(data, textStatus, xhr) {
			$("#" + i).remove()
		}
	);
}
function yuantu(x){
	var id = '#thumb'+x;
	// alert(x.name);
	// $.layer({
	// 	type: 1, //0-4的选择,
	// 	title: false,
	// 	border: [0],
	// 	closeBtn: [0],
	// 	shadeClose: true,
	// 	area: ['1048', '534'],
	// 	page: {								
	// 		html:   '<div style="width:1048px; height:524px; color:#fff;">'+
	// 				 	'<div style="padding:10px;text-align:center;">'+
	// 						'<img src="./Uploads/PrImages/' + x.name + '" style="display: block;margin:0 auto;">'+
	// 					'</div>'+
	// 				'</div>' 
	// 	}
	$.layer({
        type : 1,
        title : false,
        offset:['150px' , ''],
        border : false,
        area : ['1068','544'],
        page : {dom : id}
	});
}



