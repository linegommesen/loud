<?php
add_action( 'wp_enqueue_scripts', 'enqueue_important_files' );
function enqueue_important_files() {
/*hent parent stylesheet i parenttemaets mappe*/
wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}



add_filter( 'radio_station_post_type_show', 'custom_show_rewrite_slug' );
function custom_show_rewrite_slug( $post_type ) {
$post_type['rewrite']['slug'] = 'podcast';
return $post_type;
}

?>
