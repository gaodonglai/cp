<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:14
 * pageName:分销管理
 */

?>

<!--个人中心内容-->
<main class="personal_main">
    <?php
    include VIEW_PC.'accountSidebar.php';
    ?>
    <div class="personal_main_right">
        <!--分销管理-->
        <div class="personal_main_macen">
            <div class="per_main_rig_top">
                <h4>分销管理</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla rig_main_capital">
                    <a class="betting_top-active" href="#distr_card_binding1">我的名片</a>
                    <a href="#distr_card_binding2">我的会员</a>
                    <a href="#distr_card_binding3">我的佣金</a>
                </p>
                <div class="basic_information">
                    <div class="table_betting_main table_betting_active table_capital_main" id="distr_card_binding1">
                        <p class="color_red_mddd fonttextmddd"><i class="iconfont">&#xe60b;</i>链接和二维码有效时间还剩：</p>
                        <div class="clock qrcode_clock"></div>
                        <div class="copy_text">
                            <p>我的链接</p>
                            <input type="text" id="foo" readonly="readonly"  value="<?=$distri_url?>">
                            <span class="input-group-btn">
                            <button class="input-group-pr" type="button" data-clipboard-action="copy" data-clipboard-target="#foo">复制</button>
                            </span>
                        </div>
                        <div class="copy_text copy_text_img">
                            <p>我的二维码</p>
                            <iframe style="width:140px;height:140px" frameborder="0" scrolling="no" src="<?=_get_home_url('account/myQrCode?code='.$distri_url)?>"></iframe>

                            <p class="color_red_mddd">鼠标右键单击二维码图片复制</p>
                        </div>
                        <p class="zhuangyai">我的名片状态：<span class="color_red_mddd card_status">正常</span>。<button class="modify_sub">点击刷新</button></p>
                    </div>
                    <div class="table_betting_main table_capital_main" id="distr_card_binding2">
                        <div class="Accordion_Record">
                            <div class="Accordion_Record_main" style="display: block;">
                                  <div class="child">
                                    <div class="childTitle">
                                        <div class="childIcon">
                                            <div class="sub sub1">
                                            </div>
                                            <div class="sub sub2">
                                            </div>
                                        </div>
                                        <div class="title">
                                            <p>我的一级会员</p>
                                        </div>
                                    </div>
                                    <div class="childContent">
                                      <div class="basic_information">
                                            <div class="table_betting_main table_betting_active">
                                                 <table class="table_reference"> 
                                                   <thead class="tbody_referencea childContenttha">
                                                      <tr> 
                                                        <th><span>会员账号</span></th> 
                                                        <th><span>返水金额</span></th> 
                                                        <th><span>充值时间</span></th>
                                                      </tr> 
                                                     </thead> 
                                                     <tbody class="tbody_referenceb tbody_referencebc">  
                                                      <tr class="screen_nowin_a"> 
                                                        <td><span>砸锅卖铁去上网</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                       <tr class="screen_nowin_a"> 
                                                        <td><span>梅川内酷</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                      <tr class="screen_nowin_a"> 
                                                        <td><span>少年包工头</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                      </tr>
                                                     <tr class="screen_nowin_a"> 
                                                        <td><span>秋名山86</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                       <tr class="screen_nowin_a"> 
                                                        <td><span>性盛致灾</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                       <tr class="screen_nowin_a"> 
                                                        <td><span>割以永治</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                      <tr class="screen_nowin_a"> 
                                                        <td><span>个个都是人才</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                       <tr class="screen_nowin_a"> 
                                                        <td><span>打工是不可能的</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  <hr class="style12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="childTitle">
                                        <div class="childIcon">
                                            <div class="sub sub1">
                                            </div>
                                            <div class="sub sub2">
                                            </div>
                                        </div>
                                        <div class="title">
                                            <p>我的二级会员</p>
                                        </div>
                                    </div>
                                    <div class="childContent">
                                      <div class="basic_information">
                                            <div class="table_betting_main table_betting_active">
                                                 <table class="table_reference"> 
                                                   <thead class="tbody_referencea childContenttha">
                                                      <tr> 
                                                        <th><span>会员账号</span></th> 
                                                        <th><span>返水金额</span></th> 
                                                        <th><span>充值时间</span></th>
                                                      </tr> 
                                                     </thead> 
                                                     <tbody class="tbody_referenceb tbody_referencebc">  
                                                      <tr class="screen_nowin_a"> 
                                                        <td><span>砸锅卖铁去上网</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                       <tr class="screen_nowin_a"> 
                                                        <td><span>梅川内酷</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                      <tr class="screen_nowin_a"> 
                                                        <td><span>少年包工头</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                      </tr>
                                                     <tr class="screen_nowin_a"> 
                                                        <td><span>秋名山86</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                       <tr class="screen_nowin_a"> 
                                                        <td><span>性盛致灾</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                       <tr class="screen_nowin_a"> 
                                                        <td><span>割以永治</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                      <tr class="screen_nowin_a"> 
                                                        <td><span>个个都是人才</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                       <tr class="screen_nowin_a"> 
                                                        <td><span>打工是不可能的</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  <hr class="style12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table_betting_main table_capital_main" id="distr_card_binding3">
                       <div class="plTotal_main">
                            <div class="plTotal">
                                <i class="iconfont">&#xe627;</i> 
                                <div class="detail">
                                    <p>我的佣金(总)</p> 
                                    <em>0.00</em>
                                </div>
                            </div>
                            <div class="plTotal">
                                <i class="iconfont">&#xe605;</i> 
                                <div class="detail">
                                    <p>今日佣金返水金额</p> 
                                    <em>0.00</em>
                                </div>
                            </div>
                       </div>
                        <div class="Accordion_Record">
                            <div class="Accordion_Record_main" style="display: block;">
                                  <div class="child">
                                <div class="childTitle">
                                    <div class="childIcon">
                                        <div class="sub sub1">
                                        </div>
                                        <div class="sub sub2">
                                        </div>
                                    </div>
                                    <div class="title">
                                        <p>我的佣金明细：</p>
                                    </div>
                                </div>
                                <div class="childContent">
                                  <p class="record_p">暂无记录</p>
                                  <div class="basic_information">
                                        <div class="table_betting_main table_betting_active">
                                             <table class="table_reference"> 
                                               <thead class="tbody_referencea">
                                                  <tr> 
                                                    <th><span>代理用户名</span></th> 
                                                    <th><span>充值金额</span></th> 
                                                    <th><span>返水金额</span></th>
                                                    <th><span>充值时间</span></th> 
                                                  </tr> 
                                                 </thead> 
                                                 <tbody class="tbody_referenceb tbody_referencebc">  
                                                   <tr class="screen_nowin_a"> 
                                                        <td><span>砸锅卖铁去上网</span></td>
                                                        <td><span>2000.00</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                    </tr>
                                                    <tr class="screen_nowin_a"> 
                                                        <td><span>砸锅卖铁去上网</span></td>
                                                        <td><span>2000.00</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                    </tr>
                                                    <tr class="screen_nowin_a"> 
                                                        <td><span>砸锅卖铁去上网</span></td>
                                                        <td><span>2000.00</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                    </tr>
                                                    <tr class="screen_nowin_a"> 
                                                        <td><span>砸锅卖铁去上网</span></td>
                                                        <td><span>2000.00</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                    </tr>
                                                    <tr class="screen_nowin_a"> 
                                                        <td><span>砸锅卖铁去上网</span></td>
                                                        <td><span>2000.00</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                    </tr>
                                                    <tr class="screen_nowin_a"> 
                                                        <td><span>砸锅卖铁去上网</span></td>
                                                        <td><span>2000.00</span></td> 
                                                        <td><span class="color_red_da">100.00</span></td>
                                                        <td><span>2017-08-23 16:46:29</span></td>
                                                    </tr>
                                                </tbody>
                                              </table>
                                              <hr class="style12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!--倒计时-->
<script src="<?=_get_home_url()?>View/pc/js/flipclock.min.js"></script>
<script>
    /*倒计时*/
    var clock = $('.clock').FlipClock({
        clockFace: 'HoilyCounter',
        autoStart: false,
        callbacks: {
            stop: function() {
                $('.card_status').html('已失效')
            }
        },
    });
    clock.setCountdown(true);
    clock.setTime(<?=$residue_time?>);
    clock.start();


</script>

