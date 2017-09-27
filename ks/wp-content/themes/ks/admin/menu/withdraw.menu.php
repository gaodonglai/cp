<?php
/**
 * 取现管理
 */
class withdraw_calss{
    public function __construct()
    {
        add_action('admin_menu',array($this,'add_withdraw_menu'));
        add_action('load-themes.php',array($this,'add_withdraw_menu_role'));//模板加载时
    }


    public function add_withdraw_menu_role(){
        global $pagenow,$wp_roles;
         //判断是否为激活主题页面
        if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

            $role = 'withdraw';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '取现管理';
            $role = 'withdraw_setting';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '取现设置';
            /*$role = 'test1';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试1';

            $role = 'test2';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试2';*/

        }
    }


    public function add_withdraw_menu() {

        add_menu_page('取现管理','取现管理','withdraw','withdraw',array($this,'fun_menu'),'',208);
        add_submenu_page('withdraw','取现设置','取现设置','withdraw_setting','withdraw_setting',array($this,'fun_menu1'));
       /* add_submenu_page('test','测试1','测试1','test1','test1',array($this,'menu_test1'));
        add_submenu_page('test','测试2','测试2','test2','test2',array($this,'menu_tes2'));*/

    }

    public function fun_menu(){
        $bank = array('1'=>'中国工商银行','2'=>'中国建设银行','3'=>'中国农业银行','4'=>'中国邮政储蓄银行'
        ,'5'=>'交通银行','6'=>'招商银行','7'=>'中国银行','8'=>'中国光大银行',
            '9'=>'中信银行','10'=>'浦发银行','11'=>'中国民生银行','12'=>'兴业银行',
            '13'=>'平安银行','14'=>'广发银行','15'=>'华夏银行'
        );
        $pay_type = array('bank'=>'银行卡','wechat'=>'微信支付','alipay'=>'支付宝','qq'=>'qq钱包','artificial'=>'人工充值',);
        $pay_status = array('1'=>'待处理','2'=>'已完成','3'=>'未通过');

        global $wpdb;
        $like = $_GET['like'];
        if($like){
            $g_like = "WHERE b.user_name LIKE '%{$like}%' or b.nick_name LIKE '%{$like}%'";
        }

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 10;
        $offset = ( $pagenum - 1 ) * $limit;
        $entries = $wpdb->get_results( "SELECT a.*,b.user_name,b.nick_name,b.user_money,d.account_number,d.opening_bank,d.card_type FROM {$wpdb->prefix}extract_money_log as a 
                                                    inner JOIN {$wpdb->prefix}account as b on a.user_id = b.user_id  
                                                    INNER JOIN {$wpdb->prefix}card_binding as d on a.bankcard = d.id
                                                    $g_like ORDER BY  `id` DESC   LIMIT $offset, $limit " );
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">提现用户列表</h1>

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

                        <th scope="col" id="role" class="manage-column column-posts num">提现金额</th>
                        <th scope="col" id="role" class="manage-column column-posts num">手续费</th>
                        <th scope="col" id="role" class="manage-column column-posts num">取现类别</th>
                        <th scope="col" id="role" class="manage-column column-role">银行名称</th>
                        <th scope="col" id="role" class="manage-column column-role">卡号</th>
                        <th scope="col" id="role" class="manage-column column-role">提交时间</th>
                        <th scope="col" id="role" class="manage-column column-role">状态</th>
                        <th scope="col" id="role" class="manage-column column-role">操作</th>
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

                                <td class="user_id column-user_id" data-colname="提现金额"><?=$entry->money?></td>
                                <td class="user_id column-user_id" data-colname="手续费"><?=$entry->service_charge?></td>
                                <td class="user_id column-user_id" data-colname="取现类别"><?=$pay_type[$entry->card_type]?></td>
                                <td class="user_id column-user_id" data-colname="银行名称"><?=$bank[$entry->opening_bank]?></td>
                                <td class="user_id column-user_id" data-colname="银行卡号"  ><?=$entry->account_number?></td>
                                <td class="user_id column-user_id" data-colname="提交时间"><?=$entry->time?></td>
                                <td class="user_id column-user_id" data-colname="状态"><?=$pay_status[$entry->status]?>
                                <?php
                                    if($entry->status == 3){
                                        ?><span title="<?=$entry->refuse_reason?>" class="customize-help-toggle dashicons dashicons-editor-help"></span><?php
                                    }
                                    ?>
                                </td>
                                <td class="user_id column-user_id" data-colname="操作">
                                    <?php
                                    if($entry->status == '1'){
                                        ?><a data-id="<?=$entry->id?>" data-userid="<?=$entry->user_id?>" data-card="<?=$entry->account_number?>" class="add-verify" href="javascript:;">提现确认</a> | <a data-id="<?=$entry->id?>" data-userid="<?=$entry->user_id?>" class="cancel-verify" href="javascript:;">提现取消</a><?php
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
                        <th scope="col" id="name" class="manage-column column-name">姓名</th>

                        <th scope="col" id="role" class="manage-column column-posts num">提现金额</th>
                        <th scope="col" id="role" class="manage-column column-posts num">手续费</th>
                        <th scope="col" id="role" class="manage-column column-posts num">取现类别</th>
                        <th scope="col" id="role" class="manage-column column-role">银行名称</th>
                        <th scope="col" id="role" class="manage-column column-role">卡号</th>
                        <th scope="col" id="role" class="manage-column column-role">提交时间</th>
                        <th scope="col" id="role" class="manage-column column-role">状态</th>
                        <th scope="col" id="role" class="manage-column column-role">操作</th>
                    </tr>
                    </tfoot>

                </table>
                <div class="tablenav bottom">



            </form>
            <?php

            $total = $wpdb->get_var( "SELECT COUNT(`id`) FROM {$wpdb->prefix}extract_money_log {$g_like}" );
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
                if(!confirm("请确认已把现金转到这个账户:"+_this.attr('data-card'))){
                    return false;
                }

                $.ajax({
                    type : 'POST',  //提交方式
                    dataType:'json',
                    url :"<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>",//路径
                    data:{'submit_type':'confirm','id':_this.attr('data-id'),'user_id':_this.attr('data-userid'),'action':'account/withdraw/withdrawConfirm'},//
                    success : function(data) {//返回数据根据结果进行相应的处理

                        if ( data.status == 'y') {
                            alert(data.info);
                            window.history.go(0);
                        } else {
                            alert(data.info);
                        }
                    }
                });
                return false;

            });

            $(".cancel-verify").on("click",function(){

                var _this = $(this);
                var cancel_content = prompt("请输入取消理由", ""); //将输入的内容赋给变量 name ，

                //这里需要注意的是，prompt有两个参数，前面是提示的话，后面是当对话框出来后，在对话框里的默认值
                if (cancel_content == null || cancel_content == undefined || cancel_content == '') {
                    return false;
                }

                $.ajax({
                    type : 'POST',  //提交方式
                    dataType:'json',
                    url :"<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>",//路径
                    data:{'cancel_content':cancel_content,'id':_this.attr('data-id'),'user_id':_this.attr('data-userid'),'action':'account/withdraw/withdrawCancel'},//
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

        </script>


        <?php
    }

    public function fun_menu1(){
            ?>
        <div class="wrap">
            <h1 id="add-new-user">用户取现设置</h1>


            <div id="ajax-response"></div>

            <p>新建用户，并将用户加入此站点。</p>
            <form method="post" name="createuser" id="createuser" class="validate" novalidate="novalidate">
                <input name="action" type="hidden" value="createuser">
                <input type="hidden" id="_wpnonce_create-user" name="_wpnonce_create-user" value="33ef5a5f05"><input type="hidden" name="_wp_http_referer" value="/cp/ks/wp-admin/user-new.php"><table class="form-table">
                    <tbody><tr class="form-field form-required">
                        <th scope="row"><label for="user_login">用户名 <span class="description">（必填）</span></label></th>
                        <td><input name="user_login" type="text" id="user_login" value="" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60"></td>
                    </tr>
                    <tr class="form-field form-required">
                        <th scope="row"><label for="email">电子邮件 <span class="description">（必填）</span></label></th>
                        <td><input name="email" type="email" id="email" value=""></td>
                    </tr>
                    <tr class="form-field">
                        <th scope="row"><label for="first_name">名字 </label></th>
                        <td><input name="first_name" type="text" id="first_name" value=""></td>
                    </tr>
                    <tr class="form-field">
                        <th scope="row"><label for="last_name">姓氏 </label></th>
                        <td><input name="last_name" type="text" id="last_name" value=""></td>
                    </tr>
                    <tr class="form-field">
                        <th scope="row"><label for="url">站点</label></th>
                        <td><input name="url" type="url" id="url" class="code" value=""></td>
                    </tr>
                    <tr class="form-field form-required user-pass1-wrap">
                        <th scope="row">
                            <label for="pass1-text">
                                密码				<span class="description hide-if-js">（必填）</span>
                            </label>
                        </th>
                        <td>
                            <input class="hidden" value=" "><!-- #24364 workaround -->
                            <button type="button" class="button wp-generate-pw hide-if-no-js">显示密码</button>
                            <div class="wp-pwd hide-if-js" style="display: none;">
								<span class="password-input-wrapper show-password">
					<input type="password" name="pass1" id="pass1" class="regular-text strong" autocomplete="off" data-reveal="1" data-pw="33goQxykfVKqXe8LYFnFB@sT" aria-describedby="pass-strength-result" disabled=""><input type="text" id="pass1-text" name="pass1-text" autocomplete="off" class="regular-text strong" disabled="">
				</span>
                                <button type="button" class="button wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="隐藏密码">
                                    <span class="dashicons dashicons-hidden"></span>
                                    <span class="text">隐藏</span>
                                </button>
                                <button type="button" class="button wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="取消密码修改">
                                    <span class="text">取消</span>
                                </button>
                                <div style="" id="pass-strength-result" aria-live="polite" class="strong">强</div>
                            </div>
                        </td>
                    </tr>
                    <tr class="form-field form-required user-pass2-wrap hide-if-js" style="display: none;">
                        <th scope="row"><label for="pass2">重复密码 <span class="description">（必填）</span></label></th>
                        <td>
                            <input name="pass2" type="password" id="pass2" autocomplete="off" disabled="">
                        </td>
                    </tr>
                    <tr class="pw-weak" style="display: none;">
                        <th>确认密码</th>
                        <td>
                            <label>
                                <input type="checkbox" name="pw_weak" class="pw-checkbox">
                                确认使用弱密码			</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">发送用户通知</th>
                        <td>
                            <input type="checkbox" name="send_user_notification" id="send_user_notification" value="1" checked="checked">
                            <label for="send_user_notification">向新用户发送有关账户详情的电子邮件。</label>
                        </td>
                    </tr>
                    <tr class="form-field">
                        <th scope="row"><label for="role">角色</label></th>
                        <td><select name="role" id="role">

                                <option selected="selected" value="subscriber">订阅者</option>
                                <option value="contributor">投稿者</option>
                                <option value="author">作者</option>
                                <option value="editor">编辑</option>
                                <option value="administrator">管理员</option>			</select>
                        </td>
                    </tr>
                    </tbody></table>


                <p class="submit"><input type="submit" name="createuser" id="createusersub" class="button button-primary" value="添加用户"></p>
            </form>
        </div>
<?php
    }


}
new withdraw_calss();
?>