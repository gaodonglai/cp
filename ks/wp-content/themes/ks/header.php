<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="format-detection" content="telephone=no" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="baidu-site-verification" content="G9Qk2XCGoQ" />
	<link rel="shortcut icon" href="<?=IMG?>/favicon.ico" />
	<title>
		<?php
		if ( is_home() || is_front_page() ) {
			bloginfo('name'); echo ' | ';bloginfo('description');
		} elseif (is_search() ) {
			echo "搜索结果".' | ';bloginfo('name');
		}elseif(defined('TITLEHEAD')) {
			echo TITLEHEAD.' | ';bloginfo('name');
		}else{
			wp_title( '|', true, 'right' );bloginfo('name');
		}
		?>
	</title>

	<?php
	wp_enqueue_script('jquery');
	wp_head();
	?>
	<!--[if lt IE 9]>
	<script src="<?=JS?>/html5.js?ver=<?=CJ_VER?>"></script>
	<![endif]-->
	<script src="<?=JS?>/cookie.url.config.js?var=<?=CJ_VER?>"></script>
	<script src="<?=JS?>/bootstrap3.0.min.js?ver=<?=CJ_VER?>"></script>
	<script src="<?=JS?>/public.js?ver=<?=CJ_VER?>"></script>
	<script>
		window.home_url = '<?=home_url();?>';
	</script>
</head>
<body>
