<?php
/**
 * UnifyFramework utility support
 */

/**
 * get current page, to String.
 *
 * @return String
 */
function uf_get_current_page_to_string() {
    $page = "home";
    if(is_search()) {
        $page = "search";
    }
    else if(is_single() || is_page()) {
        $page = "post";
    }
    else if (is_category()) {
        $page = "category";
    }
    else if(is_tag()) {
        $page = "tag";
    }
    else if(is_day()) {
        $page = "day";
    }
    else if(is_month()) {
        $page = "month";
    }
    else if(is_year()) {
        $page = "year";
    }
    else if(is_date()) {
        $page = "date";
    }
    else if (is_404()) {
        $page = "404";
    }
    return $page;
}


/**
 * get current page body class
 * alias to body_class method.
 */
function uf_body_class() {
    if(function_exists("body_class")) {
        body_class();
    }
    else {
        echo 'class="'. uf_get_current_page_to_string() .'"';
    }
}


/**
 * get contents wrapper class name
 *
 * @return String    grid class
 */
function uf_get_contents_class() {
    $class = "grid_16";
    if(uf_has_sidebar("left-sidebar") && uf_has_sidebar("right-sidebar")) {
        $class = "grid_8";
    }
    elseif (uf_has_sidebar("left-sidebar") || uf_has_sidebar("right-sidebar")) {
        $class = "grid_12";
    }

    return $class;
}


/**
 * do enqueue stylesheets.
 *
 */
function uf_init() {
    if(is_admin ()) {
        return;
    }
}
add_action("init", "uf_init", 100);


/**
 * load enqueued stylesheets
 *
 */
function uf_css() {
    $page = uf_get_current_page_to_string();
    wp_enqueue_style("unify_framework-core",  get_bloginfo("template_url"). "/css/unify.css", null, UF_VERSION, "all");
    wp_enqueue_style("unify_framework-layout",  get_bloginfo("template_url"). "/css/layout.css", null, UF_VERSION, "all");
    if (file_exists(TEMPLATEPATH. "/css/{$page}.css")) {
        wp_enqueue_style("unify_framework",  get_bloginfo("template_url"). "/css/{$page}.css", null, UF_VERSION, "all");
    }

    do_action("uf_css");
}


/**
 * load enqueued javascripts
 *
 */
function uf_javascript() {
    wp_enqueue_script("jquery");
    wp_enqueue_script("laquu-js", get_bloginfo("template_url"). "/js/jquery.laquu-min.js", null, UF_VERSION);
    wp_enqueue_script("unify-js", get_bloginfo("template_url"). "/js/unify.js", null, UF_VERSION);

    // Comment reply javascript
    if(is_singular() && get_option("thread_comments")) {
        wp_enqueue_script( 'comment-reply' );
    }

    do_action("uf_javascript");
}


/**
 * check PHP script file direct access ?
 *
 * @param  $filename   check target file name
 * @return Bool
 */
function uf_is_direct_acess($filename) {
    return (!empty($_SERVER["SCRIPT_FILENAME"]) && $filename === $_SERVER["SCRIPT_FILENAME"]);
}


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
    return apply_filters("uf_content_more_link", $more);
}
add_filter("the_content_more_link", "uf_content_more_link");


/**
 * get post comment count
 *
 * @param  $field    String|Null   approved, awaiting_moderation, spam, total_comments
 * @return Int
 */
function uf_get_comment_count($field = null) {
    global $post;
    if(!isset($post)) {
        return 0;
    }
    $comments = get_comment_count($post->ID);
    if(is_null($field)) {
        return $comments;
    }

    return $comments[$field];
}


/**
 * wp_pagenavi wrapper method.
 * plugin installed use to wp_pagenavi.
 *
 * @param  $before   String|Array   page navigation prefix
 * @param  $after    String         page navigation suffix
 * @return Void
 */
function uf_pagenavi($before = '', $after = '') {
    if(!function_exists("wp_pagenavi")) {
        _uf_pagenavi($before);
    }
    else {
        wp_pagenavi($before, $after);
    }
}


/**
 * uf_pagenavi privatemethod
 *
 * @access private
 * @param  $args   Array   page navigation prefix
 * @return Void
 */
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


/**
 * display pagenumbers
 *
 */
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
            array(get_pagenum_link(1), "first_page", 1)
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
