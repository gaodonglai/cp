<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 21:18
 */

namespace Model;


class FastThree
{
    function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->prefix = $wpdb->prefix;

    }

    /**
     * 获取彩票
     * @param string $start
     * @param string $limit
     * @return array|null|object
     */
    public function get_lotterys($start='1',$limit=''){
        $sql = "SELECT * FROM `{$this->prefix}lottery` l ";
        $sql .= "order by l.sort,l.id desc ";
        if($limit){
            $start = ($start-1)*$limit;
            $sql .= "limit {$start},{$limit}";
        }

        return $this->wpdb->get_results($sql,ARRAY_A);
    }
    /**
     * 获取所有的有效彩票
     * @param string $start
     * @param string $limit
     * @return array|null|object
     */
    public function get_FastThrees($start='1',$limit='20'){
        $sub_sql = "SELECT * FROM `{$this->prefix}lottery_period` ";
        $sub_sql .= "where p_state='y' order by p_id desc";
        $sql = "SELECT * FROM `{$this->prefix}lottery` l ";
        $sql .= "left join ({$sub_sql}) lp on lp.lottery = l.id ";
        $sql .= "group by l.id order by l.sort,l.id desc ";
        $start = ($start-1)*$limit;
        $sql .= "limit {$start},{$limit}";
        return $this->wpdb->get_results($sql);
    }

    /**
     * @param $ksid 彩票id
     * @return array|bool|null|object|void
     * 根据彩票id获取最新不能投注彩票期号
     */
    public function get_FastThree($ksid){
        if(!is_numeric($ksid)) return false;
        $sql = "SELECT * FROM `{$this->prefix}lottery` l ";
        $sql .= "left join `{$this->prefix}lottery_period` lp on lp.lottery = l.id and lp.p_state in('y','s')";
        $sql .= "WHERE l.id ={$ksid} ";
        $sql .= "order by lp.p_id desc ";
        return $this->wpdb->get_row($sql);
    }

    /**
     * 根据彩票id获取最新的期号
     * @param $ksid 彩票id
     * @param string $p_state 状态，y：开奖，s:开奖中,n：未开奖；ys
     * @return array|bool|null|object|void
     */
    public function get_lottery_period($ksid,$p_state=''){
        if(!is_numeric($ksid)) return false;
        $sql = "SELECT * FROM `{$this->prefix}lottery_period` ";
        $sql .= "WHERE lottery ={$ksid} ";
        if(!empty($p_state)){
            if($p_state=='ys'){
                $sql .= "and p_state in('y','s') ";
            }else{
                $sql .= "and p_state='{$p_state}' ";
            }

        }
        $sql .= "order by p_id desc";
        return $this->wpdb->get_row($sql);
    }

    /**
     * 根据彩票id获取期数
     * @param $ksid
     * @param string $start
     * @param string $limit
     * @param string $p_state
     * @return array|bool|null|object
     */
    public function get_lottery_periods($ksid,$start='1',$limit='20',$p_state=''){
        if(!is_numeric($ksid)) return false;
        $sql = "SELECT * FROM `{$this->prefix}lottery_period` ";
        $sql .= "WHERE lottery ={$ksid} ";
        /*查询今天*/
        $limits = '';
        switch ($start){
            case 'today':/*今天*/
                $sql .= "and to_days(p_lottery_time) = to_days(now()) ";
                break;
            case 'yesterday':/*昨天*/
                $sql .= "and to_days(now()) - to_days(p_lottery_time) = 1 ";
                break;
            case 'daybeforeyesterday':/*昨天*/
                $sql .= "and to_days(now()) - to_days(p_lottery_time) = 2 ";
                break;
            default:
                $start = ($start-1)*$limit;
                $limits = "limit {$start},{$limit}";
                break;
        }
        if(!empty($p_state)){
            $sql .= "and p_state='{$p_state}' ";
        }
        $sql .= "order by p_id desc {$limits}";
        return $this->wpdb->get_results($sql,ARRAY_A);
    }

    /**
     * 获取投注
     * @param array $data
     * @return array|null|object
     */
    public function get_bet_list($data=array()){
        $sql = "SELECT * FROM `{$this->prefix}betting` b ";
        $sql .= "inner JOIN `{$this->prefix}lottery_period` lp on lp.p_id = b.betting_series ";
        $sql .= "inner JOIN `{$this->prefix}lottery` l on l.id = b.lottery ";
        $sql .= "inner JOIN `{$this->prefix}bet_type` bt on bt.bt_id = b.betting_type ";
        if($data) {
            $sql .= "WHERE ";
            $sqlarr=array();
            if($data['c_id']){
                $sqlarr[] = "b.c_id={$data['c_id']}";
            }
            if($data['lottery']){
                $sqlarr[] = "b.lottery={$data['lottery']}";
            }
            if($data['betting_series']){
                $sqlarr[] = "b.betting_series={$data['betting_series']}";
            }

            if($data['betting_type']){
                $sqlarr[] = "b.betting_type={$data['betting_type']}";
            }
            if($data['receive_status']){
                $sqlarr[] = "b.receive_status={$data['receive_status']}";
            }
            if($data['betting_state']){
                $sqlarr[] = "b.betting_state={$data['betting_state']}";
            }
            if($data['start_betting_time']){
                $sqlarr[] = "unix_timestamp(b.betting_time)>=unix_timestamp({$data['betting_time']})";
            }
            if($data['end_betting_time']){
                $sqlarr[] = "unix_timestamp(b.betting_time)<=unix_timestamp({$data['betting_time']})";
            }
            $sql .= join(' and ',$sqlarr);


        }
        $limit = $data['limit'] ? $data['limit'] : '20';
        $start =$data['start'] ? ($data['start']-1)*$limit : '1';
        $sql .= " limit {$start},{$limit}";
        //var_dump($sql);
        return $this->wpdb->get_results($sql);
    }
    /**
     * 获取快三概率
     */
    public function get_probability(){
        $sql = "SELECT * FROM `{$this->prefix}bet_type` bt ";
        $sql .= "inner JOIN `{$this->prefix}bt_odds` bo on bo.bt_id = bt.bt_id ";
        return $this->wpdb->get_results($sql);
    }

    /**
     * 获取概率
     * @param string $odds_id
     * @param bool $type 根据类型判断是概率id  还是投注类型id
     * @return array|bool|null|object
     */
    public function get_bt_odds($odds_id='',$type=false){
        if($odds_id && !is_numeric($odds_id)) return false;
        $sql = "SELECT * FROM `{$this->prefix}bt_odds` bo ";
        if($odds_id){
            if($type){
                $sql .= "where bo.bt_id = '{$odds_id}'";
            }else{
                $sql .= "where bo.odds_id = '{$odds_id}'";
            }

        }
        return $this->wpdb->get_results($sql);
    }

    /**
     * 根据彩票、期号、获取当前所有投注
     * @param $lottery
     * @param $betting_series
     * @return array|bool|null|object
     */
    public function get_betting($lottery,$betting_series){
        if(is_numeric($lottery) || !is_numeric($betting_series)) return false;
        $sql = "SELECT * FROM `{$this->prefix}betting` b ";
        $sql .= "where lottery = '{$lottery}' and betting_series='{$betting_series}'";
        return $this->wpdb->get_results($sql);
    }

    /**
     * 中奖了更新用户金额以及投注
     * @param $betting_id 投注id
     * @param $c_id 用户id
     * @param int $winning_money 中奖金额
     * @return bool
     */
    public function update_betting($betting_id,$c_id,$winning_money=0){
        $betting_state = 'n';
        if($winning_money>0){
            $betting_state = 'y';
            /*中奖*/
            $c_sql = "UPDATE `{$this->prefix}account` SET ";
            $c_sql .= "betting_money = betting_money+{$winning_money} ";
            $c_sql .= "where user_id='{$c_id}'";
            $c_return = $this->wpdb->query($c_sql);
            if(!$c_return) return false;
        }

        $sql = "UPDATE `{$this->prefix}betting` SET ";
        $sql .= "`betting_state`='{$betting_state}',
                `winning_money`='{$winning_money}',
                `p_state`='y' ";
        $sql .= "WHERE betting_id={$betting_id} and c_id='{$c_id}'";
        $return = $this->wpdb->query($sql);
        if($return){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $p_id
     * @param array $number 开奖号码
     * @return bool
     */
    public function update_lottery_period($p_id,$number=array()){
        if(!is_numeric($p_id)) return false;
        if(!is_array($number)) return false;
        $number = sort($number);
        $n1 = $number[0];
        $n2 = $number[1];
        $n3 = $number[2];
        /*和*/
        $sumvalue = $n1+$n2+$n3;
        /*开奖存储*/
        $p_number = implode(',',$number);/*开奖号码*/
        /*判断大小*/
        $p_size = $sumvalue>9?'y':'n';
        /*判断单双*/
        $p_odd_even = ($sumvalue%2==0)?'y':'n';

        /*三同号通选*/
        //$sthtx = ($n1==$n2 && $n1==$n3) ?true:false;
        /*三同号单选*/
        //$sthdx = $sthtx;
        /*三不同号*/
        //$sbth = ($n1!=$n2 && $n1!=$n3 && $n2!=$n3) ?true:false;
        /*三连号通选*/
        //$slhtx = ($n1+1==$n2 && $n2+1==$n3) ?true:false;
        /*二同号复选*/
        //$ethfx = ($n1==$n2 || $n2==$n3) ?true:false;
        /*二同号单选*/
        //$ethdx = $ethfx;
        /*二不同号*/
        //$ebth = $sthtx ? false : true;

        /*同号*/
        $p_age21 = ($n1==$n2 && $n1==$n3)?'y':'n';
        /*开奖时间*/
        $p_lottery_time = date('Y-m-d H:i:s',time());
        /*开启事务*/
        $this->model->wpdb->query("BEGIN");
        $sql = "UPDATE `{$this->prefix}lottery_period` SET ";
        $sql .= "`p_number`='{$p_number}',
                `p_odd_even`='{$p_odd_even}',
                `p_size`='{$p_size}',
                `p_age21`='{$p_age21}',
                `sumvalue`='{$sumvalue}',
                `p_state`='y',
                `p_lottery_time`='{$p_lottery_time}' ";
        $sql .= "WHERE p_id={$p_id}";
        $return = $this->wpdb->query($sql);
        if(!$return){
            /*回滚事务*/
            $this->wpdb->query("ROLLBACK");
            return false;
        }
        /*提交事务*/
        $this->wpdb->query("COMMIT");
        return true;
    }

    public function add_lottery_period($data=array())
    {
        if (!is_array($data)) return false;
        $date = date('Y-m-d h:i:s', time());
        $sql = "INSERT INTO `{$this->prefix}lottery_period` ";
        $sql = "(";
        $sqlv = "VALUES (";
        foreach ($data as $k => $v) {
            $sql .= "`{$k}`,";
            $sqlv .= "'{$v}',";
        }
        $sqlv .= "{$date})";
        $sql .= "`p_time`) {$sqlv}";
        /*开启事务*/
        $this->wpdb->query("BEGIN");

        $return = $this->wpdb->query($sql);
        if ($return) {
            /*提交事务*/
            $this->wpdb->query("COMMIT");
        } else {
            /*回滚事务*/
            $this->wpdb->query("ROLLBACK");
        }
    }
    public function my_bet(){
        $user_id = get_user_id();/*当前用户id*/
        $sql = "";
    }
    /*public function update_lottery_period($data=array())
    {
        if(!is_array($data)) return false;
        $date = date('Y-m-d h:i:s',time());
        $sql .= "p_time = '{$date}'";
        foreach ($data as $k=>$v){
            $sql .= ",{$k} = '{$v}'";
        }
        /*开启事务*//*
        $this->wpdb->query("BEGIN");

        $return = $this->wpdb->query($sql);
        if($return){
            /*提交事务*//*
            $this->wpdb->query("COMMIT");
        }else{
            /*回滚事务*//*
            $this->wpdb->query("ROLLBACK");
        }
    }*/

}