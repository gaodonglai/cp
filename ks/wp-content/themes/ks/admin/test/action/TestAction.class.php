<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/26
 * Time: 14:01
 */
namespace admin\test\action;
use libraries\controller\AdminAction;

class TestAction extends AdminAction
{

    function __construct()
    {

        if(!is_user_logged_in()){
            die('用户未登录');
        }

    }

    /*活动列表*/
    public function index(){


/*        wp_enqueue_script( 'jqueryuijs', JS.'/jquery-ui/jquery-ui.js' );
        wp_enqueue_script( 'datepicker_zh', JS.'/jquery-ui/jquery.ui.datepicker-zh-CN.js' );
        wp_enqueue_script( 'timepicker_addon', JS.'/jquery-ui/jquery-ui-timepicker-addon.js' );
        wp_enqueue_script( 'timepicker_zh', JS.'/jquery-ui/jquery-ui-timepicker-zh-CN.js' );*/

        $this->display('test/index');

        
    }



}