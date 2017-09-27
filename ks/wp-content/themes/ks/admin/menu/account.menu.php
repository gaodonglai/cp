<?php
/**
 * test
 */
class order_account_calss{
    public function __construct()
    {
        add_action('admin_menu',array($this,'add_account_menu'));
        add_action('load-themes.php',array($this,'add_account_menu_role'));//模板加载时
    }


    public function add_account_menu_role(){
        global $pagenow,$wp_roles;
         //判断是否为激活主题页面
        if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

            $role = 'account';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '用户管理';

            $role = 'account_add';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '添加用户';
            /*$role = 'test1';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试1';

            $role = 'test2';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试2';*/

        }
    }


    public function add_account_menu() {

        add_menu_page('用户管理','用户管理','account','account',array($this,'fun_menu'),'',204);
        add_submenu_page('account','添加用户','添加用户','account_add','account_add',array($this,'fun_menu1'));

       /* add_submenu_page('test','测试1','测试1','test1','test1',array($this,'menu_test1'));
        add_submenu_page('test','测试2','测试2','test2','test2',array($this,'menu_tes2'));*/

    }

    public function fun_menu(){

        if($_GET['type'] == 'edit'){
            $this->edit();
            exit();
        }elseif ($_GET['type'] == 'pay'){
            $this->pay();
            exit();
        }

        global $wpdb;
        $like = $_GET['like'];
        if($like){
            $g_like = "WHERE user_name LIKE '%{$like}%' or nick_name LIKE '%{$like}%'";
        }

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 10;
        $offset = ( $pagenum - 1 ) * $limit;
        $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}account  $g_like ORDER BY  `ks_account`.`user_id` DESC   LIMIT $offset, $limit " );

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">用户列表</h1>

            <a href="?page=account_add" class="page-title-action">添加用户</a>

            <hr class="wp-header-end">

            <h2 class="screen-reader-text">过滤用户列表</h2>
            <form action="<?=add_query_arg()?>" method="get">
                <input type="hidden" id="user-search-input" name="page" value="account">
                <p class="search-box">
                    <label class="screen-reader-text" for="user-search-input">搜索用户:</label>
                    <input type="search" id="user-search-input" name="like" value="">
                    <input type="submit" id="search-submit" class="button" value="搜索用户"></p>

                    <div class="alignleft actions bulkactions">
                        <label for="bulk-action-selector-top" class="screen-reader-text">选择批量操作</label><select name="action" id="bulk-action-selector-top">
                            <option value="-1">批量操作</option>
                            <option value="delete">删除</option>
                        </select>
                        <input type="submit" id="doaction" class="button action" value="应用">
                    </div>

                <h2 class="screen-reader-text">用户列表</h2><table class="wp-list-table widefat fixed striped users">
                    <thead>
                        <tr>
                            <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                            <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="javascript:;"><span>用户名</span><span class="sorting-indicator"></span></a></th>
                            <th scope="col" id="name" class="manage-column column-name">姓名</th>
                            <th scope="col" id="email" class="manage-column column-email sortable desc"><a href="javascript:;"><span>电子邮件</span><span class="sorting-indicator"></span></a></th>
                            <th scope="col" id="role" class="manage-column column-role">余额</th>
                            <th scope="col" id="role" class="manage-column column-role">注册时间</th>
                        </tr>
                    </thead>

                    <tbody id="the-list" data-wp-lists="list:user">
                        <?php if( $entries ) { ?>

                            <?php
                            $count = 1;
                            $class = '';
                            foreach( $entries as $entry ) {
                                ?>
                                <tr id="user-1"><th scope="row" class="check-column">
                                    <td class="username column-username has-row-actions column-primary" data-colname="用户名"><strong>
                                            <a href="javascript:;"><?=$entry->user_name?></a>
                                            </strong><br>
                                        <div class="row-actions"><span class="edit">
                                            <a href="?page=account&type=edit&user_id=<?=$entry->user_id?>">编辑</a> </span>
                                            |
                                            <a href="?page=account&type=pay&user_id=<?=$entry->user_id?>">人工充值</a> </span>
                                        </div>
                                        <button type="button" class="toggle-row"><span class="screen-reader-text">显示详情</span></button>
                                    </td>
                                    <td class="name column-name" data-colname="姓名"><?=$entry->nick_name?></a></td>
                                    <td class="email column-email" data-colname="邮箱"><a href="javascript:;"><?=$entry->email?></a></td>
                                    <td class="user_id column-user_id" data-colname="余额"><?=$entry->user_money?></td>
                                    <td class="user_id column-user_id" data-colname="注册时间"><?=date('Y-m-d H:i:s',$entry->reg_time)?></td>
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
                        <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"><a href="javascript:;"><span>用户名</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="name" class="manage-column column-name">姓名</th>
                        <th scope="col" id="email" class="manage-column column-email sortable desc"><a href="javascript:;"><span>电子邮件</span><span class="sorting-indicator"></span></a></th>
                        <th scope="col" id="role" class="manage-column column-role">余额</th>
                        <th scope="col" id="role" class="manage-column column-role">注册时间</th>

                    </tr>
                    </tfoot>

                </table>
                <div class="tablenav bottom">

                    <div class="alignleft actions bulkactions">
                        <label for="bulk-action-selector-bottom" class="screen-reader-text">选择批量操作</label><select name="action2" id="bulk-action-selector-bottom">
                            <option value="-1">批量操作</option>
                            <option value="delete">删除</option>
                        </select>
                        <input type="submit" id="doaction2" class="button action" value="应用">
                    </div>

            </form>
            <?php

            $total = $wpdb->get_var( "SELECT COUNT(`user_id`) FROM {$wpdb->prefix}account {$g_like}" );
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

    public function fun_menu1(){
        ?>
        <div class="wrap">
            <h1 id="add-new-user">添加用户</h1>

            <div id="ajax-response"></div>

            <form action="<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>" method='post' name="createuser" id="createuser" class="adminAjaxPost validate" novalidate="novalidate">
                <input type="hidden" name='action' value="account/account/setAccount" />
                <table class="form-table">
                    <tbody><tr class="form-field form-required">
                        <th scope="row"><label for="user_login">用户名 <span class="description"></span></label></th>
                        <td><input name="user_name" type="text" id="user_login" value="" placeholder="" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60">
                            <p class="description" id="tagline-description">手机号或邮箱</p></td>

                    </tr>
                    <tr class="form-field form-required">
                        <th scope="row"><label for="password">密码 <span class="description"></span></label></th>
                        <td><input placeholder="" name="user_pass" type="text" id="email" value=""><p class="description" id="tagline-description">6-18位的数字加字母</p></td>

                    </tr>
                    <tr class="form-field form-required">
                        <th scope="row"><label for="re_password">重复密码 <span class="description"></span></label></th>
                        <td><input placeholder="" name="user_rePass" type="text" id="email" value=""> <p class="description" id="tagline-description">6-18位的数字加字母</p></td>

                    </tr>
                    </tbody></table>
                <p class="submit"><input type="submit" name="createuser" id="createusersub" class="button button-primary" value="添加用户"></p>
            </form>
        </div>

        <script src="<?= JS;?>/jquery2.1.1.min.js"></script>
        <script src="<?= JS;?>/public.js"></script>
<?php
    }



    function edit(){
       $user_id =  $_GET['user_id'];

        global $wpdb;
        $get_account = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}account where user_id = $user_id" );

        ?>
        <div class="wrap" id="profile-page">
            <h1 class="wp-heading-inline">用户资料</h1>


            <hr class="wp-header-end">

            <form  action="<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>" method="post" class="adminAjaxPost" novalidate="novalidate">

                <input type="hidden" name="action" value="account/account/updateAccount">
                <input type="hidden" name="user_id" value="<?=$user_id?>">
                <h2>设置</h2>
                <table class="form-table">
                    <tbody><tr class="user-user-login-wrap">
                        <th><label for="user_login">用户名</label></th>
                        <td><input type="text" name="user_name" value="<?=$get_account->user_name?>" disabled="disabled" class="regular-text"> <span class="description">用户名不可更改。</span></td>
                    </tr>


                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">姓名</label></th>
                        <td><input type="text" name="nick_name" value="<?=$get_account->nick_name?>" class="regular-text"></td>
                    </tr>

                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">密保问题</label></th>
                        <td><input type="text" name="question"  value="<?=$get_account->question?>" class="regular-text"></td>
                    </tr>
                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">密保答案</label></th>
                        <td><input type="text" name="answer" value="<?=$get_account->answer?>" class="regular-text"></td>
                    </tr>

                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">年龄</label></th>
                        <td><input type="text" name="sex"value="<?=$get_account->sex?>" class="regular-text"></td>
                    </tr>

                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">生日</label></th>
                        <td><input type="text" name="birthday"value="<?=$get_account->birthday?>" class="regular-text"></td>
                    </tr>


                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">消费积分</label></th>
                        <td><input type="text" name="pay_points"value="<?=$get_account->pay_points?>" class="regular-text"></td>
                    </tr>


                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">等级积分</label></th>
                        <td><input type="text" name="rank_points"value="<?=$get_account->rank_points?>" class="regular-text"></td>
                    </tr>


                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">上级经销商id</label></th>
                        <td><input type="text" name="parent_id"value="<?=$get_account->parent_id?>" class="regular-text"></td>
                    </tr>

                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">手机号</label></th>
                        <td><input type="text" name="mobile_phone"value="<?=$get_account->mobile_phone?>" class="regular-text"></td>
                    </tr>
                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">qq</label></th>
                        <td><input type="text" name="qq"value="<?=$get_account->qq?>" class="regular-text"></td>
                    </tr>
                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">手机号</label></th>
                        <td><input type="text" name="mobile_phone"value="<?=$get_account->mobile_phone?>" class="regular-text"></td>
                    </tr>

                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">用户密码</label></th>
                        <td><input type="text" name="password" value="" class="regular-text"><span class="description">谨慎操作，填入修改后用户将无法登录</span></td>
                    </tr>

                    <table class="form-table">

                        <tr class="show-admin-bar user-admin-bar-front-wrap">
                            <th scope="row">是否验证</th>
                            <td><fieldset><legend class="screen-reader-text"><span>工具栏</span></legend>
                                    <label for="admin_bar_front">
                                        <input name="is_validated" type="checkbox"  value="1" checked="checked">
                                        取消可让用户无法登录</label><br>
                                </fieldset>
                            </td>
                        </tr>


                    </table>

                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="更新个人资料"></p>
            </form>
        </div>
        <script src="<?= JS;?>/jquery2.1.1.min.js"></script>
        <script src="<?= JS;?>/public.js"></script>
       <?php
    }

    function pay(){
        $user_id =  $_GET['user_id'];

        global $wpdb;
        $get_account = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}account where user_id = $user_id" );

        ?>
        <div class="wrap" id="profile-page">
            <h1 class="wp-heading-inline">人工充值</h1>


            <hr class="wp-header-end">

            <form  action="<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>" method="post" class="pay-verify" novalidate="novalidate">

                <input type="hidden" name="action" value="account/account/payAccount">
                <input type="hidden" name="user_id" value="<?=$user_id?>">

                <table class="form-table">
                    <tbody><tr class="user-user-login-wrap">
                        <th><label for="user_login">用户名</label></th>
                        <td><input type="text" name="user_name" value="<?=$get_account->user_name?>" disabled="disabled" class="regular-text"> <span class="description">用户名不可更改。</span></td>
                    </tr>

                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">充值金额</label></th>
                        <td><input type="number" name="pay_money" value="" class="regluar-text ltr"></td>
                    </tr>

                    <table class="form-table">

                        <tr class="show-admin-bar user-admin-bar-front-wrap">
                            <th scope="row">是否参与活动</th>
                            <td><fieldset><legend class="screen-reader-text"><span>工具栏</span></legend>
                                    <label for="admin_bar_front">
                                        <input name="is_activity" type="checkbox"  value="1" checked="checked">
                                        取消后用户本次充值不参与充值活动</label><br>
                                </fieldset>
                            </td>
                        </tr>


                    </table>

                    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="充 值"></p>
            </form>
        </div>
        <script src="<?= JS;?>/jquery2.1.1.min.js"></script>
        <script>

            $(".pay-verify").on("submit",function(){
                var _this = $(this);
                var pay_money = $('input[name=pay_money]').val();

                if(!confirm("请确认充值金额："+pay_money+ "元")){
                    return false;
                }

                $.ajax({
                    type : 'POST',  //提交方式
                    dataType:'json',
                    url :"<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>",//路径
                    data:_this.serializeArray(),//
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

}
new order_account_calss();
?>