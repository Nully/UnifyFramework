<?php
/**
 * UnifyFramework page navigation actions
 *
 */
/**
 * Filter the title
 *
 * @access protected
 * @param  $title      String
 * @return String
 */
function uf_filter_the_title($title) {
    return apply_filters("the_title", $title);
}
add_filter("uf_title", "uf_filter_the_title");



/**
 * Filter header image width.
 *
 * @access protected
 * @param  $width      Int
 * @return Int
 */
function uf_filter_header_image_width($width) {
    return $width;
}
add_action("uf_header_image_width", "uf_filter_header_image_width");



/**
 * Filter header image height
 *
 * @access protected
 * @param  $height     Int
 * @return Int
 */
function uf_filter_header_image_height($height) {
    return $height;
}
add_action("uf_header_image_height", "uf_filter_header_image_height");



/**
 * Filter content more link
 *
 * @param  $more    String   more link text
 * @return String
 */
function uf_content_more_link($more) {
    if(!empty($more)) {
        $more = " &raquo; Read more ". $more;
    }

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
/*function uf_filter_excerpt_length($length) {
    return $length;
}
add_filter("excerpt_length", "uf_filter_excerpt_length");*/



/**
 * do filter more Excerpt text.
 *
 * @param  $more  String
 * @return String  excerpt more text
 */
/*function uf_filter_auto_more_excerpt($more) {
    return apply_filters("uf_auto_more_excerpt", "[...]");
}
add_filter("excerpt_more", "uf_filter_auto_more_excerpt");*/



/**
 * do filter custom excerpt.
 *
 * @param  $excerpt   String
 * @return String
 */
/*function uf_filter_custom_excerpt($excerpt) {
    return $excerpt;
}
add_filter("the_excerpt", "uf_filter_custom_excerpt");
*/



/**
 * Filter pagenavi formats
 *
 * @access protected
 * @param  $formats    Array    page navigation formats.
 * @return Array
 */
function uf_filter_pagenavi_formats($formats) {
    return $formats;
}
add_filter("uf_pagenavi_formats", "uf_filter_pagenavi_formats");





/**
 * UnifyFramework admin filters
 * 
 */
/**
 * Filter override mce css.
 *
 * filter TinyMCE editor style file URL.
 *
 * @access protected
 * @param  $url        String
 * @return String
 */
function uf_filter_overload_mce_css($url) {
    return $url;
}
add_filter("uf_override_mce_css", "uf_filter_overload_mce_css");



