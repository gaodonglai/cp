<?php
/**
 * 充值管理
 */
class pay_calss{
    public function __construct()
    {
        add_action('admin_menu',array($this,'add_pay_menu'));
        add_action('load-themes.php',array($this,'add_pay_menu_role'));//模板加载时
    }


    public function add_pay_menu_role(){
        global $pagenow,$wp_roles;
         //判断是否为激活主题页面
        if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

            $role = 'pay';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '充值管理';

            $role = 'pay_log';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '充值记录';

            $role = 'bank_run';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '银行卡管理';

        }
    }


    public function add_pay_menu() {

        add_menu_page('充值管理','充值管理','pay','pay',array($this,'fun_menu'),'',210);
        add_submenu_page('pay','充值记录','充值记录','pay_log','pay_log',array($this,'fun_menu1'));
        add_submenu_page('pay','银行卡管理','银行卡管理','bank_run','bank_run',array($this,'fun_menu2'));
       /*
        add_submenu_page('test','测试2','测试2','test2','test2',array($this,'menu_tes2'));*/

    }

    public function fun_menu(){
        $status = array('y'=>'充值成功','n'=>'已取消','s'=>'待确认');

        global $wpdb;
        $like = $_GET['like'];
        if($like){
            $g_like = "WHERE b.user_name LIKE '%{$like}%' or b.nick_name LIKE '%{$like}%'";
        }

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 10;
        $offset = ( $pagenum - 1 ) * $limit;
        $entries = $wpdb->get_results( "SELECT a.*,b.user_name,b.nick_name,b.user_money,d.account_number as bank_account_number,d.account_name as bank_account_name, d.card_type FROM {$wpdb->prefix}artificial_pay as a inner JOIN {$wpdb->prefix}account as b on a.user_id = b.user_id  INNER JOIN {$wpdb->prefix}card_binding as d on a.user_id=d.user_id and a.pay_type = d.id $g_like ORDER BY  a.id DESC   LIMIT $offset, $limit " );

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">充值申请</h1>

            <hr class="wp-header-end">

            <h2 class="screen-reader-text">过滤用户列表</h2>
            <form action="<?=add_query_arg()?>" method="get">
                <input type="hidden" id="user-search-input" name="page" value="pay">
                <p class="search-box">
                    <label class="screen-reader-text" for="user-search-input">搜索用户:</label>
                    <input type="search" id="user-search-input" name="like" value="">
                    <input type="submit" id="search-submit" class="button" value="搜索用户"></p>



                <h2 class="screen-reader-text">用户列表</h2><table class="wp-list-table widefat fixed striped users">
                    <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="javascipt:;"><span>用户名</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="name" class="manage-column column-name">充值途径</th>

                        <th scope="col" id="role" class="manage-column column-posts num">用户当前余额</th>
                        <th scope="col" id="role" class="manage-column column-role">本次充值金额</th>
                        <th scope="col" id="role" class="manage-column column-role">本次充值时间</th>
                        <th scope="col" id="role" class="manage-column column-posts num">状态</th>
                        <th scope="col" id="role" class="manage-column column-role">提交时间</th>
                        <th scope="col" id="role" class="manage-column column-role">操作</th>
                    </tr>
                    </thead>

                    <tbody id="the-list" data-wp-lists="list:user">
                    <?php if( $entries ) {
                        $pay_type = array('bank'=>'银行卡','wechat'=>'微信','alipay'=>'支付宝');
                        $count = 1;
                        foreach( $entries as $entry ) {
                            ?>
                            <tr id="user-1"><th scope="row" class="check-column">
                                <td class="username column-username has-row-actions column-primary" data-colname="用户名"><strong><a href="javascript:;"><?=$entry->user_name?></a></strong><br><div class="row-actions"><span class="edit"><a href="?page=account&type=edit&user_id=<?=$entry->user_id?>">编辑用户</a> </span></div><button type="button" class="toggle-row"><span class="screen-reader-text">显示详情</span></button></td>
                                <td class="name column-name" data-colname="途径"><?=$pay_type[$entry->card_type] .' '. $entry->bank_account_number .' '. $entry->bank_account_name?></a></td>

                                <td class="user_id column-user_id" data-colname="用户当前余额"><?=$entry->user_money?></td>

                                <td class="user_id column-user_id" data-colname="本次充值金额"><?=$entry->pay_money?></td>
                                <td class="user_id column-user_id" data-colname="注册时间"><?=$entry->time?></td>
                                <td class="user_id column-user_id" data-colname="状态"  ><?=$status[$entry->status]?><?=$entry->status == 'n' ? '<span title="'.$entry->remarks.'" class="dashicons dashicons-editor-help"></span>' : ''?></td>
                                <td class="user_id column-user_id" data-colname="提交时间"><?=$entry->time?></td>
                                <td class="user_id column-user_id" data-colname="操作">
                                    <?php
                                    if($entry->status == 's'){
                                        ?><a data-money="<?=$entry->pay_money?>" data-type="<?=$pay_type[$entry->pay_type]?>" class="add-verify" href="javascript:;" data-id="<?=$entry->id?>" class="">确认</a>
                                        |
                                        <a data-money="<?=$entry->pay_money?>" data-type="<?=$pay_type[$entry->pay_type]?>" class="update-verify" href="javascript:;" data-id="<?=$entry->id?>" class="">其他金额</a>
                                        |
                                    <?php
                                        }
                                    ?>

                                </td>
                            </tr>
                            <?php
                            $count++;
                        }
                        ?>

                    <?php } else { ?>
                        <tr>
                            <td colspan="2">No posts yet</td>
                        </tr>
                    <?php } ?>

                    </tbody>

                    <tfoot>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="http://localhost/cp/ks/wp-admin/users.php?orderby=login&amp;order=asc"><span>用户名</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="name" class="manage-column column-name">充值途径</th>
                        <th scope="col" id="role" class="manage-column column-posts num">用户当前余额</th>
                        <th scope="col" id="role" class="manage-column column-role">本次充值金额</th>
                        <th scope="col" id="role" class="manage-column column-role">本次充值时间</th>
                        <th scope="col" id="role" class="manage-column column-posts num">状态</th>
                        <th scope="col" id="role" class="manage-column column-role">提交时间</th>
                        <th scope="col" id="role" class="manage-column column-role">操作</th>
                    </tr>
                    </tfoot>

                </table>
                <div class="tablenav bottom">



            </form>
            <?php

            $total = $wpdb->get_var( "SELECT COUNT(`id`) FROM {$wpdb->prefix}artificial_pay {$g_like}" );
            $num_of_pages = ceil( $total / $limit );
            $page_links = paginate_links( array(
                'base' => add_query_arg( 'pagenum', '%#%' ),
                'format' => '',
                'prev_text' => __( '上一页', 'aag' ),
                'next_text' => __( '下一页', 'aag' ),
                'total' => $num_of_pages,
                'current' => $pagenum
            ) );

            if ( $page_links ) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
            }

            echo '</div>';
            ?>
            <br class="clear">

        </div>

        <script src="<?= JS;?>/jquery2.1.1.min.js"></script>
        <script>

            $(".add-verify").on("click",function(){

                var _this = $(this);
                if(!confirm("请确认 "+_this.attr('data-type')+" 账户已收到："+_this.attr('data-money') + "元")){
                    return false;
                }

                $.ajax({
                    type : 'POST',  //提交方式
                    dataType:'json',
                    url :"<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>",//路径
                    data:{'pay_money':_this.attr('data-money'),'id':_this.attr('data-id'),'action':'account/pay/updaTeartificialPay'},//
                    success : function(data) {//返回数据根据结果进行相应的处理

                        if ( data.status == 'y') {
                            alert("充值成功");
                            window.history.go(0);
                        } else {
                            alert("充值失败，请重试");
                        }
                    }
                });
                return false;

            });
            //修改金额并确认
            $(".update-verify").on("click",function(){

                var _this = $(this);
                var cancel_content = prompt("该账户为 "+_this.attr('data-type')+" 充值，本该充值："+_this.attr('data-money') + "元，下面框中填入金额并确认，将修改金额并确认申请", ""); //将输入的内容赋给变量 name ，

                //这里需要注意的是，prompt有两个参数，前面是提示的话，后面是当对话框出来后，在对话框里的默认值
                if (cancel_content == null || cancel_content == undefined || cancel_content == '') {
                    return false;
                }

                $.ajax({
                    type : 'POST',  //提交方式
                    dataType:'json',
                    url :"<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>",//路径
                    data:{'update_money':cancel_content,'id':_this.attr('data-id'),'action':'account/pay/updaTeartificialPay'},//
                    success : function(data) {//返回数据根据结果进行相应的处理

                        if ( data.status == 'y') {
                            alert("充值成功");
                            window.history.go(0);
                        } else {
                            alert("充值失败，请重试");
                        }
                    }
                });
                return false;

            });

            //取消充值申请
            $(".cancel-verify").on("click",function(){

                var _this = $(this);
                var cancel_content = prompt("取消用户 "+_this.attr('data-name')+" 本次充值 "+_this.attr('data-money') +" 元的申请，请输入原因", ""); //将输入的内容赋给变量 name ，

                //这里需要注意的是，prompt有两个参数，前面是提示的话，后面是当对话框出来后，在对话框里的默认值
                if (cancel_content == null || cancel_content == undefined || cancel_content == '') {
                    return false;
                }

                $.ajax({
                    type : 'POST',  //提交方式
                    dataType:'json',
                    url :"<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>",//路径
                    data:{'cancel_content':cancel_content,'user_id':_this.attr('data-user_id'),'pay_id':_this.attr('data-id'),'action':'account/pay/canceleErtificialPay'},//
                    success : function(data) {//返回数据根据结果进行相应的处理

                        if ( data.status == 'y') {
                            alert("充值成功");
                            window.history.go(0);
                        } else {
                            alert("充值失败，请重试");
                        }
                    }
                });
                return false;

            });

        </script>


        <?php

    }

    public function fun_menu1(){

        $bank_type = array('bank'=>'银行卡','wechat'=>'微信支付','alipay'=>'支付宝','qq'=>'qq钱包','artificial'=>'人工充值','direct'=>'账户充值');
        global $wpdb;
        $like = $_GET['like'];
        if($like){
            $g_like = "WHERE b.user_name LIKE '%{$like}%' or b.nick_name LIKE '%{$like}%'";
        }

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 10;
        $offset = ( $pagenum - 1 ) * $limit;
        $entries = $wpdb->get_results( "SELECT a.*,b.user_name,b.nick_name,b.user_money FROM {$wpdb->prefix}recharge as a inner JOIN {$wpdb->prefix}account as b on a.user_id = b.user_id $g_like ORDER BY  `id` DESC   LIMIT $offset, $limit " );
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">充值记录</h1>

            <hr class="wp-header-end">

            <h2 class="screen-reader-text">过滤用户列表</h2>
            <form action="<?=add_query_arg()?>" method="get">
                <input type="hidden" id="user-search-input" name="page" value="account">
                <p class="search-box">
                    <label class="screen-reader-text" for="user-search-input">搜索用户:</label>
                    <input type="search" id="user-search-input" name="like" value="">
                    <input type="submit" id="search-submit" class="button" value="搜索用户"></p>



                <h2 class="screen-reader-text">用户列表</h2><table class="wp-list-table widefat fixed striped users">
                    <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="javascipt:;"><span>用户名</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="name" class="manage-column column-name">姓名</th>


                        <th scope="col" id="role" class="manage-column column-role">充值金额</th>
                        <th scope="col" id="role" class="manage-column column-role">赠送金额</th>
                        <th scope="col" id="role" class="manage-column column-posts num">充值方式</th>
                        <th scope="col" id="role" class="manage-column column-role">充值时间</th>
                    </tr>
                    </thead>

                    <tbody id="the-list" data-wp-lists="list:user">
                    <?php if( $entries ) { ?>

                        <?php
                        $count = 1;
                        foreach( $entries as $entry ) {
                            ?>
                            <tr id="user-1"><th scope="row" class="check-column">
                                <td class="username column-username has-row-actions column-primary" data-colname="用户名"><strong><a href="javascript:;"><?=$entry->user_name?></a></strong><br><div class="row-actions"><span class="edit"><a href="?page=account&type=edit&user_id=<?=$entry->user_id?>">编辑</a> </span></div><button type="button" class="toggle-row"><span class="screen-reader-text">显示详情</span></button></td>
                                <td class="name column-name" data-colname="姓名"><?=$entry->nick_name?></a></td>


                                <td class="user_id column-user_id" data-colname="充值金额"><?=$entry->recharge_money?></td>
                                <td class="user_id column-user_id" data-colname="赠送金额"><?=$entry->back_now?></td>
                                <td class="user_id column-user_id" data-colname="充值方式"><?=$bank_type[$entry->recharge_type]?></td>
                                <td class="user_id column-user_id" data-colname="充值时间"><?=$entry->recharge_time?></td>
                            </tr>
                            <?php
                            $count++;
                        }
                        ?>

                    <?php } else { ?>
                        <tr>
                            <td colspan="2">No posts yet</td>
                        </tr>
                    <?php } ?>

                    </tbody>

                    <tfoot>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                        <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="http://localhost/cp/ks/wp-admin/users.php?orderby=login&amp;order=asc"><span>用户名</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="name" class="manage-column column-name">姓名</th>

                        <th scope="col" id="role" class="manage-column column-role">充值金额</th>
                        <th scope="col" id="role" class="manage-column column-role">赠送金额</th>
                        <th scope="col" id="role" class="manage-column column-posts num">充值方式</th>
                        <th scope="col" id="role" class="manage-column column-role">充值时间</th>
                    </tr>
                    </tfoot>

                </table>
                <div class="tablenav bottom">



            </form>
            <?php

            $total = $wpdb->get_var( "SELECT COUNT(`id`) FROM {$wpdb->prefix}recharge {$g_like}" );
            $num_of_pages = ceil( $total / $limit );
            $page_links = paginate_links( array(
                'base' => add_query_arg( 'pagenum', '%#%' ),
                'format' => '',
                'prev_text' => __( '上一页', 'aag' ),
                'next_text' => __( '下一页', 'aag' ),
                'total' => $num_of_pages,
                'current' => $pagenum
            ) );

            if ( $page_links ) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
            }

            echo '</div>';
            ?>
            <br class="clear">

        </div>
    <?php
    }

    public function fun_menu2(){

        $pathering_bank = get_option('admin_pathering_bank');
        ?>

        <div class="wrap">
            <h1>收款银行卡设置</h1>
            <h2 class="nav-tab-wrapper" style="margin-bottom:10px;">
                <a href="?page=bank_run&type=bank" title="银行卡" class="nav-tab <?=$_GET['type']=='bank' || empty($_GET['type']) ? 'nav-tab-active' : ''?>">银行卡</a>
                <a href="?page=bank_run&type=wechatandalipay" title="注册" class="nav-tab <?=$_GET['type']=='wechatandalipay' ? 'nav-tab-active' : ''?>">微信与支付宝</a>
            </h2>

            <?php
            if($_GET['type']=='bank' || empty($_GET['type'])){
                ?>
                <form class="add-bank-form" novalidate="novalidate">
                    <input name="action" type="hidden"  value="account/pay/patheringBankCard">
                    <table class="form-table">

                        <?php
                        if($pathering_bank){

                            foreach ($pathering_bank as $key => $item) {
                                ?>
                                <tbody>
                                <tr>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="blogname">银行卡号</label></th>
                                    <td><input name="bank_card[]" type="text"  value="<?=$item['bank_card']?>" class="regular-text"></td>
                                    <td><a href="javascript:;" class="delete-this-bank">删除</a></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="blogdescription">银行</label></th>
                                    <td><input name="bank_name[]" type="text" value="<?=$item['bank_name']?>" class="regluar-text ltr">
                                        <p class="description" id="tagline-description">银行卡所在银行名称。</p></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label >姓名</label></th>
                                    <td><input name="bank_nickname[]" type="text" value="<?=$item['bank_nickname']?>" class="regluar-text ltr">
                                        <p class="description" id="tagline-description">该张银行卡绑定的户主姓名。</p></td>
                                </tr>
                                </tbody>

                                <?php
                            }
                        }else{
                            ?>
                            <tbody>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="blogname">银行卡号</label></th>
                                <td><input name="bank_card[]" type="text"  value="" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="blogdescription">银行</label></th>
                                <td><input name="bank_name[]" type="text" value="" class="regluar-text ltr">
                                    <p class="description" id="tagline-description">银行卡所在银行名称。</p></td>
                            </tr>
                            <tr>
                                <th scope="row"><label >姓名</label></th>
                                <td><input name="bank_nickname[]" type="text" value="" class="regluar-text ltr">
                                    <p class="description" id="tagline-description">该张银行卡绑定的户主姓名。</p></td>
                            </tr>
                            </tbody>
                            <?php
                        }

                        ?>
                    </table>

                    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="保存更改">&nbsp;<button type="button" class="button add-bank">新增一个</button></p>
                </form>

                <?php
            }

            ?>


        </div>

        <script src="<?= JS;?>/jquery2.1.1.min.js"></script>
        <script>

            $(".add-bank").on("click",function(){
                $(".form-table").append("<tbody><tr>\n" +
                    "                            <td></td>\n" +
                    "                        </tr>\n" +
                    "                        <tr>\n" +
                    "                            <th scope=\"row\"><label for=\"blogname\">银行卡号</label></th>\n" +
                    "                            <td><input name=\"bank_card[]\" type=\"text\"  value=\"\" class=\"regular-text\"></td><td><a href=\"javascript:;\" class=\"delete-this-bank\">删除</a></td>\n" +
                    "                        </tr>\n" +
                    "                        <tr>\n" +
                    "                            <th scope=\"row\"><label for=\"blogdescription\">银行</label></th>\n" +
                    "                            <td><input name=\"bank_name[]\" type=\"text\" value=\"\" class=\"regluar-text ltr\">\n" +
                    "                                <p class=\"description\" id=\"tagline-description\">银行卡所在银行名称。</p></td>\n" +
                    "                        </tr>\n" +
                    "                        <tr>\n" +
                    "                            <th scope=\"row\"><label >姓名</label></th>\n" +
                    "                            <td><input name=\"bank_nickname[]\" type=\"text\" value=\"\" class=\"regluar-text ltr\">\n" +
                    "                                <p class=\"description\" id=\"tagline-description\">该张银行卡绑定的户主姓名。</p></td>\n" +
                    "                        </tr></tbody>");
            });

            $(".add-bank-form").on("submit",function(){

                var _this = $(this);


                $.ajax({
                    type : 'POST',  //提交方式
                    dataType:'json',
                    url :"<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>",//路径
                    data:_this.serializeArray(),//
                    success : function(data) {//返回数据根据结果进行相应的处理

                        if ( data.status == 'y') {
                            alert(data.info);
                            history.go(0);
                        } else {
                            alert(data.info);
                        }
                    }
                });
                return false;

            });
            $("body").on("click",'.delete-this-bank',function(){

                var _this = $(this);

                _this.parents('tbody').remove();


            });

        </script>

        <?php
    }

}
new pay_calss();
?>