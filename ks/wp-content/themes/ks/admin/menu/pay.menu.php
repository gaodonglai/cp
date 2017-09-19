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
            /*
            $role = 'test2';//权限名
            $wp_roles->add_cap('administrator', $role);//为管理员添加编辑商品权限
            $GLOBALS['role_list'][$role] = '测试2';*/

        }
    }


    public function add_pay_menu() {

        add_menu_page('充值管理','充值管理','pay','pay',array($this,'fun_menu'),'',210);
        add_submenu_page('pay','充值记录','充值记录','pay_log','pay_log',array($this,'fun_menu1'));
       /*
        add_submenu_page('test','测试2','测试2','test2','test2',array($this,'menu_tes2'));*/

    }

    public function fun_menu(){
        $status = array('y'=>'充值成功','n'=>'失败','s'=>'待确认');

        echo "<h1>充值申请</h1>";
        global $wpdb;
        $like = $_GET['like'];
        if($like){
            $g_like = "WHERE b.user_name LIKE '%{$like}%' or b.nick_name LIKE '%{$like}%'";
        }

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 10;
        $offset = ( $pagenum - 1 ) * $limit;
        $entries = $wpdb->get_results( "SELECT a.*,b.user_name,b.nick_name,b.user_money FROM {$wpdb->prefix}artificial_pay as a inner JOIN {$wpdb->prefix}account as b on a.user_id = b.user_id $g_like ORDER BY  `id` DESC   LIMIT $offset, $limit " );
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">用户列表</h1>

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

                        <th scope="col" id="role" class="manage-column column-posts num">余额</th>
                        <th scope="col" id="role" class="manage-column column-role">本次充值金额</th>
                        <th scope="col" id="role" class="manage-column column-role">本次充值时间</th>
                        <th scope="col" id="role" class="manage-column column-posts num">状态</th>
                        <th scope="col" id="role" class="manage-column column-role">提交时间</th>
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

                                <td class="user_id column-user_id" data-colname="余额"><?=$entry->user_money?></td>

                                <td class="user_id column-user_id" data-colname="本次充值金额"><?=$entry->pay_money?></td>
                                <td class="user_id column-user_id" data-colname="注册时间"><?=$entry->time?></td>
                                <td class="user_id column-user_id" data-colname="状态"  ><?=$status[$entry->status]?><?=$entry->status == 'n' ? '<span title="'.$entry->remarks.'" class="dashicons dashicons-editor-help"></span>' : ''?></td>
                                <td class="user_id column-user_id" data-colname="提交时间"><?=$entry->time?></td>
                                <td class="user_id column-user_id" data-colname="操作">
                                    <?php
                                    if($entry->status == 's'){
                                        ?><span data-money="<?=$entry->pay_money?>" data-id="<?=$entry->id?>" class="add-verify wp-menu-image dashicons-before dashicons-admin-generic"></span><?php
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
                        <th scope="col" id="role" class="manage-column column-posts num">余额</th>
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
                if(!confirm("请确认账户已收到:"+_this.attr('data-money'))){
                    return false;
                }

                $.ajax({
                    type : 'POST',  //提交方式
                    dataType:'json',
                    url :"<?=get_stylesheet_directory_uri().'/admin/ajax.php'?>",//路径
                    data:{'pay_money':_this.attr('data-money'),'id':_this.attr('data-id'),'action':'account/pay/updaTeartificialPay'},//
                    success : function(data) {//返回数据根据结果进行相应的处理

                        if ( data.status == 'y') {

                        } else {
                            $.alerts(data.info)
                        }
                    }
                });
                return false;

            });

        </script>


        <?php

    }

    public function fun_menu1(){

        echo "<h1>充值管理</h1>";
        $orderMenu = new \admin\test\action\TestAction();
        $orderMenu->index();

    }

}
new pay_calss();
?>