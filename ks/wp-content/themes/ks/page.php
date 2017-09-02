<?php
get_header();
?>
<?=do_shortcode('[rev_slider alias="home2"]');?>
<!--主体内容-->
<div class="container content-page">
	<div class="page-content sidebar-position-without sidebar-mobile-bottom">
		<div class="row">
			<div class="content col-md-12">
<?php
	
	while ( have_posts() ) : the_post();
		
		the_content();

	endwhile;
?>
			</div>
		</div><!-- end row-fluid -->
	</div>
</div><!-- end container -->
<?php get_footer(); ?>
