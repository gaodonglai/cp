<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 18:05
 */

namespace Controller;


class Index extends \Model\Index
{
    function main(){
         $this->getIndexInfo();
        /*$mIdex = new \Model\Index();
        $mIdex->getIndexInfo();*/

        get_header_front();
        display_show('index');
        get_footer_front();

    }

    function query(){
        echo '777';
    }

}