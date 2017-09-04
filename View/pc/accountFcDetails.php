<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:45
 * Created people: gaodonglai
 * pageName:资金明细
 */

?>
<!--个人中心内容-->
<main class="personal_main">
    <?php

    include VIEW_PC.'accountSidebar.php';
    ?>
    <div class="personal_main_right">
        <!--资金明细-->
        <div class="personal_main_macen">
            <div class="per_main_rig_top">
                <h4>资金明细</h4>
            </div>
            <div class="per_main_rig_main">
                <p class="rig_main_zla active_zla rig_main_capital">
                    <a class="betting_top-active" href="#table_betting1">当日资金明细</a>
                    <a href="#table_betting2">本周资质明细</a>
                    <a href="#table_betting3">本月资金明细</a>
                    <a href="#table_betting4">所有资金明细</a>
                </p>
                <div class="capital_table">
                    <table class="table_reference">
                        <thead class="tbody_referencea">
                        <tr>
                            <th><span>投注日期</span></th>
                            <th><span>投注金额</span></th>
                            <th><span>中奖金额</span></th>
                            <th><span>充值金额</span></th>
                            <th><span>提现金额</span></th>
                            <th><span>返水金额</span></th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="basic_information">
                    <div class="table_betting_main table_betting_active table_capital_main" id="table_betting1">
                        <p class="capital_operation">今天没有任何操作！</p>
                        <table class="table_reference">

                        </table>
                        <hr class="style12">
                    </div>
                    <div class="table_betting_main table_capital_main" id="table_betting2">
                        <table class="table_reference">
                            <tbody class="tbody_referenceb tbody_capital_main">
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <hr class="style12">
                    </div>
                    <div class="table_betting_main table_capital_main" id="table_betting3">
                        <table class="table_reference">
                            <tbody class="tbody_referenceb tbody_capital_main">
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <hr class="style12">
                    </div>
                    <div class="table_betting_main table_capital_main" id="table_betting4">
                        <table class="table_reference">
                            <tbody class="tbody_referenceb tbody_capital_main">
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            <tr>
                                <td><span>2017-08-26</span></td>
                                <td><span>430</span></td>
                                <td><span>654.50</span></td>
                                <td><span>100</span></td>
                                <td><span>320.00</span></td>
                                <td><span>0.00</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <hr class="style12">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
