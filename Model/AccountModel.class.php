<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 21:18
 */

namespace Model;


class Account
{

     function __construct()
     {

          global $wpdb;
          $this->wpdb = $wpdb;

     }

}