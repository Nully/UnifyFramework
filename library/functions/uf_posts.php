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


