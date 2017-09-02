$(function($){
	'use strict';
	/*tab*/
	$(".details_main_p a").on("click",function(){
		$(".details_main_p a").removeClass("details_active");
		$(this).addClass("details_active");
		$(".tab_download").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	$(".tab_form_a").on("click",function(){
		$(".tab_form_a").removeClass("login_box_on");
		$(this).addClass("login_box_on");
		$(".login_taba").hide();
		$(this.hash).delay().show();
	});
	$(".text_cite").on("click",function(){
		$(".register_tab").show();
		$(".login_box_registera").show();
		$(".pay_b_logoa").hide();
		$(".pay_b_logob").show();
		$(".login_tab_active").hide();
		$(".login_taba").hide();
	});
	$(".text_cite_b").on("click",function(){
		$(".register_tab").hide();
		$(".login_box_registera").hide();
		$(".pay_b_logoa").show();
		$(".pay_b_logob").hide();
		$(".login_tab_active").show();
		$(".login_box_onb").removeClass("login_box_on");
		$(".login_box_ona").addClass("login_box_on");
	});
	/*登录框*/
	$(".box_formlo").click(function(){
		$(".pop_box").addClass("pop_login");
		$(".mask-re").addClass("mask-reb");
		$(".login_box_onb").removeClass("login_box_on");
		$(".login_box_ona").addClass("login_box_on");
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
		$(".login_tabac").hide();
	});
	/*个人中心tab*/
	$(".sonal_main_lef_nav  a").on("click",function(){
		$(".sonal_main_lef_nav  a").removeClass("left-nav-active");
		$(this).addClass("left-nav-active");
		$(".personal_main_macen").fadeOut(300);
		$(this.hash).delay(300).fadeIn();
	});
	/*表单验证插件*/
	$(".Withdrawals_bind_form").Validform();
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
     /*城市三级联动*/
	  $('#distpicker4').distpicker({
   		 placeholder: false
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
});


