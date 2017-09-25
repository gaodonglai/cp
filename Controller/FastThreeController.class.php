<?php
/**
 * 快三控制器
 * ijitao
 * 20170913
 */
namespace Controller;

class FastThree
{
    function __construct()
    {
        //加载model
        $this->model = new \Model\FastThree();

    }

    /**
     * 快三列表界面
     */
    function main()
    {
        header("Content-type: text/html; charset=utf-8");
        var_dump('快三入口界面');
        $FastThree = $this->model->get_probability();
        var_dump($FastThree);

    }

    /**
     * 快三详情页面
     */
    function view()
    {
        $ksId = $_GET['ks'];
        if(empty($ksId)) {
            exit('404');
        }
        $args = array();
        $ks = $this->model->get_FastThree($ksId);
        $args['ks'] = $ks;

        $args['lottery'] = $this->model->get_lotterys();
        /*概率*/
        $get_probability = $this->model->get_probability();
        $g_p = array();
        foreach ($get_probability as $v){
            if(!$g_p[$v->bt_id]){
                $a = array(
                    'bt_id'         =>  $v->bt_id,
                    'bt_name'       =>  $v->bt_name,
                    'bt_type'       =>  $v->bt_type,
                    'bt_content'    =>  $v->bt_content
                );
                $g_p[$v->bt_id] = $a;
            }
            $g_p[$v->bt_id]['odds'][$v->odds_alias] = array(
                'odds_id'       =>  $v->odds_id,
                'odds_name'     =>  $v->odds_name,
                'odds_alias'    =>  $v->odds_alias,
                'odds'          =>  $v->odds
            );
           // $g_p[$v->bt_id][$v->odds_id] = $v;
        }
        $args['get_probability'] = $g_p;
        get_header_front('', $ks->name);
        display_show('fastthree_view',$args);
        $js = array(
            'pc/js//flipclock.min.js',
            'pc/js/fastthree_view.js',
        );
        get_footer_front('',$js);
    }

    /**
     * 走势图
     */
    function trendchart(){
        $lottery = $this->model->get_lotterys();

        $ksId = is_numeric($_GET['ks'])?$_GET['ks']:$lottery[0]->id;
        $args['ks'] = $this->model->get_lottery_periods($ksId,'1','50');
        $args['lottery'] = $lottery;
        $lottery = array_column($lottery, 'name','id');

        get_header_front('',$lottery[$ksId].'走势图');
        display_show('Trendchart',$args);
        get_footer_front();
    }

    /**
     * ajax请求 近期投注
     */
    public function Recent_bets(){

        $c_id = get_user_id();
        $lottery = $_POST['lottery'];
        if(!$c_id || !$lottery){
            exit(json_encode(array('status'=>0,'info'=>'','msg'=>'false')));
        }
        $data = array(
            'c_id'      =>  get_user_id(),
            'lottery'   =>  $lottery

        );
        $info = $this->model->get_bet_list($data);
        if(!$info){
            exit(json_encode(array('status'=>0,'info'=>'','msg'=>'false')));
        }
        exit(json_encode(array('status'=>1,'info'=>$info,'msg'=>'true')));
    }

    /**
     * ajax请求 近期开奖
     */
    public function Recent_lottery(){

        $lottery = $_POST['lottery'];
        if(!$lottery){
            exit(json_encode(array('status'=>0,'info'=>'','msg'=>'false')));
        }

        $info = $this->model->get_lottery_periods($lottery);
        if(!$info){
            exit(json_encode(array('status'=>0,'info'=>'','msg'=>'false')));
        }
        exit(json_encode(array('status'=>1,'info'=>$info,'msg'=>'true')));
    }
}
?>