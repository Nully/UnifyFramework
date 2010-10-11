<?php
/**
 * UnifyFramework Template scripts
 *
 */
/**
 * load enqueued stylesheets
 *
 */
function uf_css() {
    //$page = uf_get_current_page_to_string();
    wp_enqueue_style("unify_framework-core",  get_bloginfo("template_url"). "/css/unify.css", null, UF_VERSION, "all");
    wp_enqueue_style("unify_framework-layout",  get_bloginfo("template_url"). "/css/layout.css", null, UF_VERSION, "all");
    do_action("uf_css");
}
add_action("uf_head", "uf_css");



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
add_action("uf_head", "uf_javascript");



/**
 * get current page body class
 * alias to body_class method.
 */
function uf_body_class($class = null) {
    echo 'class="'. join(" ", apply_filters("uf_body_class", $class)) .'"';
}



/**
 * get current page, to String.
 *
 * @return String
 */
function uf_get_body_class($class_name = null) {
    global $is_NS4, $is_IE, $is_winIE, $is_macIE, $is_gecko, $is_chrome, $is_opera, $is_lynx, $is_main_site, $is_iphone, $is_safari;

    if(!is_array($class_name))
        $class_name = (array)$class_name;

    $classes = get_body_class();
    $class = array();

    if($is_NS4) $class[] = "ns4";
    if($is_IE) $class[] = "ie";
    if($is_winIE) $class[] = "win-ie";
    if($is_macIE) $class[] = "mac-ie";
    if($is_gecko) $class[] = "gecko";
    if($is_chrome) $class[] = "chrome";
    if($is_opera) $class[] = "opera";
    if($is_lynx) $class[] = "lynx";
    if($is_main_site) $class[] = "main-site";
    if($is_iphone) $class[] = "iphone";
    if($is_safari) $class[] = "safari";

    return apply_filters("uf_get_body_class", array_merge($class_name, $class, $classes));
}
add_filter("uf_body_class", "uf_get_body_class");



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
 * get partial loop template
 *
 * @access public
 * @param  $template_name   String  fetch target template name
 * @param  $sub_name        String  fetch target sub name
 * @return Bool
 */
function uf_get_template_part($template_name, $sub_name = null) {
    if(function_exists("get_template_part")) {
        get_template_part($template_name, $sub_name);
    }
    else {
        do_action("get_template_part_{$template_name}", $template_name, $sub_name);
        $templates = array();
        if(isset($sub_name))
            $templates[] = "{$template_name}-{$sub_name}.php";

        $templates = "{$template_name}.php";
        locate_template($templates);
    }
}






