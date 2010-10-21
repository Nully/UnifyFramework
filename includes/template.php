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



/**
 * UnifyFramework original page navigation.
 *
 * @access public
 * @param  $args    Array|String|Null   page navigation arguments
 * @return Void
 */
function uf_pagenavi($args = null) {
    if(function_exists("wp_pagenavi")) {
        wp_pagenavi();
        return;
    }

    if(is_singular()) {
        uf_pagenavi_singular();
    }
    else {
        uf_pagenavi_pager();
    }
}



/**
 * is_singular post page navigation.
 *
 * @access protected
 * @param  $args    Array|String|Null
 *   next_post_link_text: next post link text. %link is replace to link tag.
 *   prev_post_link_text: prev post link text. %link is replace to link tag.
 * @return Void
 */
function uf_pagenavi_singular($args = null) {
    $defaults = array(
        "next_post_link_text" => '<p class="next-post">&raquo; %link</p>',
        "prev_post_link_text" => '<p class="prev-post">&laquo; %link</p>',
        "link_text_format"    => "%title"
    );
    $args = wp_parse_args($args, $defaults);
    $args = apply_filters("uf_pagenavi_formats", $args);

    previous_post_link($args["prev_post_link_text"], $args["link_text_format"]);
    next_post_link($args["next_post_link_text"], $args["link_text_format"]);
}



/**
 * Display pagenavi.
 *
 * @access protected
 * @param  $args      Array|String|Null
 *   first_page_link_text:
 *   last_page_link_text:
 *   pages_link_format:
 * @return Void
 */
function uf_pagenavi_pager($args = null) {
    global $wp_query;

    $defaults = array(
        "page_of_format"         => '<span class="uf-page-of">Page %current of %max</span>'. "\n",
        "first_page_link_format" => '<a href="%link"><span class="uf-pagenavi uf-pagenavi-to-first">&laquo;</span></a>'. "\n",
        "last_page_link_format"  => '<a href="%link"><span class="uf-pagenavi uf-pagenavi-to-last">&raquo;</span></a>'. "\n",
        "next_page_link_format"  => '<a href="%link"><span class="uf-pagenavi uf-pagenavi-next-page">&gt;</span></a>'. "\n",
        "prev_page_link_format"  => '<a href="%link"><span class="uf-pagenavi uf-pagenavi-prev-page">&lt;</span></a>'. "\n",
        "pages_link_format"      => '<span class="uf-pagenavi uf-pagenumber uf-pagenumber-%page%current">%title</span>',
        "pages_dot"              => '<span class="uf-pagenavi uf-pagenavi-dot">...</span>'
    );
    $args = wp_parse_args($args, $defaults);
    $args = apply_filters("uf_pagenavi_formats", $args);

    $paged = get_query_var("paged");
    $posts_per_page = get_query_var("posts_per_page");
    if(empty($paged))
        $paged = 1;

    $max_pages = $wp_query->max_num_pages;
    if($max_pages <= 1)
        return;

    $show_page_number = 5; // @TODO: admin theme setting show_page_number.

    // start page number
    $start_page = $paged - floor(($show_page_number - 1) / 2);
    if($start_page <= 0)
        $start_page = 1;

    // end page number
    $end_page = $start_page + $show_page_number - 1;
    if($end_page >= $max_pages)
        $end_page = $max_pages;

    if(($end_page - $start_page) != $show_page_number)
        $start_page += ($end_page - $start_page)- $show_page_number + 1;

    // @TODO: theme admin pnale setting display pagenavi prefix [Page 1 of (Max)]
    echo str_replace(array("%current", "%max"), array($paged, $max_pages), $args["page_of_format"]);

    // for first page link text.
    if($paged != 1)
        echo str_replace("%link", get_pagenum_link (1), $args["first_page_link_format"]);

    // for previous page link.
    if($paged > 1)
        echo str_replace("%link", get_pagenum_link($paged - 1), $args["prev_page_link_format"]);

    // display number pages.
    for($i = $start_page; $i <= $end_page; $i ++) {
        $current = " uf-page-current";
        $link_tpl = $args["pages_link_format"];
        if($i != $paged) {
            $current = "";
            $link_tpl = '<a href="'. get_pagenum_link($i) .'">'. $link_tpl. "</a>";
        }

        echo str_replace(array("%page", "%current", "%title"), array($i, $current, $i), $link_tpl);
    }

    // for next page link.
    if($paged < $max_pages)
         echo str_replace("%link", get_pagenum_link($paged + 1), $args["next_page_link_format"]);

    // for last page link text.
    if($paged != $max_pages)
        echo str_replace("%link", get_pagenum_link($max_pages), $args["last_page_link_format"]);
}




