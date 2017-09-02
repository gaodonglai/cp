<?php
/**
*类自动加载配置
*
*/
class LoadPath{

	public static function load( $class ) {

		$class = str_replace('\\', '/', $class);//转化为路径

		$file = _TEMP_.'/'.$class . '.class.php';
		//echo $file.'<br />';
		if (file_exists($file)) {

			require_once($file);

		}

	}

}
?>