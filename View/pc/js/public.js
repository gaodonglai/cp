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
		$(".pop_box").addClass("pop_login");
		$(".mask-re").addClass("mask-reb");
		$(".pay_b_logoa").show();
		$(".pay_b_logob").hide();
	});
	$(".registr_ina").click(function(){
		$(".register_tab").show();
		$(".login_box_registera").show();
		$(".login_taba").hide();
		$(".pay_b_logoa").hide();
		$(".pay_b_logob").show();
	});
	$(".p_b_close").click(function(){
		$(".pop_box").removeClass("pop_login");
		$(".mask-re").removeClass("mask-reb");
		$(".login_tab_active").show();
		$(".register_tab").hide();
		$(".login_box_registera").hide();
	});
	$(".text_cite_a").on("click",function(){
		$(".register_tab").show();
		$(".login_box_registera").show();
		$(".pay_b_logoa").hide();
		$(".pay_b_logob").show();
		$(".login_tab_active").hide();
	});
	$(".text_cite_b").on("click",function(){
		$(".register_tab").hide();
		$(".login_box_registera").hide();
		$(".pay_b_logoa").show();
		$(".pay_b_logob").hide();
		$(".login_tab_active").show();
	});

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
	/*资金明细*/
	$(".rig_main_capital a").on("click",function(){
		$(".rig_main_capital a").removeClass("betting_top-active");
		$(this).addClass("betting_top-active");
		$(".table_capital_main").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	/*立即充值*/
	$(".Recharge_header a").on("click",function(){
		$(".Recharge_header a").removeClass("betting_top-active");
		$(this).addClass("betting_top-active");
		$(".tab_Recharge").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	/*提现申请*/
	$(".Withdrawals_bind a").on("click",function(){
		$(".Withdrawals_bind a").removeClass("betting_top-active");
		$(this).addClass("betting_top-active");
		$(".Withdrawals_bind_main").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	/*密码修改*/
	$(".password_modify_hed a").on("click",function(){
		$(".password_modify_hed a").removeClass("betting_top-active");
		$(this).addClass("betting_top-active");
		$(".password_modify").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	/*绑定银行卡*/
	$(".Bank_card_bind a").on("click",function(){
		$(".Bank_card_bind a").removeClass("betting_top-active");
		$(this).addClass("betting_top-active");
		$(".Bank_card_bind_main").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	$(".delete").on("click",function(){
		$(this).parents(".bank_manage").remove();
	});
	$(".take_bank_manage").on("click",function(){
		$(".bank_manage").removeClass("bank_manage_active");
		$(".take_bank_manage").text("设为默认帐户");
		$(this).text("默认用户");
		$(this).parents(".bank_manage").addClass("bank_manage_active");
		$(this).parents(".bank_manage").prependTo(".Bank_card_bind_mainbb");
	});
	/*投注选项卡*/
	$(".brigtinh_main_top a").on("click",function(){
		$(".brigtinh_main_top a").removeClass("betting_top-active");
		$(this).addClass("betting_top-active");
		$(".brigtinh_main_cen").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	/*投注选中*/
	$(".key_shadow_num").click(function(){
		$(this).toggleClass("Selected_null_active");
	})
	$(".key_shadow_num2").click(function(){
		$(this).toggleClass("Selected_null_active");
	})  
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
	$('#distpicker4').distpicker({
		placeholder: false
	});
	/*倒计时*/
	var clock;
		clock = $('.clock').FlipClock({
		clockFace: 'HoilyCounter',
		autoStart: false,
		callbacks: {
			stop: function() {
			$('.message').html('The clock has stopped!')
			}
		}
	});
	clock.setTime(5000);
	clock.setCountdown(true);
	clock.start();
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
             }
         },'json');
         sub_this.removeAttr('disabled');

         return false;
     });


});


