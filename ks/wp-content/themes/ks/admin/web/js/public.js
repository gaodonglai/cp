$(function(){

    /*后台Ajax post提交*/
    $('.adminAjaxPost').submit(function(){
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        $.post(url,formData,function(data){
            if(data.status=='y'){
                /*页面跳转*/
                // alert(data.info);return false;
                alert(data.info);
                if(data.url){
                    window.location.href = data.url;
                }
            }else{
                /*提示错误*/
                alert(data.info);
            }
        },'json');
        return false;
    })

})
