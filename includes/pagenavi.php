<?php
/**
 * UnifyFramework pagenavi template
 *
 */
/**
 * wp_pagenavi wrapper method.
 * plugin installed use to wp_pagenavi.
 *
 * @param  $before   String|Array   page navigation prefix
 * @param  $after    String         page navigation suffix
 * @return Void
 */
/*
function uf_pagenavi($before = '', $after = '') {
    if(!function_exists("wp_pagenavi")) {
        _uf_pagenavi($before);
    }
    else {
        wp_pagenavi($before, $after);
    }
    do_action("uf_pagenavi");
}
*/

/**
 * uf_pagenavi privatemethod
 *
 * @access private
 * @param  $args   Array   page navigation prefix
 * @return Void
 */
/*
function _uf_pagenavi($args = array()) {
    $defaults = array(
        "next_link_format"      => '<div class="next-post">%link &raquo;</div>',
        "next_permalink_format" => '%title <span class="next-nav">'.__("Next").'</span>',

        "prev_link_format"      => '<div class="prev-post">&laquo; %link</div>',
        "prev_permalink_format" => '<span class="prev-nav">'.__("Previous").'</span> %title',
    );
    $args = wp_parse_args($args, $defaults);
    if(!is_singular()) {
        _uf_pagenumber();
    }
    else {
        previous_post_link($args["prev_link_format"], $args["prev_permalink_format"]);
        next_post_link($args["next_link_format"], $args["next_permalink_format"]);
    }
}
*/

/**
 * display pagenumbers
 *
 */
/*
function _uf_pagenumber() {
    global $wp_query;

    $posts_per_page = get_query_var("posts_per_page");
    $paged = get_query_var("paged");
    if(empty($paged)) {
        $paged = 1;
    }

    $max_page = $wp_query->max_num_pages;
    if($max_page <= 1) {
        return;
    }

    // shown page numbers.
    $pages_show_num = 5;
    $pages_to_show_minus_1 = $pages_show_num - 1;
    $half_page_start = floor($pages_to_show_minus_1/2);
    $half_page_end   = ceil($pages_to_show_minus_1/2);

    // set start page number.
    $start_page = $paged - $half_page_start;
    if($start_page <= 0) {
        $start_page = 1;
    }

    // set end page number.
    $end_page = $apged + $half_page_end;
    if(($end_page - $start_page) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }

    if($end_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }

    if($start_page <= 0) {
        $start_page = 1;
    }

    // set page numbers
    $link_template = '<span class="page_numbers"><a href="%page_num_url" class="%class">%text</a></span>';
    $current_template = '<span class="page_numbers current_page">%text</span>';
    $out = "";
    $out .= sprintf(__("Pages %s Of %s : "), number_format_i18n($paged), number_format_i18n($max_page));

    if(($previous_post = true)) {
        $out .= get_previous_posts_link();
    }

    // allways display first page link
    if($start_page >= 2 && $pages_show_num < $max_page) {
        $out .= str_replace(
            array("%page_num_url", "%class", "%text"),
            array(get_pagenum_link(1), "first_page", 1),
            $link_template
        );
    }

    // shown page numbers.
    for($i = $start_page; $i <= $end_page; $i ++) {
        if($i == $paged) {
            $out .= str_replace("%text", $i, $current_template);
        }
        else {
            $out .= str_replace(
                array("%page_num_url", "%class", "%text"),
                array(get_pagenum_link($i), "page_item_link", $i),
                $link_template
            );
        }
    }

    // allways display end page link
    if($end_page < $max_page) {
        $out .= str_replace(
            array("%page_num_url", "%class", "%text"),
            array(get_pagenum_link($max_page), "last_page", $max_page),
            $link_template
        );
    }

    if(($next_post = true)) {
        $out .= get_next_posts_link();
    }

    $out = apply_filters("uf_pagenavi", $out);
    echo $out;
}
*/

