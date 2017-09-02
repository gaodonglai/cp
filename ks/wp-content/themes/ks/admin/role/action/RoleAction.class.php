<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/26
 * Time: 14:01
 */
namespace admin\role\action;
use libraries\controller\AdminAction;

class RoleAction extends AdminAction
{
    function __construct()
    {

    }

    /*角色列表*/
    function main()
    {
        $this->display('role/role');
    }
    /*添加角色*/
    function RoleAdd()
    {
        $this->display('role/RoleAdd');
    }

}