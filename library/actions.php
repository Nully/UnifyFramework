<?php
/**
 * UnifyFramework action hooks.
 * 
 * @package UnifyFramework
 */

/**
 * WordPress version over UF_SUPPORT_VERSION checking.
 * 
 * @return Void
 * @action init
 */
add_action("init", "uf_action_version_compare");
function uf_action_version_compare() {
    global $wp_version;

    if(version_compare($wp_version, UF_SUPPORT_VERSION, "<")) {
        if(is_admin()) {
            add_action("admin_notices", "uf_action_unsupport_version");
        }
        else {
            wp_die(sprintf(__(
                "this WordPress version unsupported UnifyFramework.<br />\n".
                "WordPress Version: %s<br />\n".
                "UnifyFramework Version: %s\n"
            ), $wp_version, UF_SUPPORT_VERSION), UF_TEXTDOMAIN);
        }
    }
}


/**
 * WordPress version is not supported version, announce update WordPress core.
 * 
 * @return Void
 * @action admin_notices
 */
function uf_action_unsupport_version() {
    global $wp_version;
?>
<div class="error">
    <p><?php _e(sprintf(__("UnifyFramework unsupported WordPress version %s.", $wp_version), UF_TEXTDOMAIN)); ?></p>
    <p><?php _e(sprintf(__("Update your WordPress core version !", UF_TEXTDOMAIN))); ?></p>
    <p><?php _e(sprintf(__("UnifyFramework supported Verion %s", UF_TEXTDOMAIN), UF_SUPPORT_VERSION)); ?></p>
</div>
<?php
}



/**
 * init widgets
 * 
 * @return Void
 * @action 
 */
add_action("init", "uf_action_widget_register");
function uf_action_widget_register() {
    register_sidebar(array(
        "name" => "left-sidebar",
        "before_widget" => '<div class="widget %1$s">',
        "after_widget"  => "</div>",
        "before_title"  => '<h3 class="widget-title">',
        "after_title"   => "</h3>"
    ));
    register_sidebar(array(
        "name" => "right-sidebar",
        "before_widget" => '<div class="widget %1$s">',
        "after_widget"  => "</div>",
        "before_title"  => '<h3 class="widget-title">',
        "after_title"   => "</h3>"
    ));

    register_sidebars(4, array(
        "name" => 'footer-sidebar%1$s',
        "before_widget" => '<div class="widget %1$s">',
        "after_widget"  => "</div>",
        "before_title"   => '<h3 class="widget-title">',
        "after_title"  => '</h3>'
    ));

    $widgets = get_option("uf_widgets", array());
    foreach($widgets as $widget) {
        register_sidebar(array(
            "name" => $widget["name"],
            "description" => $widget["description"],
            "before_widget" => '<'. $widget["container_tag"].' class="widget %1$s">',
            "after_widget"  => '</'.$widget["container_tag"].'>',
            "before_title"  => '<'. $widget["title_tag"] .' class="widget-title">',
            "after_title"   => '</'.$widget["title_tag"] .'>'
        ));
    }
}


/**
 * register custom menu locations.
 * 
 * @return Void
 * @action init
 */
add_action("init", "uf_action_custom_menu_register");
function uf_action_custom_menu_register() {
    register_nav_menus(array(
        "global_navi" => __("Global navigation custom menu.", UF_TEXTDOMAIN),
        "footer_navi" => __("Footer navigation custom menu.", UF_TEXTDOMAIN)
    ));

    $menus = get_option(UF_OPTION_CUSTOM_MENU, array());
    if(!is_array($menus))
        $menus = (array)$menus;

    foreach($menus as $menu) {
        register_nav_menu($menu["location"], $menu["description"]);
    }
}


/**
 * register default header images
 * 
 * @return Void
 * @action init
 */
add_action("init", "uf_register_default_headers");
function uf_register_default_headers() {
    register_default_headers(array(
        "maiko" => array(
            'url' => '%s/img/headers/maiko.jpg',
            'thumbnail_url' => '%s/img/headers/maiko-thumb.jpg',
            'description' => __("Maiko", UF_TEXTDOMAIN)
        ),
        "cerryblossom" => array(
            'url' => '%s/img/headers/cherryblossom.jpg',
            'thumbnail_url' => '%s/img/headers/cherryblossom-thumb.jpg',
            'description' => __("CherryBlossom", UF_TEXTDOMAIN)
        ),
        "fern" => array(
            'url' => '%s/img/headers/fern.jpg',
            'thumbnail_url' => '%s/img/headers/fern-thumb.jpg',
            'description' => __("Fern", UF_TEXTDOMAIN)
        ),
        "path" => array(
            'url' => '%s/img/headers/path.jpg',
            'thumbnail_url' => '%s/img/headers/path-thumb.jpg',
            'description' => __("Path", UF_TEXTDOMAIN)
        ),
    ));
}


