<?php

namespace entity\enterprise {

	/**
	 * Class user
	 * @package app\enterprise\entity
     */
	class user{

		/**
		 * @用户ID
         */
		private $user_id;
		/**
		 * @姓名
         */
		private $user_name;
		/**
		 * @性别
         */
		private $user_sex;
		/**
		 * @年龄
         */
		private $user_age;
		/**
		 * @身高
         */
		private $user_height;

		private $table = 'user';

		/**
		 * @return string
		 */
		public function getTable()
		{
			return $this->table;
		}

		/**
		 * user constructor.
         */
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

			$this->$name = $value;

		}

		/**
		 * @return mixed
		 */
		public function getUserName()
		{
			return $this->user_name;
		}

		/**
		 * @param mixed $user_name
		 */
		public function setUserName($user_name)
		{
			$this->user_name = $user_name;

		}

		/**
		 * @return mixed
		 */
		public function getUserId()
		{
			return $this->user_id;
		}

		/**
		 * @param mixed $user_id
		 */
		public function setUserId($user_id)
		{
			$this->user_id = $user_id;
		}

		/**
		 * @return mixed
		 */
		public function getUserSex()
		{
			return $this->user_sex;
		}

		/**
		 * @param mixed $user_sex
		 */
		public function setUserSex($user_sex)
		{
			$this->user_sex = $user_sex;
		}

		/**
		 * @return mixed
		 */
		public function getUserAge()
		{
			return $this->user_age;
		}

		/**
		 * @param mixed $user_age
		 */
		public function setUserAge($user_age)
		{
			$this->user_age = $user_age;
		}

		/**
		 * @return mixed
		 */
		public function getUserHeight()
		{
			return $this->user_height;
		}

		/**
		 * @param mixed $user_height
		 */
		public function setUserHeight($user_height)
		{
			$this->user_height = $user_height;
		}


		/**
		 * @param $name
		 * @return bool
         */
		public  function __isset($name) {
			//echo "isset()函数测定私有成员时，自动调用<br>";
			return isset($this->$name);
		}

		/**
		 * @param $name
         */
		public  function __unset($name) {
			//echo "当在类外部使用unset()函数来删除私有成员时自动调用的<br>";
			unset($this->$name);
		}

	}
}?>