<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/22
 * Time: 10:19
 */

namespace app\member\model;


use libraries\db\Sql;

class RegisterModel extends Sql
{

    /*单条信息获取*/
    public  function selectOne($obj,$where){
        return $this->where($where)->getRow()->select($obj);
    }

   /*用户注册*/
    function register($object){

        return $this->save($object,true);

    }

}