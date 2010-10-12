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
    CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}uf_custom_posts` (
        `id` BIGINT( 20 ) NULL AUTO_INCREMENT PRIMARY KEY,
        `custom_post` TEXT NULL ,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE = MYISAM ;
QUERY;
    if($wpdb->query($query) === false) {
        add_action("admin_notices", "uf_notice_table_create_failed");
    }

    uf_get_custom_posts();
}
add_action("uf_theme_activated", "uf_theme_activate_build_custom_posts_table");



/**
 * already registerd theme supported, get single custom post.
 *
 * @access public
 * @return stdClass Object
 */
function uf_get_custom_post($id) {
    global $wpdb;

    if(!is_numeric($id)) {
        return new WP_Error("uf_custom_post", __("custom post ID is not numeric.", "unify_framework"));
    }

    $id = $wpdb->escape((int)$id);

    if(!($results = wp_cache_get("uf_get_custom_post_{$id}"))) {
        $query = "SELECT * FROM `{$wpdb->prefix}uf_custom_posts` WHERE ID = {$id}";
        $results = $wpdb->get_row($query);
        if(empty($results))
            return false;

        wp_cache_add("uf_custom_post_{$id}", $results);
    }

    $results->custom_post = maybe_unserialize(&$results->custom_post);

    return apply_filters("uf_get_custom_post", $results, $id);
}



/**
 * already registerd theme supported, get multi custom posts.
 *
 * @access public
 * @return Array
 */
function uf_get_custom_posts() {
    global $wpdb;

    if(!($results = wp_cache_get("uf_custom_posts"))) {
        $query = "SELECT * FROM `{$wpdb->prefix}uf_custom_posts`";
        $results = $wpdb->get_results($query);
        if($results == null) {
            $results = array();
            return $results;
        }
        wp_cache_add("uf_custom_posts", $results);
    }

    foreach($results as $custom_post) {
        $custom_post->custom_post = maybe_unserialize(&$custom_post->custom_post);
    }
    return apply_filters("uf_get_custom_posts", $results);
}



/**
 * insert new custom post type
 *
 * @access public
 * @param  $data   Array|String    paramater is serializable data
 * @return Bool
 */
function uf_add_custom_post($data) {
    global $wpdb;
    if(!is_serialized($data))
        $data = maybe_serialize($data);

    return $wpdb->insert("{$wpdb->prefix}uf_custom_posts", array("custom_post" => $data), array("custom_post" => "%s"));
}




