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
    if(is_admin())
        return;

    wp_enqueue_style("unify_framework-core",  get_bloginfo("template_url"). "/css/unify.css", null, UF_VERSION, "all");
    wp_enqueue_style("unify_framework-layout",  get_bloginfo("template_url"). "/css/layout.css", null, UF_VERSION, "all");

    do_action("uf_css");
}
add_action("init", "uf_css");



/**
 * load enqueued javascripts
 *
 */
function uf_javascript() {
    if(is_admin())
        return;

    wp_enqueue_script("jquery");
    wp_enqueue_script("laquu-js", get_bloginfo("template_url"). "/includes/js/jquery.laquu-min.js", null, UF_VERSION);
    wp_enqueue_script("unify-js", get_bloginfo("template_url"). "/includes/js/unify.js", null, UF_VERSION);

    // Comment reply javascript
    if(is_singular() && get_option("thread_comments")) {
        wp_enqueue_script( 'comment-reply' );
    }

    do_action("uf_javascript");
}
add_action("init", "uf_javascript");



/**
 * display pingback URL
 *
 * @access public
 * @return Void
 */
function uf_pingback_url() {
?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
}
add_action("uf_head", "uf_pingback_url");



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
 * WordPress core over than 3.0, callable wp_nav_menu.
 * else, callable wp_page_menu.
 *
 * wp_nav_menu
 *  menu - The menu that is desired.  Accepts (matching in order) id, slug, name. Defaults to blank.
 *  menu_class - CSS class to use for the ul element which forms the menu. Defaults to 'menu'.
 *  menu_id - The ID that is applied to the ul element which forms the menu. Defaults to the menu slug, incremented.
 *  container - Whether to wrap the ul, and what to wrap it with. Defaults to 'div'.
 *  container_class - the class that is applied to the container. Defaults to 'menu-{menu slug}-container'.
 *  container_id - The ID that is applied to the container. Defaults to blank.
 *  fallback_cb - If the menu doesn't exists, a callback function will fire. Defaults to 'wp_page_menu'.
 *  before - Text before the link text.
 *  after - Text after the link text.
 *  link_before - Text before the link.
 *  link_after - Text after the link.
 *  echo - Whether to echo the menu or return it. Defaults to echo.
 *  depth - how many levels of the hierarchy are to be included.  0 means all.  Defaults to 0.
 *  walker - allows a custom walker to be specified.
 *  theme_location - the location in the theme to be used.  Must be registered with register_nav_menu() in order to be selectable by the user.
 *
 * wp_page_menu
 *  sort_column: sort oder columns. default 'menu_order, post_title'
 *  menu_class:  wrapped div element class name, default 'menu'
 *  echo:        is direct display,  default 'true'
 *  link_before: before menu link prefx, default ''
 *  link_after:  after menu link suffix, default''
 *
 * @return String
 */
function uf_nav_menu($args = array(), $show = true) {
    $args = wp_parse_args(array("echo" => false), $args);
    if(function_exists("wp_nav_menu")) {
        $menu = wp_nav_menu($args);
    }
    else {
        $menu = wp_page_menu($args);
    }
    $menu = apply_filters("uf_nav_menu", $menu);

    if($show) {
        echo $menu;
    }
    else {
        return $menu;
    }
}



/**
 * get partial loop template
 *
 * @since  1.0 beta
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






