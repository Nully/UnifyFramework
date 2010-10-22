<?php
/**
 * UnifyFramework page navigation actions
 *
 */
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
add_action("uf_header_image_height", "uf_filter_header_image_heigh");



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



