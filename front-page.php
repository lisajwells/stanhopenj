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

// Add our recent news loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'stanhopenj_news_loop' );
function stanhopenj_news_loop() {

    echo '<h3>Recent News</h3>';

    $args = array(
        'category_name' => 'news',
        'orderby'       => 'post_date',
        'order'         => 'DESC',
        'posts_per_page'=> '2',
    );
    $loop = new WP_Query( $args );
    if( $loop->have_posts() ) {
        // loop through posts
        while( $loop->have_posts() ): $loop->the_post();
        $video_id = esc_attr( genesis_get_custom_field( 'cd_youtube_id' ) );
        $video_thumbnail = '<img src="http://img.youtube.com/vi/' . $video_id . '/0.jpg" alt="" />';
        $video_link = 'http://www.youtube.com/watch?v=' . $video_id;
        echo '<div class="one-third first">';
            echo '<a href="' . $video_link . '" target="_blank">' . $video_thumbnail . '</a>';
        echo '</div>';
        echo '<div class="two-thirds">';
            echo '<h4>' . get_the_title() . '</h4>';
            echo '<p>' . get_the_date() . '</p>';
            echo '<p><a href="' . $video_link . '" target="_blank">Watch It</a> | <a href="' . get_permalink() . '" target="_blank">Show Notes</a></p>';
        echo '</div>';
        endwhile;
    }
    wp_reset_postdata();
}


genesis();
