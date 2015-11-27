jQuery(document).ready(function($) {
	$("#imgDiv").children('div:first').children('button.upMove').hide()
	$("#imgDiv").children('div:last').children('button.downMove').hide()
	$('#myForm').ajaxForm(function(e) {  
		var imgData = jQuery.parseJSON(e)
	    var iid = imgData.imgId
	    var iurl = imgData.imgUrl
	    if ($("#imgDiv").children().size()==0) {$("#imgDiv").append("<div id="+iid+"><img src="+iurl+" alt='' /><button onclick='imgDel("+iid+")'>delete</button><button class='upMove' hidden>上移</button><button class='downMove' hidden>下移</button></div>")}else{$("#imgDiv").append("<div id="+iid+"><img src="+iurl+" alt='' /><button onclick='imgDel("+iid+")'>delete</button><button class='upMove'>上移</button><button class='downMove' hidden>下移</button></div>")}
	    
	});
});
function subImg () {
	$("#myForm").trigger("submit");
	$("#imgDiv").children('div:last').children('button.downMove').show()
}
function imgDel (i) {
	$.ajax({
		type: 'post',
		url: '?s=test/index/testDel',
		data: {imgId: i},
		success: function(e){
			alert(e)
			var upMove = $("#"+i).children('button.upMove').is(":visible")
			var downMove = $("#"+i).children('button.downMove').is(":visible")
			// alert(upMove)
			if (!upMove) {
				$("#"+i).next().children('button.upMove').hide()
			}
			if (!downMove) {
				$("#"+i).prev().children('button.downMove').hide()
			}
			$("#"+i).remove()
		}
	})
}
jQuery(document).ready(function($) {
	alert(1)
});