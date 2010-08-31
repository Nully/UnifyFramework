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
 * do enqueue stylesheets.
 *
 */
function uf_init_styles() {
    if(is_admin ()) {
        return;
    }
    $page = uf_get_current_page_to_string();
    wp_enqueue_style("unify_framework-core",  get_bloginfo("template_url"). "/css/unify.css", null, UF_VERSION, "all");
    wp_enqueue_style("unify_framework-layout",  get_bloginfo("template_url"). "/css/unify.css", null, UF_VERSION, "all");
    wp_enqueue_style("unify_framework",  get_bloginfo("template_url"). "/css/{$page}.css", null, UF_VERSION, "all");
}
add_action("init", "uf_init_styles");


/**
 * load enqueued stylesheets
 *
 */
function uf_css() {
    wp_enqueue_style("unify_framework-core");
    wp_enqueue_style("unify_framework-layout");
    wp_enqueue_style("unify_framework");

    do_action("uf_css");
}


/**
 * load enqueued javascripts
 *
 */
function uf_javascript() {
    wp_enqueue_script("jquery");

    do_action("uf_javascript");
}

