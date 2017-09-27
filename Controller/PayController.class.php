<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/23
 * Time: 18:05
 * 银行卡与提现管理
 */

namespace Controller;


class Pay
{
    public $model;
    public $user_info;

    function __construct(){

        $this->user_info = get_user_info();
        //如果没有登录跳转到登录页面
        if(!$this->user_info){
            redirect(_get_home_url('?show=login'));
        }
        $this->model = new \Model\Pay();

    }

    /**
     * 人工充值审核提交
     */
    function setArtificialPay(){
        //rand(10,100)
        if(in_array("",$_POST)){
            exit(json_encode(array('status'=>'n','info'=>'请完善信息')));
        }
        $type = $_POST['type'];
        if(!in_array($type,array('bank','wechat','alipay'))){
            exit(json_encode(array('status'=>'n','info'=>'请完成支付类型的选择')));
        }

        $money = $_POST['pay_money'];
        if(!is_numeric($money)){
            exit(json_encode(array('status'=>'n','info'=>'请填写金额')));
        }

        //这段代码只是为了做一些简单的防重复，足够用了。
        $flag = 1;
        while($flag <100) {
            $pay_money = $money.'.'.rand(10,99);
            $getToday = $this->model->getTodayPayMoney($pay_money);
            if(empty($getToday)){
                break;
            }

            if($flag == 99){
                exit(json_encode(array('status'=>'n','info'=>'抱歉今天充值的'.$money.'数额已经不能再进行充值')));
            }
            $flag++;
        }

        $user_id = $this->user_info->user_id;
        $args = array(
            'user_id'=>$user_id,
            'pay_type'=>$type,
            'pay_money'=>$pay_money,
            'time'=>date('Y-m-d H:i:s',time())
        );

        $result = $this->model->insertPyaInfo('artificial_pay',$args);

        if($result){

            if($type == 'bank'){
                $pathering_bank = get_option('admin_pathering_bank');//获取银行卡
                if($pathering_bank){
                    $count = count($pathering_bank);

                    if($count == 1){
                        $rand = 0;
                    }else{
                        $rand = rand(0,$count);
                    }
                    $pathering_bank = $pathering_bank[$rand];

                }
                $content = '<div class="blankRemittance"> 
                                <div class="blankRemittance_bg"> 
                                    <ul>
                                         <li><img src="'._get_home_url().'View/pc/image/icon_h_recharge.png"  class="icon_h_recharge"><span class="h_title">充值列表</span></li> 
                                         <li class=""> <p>银行：<span class="">'.$pathering_bank['bank_name'].'</span></p> </li>
                                         <li class=""> <p>卡号：<span class="">'.$pathering_bank['bank_card'].'</span></p> </li>
                                         <li class=""> <p>姓名：<span class="">'.$pathering_bank['bank_nickname'].'</span></p> </li>
                                         <li class=""> <p>充值金额：<span class="h_title">'.$pay_money.'</span>请按照本次显示的金额往以上的账户进行转账，以便快速确认</p> </li>
                            
                                   </ul>
                                </div>
                         </div>';

                exit(json_encode(array('status'=>'y','info'=>$content)));
            }else{

            }
        }else{
            exit(json_encode(array('status'=>'n','info'=>'添加失败，请重试')));
        }



    }



}