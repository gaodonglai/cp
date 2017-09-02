<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2016/1/27
 * Time: 16:54
 */

namespace libraries\util;
use entity\items\ItemsAttributeList;
use libraries\db\Sql;

/**
 * Class 普通分页
 * @package libraries\util
 */
class SkipPaging extends Sql
{

    public $offset ='';        //偏移位置
    public $limit = -1;    //默认显示十五个内容
    public $sum='';        //总数
    public $pagenum = '';   //页数




    /**
     * 获取页面总数，获取偏移后的内容。
     * array('table'=>'','where'=>'') 以数组方式查询。
     * $object 实例化需要查询的类。
     * @param $object/$array
     */
    public function change_to_quotes($str) {
                return sprintf("'%s'", $str);
    }
    public function ItemSkip(){
        add_action('items_pages',array($this,'linkClick'),10, 2 );
    }
   public function getContent($object,$where='',$asline=''){
       $Tthiss = $this;
       /*条件*/
        if($where) {
            $i=1;

            foreach($where['if'] as $v){

                $value = implode(',',array_map(array($this,'change_to_quotes'), $v['value'] ));
                if(empty($v['operator'])){
                    $v['operator'] = '=';
                }

                switch(strtoupper($v['operator'])){
                    case 'IN':
                        $value = "({$value})";
                    break;
                    default:
                        $value = $value;
                    break;

                };
                $value = "{$v['field']} {$v['operator']} {$value} ";


               if($i==1){
                   $wheres = $value;
                  $i++;
               }else{

                   $wheres .= "{$where['relation']} $value";
               }
            }

            $Tthiss = $Tthiss->where($wheres);

        }

       /*分页*/
       if($this->limit != '-1'){
           //获取分页数
           $this->pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
           $this->offset = ( $this->pagenum - 1 ) * $this->limit;
           if($asline){
               $asline2 = clone $asline;
           }
            if($_GET['page'] == 'order' || $_GET['page'] == 'orderRefund' || $_GET['page'] == 'items' ){
                $this->sum =  $asline->field('count(*) as num')->getVar()->select($object);
            }else{
                $this->sum =  $Tthiss->field('count(*) as num')->getVar()->select($object);
            }


           if($wheres){
               $Tthiss = $Tthiss->where($wheres);
           }
           $Tthiss = $Tthiss->limit($this->offset,$this->limit);
            if($this->sum>0):
                add_action('items_pages',array($this,'linkClick')); 
            endif;
       }

        if($_GET['page'] == 'itemsVariables'){
           return $Tthiss->order('i_at_id DESC')->select($object);
       }else if($_GET['page'] == 'order' || $_GET['page'] == 'orderRefund'){
           $res = $asline2->limit($this->offset,$this->limit)->order('a.o_id desc')->select($object);
           return $res;
       }else if($_GET['page'] == 'items'){
           $res = $asline2->limit($this->offset,$this->limit)->select($object);
           return $res;
       }else{
           return $Tthiss->order('i_term_id DESC')->select($object);
       }

    }

    /**
     * 分页按钮
     */
    public function linkClick($type='',$position=''){

        $num_of_pages = ceil( $this->sum / $this->limit );
        switch($type){
            case '1':
                $pagenum = $this->pagenum;
                $next = $pagenum+1;
                $prev = $pagenum-1;
                $f_p_prev = array(
                    'first' =>array('1','2','«'),
                    'prev' =>array($prev,'1','‹')
                );
                $f_p_next = array(
                    'next' =>array($next,$num_of_pages,'›'),
                    'last' =>array($num_of_pages,$num_of_pages-1,'»'),
                );
                ?>
                <div class="tablenav-pages">
                    <span class="displaying-num"><?=$this->sum;?>项目</span>
                    <?php if($num_of_pages>1):?>
                    <span class="pagination-links">
                    <?php
                        foreach($f_p_prev as $k=>$v){
                            if($pagenum>$v[1]){
                                echo '<a class="'.$k.'-page" href="'.add_query_arg( 'pagenum', $v['0'] ).'">';
                                echo '<span aria-hidden="true">'.$v['2'].'</span>';
                                echo '</a> ';
                            }else{
                                echo '<span class="tablenav-pages-navspan" aria-hidden="true">'.$v['2'].'</span> ';
                            }
                        }
                    ?>

                        <span class="paging-input">
                            第<label for="current-page-selector" class="screen-reader-text">当前页</label>
                            <?php if($position=='footer'){
                                echo $this->pagenum;
                            }else{?>
                                <input class="current-page" id="current-page-selector" type="text" name="pagenum" value="<?=$this->pagenum?>" size="1" aria-describedby="table-paging">
                            <?php
                            } ?>
                            页，
                            共<span class="total-pages"><?=$num_of_pages?></span>页
                        </span>
                    <?php
                        foreach($f_p_next as $k=>$v){
                            if($pagenum<$v[1]){
                                echo '<a class="'.$k.'-page" href="'.add_query_arg( 'pagenum', $v['0'] ).'">';
                                echo '<span aria-hidden="true">'.$v['2'].'</span>';
                                echo '</a> ';
                            }else{
                                echo '<span class="tablenav-pages-navspan" aria-hidden="true">'.$v['2'].'</span> ';
                            }
                        }
                    ?>
                    </span>
                <?php endif;?>
                </div>

                <?php
                break;
            default:
                $page_links = paginate_links( array(
                    'base' => add_query_arg( 'pagenum', '%#%' ),
                    'format' => '',
                    'prev_text' => __( '上一页', 'aag' ),
                    'next_text' => __( '下一页', 'aag' ),
                    'total' => $num_of_pages,
                    'current' => $this->pagenum
                ) );
                $page_links = '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' .$page_links . '</div></div>';
                return $page_links;
            break;
        }



    }

}