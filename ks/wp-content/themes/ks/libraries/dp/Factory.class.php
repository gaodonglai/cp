<?php
namespace libraries\dp;

class Factory
{
    static $proxy = null;

    /**
     * @param $name
     * @return bool
     */
    static function getModel($name)
    {
        // $key = 'app_model_'.$name;
        $key = $name;

        $model = Register::get($key);
        //如果注册树中不存在对象字段进入新建一个
        if (!$model) {

            $model = new $name;
            Register::set($key, $model);
        }
        return $model;
    }

}