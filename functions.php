<?php
/**
 * UnifyFramework functions support
 *
 */
define("UF_VERSION", "1.0-Beta");
define("UF_SUPPOR_VERSION", "2.9");
define("UF_LIB_PATH", realpath(dirname(__FILE__). "/../library"). "/");


if(version_compare(UF_SUPPOR_VERSION, $wp_version, ">=")) {
    if(is_admin())
        add_action("admin_notices", "uf_unsupported_version_notice");
    else {
        wp_die(sprintf(__(
            "this WordPress version unsupported UnifyFramework.<br />\n".
            "WordPress Version: %s<br />".
            "UnifyFramework Version: %s<br />",
            $wp_version, UF_VERSION
        )));
    }

}


// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'unify_framework', TEMPLATEPATH . '/langs' );


/**
 * Over than WordPress version 3, register custom menu.
 *
 */
if(function_exists("register_nav_menus")) {
    register_nav_menu("Primary nav menu", "primary navigation menu");
}


/**
 * Load UnifyFramework uses scripts
 *
 */
require_once TEMPLATEPATH. "/includes/core.php";
require_once TEMPLATEPATH. "/includes/actions.php";
require_once TEMPLATEPATH. "/includes/helpers.php";
require_once TEMPLATEPATH. "/includes/theme-support.php";
require_once TEMPLATEPATH. "/includes/template.php";
require_once TEMPLATEPATH. "/includes/posts.php";
require_once TEMPLATEPATH. "/includes/comments.php";
require_once TEMPLATEPATH. "/includes/pagenavi.php";
require_once TEMPLATEPATH. "/includes/widget.php";


/**
 * Load extensions
 */
require_once TEMPLATEPATH. "/includes/extension.php";
require_once TEMPLATEPATH. "/includes/extensions/default-extensions.php";


if(is_admin()) {
    require_once TEMPLATEPATH. "/includes/admin.php";
}


/**
 * Load user original custom functions
 *
 */
if(file_exists(TEMPLATEPATH. "/includes/custom-functions.php")) {
    require_once TEMPLATEPATH. "/includes/custom-functions.php";
}


/**
 * Hook uf_init registerd hooks
 * 
 */
do_action("uf_init");



