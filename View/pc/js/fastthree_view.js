/**
*快三详情
*author:i
date:2017/08/23 10:02
**/
jQuery(function($){

    /*倒计时*/
    var date1= '2017/09/23 23:12:00';  //开始时间
    var date2 = new Date();    //结束时间
    var date3 =  new Date(date1).getTime() - date2.getTime();   //时间差的毫秒数
    var $time = parseInt(date3/1000);
    var clock;
    clock = $('.clock').FlipClock({
        clockFace: 'HoilyCounter',
        autoStart: false,
        countdown: true,
        callbacks: {
            stop: function() {
                var date1= '2017/09/23 23:13:00';
                var date2 = new Date();    //结束时间
                var date3 =  new Date(date1).getTime() - date2.getTime();   //时间差的毫秒数
                var $time = parseInt(date3/1000);
                if($time>0)
                {
                    clock.setTime($time);
                    clock.start();
                }
            }
        }
    });
    if($time>0)
    {
        clock.setTime($time);
        clock.start();
    }


    /*当前操作id*/
    $id = $.Request('ks');
    /*获取近期投注 20以内*/
    function Recent_bets(){
        var $url = home+'fastthree/Recent_bets';
        var $data = {lottery:$id};
       $.ajax({
           url: $url,
           method:'post',
           data:$data,
           dataType:'json',
           success:function(json){

                if(json.status==1){
                    /*返回数据成功以后处理业务*/
                    //var $info = json.info;
                    $templ = template('Recent_bets',json);
                }else{
                    $templ = template('no_Recent_bets',json);
                }
               $('#Recent_bets_html').html($templ);
           },
           /*error:function(){
            $.alert('请求失败，请稍后重试');
           }*/
       });
    }
    Recent_bets();
    /*近期开奖 20*/
    function Recent_lottery(){
        var $url = home+'fastthree/Recent_lottery';
        var $data = {lottery:$id};
        $.ajax({
            url: $url,
            method:'post',
            data:$data,
            dataType:'json',
            success:function(json){

                if(json.status==1){
                    /*返回数据成功以后处理业务*/
                    //var $info = json.info;
                    $templ = template('Recent_lottery',json);
                }else{
                    $templ = template('no_Recent_lottery',json);
                }
                $('#Recent_lottery_html').html($templ);
            },
            /*error:function(){
             $.alert('请求失败，请稍后重试');
             }*/
        });
    }
    Recent_lottery();

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
});