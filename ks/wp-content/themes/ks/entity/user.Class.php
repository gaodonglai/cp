<?php
class user{
	
	private $user_id;//用户ID
	private $user_name;//姓名
	private $user_sex;//性别
	private $user_age;//年龄
	private $user_height;//身高
	
	
	public function __construct(){

		
	}
	
	public function __get($name){ 
		 
		if(isset($this->$name)){ 
			return($this->$name); 
		}else{ 
			return(NULL); 
		} 
		
	} 
	 
	public function __set($name, $value){ 
		
		if($name == 'user_name'){
			
		}
		$this->$name = $value; 
	} 
	
	public  function __isset($name) {  
        echo "isset()函数测定私有成员时，自动调用<br>";  
        return isset($this->$name);  
    }  
	
    public  function __unset($name) {  
        echo "当在类外部使用unset()函数来删除私有成员时自动调用的<br>";  
        unset($this->$name);  
    }

} 
?>