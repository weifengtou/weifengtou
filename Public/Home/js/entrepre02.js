$(document).ready(function() {
    // ===================身份证正面图片表单===============================================================
    //保存身份证正面图片
    $('#fornt').on('change', function() {
        var prid = $('.prid').val();
        var filename = $('#fornt').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串
        if (prid == '') {
            layer.tips('请首先填写项目资料', '#fornt', {
                time: 3,
                guide: 2
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#fornt', {
                time: 3,
                guide: 2
            });
            return false;
        } else {
            $('#imgform01').trigger('submit');
            return true;
        }
    });
    $('#imgform01').ajaxForm(function(data) {
        // alert(data);
        if (data == -1) {
            layer.alert('上传失败，请登录', 8);
        } else if (data == 0) {
            layer.tips('图片大小不应大于1024kb,请重传！', '#fornt', {
                time: 3,
                guide: 0
            });
        } else {
            var t = JSON.parse(data);
            var fornt = './Uploads/Company/' + t;
            $('#img02').attr('src', fornt);
            //$('.companyid').val(t.id);
            $('#img01').hide();
            $('#cd01').hide();
            $('#cd02').show();
            $('#img02').show();
        }
    });
    //重新上传身份证正面图片
    $('#reupload01').on('click', function() {
        $('#cd03').show();
        $('#cd02').hide();
    });
    //更新身份证正面图片
    $('#fornt02').on('change', function() {
        var prid = $('.prid').val();
        var filename = $('#fornt02').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串
        if (prid == '') {
            layer.tips('请首先法人身份证正面图片', '#fornt02', {
                time: 3,
                guide: 2
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#fornt02', {
                time: 3,
                guide: 2
            });
            return false;
        } else {
            $('#imgform02').trigger('submit');
            return true;
        }
    });
    $('#imgform02').ajaxForm(function(data){
//        alert(data);
        if (data == -1) {
            layer.alert('重新上传失败，请登录', 8);
        } else if (data == 0) {
            layer.tips('图片大小不应大于1024kb,请重传！', '#fornt02', {
                time: 3,
                guide: 2
            });
        } else {
            var t = JSON.parse(data);
            $('#img02').attr('src', './Uploads/Company/' + t);
            $('#img02').show();
            $('#img03').hide();
            $('#cd02').show();
            $('#cd03').hide();
        }
    });
    // ===================================================================================================

    // =================身份证反面图片表单================================================================
    //保存身份证反面图片
    $('#rear11').on('change', function() {
        var prid = $('.prid').val();
        var filename = $('#rear11').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串 
        if (prid == '') {
            layer.tips('请首先填写项目资料', '#rear11', {
                time: 3,
                guide: 2
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#rear11', {
                time: 3,
                guide: 2
            });
            return false;
        } else {
            $('#imgform11').trigger('submit');
            return true;
        }
    });
    $('#imgform11').ajaxForm(function(data){
        if (data == -1) {
            layer.alert('上传失败，请登录', 8);
        } else if (data == 0) {
            layer.tips('图片大小不应大于1024kb,请重传！', '#rear11', {
                time: 3,
                guide: 2
            });
        } else {
            var t = JSON.parse(data);
            var rear = './Uploads/Company/' + t;
            $('#img12').attr('src', rear);
            $('#cd11').hide();
            $('#cd12').show();
            $('#img12').show();
            $('#img11').hide();
        }
    });
    //重新上传身份证反面图片
    $('#reupload11').on('click', function() {
        var companyid = $('.companyid').val();
        $('#cd13').show();
        $('#imgform11').hide();
        $('#cd12').hide();
    });
    //更新身份证反面图片
    $('#rear12').on('change', function() {
        var prid = $('.prid').val();
        var companyid = $('.companyid').val();
        var filename = $('#rear12').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串
        if (prid == '') {
            layer.tips('请首先填写项目资料', '#rear12', {
                time: 3,
                guide: 2
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#rear12', {
                time: 3,
                guide: 2
            });
            return false;
        } else {
            $('#imgform12').trigger('submit');
            return true;
        }
    });    
    $('#imgform12').ajaxForm(function(data){
        if (data == -1) {
            layer.alert('重新上传失败，请登录', 8);
        }else if(data == 0){
            layer.tips('图片大小不应大于1024kb,请重传！', '#rear12', {
                time: 3,
                guide: 2
            });
        } else {
            var t = JSON.parse(data);
            $('#img12').attr('src', './Uploads/Company/' + t);
            $('#cd13').hide();
            $('#cd12').show();
            $('#img12').show();
        }
    });
    // ==================================================================================================

    // ===============法人证信报告=======================================================================
    //保存法人证信报告图片
    $('#legalperson21').on('change',function(){
        var prid = $('.prid').val();
        var companyid = $('.companyid').val();
        var filename = $('#legalperson21').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串
        if (prid == '') {
            layer.tips('请首先填写项目资料', '#legalperson21', {
                time: 3,
                guide: 0
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#legalperson21', {
                time: 3,
                guide: 0
            });
            return false;
        } else {
            $('#imgform21').trigger('submit');
            return true;
        }
    });
    $('#imgform21').ajaxForm(function(data){
        if (data == -1) {
            layer.alert('上传失败，请登录', 8);
        }else if(data == 0){
            layer.tips('图片大小不应大于1024kb,请重传！', '#legalperson21', {
                time: 3,
                guide: 0
            });
        } else {
            var t = JSON.parse(data);
            var legalperson = './Uploads/Company/' + t;
            $('#img22').attr('src', legalperson);
            $('#cd21').hide();
            $('#cd22').show();
            $('#img22').show();
            $('#img21').hide();
        }
    });
    //重新上传法人证信报告图片
    $('#reupload21').on('click', function() {
        var companyid = $('.companyid').val();
        $('#cd23').show();
        $('#cd22').hide();
    });
    //更新法人证信报告图片
    $('#legalperson22').on('change', function() {
        var prid = $('.prid').val();
        var companyid = $('.companyid').val();
        var filename = $('#legalperson22').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串
        if (prid == '') {
            layer.tips('请首先填写项目资料', '#legalperson22', {
                time: 3,
                guide: 0
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#legalperson22', {
                time: 3,
                guide: 0
            });
            return false;
        } else {
            $('#imgform22').trigger('submit');
            return true;
        }
    });
    $('#imgform22').ajaxForm(function(data){
        if (data == -1) {
            layer.alert('重新上传失败，请登录', 8);
        }else if(data == 0){
            layer.tips('图片大小不应大于1024kb,请重传！', '#legalperson22', {
                time: 3,
                guide: 0
            });
        } else {
            var t = JSON.parse(data);
            var legalperson = './Uploads/Company/' + t;
            $('#img22').attr('src', legalperson);
            $('#cd23').hide();
            $('#cd22').show();
        }
    });
    // =================================================================================================
    
    // ================营业执照图片表单=================================================================
    //保存营业执照图片
    $('#businesslicence31').on('change', function() {
        var prid = $('.prid').val();
        var companyid = $('.companyid').val();
        var filename = $('#businesslicence31').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串
        if (prid == '') {
            layer.tips('请首先填写项目资料', '#businesslicence31', {
                time: 3,
                guide: 0
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#businesslicence31', {
                time: 3,
                guide: 0
            });
            return false;
        } else {
            $('#imgform31').trigger('submit');
            return true;
        }
    });    
    $('#imgform31').ajaxForm(function(data){
        if (data == -1) {
            layer.alert('上传失败，请登录', 8);
        }else if (data == 0) {
            layer.tips('图片大小不应大于1024kb,请重传！', '#businesslicence31', {
                time: 3,
                guide: 0
            });
        } else {
            var t = JSON.parse(data);
            var businesslicence = './Uploads/Company/' + t;
            $('#img32').attr('src', businesslicence);
            $('#cd31').hide();
            $('#cd32').show();
            $('#img32').show();
            $('#img31').hide();
        }
    });
    //重新上传营业执照图片
    $('#reupload31').on('click', function() {
        var companyid = $('.companyid').val();
        $('#cd32').hide();
        $('#cd33').show();
    });
    //更新营业执照图片
    $('#businesslicence32').on('change', function() {
        var prid = $('.prid').val();
        var companyid = $('.companyid').val();
        var filename = $('#businesslicence32').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串
        if (prid == '') {
            layer.tips('请首先填写项目资料', '#businesslicence32', {
                time: 3,
                guide: 0
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#businesslicence32', {
                time: 3,
                guide: 0
            });
            return false;
        } else {
            $('#imgform32').trigger('submit');
            return true;
        }
    });
    $('#imgform32').ajaxForm(function(data){
        if (data == -1) {
            layer.alert('重新上传失败，请登录', 8);
        }else if (data == 0) {
            layer.tips('图片大小不应大于1024kb,请重传！', '#businesslicence32', {
                time: 3,
                guide: 0
            });
        } else {
            var t = JSON.parse(data);
            var businesslicence = './Uploads/Company/' + t;
            $('#img32').attr('src', businesslicence);
            $('#cd33').hide();
            $('#cd32').show();
        }
    });
    // ================================================================================================

    // ==================税务登记证图片表单============================================================
    //保存税务登记证图片
    $('#taxcertificate41').on('change', function() {
        var prid = $('.prid').val();
        var companyid = $('.companyid').val();
        var filename = $('#taxcertificate41').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串
        if (prid == '') {
            layer.tips('请首先填写项目资料', '#taxcertificate41', {
                time: 3,
                guide: 1
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#taxcertificate41', {
                time: 3,
                guide: 0
            });
            return false;
        } else {
            $('#imgform41').trigger('submit');
            return true;
        }
    });    
    $('#imgform41').ajaxForm(function(data){
        if (data == -1) {
            layer.alert('上传失败，请登录', 8);
        }else if(data == 0){
            layer.tips('图片大小不应大于1024kb,请重传！', '#taxcertificate41', {
                time: 3,
                guide: 0
            });
        } else {
            var t = JSON.parse(data);
            var taxcertificate = './Uploads/Company/' + t;
            $('#img42').attr('src', taxcertificate);
            $('#img42').show();
            $('#img41').hide();
            $('#cd41').hide();
            $('#cd42').show();
        }
    });
    //重新上传税务登记证图片
    $('#reupload41').on('click', function() {
        var companyid = $('.companyid').val();
        $('#cd43').show();
        $('#cd42').hide();
    });
    //更新税务登记证图片
    $('#taxcertificate42').on('change', function() {
        var prid = $('.prid').val();
        var companyid = $('.companyid').val();
        var filename = $('#taxcertificate42').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串 
        if (prid == '') {
            layer.tips('请首先填写项目资料', '#taxcertificate42', {
                time: 3,
                guide: 1
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#taxcertificate42', {
                time: 3,
                guide: 0
            });
            return false;
        } else {
            $('#imgform42').trigger('submit');
            return true;
        }
    });
    $('#imgform42').ajaxForm(function(data){
        if (data == -1) {
            layer.alert('重新上传失败，请登录', 8);
        } else if (data == 0) {
            layer.tips('图片大小不应大于1024kb,请重传！', '#taxcertificate42', {
                time: 3,
                guide: 0
            });
        } else {
            var t = JSON.parse(data);
            var taxcertificate = './Uploads/Company/' + t;
            $('#img42').attr('src', taxcertificate);
            $('#cd43').hide();
            $('#cd42').show();
        }
    });
    // ================================================================================================

    // ================公司图片表单====================================================================
    //保存公司图片
    $('#companyimg51').on('change', function() {
        var prid = $('.prid').val();
        var companyid = $('.companyid').val();
        var filename = $('#companyimg51').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串
        if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#companyimg51', {
                time: 3,
                guide: 0
            });
            return false;
        } else {
            $('#imgform51').trigger('submit');
            return true;
        }
    });
    $('#imgform51').ajaxForm(function(data){
        if (data == -1) {
            layer.alert('上传失败，请登录', 8);
        } else if (data == 0) {
            layer.tips('图片大小不应大于1024kb,请重传！', '#taxcertificate42', {
                time: 3,
                guide: 0
            });
        } else {
            var t = JSON.parse(data);
            var companyimg = './Uploads/Company/' + t;
            $('#img52').attr('src', companyimg);
            $('#img52').show();
            $('#img51').hide();
            $('#cd51').hide();
            $('#cd52').show();
        }
    });
    //重新上传公司图片
    $('#reupload51').on('click', function() {
        var companyid = $('.companyid').val();
        $('#cd53').show();
        $('#cd52').hide();
    });
    //更新公司图片
    $('#companyimg52').on('change', function() {
        var prid = $('.prid').val();
        var companyid = $('.companyid').val();
        var filename = $('#companyimg52').val();
        var start = filename.lastIndexOf('.'); //获取最后“.”的位置
        var c = filename.substring(start + 1).toLowerCase(); //截取字符串
        if (companyid == '') {
            layer.tips('请先上传身份证正面图片', '#companyimg52', {
                time: 3,
                guide: 1
            });
            return false;
        } else if (prid == '') {
            layer.tips('请首先填写项目资料', '#companyimg52', {
                time: 3,
                guide: 1
            });
            return false;
        } else if (c != 'gif' && c != 'jpeg' && c != 'png' && c != 'jpg') {
            layer.tips('请选择上传图片正确格式', '#companyimg52', {
                time: 3,
                guide: 0
            });
            return false;
        } else {
            $('#imgform52').trigger('submit');
            return true;
        }
    });
    $('#imgform52').ajaxForm(function(data){
        if (data == -1) {
            layer.alert('重新上传失败，请登录', 8);
        } else if (data == 0) {
            layer.tips('图片大小不应大于1024kb,请重传！', '#taxcertificate42', {
                time: 3,
                guide: 0
            });
        } else {
            var t = JSON.parse(data);
            var companyimg = './Uploads/Company/' + t;
            $('#img52').attr('src', companyimg);
            $('#cd53').hide();
            $('#cd52').show();
        }
    });
    // ================================================================================================
});

// ======================取消修改操作===================================================================
//取消身份证正面图片修改
function backimg01() {
    $('#cd02').show();
    $('#cd03').hide();
}
//取消身份反面图片修改
function backimg11() {
    $('#cd13').hide();
    $('#cd12').show();
}
//取消法人证信报告图片修改
function backimg21() {
    $('#cd22').show();
    $('#cd23').hide();
}
//取消营业执照图片修改
function backimg31() {
    $('#cd32').show();
    $('#cd33').hide();
}
//取消税务登记证图片修改
function backimg41() {
    $('#cd42').show();
    $('#cd43').hide();
}
//取消公司图片修改
function backimg51() {
    $('#cd52').show();
    $('#cd53').hide();
}
// ======================================================================================================



