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

// If we supply no parameters, the default number of events to
// show per page are fetched, earliest first
$events = tribe_get_events( array(
    'posts_per_page' => 3,
    'cat'            => 'featured'
) );

// The result set may be empty
if ( empty( $events ) ) {
    echo 'Sorry, nothing found.';
}

// Or we may have some to show
else foreach( $events as $event ) {
    echo get_the_title( $event ) . '<br/>';
}

// Add our custom loop
// add_action( 'genesis_loop', 'stanhopenj_events_loop' );

// function stanhopenj_events_loop() {

//     $args = array(
//         'cat'           => 21,
//         'orderby'       => 'post_date',
//         'order'         => 'DESC',
//         'posts_per_page'=> '3', // overrides posts per page in theme settings
//     );

//     $loop = new WP_Query( $args );
//     if( $loop->have_posts() ) {

//         // this is shown before the loop
//         echo '<h2>Read my latest blog posts</h2>';

//         // loop through posts
//         while( $loop->have_posts() ): $loop->the_post();

//         echo '<h3><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h3>';
//         echo '<p>' . get_the_date() . '</p>';
//         echo '<p>' . get_the_excerpt() . '</p>';


//         endwhile;

//         // link to more posts is shown after the loop
//         echo '<a href="./blog/">More from the blog</a>';
//     }

//     wp_reset_postdata();

// }


genesis();
