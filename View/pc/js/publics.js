/*全局提交表单*/
 $(document).on('submit','.postAjax',function(){

	 var _this = $(this);
	 var sub_this = $(":submit",this);
	 if($('.subHint').length>0){
		 $('.subHint').hide();
	 }

	 sub_this.attr("disabled","disabled");
	 var formData = _this.serialize();
	 $.post(_this.attr('action'),formData,function(data){
		 if(data.status=='200'){

		 }else if(data.status=='y'){
			 $.alerts(data.info);
			 if(data.url){
				 window.location.href = data.url;
			 }
		 }else if(data.status == 'n'){
			 $.alerts(data.info);
		 }else if(data.status == 'r'){
             if(data.url){
                 window.location.href = data.url;
             }
         }

	 },'json');
	 sub_this.removeAttr('disabled');

	 return false;
 });

 //获取链接标签（#）
 $.getUrlParam = function(name) {
	 var reg = new RegExp("(^|&)" + name + "_([^&]*)(&|$)");
	 var r = window.location.hash.substr(1).match(reg);
	 if(r != null) return unescape(r[2]);
	 return null;
 }


