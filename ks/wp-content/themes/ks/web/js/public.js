/**
 * 公共配置
 * User: ijita
 * Date: 2016/3/3
 * Time: 10:09
 * v1.0
 */
jQuery(function($){
    /**
     *菜单固定
     */
    if($('.header-posfixed').length>0) {
        $('.header-posfixed').posfixed({
            distance: 0,
            pos: 'top',
            type: 'while',
            hide: false
        });
    }
    /*end*/
    /*回到顶部*/
    if($('#back-top').length>0) {
        $('#back-top').posfixed({
            distance : 60,
            direction : 'bottom',
            type : 'always',
            hide : true
        });
        $('#back-top').click(function(){
            $("html,body").animate({"scrollTop": "0px"},500);
            return false;
        });
    }
    /*mobile菜单*/
    $('.st-pusher').click(function(){
        if($(event.target).hasClass('menu-icon')){
            if($('html').hasClass('st-menu-open')){
                $('html').removeClass('st-menu-open');
            }else{
                $('html').addClass('st-menu-open');
            }
        }else{
            if($('html').hasClass('st-menu-open')){
                $('html').removeClass('st-menu-open');
            }
        }
    });
    $('.st-menu .menu-item-has-children>a,.st-menu .menu-item-has-children>.open-child').click(function(){
        var _parent = $(this).parent();
        if(_parent.hasClass('over')){
            _parent.removeClass('over');
            _parent.children('ul').fadeOut();
            _parent.children('ul').removeClass('mobile_right_blocks');
        }else{
            _parent.addClass('over');
            _parent.children('ul').fadeIn();
            _parent.children('ul').addClass('mobile_right_blocks');
        }
        return false;
    });
    $('li.mobile_return_block').click(function(){
        $(this).parents('.sub_menu').removeClass('mobile_right_blocks');
        $(this).parents('.over').removeClass('over');
    });

    /*单排产品切换*/
    if($("#productCarousel").length>0)
    {
        var Related = new Swiper('#productCarousel', {
            spaceBetween: 10,
            slidesPerView: 'auto',
            touchRatio: 0.2,
            prevButton: '#carousel-prev',
            nextButton: '#carousel-next',
            onSlideChangeStart: function (swiper) {
                if (swiper.isBeginning) {
                    swiper.prevButton[0].style.display = 'none';
                } else {
                    swiper.prevButton[0].style.display = 'block';
                }
            },
            onSlideChangeEnd: function (swiper) {
                if (swiper.isEnd) {
                    swiper.nextButton[0].style.display = 'none';
                } else {
                    swiper.nextButton[0].style.display = 'block';
                }
            }
        });
    }
    var pathName = window.document.location.pathname;
    /*二级目录时使用*/
    var projectName = pathName.substring(0, pathName.substr(1).indexOf('/') + 1);
    var host = window.location.host+projectName;
    /**
     * 关注商品
     */
    $('.attention-items').click(function(){
        var _this = $(this);
        var items = _this.attr('data-id');
        $.ajax({
            type: "post",
            url: home_url+"/consumer/collection/setCollectionItems",
            data: {'items':items},
            dataType: "json",
            success: function(data){
                if(data.status == 'y'){
                    $.alerts(data.info);
                    _this.html('<i class="iconfont ac-active">&#xe61b;</i>已收藏');

                }else if(data.status == 'd'){
                    $.alerts(data.info);
                    _this.html('<i class="iconfont">&#xe61b;</i>收藏');

                }else{
                    $.alerts(data.info);
                }

            },error : function(textStatus, errorThrown) {
                $.alerts('请先登录');
            },
        });
    });

    /*判断唯一性*/
    $('.isOnly').blur(function(){
        var name = /[a-zA-z][a-zA-Z0-9_-]{5}/;
        var phone = /^0?1[3|4|5|7|8][0-9]\d{8}/;
        var email  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})/;
        var val = $(this).val();
        // console.debug(name.test(val)+'---'+phone.test(val)+'---'+email.test(val));
        if (!name.test(val) && !phone.test(val) && !email.test(val)) {
            $.alerts("输入格式不正确");
            return false;
        }
        var type = $(this).attr('only-type');
        if(type =='register'){
            var url = home_url+'/member/register/judgeOnly';
        }else if(type == 'backPass'){
            var url = home_url+'/member/register/judgeIsNull';
        }else{
            var url = home_url+'/member/register/judgeOnly';
        }

        var _this = $(this);

        $.post(url,{'name':$(this).attr('name'),'param':val,'rand':Math.random()},function(data){
            _this.attr('status',data.status);
            if(data.status == 'y'){
                //alert(data.info);
            }else{
                $.alerts(data.info);
            }
        },'json');
    })

    /*获取手机验证码*/
    $('#getCode').one('click',getCodesFn);

    function getCodesFn(){
        var partten = /(^13\d{9}$)|(^14)[5,7]\d{8}$|(^15[0,1,2,3,5,6,7,8,9]\d{8}$)|(^17)[6,7,8]\d{8}$|(^18\d{9}$)/g;
        var inputString=$('#userPhone').val();
        var userPhone = $("input[name=userPhone]");
        var _this = $(this);
        /*
         if(!GetQueryString('param') && userPhone.parent().find(".Validform_checktip").length>0){
         if(userPhone[0].validform_valid !='true'){
         userPhone.blur().focus();
         $('#getCode').one('click',getCodes);
         return false;
         }
         }
         */
        if(partten.test(inputString))
        {
            $.InterValObjFn(_this,'',getCode());

        }else{

            $.alerts('不是有效的手机号码');
        }

        $('#getCode').one('click',getCodesFn);

    }
    function getCode(){
        var url = home_url+'/member/register/getPhoneCode';
        $.post(url,{
            'geetest_challenge': $('input[name=geetest_challenge]').val(),
            'geetest_validate': $('input[name=geetest_validate]').val(),
            'geetest_seccode': $('input[name=geetest_seccode]').val(),
            'phone':$('#userPhone').val(),
            'type':$('#userPhone').attr('only-type'),
            'rand':Math.random()}
            ,function(data){
            if(data.status == 'y'){
                //$.InterValObjFn($(this),'',getCode());
                $('#getCode').one('click',getCodesFn);
                $.alerts('发送成功');
            }else{
                $.alerts(data.info);
            }
        },'json');
    }

    /*获取邮件验证码*/
    $('#getEmailCode').one('click',getEmailCode);

    function getEmailCode(){

        var user_email = $("input[name=userEmail]");
        var user_email_val = user_email.val();
        var e = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        var _this = $(this);

        if(e.test(user_email_val)){

            $.InterValObjFn(_this,'',emailCode());

        }else{
            $.alerts('不是有效的邮箱号码');
        }

        $('#getEmailCode').one('click',getEmailCode);

    }

    function emailCode(){
        var url = home_url+'/consumer/account/getEmailCode';

        $.post(url,{'email':$('#userEmail').val(),'type':$('#userEmail').attr('only-type'),'rand':Math.random()},function(data){
            if(data.status == 'y'){
                $.alerts('发送成功');
            }else{
                $.alerts(data.info);
            }
        },'json');

        return false;

    }



    /*四级联动*/
    $(document).on('change','.province',function(){
        ajaxLoadArea($(this));
    });

    /*ajax GET提交*/
    $('body').on('click','.getAjax',function(){
        var _this= $(this);
        var url = _this.attr('href');
        if(_this.hasClass('Aactive')){
            return false;
        }
        if(_this.hasClass('deladdress')){
            _this.parents('li').css('background','#ffefef');
        }
        if(_this.hasClass('deladdressp')){
            _this.parents('.address_row').css('background','#ffefef');
        }
        $.get(url,function(data){
            if(data.status != '200'){
                $.alerts(data.info);
            }
            if(data.status == 'y'){
                if(_this.hasClass('deladdress')){
                    _next = _this.parents('li');
                    $num = _next.siblings('li').length;
                    if(_next.hasClass('active')){
                        _next.next().addClass('active');
                    }
                    if($('.dam_list_address_lists').length>0) {
                        $num =$('.dam_list_address_lists>li').length-2;
                        $n = 10 - $num;
                        if ($n < 0) {
                            $n = 0;
                        }
                        $('.numberAddress b').text($num)
                            .siblings('em').text($n);
                        if($num<10 && $('.AddaClick').length<1){
                            $('.numberAddress').append('<a class="balance_new_address_tan fr AddaClick" href="JavaScript: void (0)">新增收货地址</a>');

                        }
                    }else{
                        if($num<10 && $('.AddaClick').length<1){
                            $('.balance_content_address').siblings('.balance_content_info')
                                .append('<a class="balance_new_address_tan fr AddaClick" href="JavaScript: void (0)">新增收货地址</a>');

                        }
                        if($num<2){
                            $('.balance_content_address_more').remove();
                        }
                    }
                    if($num<1){
                        _next.parents('ul').html($('#NoaddressLI').tmpl());
                    }

                    _next.remove();
                    return false;
                }else if(_this.hasClass('deladdressp')){
                    _next = _this.parents('.address_row');
                    $num = _next.siblings('.address_row').length;
                    if($num<9 && $('.address_add_new_address').length<1){
                        $('.address-content').append('<a href="'+window.home_url+'/order/create?proth=addressAdd" class="address_add_new_address">+新增收货地址</a>');
                    }
                    if($num<1){
                        $('.address-content').append('<h3 class="noReceipt_address"><i class="fa fa-frown-o"></i>暂无收货地址,请添加！</h3>');
                    }
                    _next.remove();
                    return false;
                }
                history.go(0);
            }else if(data.status == 'mr' ){
                if(_this.hasClass('pcDefault')){
                    $('.defaultSpan').remove();
                    $('.Aactive').removeClass('Aactive');
                    _this.addClass('Aactive')
                        .parent().before('<span class="defaultSpan">默认地址</span>');
                }else{
                    $('.Aactive').html('<i class="fa fa-square-o"></i> 设为默认地址').removeClass('Aactive');
                    _this.html('<i class="fa fa-check-square-o"></i> 默认地址').addClass('Aactive');
                }
            }else if(data.status == '200'){
                /*订单页地址编辑*/
                data.info['title']='编辑收货地址';
                $('body').append($('#balance_new_address_tanTmpl').tmpl(data.info));
                $('.receProvince option[value="'+data.info.c_ad_province+'"]').attr("selected",true);
                ajaxLoadArea($('.receProvince'),data.info.c_ad_city,data.info.c_ad_county);
                postValidform = $(".postAjax").Validform();
            }
            return false;
        },'json')
        return false;
    });

    /*ajax POST提交*/

    /*表单验证*/
    if($(".postAjax").length>0){
        var getInfoObj=function(){
            return 	$(this).parents("li").find(".info");
        }
        $("[datatype]").focusin(function(){
            if(this.timeout){clearTimeout(this.timeout);}
            var infoObj=getInfoObj.call(this);
            if(infoObj.siblings(".Validform_right").length!=0){
                return;
            }
            infoObj.show().siblings().hide();

        }).focusout(function(){
            var infoObj=getInfoObj.call(this);
            // console.debug(infoObj.text());
            this.timeout=setTimeout(function(){
                infoObj.hide().siblings(".Validform_wrong,.Validform_loading").show();
            },0);

        });

        var postValidform = $(".postAjax").Validform({
            tiptype:2,
            usePlugin:{
                passwordstrength:{
                    minLen:6,
                    maxLen:18,
                    trigger:function(obj,error){
                        //console.debug(obj);
                        if(error){
                            obj.parent().find(".passwordStrength").hide().siblings(".info").show();
                        }else{
                            obj.removeClass("Validform_error").parent().find(".passwordStrength").show().siblings().hide();
                        }
                    }
                }

            }
        });
    }

    $(document).on('submit','.postAjax',function(){
        var _this = $(this);
        var sub_this = $(":submit",this);
        if($('.subHint').length>0){
            $('.subHint').hide();
        }
        if(postValidform.check() == false){
            $('.Validform_error:eq(0)').focus();
            return false;
        }
        sub_this.attr("disabled","disabled");
        var formData = _this.serialize();
        $.post(_this.attr('action'),formData,function(data){
            if(data.status=='200'){
                $('.in-form').remove();
                $('.in-c-g').css('display','block');
            }else if(data.status=='y'){
                $.alerts(data.info);
                if(data.jump=='n'){
                    /**
                     * 结算页面更新地址
                     */
                    val = data.val;
                    val['p'] = $('.delete_box option[value='+val.receProvince+']').text();
                    val['c'] = $('.delete_box option[value='+val.receCity+']').text();
                    val['a'] = $('.delete_box option[value='+val.receArea+']').text();console.log(val);
                    if($('.noaddress').length>0){
                        $('.noaddress').remove();
                    }
                    if(val.c_ad_default==1){
                        if($('.pcDefault').length<1){
                            $('.Aactive').html('<i class="fa fa-square-o"></i> 设为默认地址');
                        }else{
                            $('.defaultSpan').remove();
                        }
                        $('.Aactive').removeClass('Aactive');
                    }
                    if($('.dam_list_address_lists').length>0){
                        $('.dam_list_address_lists li[data-id='+val.ids+']').remove();
                        $('.dam_list_address_lists .dam_list_address_top').after($('#addressLI2').tmpl(val));
                        $num = $('.dam_list_address_lists>li').length-1;
                        $n = 10-$num;
                        if($n<0){
                            $n = 0;
                        }
                        $('.numberAddress b').text($num)
                            .siblings('em').text($n);
                    }else{
                        $('.balance_content_address input[value='+val.ids+']').parents('li').remove();
                        $('.balance_content_address li.active').removeClass('active').find('input').removeAttr('checked');
                        $('.balance_content_address ul').prepend($('#addressLI').tmpl(val));
                        $num = $('.balance_content_address ul li').length;
                        if($num>=2 && $('.balance_content_address_more').length<1){
                            $('.balance_content_address ul').after('<div class="balance_content_address_more fl">更多地址</div>');
                        }
                    }
                    $('.delete_box,.bantouming').remove();
                    if($num>=10){
                        $('.AddaClick').remove();
                    }

                }else if(data.url){
                    window.location.href = data.url;
                }
            }else if(data.status == 'f'){

                if(data.type == 'pc'){
                    $('.top_small').find('.fl').html(data.info);
                }else{

                }
                if(_this.attr('gete')=="cart_param"){
                    data =$('.single_add_to_cart_button').parents('form').serialize()+'&type=immediately';
                    ajaxcreate(data);
                }
                $('#lgoin_modal').modal('hide');
                $('.single_add_to_cart_button').removeAttr('type').removeAttr('data-target').removeAttr('data-toggle');
                $.alerts('登录成功');
            }else if(data.status=='items'){
                /**
                 * 商品不在销售区域
                 */

                nosockItems(data.info);
            }else{

                /*提示错误*/
                if($('.subHint').length>0){
                    $('.subHint').text(data.info).show();
                }else{
                    $.alerts(data.info);
                }
            }
        },'json');
        sub_this.removeAttr('disabled');
        return false;
    });

    $('.shopping-cart-widget').mouseenter(function(){

        $.ajax({
            type: "post",
            url: home_url+"/store/cart/shortcutCart",
            data: $('#cart_param').serialize(),
            dataType: "json",
            success: function(data){
                if(data.content == null){
                    $('.product_list_widget').html('<p class="empty a-center">购物车中没有产品.</p>');
                    return false;
                }
                var html = '';
                var input = '';
                var amount = 0;
                $.each(data.content,function (index,domEle){
                    if(domEle.p_price!=null){
                        domEle.price = domEle.p_price;
                    }
                    if(domEle.list){
                        list = "<em>("+domEle.list+")</em>";
                    }
                    $url = window.home_url+'/store/items/'+domEle.goods_id;
                    html += "<li>";
                    // html += '<a href="#" class="close-order-li" title="删除该商品"><i class="fa fa-times-circle"></i></a>';
                    html += '<div class="media">';
                    html += '<a class="pull-left" href="'+$url+'" ';
                    if(domEle.var_photo) {
                        html += 'style="background-image: url('+domEle.var_photo+')"';
                    }
                    html += '></a>';
                    html += '<div class="media-body">';
                    html += '<h4 class="media-heading">';
                    html += '<a href="'+$url+'">'+domEle.title+list+'</a>';
                    html += '</h4>';
                    html += '<div class="descr-box">';
                    html += '<span class="coast">'+domEle.num+' x <span class="medium-coast"><span class="amount">¥'+domEle.price+'</span></span></span>';
                    html += '</div></div></div></li>';

                    amount += parseFloat(domEle.price) * parseFloat(domEle.num);

                    input += '<input type="hidden" name="checkItems[]" value="'+domEle.variables_id+'">';

                });

                html += '<p class="small-h pull-left">显示购物车小计</p>';
                html += '    <span class="big-coast pull-right">';
                html += '    <span class="amount">¥'+amount.toFixed(2)+'</span>';
                html += '</span>';
                html += '<div class="bottom-btn">';
                html += '    <a href="'+home_url+'/store/cart" class="btn text-center border-grey">查看购物车</a>';
                html += '    <form action="'+home_url+'/order/create" method="post" id="create_form">'+input+'<a href="#" class="btn text-center big filled GoCash">前往收银台</a></form>';
                html += '    </div>';
                $('.head-money-show').html(amount.toFixed(2));
                $('.product_list_widget').html(html);
            }
        });
    });

    $('.header_search_big').click(function(){
        $(".header_search_big").toggleClass('header-search_op');
        $('.sousuo-xiala').addClass('sousuo-xiala-oi');
        $('.header_search_ti').addClass('header_search_lefty');
        $('.header_search').toggleClass('header_search_leftypo');
    });
    $('.cancel_search_po').click(function(){
        $('.sousuo-xiala').removeClass('sousuo-xiala-oi');
        $('.header_search_ti').removeClass('header_search_lefty');
    });
    /*监听input内容和清除*/
    $(".weui_icon_clear").click(function(){
        $(this).siblings(".header_search,.login_center_info_text").val("");
        $(".header_search,.login_center_info_text").focus();
        $(this).hide();
    });
    $(".login_center_info_text,.header_search").keydown(function(){
        if ($(this).val().trim()!="") {
            $(this).siblings(".weui_icon_clear").show();
        }
    });
    $(".login_center_info_text,.header_search").keyup(function(){
        if ($(this).val().trim()!="") {
            $(this).siblings(".weui_icon_clear").show();
        }
    });
    //登录记住密码
    $('.login_hao label').click(function(){
        if($(this).find('input').prop('checked') == true){
            $(this).find('i').html('&#xe60e;').addClass('color_b09183').removeClass('color_block');
        }else if($(this).find('input').prop('checked') == false){
            $(this).find('i').html('&#xe60f;').addClass('color_block').removeClass('color_b09183');
        }
    });

    showContentNum($('.collect_li_line').find('h3'),18);  //手机收藏夹字数控制

    //申请售后凭证
    $('.afs_bill label').click(function(){
        $(this).parents('.afs_bill').siblings().find('img').attr('src',WP_IMG+'/ara_circle2.png');
        if($(this).prop('checked') == true){
        }else{
            $(this).find('img').attr('src',WP_IMG+'/ara_circle1.png');
        }
    });
    //结算页新增收货地址
    $('body').on('click','.balance_new_address_tan',function(){
        $data=[{title:'添加收货地址',c_ad_phone:'',c_ad_name:'',c_ad_phone:'',c_ad_details:'',c_ad_id:'',c_ad_default:'-1'}];
        $('body').append($('#balance_new_address_tanTmpl').tmpl($data));
        postValidform = $(".postAjax").Validform();
    });

    //显示内容指定字数
    function showContentNum(obj,showNum){
        obj.each(function(index){
            if($(this).text().length >= (showNum + 1)){
                $(this).text($(this).text().substring(0,showNum)+" ...");
            }
        });
    }
    function nosockItems($items){
        $html="<span class='swal-items'>";
        var $rID = '';
        $.each($items,function(i,v){
            if(i>0){
                $rID += ',';
            }
            $rID+= v.variables_id;
            img = '';
            if(v.var_photo){
                img = 'style="background-image: url('+v.var_photo+')"';
            }
            $html+="<span class='swal-items-li'><span class='swal-items-img' "+img+"></span>"+v.title+"</span>";
        })
        $html+="</span>";
        swal({
            title: '以下商品无货，你确认删除吗',
            text: $html,
            type: 'info',
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonColor: "#8c1b1b",
            confirmButtonText: "确 定",
            cancelButtonText: "取 消"
        }, function(isConform){
            if(isConform){
                $.ajax({
                    type: "post",
                    url: home_url+"/order/create/deleteCreate",
                    data: {'goods_id':$rID},
                    dataType: "json",
                    success: function(data){
                        $.alerts(data.info);
                        if(data.status == 'y'){
                            history.go(0);
                        }else if(data.status == 'n'){
                            window.location = data.url;
                        }
                        return false;
                    }
                });
            }
        });
    }
    /**
     * 提交到购物车
     */
    $(document).on('click','#CARTtj,.GoCash',function(){
        ajaxcreate();
        return false;
    });

});
var ajaxcreate=function(data){
    if(!data){
        data = jQuery('#create_form').serialize();
    }
    jQuery.ajax({
        type: "post",
        url: window.home_url+'/order/create/ajaxcreate',
        data:data ,
        dataType: "json",
        success: function(d){
            if(d.status =='y'){
                window.location.href = window.home_url+'/order/create';
            }else{
                jQuery.alerts(d.info);
            }
            return false;
        }
    },'json');
}
function ajaxLoadArea (_this, v1, v2) {
    if (!_this) {
        var _this = jQuery(this);
    }
    var parentId = _this.val();
    var thisName = _this.attr('name');
    if (thisName == 'liveArea' || thisName == 'homeArea' || thisName == 'receRoad' || thisName == 'receArea') {
        return false;
    }
    var select = _this.parent().children("select")
    var url = home_url + '/member/login/getArea';
    select.each(function () {
        var _that = jQuery(this);
        if (_that.index() > _this.index()) {
            _that.html("<option value=''>--请选择--</option>");
        }
    })
    _this.nextAll('select').remove();
    jQuery.post(url, {'parentId': parentId, 'thisName': thisName, 'rand': Math.random()}, function (data) {
        if (data.status == 'y') {
            var optionHtml = '<option value="">--请选择--</option>';
            jQuery.each(data.info, function (no, items) {
                var se = '';
                if (v1 == items.code) {
                    se = 'selected="selected"';
                }
                optionHtml += '<option value="' + items.code + '" ' + se + '>' + items.name + '</option>';
            });
            _this.parent().append('<select name="'+data.nextType+'" class="my_select_con dam_write_address_qu province">'+optionHtml+'</select>');
            if (v1) {
                ajaxLoadArea(_this.next('select'),v2);
            }
            return false;
        } else {
            _this.nextAll('select').remove();
        }
    }, 'json');
}
//JS获取URL参数
function GetQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}

