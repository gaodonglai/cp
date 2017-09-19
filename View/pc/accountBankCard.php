<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:14
 * pageName:银行卡管理
 */

?>

<!--个人中心内容-->
<main>
<div class="personal_main">
    <?php

    include VIEW_PC.'accountSidebar.php';
    ?>
    <div class="personal_main_right">
        <!--银行卡管理-->
        <div class="personal_main_macen">
            <div class="per_main_rig_top">
                <h4>银行卡管理</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla rig_main_capital">
                    <a class="card_binding1 betting_top-active" href="#Bank_card_binding1">绑定新的银行卡</a>
                    <a class="card_binding2" href="#Bank_card_binding2">绑定支付宝账号</a>
                    <a class="card_binding3" href="#Bank_card_binding3">绑定微信账号</a>
                    <a class="card_binding4" href="#Bank_card_binding4">已绑定的账号</a>
                </p>
                <div class="basic_information">
                    <div class="table_betting_main table_betting_active table_capital_main" id="Bank_card_binding1">
                        <p class="color_red_mddd"><i class="iconfont">&#xe60b;</i>不支持信用卡，请填写实名认证的银行卡账户信息。</p>
                        <form action="<?=_get_home_url('account/setBankCard')?>" class="postAjax basic_information_form">
                            <input type="hidden" name="type" value="bank" />
                            <ul>
                                <li class="basic_information_a">
                                    <label for="">选择银行：</label>
                                    <select name="bank_card" class="loginValue" nullmsg="请选择银行" datatype="*"">
                                        <option value="">请选择银行</option>
                                    <?php
                                    foreach ($bank as $key=>$item) {
                                        ?><option value="<?=$key?>"><?=$item?></option><?php
                                    }
                                    ?>
                                    </select>
                                    <span class="Validform_checktip"></span>
                                </li>
                               <!-- <li class="basic_information_b">
                                    <label for="">银行名称：</label>
                                    <input type="text" name="bank_account" value=""  datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/>
                                    <span class="Validform_checktip"></span>
                                </li>-->
                                <li class="basic_information_g">
                                    <label for="">卡号：</label>
                                    <input type="number" name="bank_account" value="" datatype="n16-19"  errormsg="银行卡格式不正确！"/  >
                                    <span class="Validform_checktip"></span>
                                </li>
                               <!-- <li class="basic_information_c">
                                    <label for="">开户城市：</label>
                                    <div id="distpicker4" data-toggle="distpicker" class="province-city" >
                                      <select name="province"></select>
                                      <select name="city"></select>
                                    </div>
                                </li>
                                <li class="basic_information_d">
                                    <label for="">开户支行：</label>
                                    <input type="text" name="subbank" value=""  datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/>
                                    <span class="Validform_checktip">请填写详细的支行名称</span>
                                </li>-->
                                <li class="basic_information_e">
                                    <label for="">持有人：</label>
                                    <input type="text" name="bank_name" value="" datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/ >
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">绑定银行卡</button>
                                    <span class="color_red_mdcc">您最多可以保存2个银行卡账号</span>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="table_betting_main table_capital_main" id="Bank_card_binding2">
                         <form action="<?=_get_home_url('account/setBankCard')?>" class="postAjax basic_information_form">
                             <input type="hidden" name="type" value="alipay" />
                            <ul>
                               
                                <li class="basic_information_b">
                                    <label for="">支付宝账号：</label>
                                    <input type="text" name="alipay_account" value=""  datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                <li class="basic_information_b">
                                    <label for="">真实姓名：</label>
                                    <input type="text" name="alipay_name" value=""  datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                 <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">绑定支付宝</button>
                                    <span class="color_red_mdcc">您最多可以保存1个支付宝账号</span>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="table_betting_main table_capital_main" id="Bank_card_binding3">
                        <form action="<?=_get_home_url('account/setBankCard')?>" class="postAjax basic_information_form ">
                            <input type="hidden" name="type" value="wechat" />
                            <ul>
                                <li class="basic_information_b">
                                    <label for="">微信账号：</label>
                                    <input type="text" name="wechat_account" value=""  datatype="s4-18"  errormsg="至少4个字符,最多18个字符！"/>
                                    <span class="Validform_checktip"></span>
                                </li>
                                 <li class="basic_information_i">
                                    <label for=""></label>
                                    <button class="modify_sub">绑定微信</button>
                                    <span class="color_red_mdcc">您最多可以保存1个微信账号</span>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="table_betting_main table_capital_main  Bank_card_bind_mainbb" id="Bank_card_binding4">

                        <?php

                        foreach ($content as $val) {
                                if($val->card_type == 'bank'){
                                    ?>
                                    <div class="bank_manage <!--bank_manage_active-->">
                                        <div class="item">
                                            <div class="head">
                                                <span><?=$bank[$val->opening_bank]?><i class="iconfont">&#xe622;</i></span>
                                                <a class="delete" data-id="<?=$val->id?>"  href="javascript:void(0)"><i class="iconfont">&#xe629;</i></a>
                                            </div>
                                            <div class="body">
                                                <dl>
                                                    <dd>
                                                        <span>卡号：</span>***<?=substr($val->account_number,'-4')?></dd>
                                                    <dd><span>户名：</span><?=$val->account_name?></dd>
                                                </dl>
                                                <a href="javascript:void(0)" class="take take_bank_manage">设为默认帐户</a>
                                               <a href="javascript:void(0)" class="take take_bank_manage">默认帐户</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }else if($val->card_type == 'alipay'){
                                    ?>
                                    <div class="bank_manage">
                                        <div class="item">
                                            <div class="head">
                                                <span class="zhifubao">支付宝账号<i class="iconfont">&#xe62b;</i></span>
                                                <a class="delete" data-id="<?=$val->id?>" href="javascript:void(0)"><i class="iconfont">&#xe629;</i></a>
                                            </div>
                                            <div class="body">
                                                <dl>
                                                    <dd>
                                                        <span>账号：</span><?=hideStar($val->account_number)?></dd>
                                                    <dd><span>名字：</span><?=$val->account_name?></dd>
                                                </dl>
                                                <a href="javascript:void(0)" class="take take_bank_manage">设为默认帐户</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="bank_manage">
                                        <div class="item">
                                            <div class="head">
                                                <span class="weixina">微信账号<i class="iconfont">&#xe603;</i></span>
                                                <a class="delete" data-id="<?=$val->id?>"  href="javascript:void(0)"><i class="iconfont">&#xe629;</i></a>
                                            </div>
                                            <div class="body">
                                                <dl>
                                                    <dd>
                                                        <span>账号：</span><?=$val->account_number?></dd>
                                                </dl>
                                                <a href="javascript:void(0)" class="take take_bank_manage">设为默认帐户</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <!--<div class="bank_manage">
                            <div class="item">
                                <div class="head">
                                    <span>中国农业银行<i class="iconfont">&#xe622;</i></span>
                                    <a class="delete"  href="javascript:void(0)"><i class="iconfont">&#xe629;</i></a>
                                </div>
                                <div class="body">
                                    <dl>
                                        <dd>
                                            <span>卡号：</span>6217 *********** 7564</dd>
                                        <dd><span>户名：</span>张奎</dd>
                                        <dd><span>城市：</span>四川 成都</dd>
                                        <dd><span>支行：</span>云南省曲靖市</dd>
                                    </dl>
                                    <a href="javascript:void(0)" class="take take_bank_manage">设为默认帐户</a>
                                </div>
                            </div>
                        </div>-->
                        <p class="text_alingaa"><a class="modify_sub shuaxin" href="javascript:history.go(0);">刷新</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</main>

<script>
var url_status = $.getUrlParam('Bank');
if(url_status){
    $(".rig_main_capital a").removeClass("betting_top-active");
    $('.'+url_status).addClass("betting_top-active");
    $(".table_capital_main").removeClass("table_betting_active");
    $(".brigtinh_main_cen").fadeOut(300);
    $('#Bank_'+url_status).delay(300).fadeIn();
}

$(".delete").on("click",function(){
    var _this = $(this);
    $.ajax({
        type : 'POST',  //提交方式
        dataType:'json',
        url : '<?=_get_home_url('account/deleteBankCard')?>',//路径
        data:{'bank':_this.data('id')},//数据，这里使用的是Json格式进行传输
        success : function(data) {//返回数据根据结果进行相应的处理
            console.log(data);
            if ( data.status == 'y') {
                $.alerts(data.info)
                _this.parents(".bank_manage").remove();
            } else {
                $.alerts(data.info)
            }
        }
    });

});
</script>