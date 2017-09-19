<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 21:18
 */

namespace Model;


class Index
{

     public function activity(){
         get_header_front();
         display_show('activity');
         get_footer_front();
     }

    public function help(){
        get_header_front();
        display_show('help');
        get_footer_front();
     }

    public function Trendchart(){
        get_header_front();
        display_show('Trendchart');
        get_footer_front();
     }

}