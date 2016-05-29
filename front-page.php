<?php
/**
 */

//* Add the alert box widget in the content
add_action( 'genesis_before_loop', 'stanhopenj_add_alert' );
function stanhopenj_add_alert() {
    genesis_widget_area ('alert-box', array(
        'before' => '<div class="alert-box"><div class="wrap">',
        'after' => '</div></div>',
    ) );
}




genesis();
