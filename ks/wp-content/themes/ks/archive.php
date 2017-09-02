<?php
get_header(); ?>
<div class="container main-container">
    <div role="tabpanel">
        <!-- Tab panes -->
        <div class="tab-content">

          <div role="tabpanel" class="tab-pane active" id="panel-1">
            <div class="row masonry-container" id="masonry">
    <?php
    if (have_posts()) {
        $count = 0;
        while (have_posts()) {
            the_post();
            $count++; ?>

          <div  onclick="javascript:window.location.href='<?php the_permalink()?>'" class="col-md-4 col-sm-6 item etContentDiv">

            <?php
            if ( get_post_thumbnail_id($post->ID) )
            {
                $thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID));
                $newPic = $thumbnail_image_url[0];
            }else{
                $newPic = IMG.'/default.png';
            }?>
            <ul class="articlescrap_lists_data">
                <li>
                    <span><?php the_time('n月') ?></span>
                </li>
                <li>
                    <span><?php the_time('j') ?></span>
                </li>
                <li>
                    <span><?php the_time('Y') ?></span>
                </li>
            </ul>
    
            <?php
            if ( get_post_thumbnail_id($post->ID) )
            {
                $thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID));
                $newPic = $thumbnail_image_url[0];
            }else{
                $newPic = IMG.'/default.png';
            }?>
            
            <div class="thumbnail">
              <img src="<?=$newPic?$newPic:IMG.'/banner55.jpg'?>" alt="">
              <div class="caption">
                <h3><?=csubstr(get_the_title(),0,20,true);?></h3>
                <p><?=!empty($post->post_excerpt) ? csubstr(strip_tags($post->post_excerpt),0,100,true) : csubstr(strip_tags($post->post_content),0,100,true);?></p>
                </div>
            </div>
          </div>
            <?php
        }
        theme_echo_pagenavi(true);  //分页
    }?>




        </div> 
      </div>

    </div> 

  </div> 
</div>
<script src="<?=get_stylesheet_directory_uri().'/web/js/jquery.masonry.min.js'?>"></script>

<script src="<?=get_stylesheet_directory_uri().'/web/js/masonry.pkgd.min.js'?>"></script>

<script src="<?=get_stylesheet_directory_uri().'/web/js/imagesLoaded.js'?>"></script>

<?php add_action('wp_footer','add_footer');
	function add_footer(){
		?>
		<script>
		(function( $ ) {

		    var $container = $('.masonry-container');
		    $container.imagesLoaded( function () {
		        $container.masonry({
		            columnWidth: '.item',
		            itemSelector: '.item'
		        });
		    });
		    
		    //Reinitialize masonry inside each panel after the relative tab link is clicked - 
		    $('a[data-toggle=tab]').each(function () {
		        var $this = $(this);
		
		        $this.on('click', function () {
		        
		            $container.imagesLoaded( function () {
		                $container.masonry({
		                    columnWidth: '.item',
		                    itemSelector: '.item'
		                });
		            });
		
		        }); //end shown
		    });  //end each
		    
		})(jQuery);
	</script>
		<?php
	}
?>




<?php get_footer(); ?>
