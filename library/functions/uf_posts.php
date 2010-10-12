<?php
/**
 * UnifyFramework posts template
 *
 */
/**
 * apply filter 'the_content_more_link'
 *
 * @param  $more    String
 * @return String
 */
function uf_content_more_link($more) {
    if(!empty($more)) {
        $more = " &raquo; Read more ". $more;
    }

    do_action("uf_content_more_link");
    return apply_filters("uf_content_more_link", $more);
}
add_filter("the_content_more_link", "uf_content_more_link");



/**
 * do filter Post or Page Excerpt length.
 *
 * @TODO  support admin panel excerpt length.
 *
 * @param $length    Int
 * @return Int
 */
function uf_filter_excerpt_length($length) {
    $excerpt_length = 40;
    return $excerpt_length;
}
add_filter("excerpt_length", "uf_filter_excerpt_length");



/**
 * do filter more Excerpt text.
 *
 * @param  $more  String
 * @return String  excerpt more text
 */
function uf_filter_auto_more_excerpt($more) {
    return "[...]";
}
add_filter("excerpt_more", "uf_filter_more_excerpt");



/**
 * do filter custom excerpt.
 *
 * @param  $excerpt   String
 * @return String
 */
function uf_filter_custom_excerpt() {
}
add_filter("get_the_excerpt", "uf_filter_custom_excerpt");



/**
 * theme activated action script.
 *   theme activated, build theme supported custom-posts uses table.
 *
 * @access protected
 * @notice uf_notice_table_create_failed
 * @action uf_theme_activate
 * @return Void
 */
function uf_theme_activate_build_custom_posts_table() {
    global $wpdb;
$query = <<<QUERY
    CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}uf_comments` (
        `id` BIGINT( 20 ) NULL AUTO_INCREMENT PRIMARY KEY,
        `custom_post` TEXT NULL ,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE = MYISAM ;
QUERY;
    if($wpdb->query($query) === false) {
        add_action("admin_notices", "uf_notice_table_create_failed");
    }
}
add_action("uf_theme_activated", "uf_theme_activate_build_custom_posts_table");






