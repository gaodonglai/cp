<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/26
 * Time: 14:01
 */
namespace admin\account\model;

class DrpModel
{

    function __construct()
    {

        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = $this->wpdb->prefix;

    }

    /**
     * 插入信息
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function insertDrpInfo($table,$data_array){
        return $this->wpdb->insert($this->table.$table,$data_array);

    }

    /**
     * 更新信息
     * @param $data_array
     * @param $where_clause
     * @return mixed
     */
    public function updateDrpInfo($table,$data_array,$where_array){
        return $this->wpdb->update($this->table.$table,$data_array,$where_array);

    }


}