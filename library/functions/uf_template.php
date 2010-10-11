<?php
/**
 * UnifyFramework Template scripts
 *
 */
if($uf_is_wp_version_under_3) {
    automatic_feed_links(true);
}
else {
    add_theme_support("automatic-feed-links");
}



$uf_support_separators = array(
    0 => "&gt;",
    1 => "&lt;",
    2 => " &laquo; ",
    3 => " &raquo; ",
    4 => " - ",
    5 => " | ",
    6 => " : ",
);
/**
 * display template title tag.
 *
 * @access public
 * @return Void
 */
function uf_title() {
    global $uf_support_separators;
    $separator = $uf_support_separators[get_option("uf_doctitle_separator", 2)];
    echo apply_filters("uf_title", join($separator, uf_get_title()));
}


/**
 * get custom template title
 *
 * @access public
 * @return Array
 */
function uf_get_title() {
    global $paged, $page, $s, $uf_support_separators;
    $separator = $uf_support_separators[get_option("uf_doctitle_separator", 2)];

    $title = array();
    if(_uf_exists_seo_plugins ()) {
        $title[] = wp_title($separator, false);
    }
    else {
        if(is_home () || is_front_page()) {
            $title[] = apply_filters("uf_title-is_home", get_bloginfo("description"));
        }
        elseif(is_404()) {
            $title[] = __("Page not found.", "uf");
        }
        elseif(is_date() || is_archive()) {
            if(is_year()) {
                $title[] = apply_filters("uf_title-is_year", get_the_time("Y"));
            }
            if(is_month()) {
                $title[] = apply_filters("uf_title-is_day",get_the_time("F"));
            }
            if(is_day()) {
                $title[] = apply_filters("uf_title-is_day", get_the_time("d"));
            }
            // @TODO: add document title to, shown page week ?
        }
        elseif(is_search()) {
            $title[] = sprintf(__("Search results %s", "uf"), esc_attr($s));
        }
        elseif((is_single() || is_page()) && !is_front_page()) {
            $title[] = single_post_title(null, false);
        }

        if($paged > 2 || $page > 2) {
            $title[] = sprintf(__("Page %s"), max($paged, $page));
        }

        $title[] = get_bloginfo("name");
    }

    return apply_filters("uf_title", $title);
}


/**
 * is installed SEO plugins ?
 *
 * @return Bool
 */
function _uf_exists_seo_plugins() {
    $seo_plugins = array(
        "class" => array(
            "All_in_One_SEO_Pack", "Platinum_SEO_Pack"
        ),
        "method" => array(
        )
    );

    foreach($seo_plugins as $type => $vars) {
        foreach($seo_plugins[$type] as $var) {
            if(function_exists($var) || class_exists($var)) {
                return true;
            }
        }
    }
    return false;
}


/**
 * load enqueued stylesheets
 *
 */
function uf_css() {
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






