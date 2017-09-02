<?php
/**
 * Created by PhpStorm.
 * User: ijita
 * Date: 2016/2/17
 * Time: 10:22
 */

namespace libraries\util;

class DoGctjkBoxes
{
    public function __construct()
    {
        /**
         * 增加页面模块接口
         */
        add_action("do_item_normal_meta_boxes", array($this,'do_item_meta_boxes'),'','2' );

    }

    public function do_item_meta_boxes($page,$context) {
        global $wp_meta_boxes;

        $hidden = get_user_option( "metaboxhidden_{$page}" );

        if(!$hidden) $hidden =array();

        printf('<div id="%s-sortables" class="meta-box-sortables">', htmlspecialchars($context));

        $i = 0;

        if ( isset( $wp_meta_boxes[ $page ][ $context ] ) ) {
            foreach ( array( 'high', 'sorted', 'core', 'default', 'low' ) as $priority ) {
                if ( isset( $wp_meta_boxes[ $page ][ $context ][ $priority ]) ) {
                    foreach ( (array) $wp_meta_boxes[ $page ][ $context ][ $priority ] as $box ) {
                        if ( false == $box || ! $box['title'] )
                            continue;
                        $i++;

                        $hidden_class = in_array($box['id'], $hidden) ? ' hide-if-js' : '';
                        echo '<div id="' . $box['id'] . '" class="postbox ' . postbox_classes($box['id'], $page) . $hidden_class . '" ' . '>' . "\n";
                        if ( 'dashboard_browser_nag' != $box['id'] ) {
                            echo '<button type="button" class="handlediv button-link" aria-expanded="true">';
                            echo '<span class="screen-reader-text">' . sprintf( __( 'Toggle panel: %s' ), $box['title'] ) . '</span>';
                            echo '<span class="toggle-indicator" aria-hidden="true"></span>';
                            echo '</button>';
                        }
                        echo "<h2 class='hndle'><span>{$box['title']}</span></h2>\n";
                        echo '<div class="inside">' . "\n";
                        call_user_func($box['callback'], $object, $box);
                        echo "</div>\n";
                        echo "</div>\n";
                    }
                }
            }
        }

        echo "</div>";

        return $i;

    }


}