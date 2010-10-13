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
 * already registerd theme supported, get single custom post.
 *
 * @access public
 * @return stdClass Object
 */
function uf_get_custom_post($id) {
}



/**
 * already registerd theme supported, get multi custom posts.
 *
 * @access public
 * @return Array
 */
function uf_get_custom_posts() {
    $custom_posts = get_option("uf_custom_posts");
    if(!is_array($custom_posts) || empty($custom_posts)) {
        $custom_posts = array();
    }

    return $custom_posts;
}



/**
 * add CustomPost data
 *
 * @access public
 * @param  $post_type_name   String
 * @param  $options          Array    custom post type options
 * @return Bool
 */
function uf_add_custom_post($post_type_name, $options) {
    $custom_posts = uf_get_custom_posts();

    // post type name is only Alnums.
    if(!preg_match("#^[\w]+$#", $post_type_name)) {
        return false;
    }

    // already registerd custom post type, return error.
    if(!array_key_exists($post_type_name, $custom_posts)) {
        return false;
    }

    if(!uf_validate_custom_post($options)) {
        return false;
    }

    $custom_posts[$post_type_name] = $options;
    update_option("uf_custom_posts", $custom_posts);
}


/**
 * check custom post values.
 *
 * @access public
 * @param  $args    Array
 * @return Bool
 */
function uf_validate_custom_post($args) {
}


