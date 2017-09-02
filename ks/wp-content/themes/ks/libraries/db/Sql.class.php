<?php

/**
 * Db_Abstract 数据库操作类
 *
 * @package Framework
 * @version $Id: Abstract.php 256 2008-03-16 19:20:53Z yan weidong $
 */
namespace libraries\db {


    use ReflectionClass;
    use ReflectionProperty;

    class Sql{

        private $field     = "*";    //输出内容
        private $tableName = "";     //表名
        private $where     = "";     //条件
        private $on        = "";     //条件
        private $order     = "";     //顺序
        private $limit     = "";     //条数

        private $show      = false;     //显示sql语句

        private $way = 1;   //查询方式 1.get_results 2.get_row 3.get_var 默认为1

        private $wpdb;
        private $prefix;

        /**
         * 查询完后初始化数据
         */
        private function close(){

            $this->field        = '*';
            $this->tableName    = '';
            $this->where        = '';
            $this->on           = '';
            $this->order        = '';
            $this->show         = false;
            $this->way          = 1;

        }

        /**
         * @return mixed
         */
        public function getPrefix()
        {
            return $this->prefix;
        }

        /**
         * @return mixed
         */
        public function getWpdb()
        {
            return $this->wpdb;
        }

        /*
         * 初始化表
         */
        public function __construct(){

            global $wpdb;
            $this->wpdb = $wpdb;
            $this->prefix = $wpdb->prefix;

        }

        /**
         * @param string $field
         * @return 输出字段添加
         */
        protected function field($field){
            if(empty($field)){
                exit('温馨提示：使用了field但是没有添加相应的显示字段名');
            }
            $this->field = $field;
            return $this;
        }

        /**
         * @param string $tableName
         * @return 表名添加
         */
        protected function table($tableName=''){

            if(empty($tableName)){
                exit('温馨提示：使用了table但是没有添加表名');
            }

            if(is_array($tableName)){

                foreach($tableName as $key=>$value){

                    $tableNames .= ' '.$this->prefix.$key .' as ' . $value .' ,';
                }


                $_tableName = substr($tableNames, 0, -1);
            }else{
                $_tableName = $tableName;
            }

            $this->tableName = $_tableName;
            return $this;

        }

        protected function order($order=''){
            if(empty($order)){
                exit('温馨提示：使用了order但是没有添加需要排序的条件');
            }
            $this->order = " ORDER BY ".$order;
            return $this;
        }

        protected function where($where=''){

            if(empty($where)){
                exit('温馨提示：使用了where但是没有添加条件');
            }
            $this->where = " WHERE ".$where;
            return $this;
        }

        protected function on($on=''){
            if(empty($on)){
                exit('温馨提示：使用了on但是没有添加条件');
            }
            $this->on = " on ".$on;
            return $this;
        }

         protected function limit($index, $limit = 0){

            $this->limit = " LIMIT ".$index;

            if($limit){
                $this->limit.= ",{$limit}";
            }

            return $this;
        }

        /**
         * @return 查询一个字段
         */
         protected function getVar(){

            $this->way = 3;

            return $this;
        }

        /**
         * @return 查询一行数据
         */
        protected function getRow(){

            $this->way = 2;

            return $this;
        }

        /**
         *
         * @return 显示sql
         */
        protected function showSql(){
            $this->show = true;

            return $this;
        }

        /**
         * @param $object
         * @return 查询/返回查询结果
         */
        protected function select($object=null,$output_type = ARRAY_A){
            //如果对象存在使用对象作为条件
            if($object){
                $arr = self::_reflectionClass($object);//使用反射机制为条件赋值

                if(empty($this->tableName)){

                    $this->tableName = $this->prefix.$arr['table'];

                }
               /* $values = '';

                foreach($arr['arr'] as $key => $value){

                    if(is_string($value)){
                        $values = $values .' '.$key.'='. "'{$value}'" . ',';

                    }else{
                        $values = $values .' '.$key.'='. $value . ',';
                    }

                }
                //如果条件存在
                if($values){
                    $this->where = ' where '.substr($values, 0, -1);
                }*/
            }else{
                if(empty($this->tableName)){
                    exit('温馨提示:如果不传对象的话，请填写表名。');
                }
            }

            $sql = "SELECT {$this->field} FROM {$this->tableName}{$this->on}{$this->where}{$this->order}{$this->limit}"; //构造SQL语句

            //显示sql
            if($this->show){

                return $sql;
            }

            //查询方式
            switch($this->way){
                case 1:
                    $result = $this->wpdb->get_results($sql,$output_type);
                    break;
                case 2:
                    $result = $this->wpdb->get_row($sql,$output_type);
                    break;
                case 3:
                    $result = $this->wpdb->get_var($sql);
                    break;
            }

            //初始化变量
            $this->close();

            return $result;

        }

        /**
         * 对象查询
         *
         * $res[0]:排序字段,$res[1]:排序规则,$res[2]:偏移位置,$res[3]:显示数量
         *
         * @param $object 对象
         * @param string 如果是数组将作为分页
         * @return mixed
         */
        public function selectObject($object,$res='')
        {
            //如果对象存在使用对象作为条件
            if ($object) {

                $arr = self::_reflectionClass($object);//使用反射机制为条件赋值

                if (empty($this->tableName)) {

                    $this->tableName = $this->prefix . $arr['table'];

                }

                $values = '';

                foreach ($arr['arr'] as $key => $value) {

                    if (is_string($value)) {
                        $values = $values . ' ' . $key . '=' . "'{$value}'" . ' and';

                    }else if(is_array($value)){

                        $values = $values .' '. $value[0] . ' and';

                    } else {
                        $values = $values . ' ' . $key . '=' . $value . ' and';
                    }

                }

                if(is_array($res)){
                    $limit = " ORDER BY $res[0] $res[1] limit $res[2],$res[3] ";
                    $field='*';
                }else{
                    if ($res == 'count') {
                        $field ='count(*)';

                    } else {
                        $field='*';
                    }
                }



                //如果条件存在
                if ($values) {
                    $sql = "select {$field} from {$this->tableName} where " . substr($values, 0, -3).$limit;
                }else{
                    $sql = "select {$field} from {$this->tableName} $limit";
                }
                switch ($res) {
                    case 'count':
                        $result = $this->wpdb->get_var($sql);
                        break;
                    case 'row':
                        $result = $this->wpdb->get_row($sql, ARRAY_A);
                        break;
                    default:

                        $result = $this->wpdb->get_results($sql, ARRAY_A);

                }
            }

            //初始化变量
            $this->close();

            return $result;
        }


        /**
         * 删除
         * @param null $object
         * @return bool
         */
        protected function delete($object=null) {
            //如果对象存在使用对象作为条件
            if($object){

                $arr = self::_reflectionClass($object);//使用反射机制为条件赋值

                if(empty($this->tableName)){

                    $this->tableName = $this->prefix.$arr['table'];

                }

                $values = '';

                foreach($arr['arr'] as $key => $value){

                    if(is_string($value)){
                        $values = $values .' '.$key.'='. "'{$value}'" . 'and';

                    }else{
                        $values = $values .' '.$key.'='. $value . " and";
                    }

                }
                //如果条件存在
                if($values){
                    $this->where = ' where '.substr($values, 0, -3);
                }

            }else{

                if(empty($this->tableName)){
                    exit('温馨提示:如果不传对象的话，请填写表名。');
                }

            }

            if(empty($this->where)){
                exit('温馨提示：删除条件为空');
            }

            $sql = "DELETE FROM {$this->tableName}{$this->where}"; //构造SQL语句



            //显示sql
            if($this->show){

                exit($sql);
            }

            $result = $this->wpdb->query($sql);

            //初始化变量
            $this->close();

            if($result){
                return true;
            } else {
                return false;
            }


        }

        /**
         * @param $object
         * @return 保存/返回bool
         */
        protected function save($object,$return_id=false){

            $arr = self::_reflectionClass($object);

            foreach($arr['arr'] as $key => $value){
            
                $field .= $key . ',' ;

                if(is_string($value)){
                    $value = "'{$value}'";
                }
                $values .= $value . ',';
            }

            if(empty($values)){
                exit('温馨提示:创建了对象但是没有set参数。');
            }

            $sql = "INSERT INTO " . $this->prefix.$arr['table'] . " (" . substr($field, 0, -1) . ") VALUES (" . substr($values, 0, -1) . ")";



            //显示sql
            if($this->show){

                exit($sql);
            }
            $result = $this->wpdb->query($sql);
            //初始化变量
            $this->close();

            if($result){
                if($return_id)
                {
                    return $this->wpdb->insert_id;
                }
                else
                {
                    return true;
                }

            } else {
                return false;
            }

        }


        /**
         * @param $object
         * @return 更新/返回结果
         */
        protected function update($object){

            $arr = self::_reflectionClass($object);


            foreach($arr['arr'] as $key => $value){

                if($value == 'null'){
                    $value = $key.' = ""';
                }elseif(is_string($value)){
                    $value = $key.' = '."'{$value}'";
                }else{
                    $value = $key.' = '. $value;
                }

                $values = $values . $value . ',';
            }

            if(empty($values) || empty($this->where)){
                exit('温馨提示:没有更新内容或条件');
            }

            $sql = "UPDATE " . $this->prefix.$arr['table'] . " SET " . substr($values, 0, -1) .' '. $this->where;


            //显示sql
            if($this->show){

                exit($sql);
            }

            $result = $this->wpdb->query($sql);

            //初始化变量
            $this->close();

            if($result){
                return true;
            } else {
                return false;
            }

        }

        /*
         * 直接执行SQL
         * @ $sql str
         * @ $format 返回类型
         * */
        public function query($sql,$format=''){
            $_this = $this->wpdb;
            
            switch($format){
                case "row":
                    $rows = $_this->get_row($sql,'ARRAY_A');
                    break;
                case "var":
                
                    $rows = $_this->get_var($sql);
                    break;
                default:
                    $rows = $_this->get_results($sql,'ARRAY_A');
            }

            return $rows;

        }

        /**
         * @param $mode 方式
         * @param $table 表名
         * @param $table_id 表ID
         * @param $object_id 字段ID
         * @param $object_key 字段键
         * @param string $object_meta 需要更新的内容
         * @return mixed
         */
        protected function dateMeta($mode,$table,$table_id,$object_id,$object_key,$object_meta=''){

            if(is_array($object_meta)){
                $object_meta = serialize($object_meta);
            }

            switch($mode){
                case "get":

                    $result = $this->wpdb->get_var("SELECT  meta_value FROM {$this->prefix}$table WHERE $table_id = $object_id and meta_key = '{$object_key}'");
                    if(is_serialized($result)){
                        $result = unserialize($result);
                    }

                    break;
                case "update":

                    $getMeta = $this->wpdb->query("SELECT * FROM {$this->prefix}$table WHERE $table_id = $object_id and meta_key = '{$object_key}'");

                    if($getMeta){
                        $result = $this->wpdb->query("UPDATE {$this->prefix}$table SET `meta_value`='{$object_meta}' WHERE $table_id = $object_id and meta_key = '{$object_key}'");
                    }else{

                        $result = $this->wpdb->query("INSERT INTO {$this->prefix}$table({$table_id},`meta_key`, `meta_value`) VALUES ($object_id,'{$object_key}','{$object_meta}')");
                    }

                    break;
                case "delete":

                    break;
                case "add":

                    break;
            }


            return $result;

        }

        /**
         * @return 开启事务
         */
        public  function startTransaction(){

            return $this->wpdb->query('START TRANSACTION');

        }

        /**
         * @return 提交事务
         */
        public function commitTransaction(){

            return $this->wpdb->query('COMMIT');

        }

        /**
         * @return 回滚事务
         */
        public function rollbackTransaction(){

            return $this->wpdb->query('ROLLBACK');

        }

        /**
         * @return mixed结束事务
         */
        public function endTransaction(){

            return $this->wpdb->query('END');

        }


        /**
         * 反射机制调出私有属性
         * @param $object
         * @return array
         */
        private static function _reflectionClass($object){
            if(!is_object($object)){
                exit('温馨提示：请传入对象');
            }

            $class = new ReflectionClass(get_class($object));
            $properties = $class->getProperties(ReflectionProperty::IS_PRIVATE);

            foreach($properties as $value){
                $as = $value->name;
                if(isset($object->$as)){
                    $arr[$as] = $object->$as;
                }

            }

            $tableName = $arr['table'];     //为表名表名
            if(empty($tableName)){
                exit('温馨提示：请到实体类中添加table属性');
            }

            unset($arr['table']);

            return array('arr'=>$arr,'table'=>$tableName);

        }

    }
}
