<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:45
 * Created people: gaodonglai
 * pageName:我的账户
 */
?>
<!--个人中心内容-->
<main>
<div class="personal_main">
    <?php

    include VIEW_PC.'accountSidebar.php';
    ?>
    <div class="personal_main_right">
        <!--我的账户-->
        <div class="personal_main_macen">
            <div class="per_main_rig_top">
                <h4>我的账户</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla  rig_main_capital">
                    <a class="betting_top-active bindingaa1" href="#modify_bindingaa1">基本信息</a>
                    <a class="bindingaa2" href="#modify_bindingaa2">充值记录</a>
                    <a class="bindingaa3" href="#modify_bindingaa3">积分与现金记录</a>
                </p>
                <div class="basic_information">
                 <div class="table_betting_main table_betting_active table_capital_main" id="modify_bindingaa1">
                     <div class="plTotal_main my_account">
                         <div class="plTotal">
                             <i class="iconfont">&#xe627;</i>
                             <div class="detail">
                                 <p>账户余额</p>
                                 <em><?=get_user_info()->user_money;?></em>
                             </div>
                         </div>
                         <div class="plTotal">
                             <i class="iconfont">&#xe605;</i>
                             <div class="detail">
                                 <p>投注金额</p>
                                 <em><?=get_user_info()->betting_money?></em>
                             </div>
                         </div>
                         <div class="plTotal">
                             <i class="iconfont">&#xe6ca;</i>
                             <div class="detail">
                                 <p>可提现金额</p>
                                 <em><?=get_user_info()->reward_money?></em>
                             </div>
                         </div>
                     </div>
                     <hr class="style12">
                    <form action="<?=_get_home_url('account/updateAccount')?>" class="postAjax basic_information_form">
                        <ul>
                            <li class="basic_information_a">
                                <label for="">用户名：</label>
                                <input type="text" disabled="disabled" name="name" value="<?=get_user_info()->user_name?>" >
                                <span class="Prompt_header" />不能修改</span>
                                <span class="color_red_mdcc">可以用于登陆，请牢记！</span>
                            </li>
                            <li class="basic_information_b">
                                <label for="">姓名：</label>
                                <input type="text" value="<?=get_user_info()->nick_name?>" name="nick_name"  datatype="s4-8"  errormsg="昵称至少4个字符,最多8个字符！" />
                                <span class="Validform_checktip"></span>
                            </li>

                            <li class="basic_information_d">
                                <label for="">手机：</label>
                                <input type="number" name="mobile_phone" value="<?=get_user_info()->mobile_phone?>" id="phone"  datatype="m" errormsg="请输入您的手机号码！"/>
                                <span class="Validform_checktip"></span>
                            </li>
                            <li class="basic_information_e">
                                <label for="">QQ：</label>
                                <input type="number" name="qq" value="<?=get_user_info()->qq?>"   datatype="n6-11" errormsg="请输入您的QQ号码！"/>
                                <span class="Validform_checktip"></span>
                            </li>
                            <li class="basic_information_f">
                                <label for="">Email：</label>
                                <input type="text" name="email" value="<?=get_user_info()->email?>"   datatype="e" errormsg="请输入您的Email！"/>
                                <span class="Validform_checktip"></span>
                            </li>
                            <li class="basic_information_g">
                                <label for=""></label>
                                <button class="modify_sub">修改</button>
                                <span class="color_red_mdcc">为了你的财产安全，请填写真实信息</span>
                            </li>
                        </ul>
                    </form>
                   </div> 
                     <div class="table_betting_main table_capital_main" id="modify_bindingaa2">
                        <table class="table_reference">
                            <thead class="tbody_referencea">

                                <tr>
                                    <th><span>充值时间</span></th>
                                    <th><span>充值金额</span></th>
                                    <th><span>赠送金额</span></th>
                                    <th><span>充值方式</span></th>

                                </tr>
                            </thead>
                            <tbody class="tbody_referenceb tbody_capital_main">

                            <?php
                            if($pay_log['content']){

                                foreach ($pay_log['content'] as $item) {
                                    ?>
                                    <tr>
                                        <td><span><?=$item->recharge_time?></span></td>
                                        <td><span>￥<?=$item->recharge_money?></span></td>
                                        <td><span>￥<?=$item->back_now?></span></td>
                                        <td><span><?=$recharge_type[ $item->recharge_type]?></span></td>
                                    </tr>
                                    <?php
                                }

                            }else{
                                ?>
                                <tr class="zanwujl">
                                    <td colspan="4" style="text-align: center;"><span><i class="iconfont">&#xe60b;</i>没有充值记录</span></td>
                                </tr>
                                <?php
                            }

                            ?>
                            </tbody>
                        </table>
                        <hr class="style12">
                         <?php
                         $page_links = paginate_links( array(
                             'base' => add_query_arg( 'page', '%#%'.'#modify_bindingaa2' ),
                             'format' => '',
                             'prev_text' => __( '上一页', 'aag' ),
                             'next_text' => __( '下一页', 'aag' ),
                             'total' => ceil( $pay_log['count']),
                             'current' => $pay_log['pagenum']
                         ) );

                         if ( $page_links ) {
                             echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
                         }
                         ?>
                    </div>
                     <div class="table_betting_main table_capital_main" id="modify_bindingaa3">
                         <table class="table_reference">
                             <thead class="tbody_referencea">

                             <tr>
                                 <th><span>时间</span></th>
                                 <th><span>金额</span></th>
                                 <th><span>类型</span></th>
                             </tr>
                             </thead>
                             <tbody class="tbody_referenceb tbody_capital_main">

                             <?php
                             if($cash_log['content']){
                                 foreach ($cash_log['content'] as $item) {
                                     ?>
                                     <tr>
                                         <td><span><?=$item->cash_record_time?></span></td>
                                         <td><span><?=$item->cash_record_type?>￥<?=$item->cash_record_cost?></span></td>
                                         <td><span><?=$cost_type[ $item->cost_type]?></span></td>
                                     </tr>
                                     <?php
                                 }

                             }else{
                                 ?>
                                 <tr class="zanwujl">
                                     <td colspan="4" style="text-align: center;"><span><i class="iconfont">&#xe60b;</i>没有记录</span></td>
                                </tr>
                                 <?php
                             }

                             ?>
                             </tbody>
                         </table>
                        <hr class="style12">
                         <?php
                         $page_links = paginate_links( array(
                             'base' => add_query_arg( 'pagenum', '%#%'.'#modify_bindingaa3' ),
                             'format' => '',
                             'prev_text' => __( '上一页', 'aag' ),
                             'next_text' => __( '下一页', 'aag' ),
                             'total' => ceil( $cash_log['count']),
                             'current' => $cash_log['pagenum']
                         ) );

                         if ( $page_links ) {
                             echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
                         }
                         ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div> 
</main>
+<script>
    window.onload = function() {
        var url_status = $.getUrlParam('modify');
        if(url_status){
            $(".rig_main_capital a").removeClass("betting_top-active");
            $('.'+url_status).addClass("betting_top-active");
            $(".table_capital_main").removeClass("table_betting_active");
            $(".brigtinh_main_cen").fadeOut(300);
            $('#modify_'+url_status).delay(300).fadeIn();
        }
    };
</script>