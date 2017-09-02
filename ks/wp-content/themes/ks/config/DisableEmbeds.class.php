<?php
/*包含所有的前台禁止的css,js*/
Class DisableEmbeds{
    public function __construct() {

        define('CJ_VER','2.53');//css|js版本控制

        add_action( 'init', array($this,'disable_embeds_init'), 9999 );
        register_activation_hook( __FILE__, array($this,'disable_embeds_remove_rewrite_rules' ));
        register_deactivation_hook( __FILE__, array($this,'disable_embeds_flush_rewrite_rules' ));
    }
    public function disable_embeds_init() {
        /* @var WP $wp */
        global $wp;

        // Remove the embed query var.
        $wp->public_query_vars = array_diff( $wp->public_query_vars, array(
            'embed',
        ) );

        // Remove the REST API endpoint.
        remove_action( 'rest_api_init', 'wp_oembed_register_route' );

        // Turn off
        add_filter( 'embed_oembed_discover', '__return_false' );

        // Don't filter oEmbed results.
        remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

        // Remove oEmbed discovery links.
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links'  );

        // Remove oEmbed-specific JavaScript from the front-end and back-end.
        remove_action( 'wp_head', 'wp_oembed_add_host_js'  );
        add_filter( 'tiny_mce_plugins', array($this,'disable_embeds_tiny_mce_plugin' ) );
        add_action('wp_head',array($this,'add_web_style'));
        // Remove all embeds rewrite rules.
        add_filter( 'rewrite_rules_array', array($this,'disable_embeds_rewrites' ) );
        //精简头部信息
        //remove_action( 'wp_head', 'wp_enqueue_scripts', 1 ); //Javascript的调用
        remove_action( 'wp_head', 'alternate', 2 ); //移除feed
        remove_action( 'wp_head', 'feed_links', 2 ); //移除feed
        remove_action( 'wp_head', 'feed_links_extra', 3 ); //移除feed
        remove_action( 'wp_head', 'rsd_link' ); //移除离线编辑器开放接口
        remove_action( 'wp_head', 'wlwmanifest_link' );  //移除离线编辑器开放接口
        remove_action( 'wp_head', 'index_rel_link' );//去除本页唯一链接信息
        remove_action('wp_head', 'parent_post_rel_link', 10, 0 );//清除前后文信息
        remove_action('wp_head', 'start_post_rel_link', 10, 0 );//清除前后文信息
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        remove_action( 'wp_head', 'locale_stylesheet' );
        remove_action('publish_future_post','check_and_publish_future_post',10, 1 );
        remove_action( 'wp_head', 'noindex', 1 );
        //remove_action( 'wp_head', 'wp_print_styles', 8 );//载入css
        //remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
        remove_action( 'wp_head', 'wp_generator' ); //移除WordPress版本
        remove_action( 'wp_head', 'rel_canonical' );
        remove_action( 'wp_footer', 'wp_print_footer_scripts' );
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
        remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
        add_filter('rest_enabled', '_return_false');
        add_filter('rest_jsonp_enabled', '_return_false');

        remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
    }



    /**
     * Removes the 'wpembed' TinyMCE plugin.
     *
     * @since 1.0.0
     *
     * @param array $plugins List of TinyMCE plugins.
     * @return array The modified list.
     */
    function disable_embeds_tiny_mce_plugin( $plugins ) {
        return array_diff( $plugins, array( 'wpembed' ) );
    }

    function add_web_style(){
        echo "<script>
        window.WP_JS = '".JS."';
        window.WP_CSS = '".CSS."';
        window.WP_IMG = '".IMG."';
        </script>";
    }

    /**
     * Remove all rewrite rules related to embeds.
     *
     * @since 1.2.0
     *
     * @param array $rules WordPress rewrite rules.
     * @return array Rewrite rules without embeds rules.
     */
    function disable_embeds_rewrites( $rules ) {
        foreach ( $rules as $rule => $rewrite ) {
            if ( false !== strpos( $rewrite, 'embed=true' ) ) {
                unset( $rules[ $rule ] );
            }
        }

        return $rules;
    }

    /**
     * Remove embeds rewrite rules on plugin activation.
     *
     * @since 1.2.0
     */
    function disable_embeds_remove_rewrite_rules() {
        add_filter( 'rewrite_rules_array', array($this,'disable_embeds_rewrites' ));
        flush_rewrite_rules();
    }

    /**
     * Flush rewrite rules on plugin deactivation.
     *
     * @since 1.2.0
     */
    function disable_embeds_flush_rewrite_rules() {
        remove_filter( 'rewrite_rules_array', array($this,'disable_embeds_rewrites' ));
        flush_rewrite_rules();
    }
}
new DisableEmbeds();
?>