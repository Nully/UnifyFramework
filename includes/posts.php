<?php
/**
 * UnifyFramework posts template
 *
 */
/**
 * already registerd theme supported, get single custom post.
 *
 * @access public
 * @return stdClass Object
 */
/*function uf_get_custom_post($id) {
}*/



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


