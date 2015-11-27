$(document).ready(function(){
	// 编辑项目
	$('#preditbun').on('click', function() {
		var prid = $('#prid').val();
		$.ajax({
			type: "get",
			url: "__URL__/predit01&prid=" + prid,
			success: function(data) {
				alert('---');
			}
		});
	});
})
