<?php
/**
 * 首页
 */
$action = new \libraries\controller\Action();
$action->css('index/home');
$action->js('index/home');
get_header();

$action->display('inline/index');

get_footer();
?>
