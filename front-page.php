<?php
/**
 */

// Remove post title area
remove_action( 'genesis_entry_header', 'genesis_do_post_title'                 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open',  5  );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//* Add the alert box widget in the content
add_action( 'genesis_before_loop', 'stanhopenj_add_alert' );
function stanhopenj_add_alert() {
    genesis_widget_area ('alert-box', array(
        'before' => '<div class="alert-box"><div class="wrap">',
        'after' => '</div></div>',
    ) );
}

// add events list widget
add_action( 'genesis_before_loop', 'stanhopenj_add_upcoming' );
function stanhopenj_add_upcoming() {
    genesis_widget_area ('upcoming-events', array(
        'before' => '<div class="upcoming-events"><div class="wrap">',
        'after' => '</div></div>',
    ) );
}


genesis();
