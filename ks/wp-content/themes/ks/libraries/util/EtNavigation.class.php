<?php

/**
 * 菜单类
 * User: ijita
 * Date: 2016/3/3
 * Time: 17:48
 */
class EtNavigation extends Walker_Nav_Menu
{
    public $styles = '';
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $display_depth = ($depth + 1);
        if($display_depth == '1') {
            $class_names = 'nav-sublist-dropdown';
            $container = 'container';
        } else {
            $class_names = 'nav-sublist';
            $container = '';
        }

        $indent = str_repeat("\t", $depth);

        $output .= "\n$indent<div class=".$class_names."><div class='".$container."'><ul>\n";
    }

}


class Et_Navigation_Mobile extends Walker_Nav_Menu
{

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        print_r($indent);
        $output .= "\n$indent<span class=\"open-child\"></span><ul class=\"sub_menu\">\n";
        $output .= "\n<li class=\"mobile_return_block\"><a href=\"javascript:;\">返回主菜单<i class=\"fa fa-angle-left fr\"></i></a></li>\n";

    }
}