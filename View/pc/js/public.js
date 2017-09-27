 $(function($){
	'use strict';
	/*首页轮播*/
	var swiper = new Swiper('.home-swiper .swiper-container', {
		pagination: '.swiper-pagination',
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		paginationClickable: true,
		spaceBetween: 30,
		centeredSlides: true,
		autoplay: 3000,
		autoplayDisableOnInteraction: false,
	});
	/*tab*/
	$(".details_main_p a").on("click",function(){
		$(".details_main_p a").removeClass("details_active");
		$(this).addClass("details_active");
		$(".tab_download").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	/*登录框*/
	$(".box_formlo").click(function(){
		$(".pop_boxa").addClass("pop_login");
		$(".mask-re").addClass("mask-reb");
	});
	$(".p_b_close").click(function(){
		$(".pop_box").removeClass("pop_login");
		$(".mask-re").removeClass("mask-reb");
	});
	/*活动中心手风琴*/
	$(".floorRrightaa").on("click",function(){
		if($(this).parents(".showDetail").next(".floorDetail").hasClass("floorDetail_blok")){
			$(this).parents(".showDetail").next(".floorDetail").removeClass("floorDetail_blok");
			$(this).removeClass("floorRrightaa_xuan");
		}else{
			$(".floorDetail").removeClass("floorDetail_blok");
			$(this).parents(".showDetail").next(".floorDetail").addClass("floorDetail_blok");
			$(".floorRrightaa").removeClass("floorRrightaa_xuan");
			$(this).addClass("floorRrightaa_xuan");
		}
	})
	/*投注筛选*/
	var fActive;
	function filterscreen(screen){
		if(fActive != screen){
		$(".tbody_referencebc tr").filter('.' +screen).show('3000');
		$(".tbody_referencebc tr").filter(":not(."+screen+")").hide('3000');
		fActive = screen;
		}
	}
	$('.screen_winning').click(function(){ 
		filterscreen('screen_winning_a');
		$(".rig_main_zlabett  a").removeClass("betting_top-active");
		$(this).addClass("betting_top-active");
	});
	$('.screen_nowin').click(function(){ 
		filterscreen('screen_nowin_a');
		$(".rig_main_zlabett  a").removeClass("betting_top-active");
		$(this).addClass("betting_top-active");
	});
	$(".screen_all").click(function(){
		$(".tbody_referencebc tr").show();
		fActive = 'all';/*全部的*/
		$(".rig_main_zlabett a").removeClass("betting_top-active");
		$(this).addClass("betting_top-active");
	});
	/*个人中心选项卡*/
	$(".rig_main_capital a").on("click",function(){
		$(".rig_main_capital a").removeClass("betting_top-active");
		$(this).addClass("betting_top-active");
		$(".table_capital_main").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	$(".sonal_main_lef_nav  a").on("click",function(){
		$(".sonal_main_lef_nav  a").removeClass("left-nav-active");
		$(this).addClass("left-nav-active");
		$(".personal_main_macen").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	/*绑定银行卡*/
	/*$(".delete").on("click",function(){
		$(this).parents(".bank_manage").remove();
	});*/
	$(".take_bank_manage").on("click",function(){
		$(".bank_manage").removeClass("bank_manage_active");
		$(".take_bank_manage").text("设为默认帐户");
		$(this).text("默认账户");
		$(this).parents(".bank_manage").addClass("bank_manage_active");
		$(this).parents(".bank_manage").prependTo(".Bank_card_bind_mainbb");
	});
	/*投注侧边栏手风琴*/
	$(".childTitleaa").on("click",function(){
		$(this).toggleClass("iconnone")
		$(".childContentbb").toggleClass("chlidactive");
	});
	/*招聘手风琴*/
	$(".childTitle").on("click",function(){
		if($(this).hasClass("Record_active")){
			$(this).removeClass("Record_active");
			$(this).siblings(".childContent").slideUp(200);
		}else{   
			//元素筛选
			$(".childTitle").removeClass("Record_active");
			$(this).addClass("Record_active");
			$(".childContent").slideUp(200);
			$(this).siblings('.childContent').slideDown(200);
		}
	});
	/*城市三级联动*/
	/*$('#distpicker4').distpicker({
		placeholder: false
	});*/

	/*复制链接*/
	var clipboard = new Clipboard('.input-group-pr');
    clipboard.on('success', function(e) {
    	alert("链接已复制到剪贴板中");
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });
	/*返回顶部*/
	showScroll();
	function showScroll(){
		$(window).scroll( function() { 
		var scrollValue=$(window).scrollTop();
			scrollValue > 100 ? $('div[class=scroll]').fadeIn():$('div[class=scroll]').fadeOut();
		});	
		$('#scroll').click(function(){
			$("html,body").animate({scrollTop:0},200);	
		});	
	}

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
             }else if(data.status == 's'){
                 $.alerts(data.info);
                 history.go(0);
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




 });


