<?php
define("UF_VERSION", "1.0-Beta");
define("UF_SUPPOR_VERSION", "2.9");
define("UF_LIB_PATH", realpath(dirname(__FILE__). "/../library"). "/");


if(version_compare(UF_SUPPOR_VERSION, $wp_version, ">=")) {
    wp_die(sprintf(__(
        "this WordPress version unsupported UnifyFramework.<br />\n".
        "WordPress Version: %s<br />".
        "UnifyFramework Version: %s<br />",
        $wp_version, UF_VERSION
    )));
}



if(function_exists("register_nav_menus")) {
    register_nav_menu("Primary nav menu", "primary navigation menu");
}



/**
 * load functions directory PHP file.
 */
if(is_admin()) /* load admin page only.*/
    require_once UF_LIB_PATH. "functions/uf_admin.php";

require_once UF_LIB_PATH. "functions/uf_actions.php";
require_once UF_LIB_PATH. "functions/uf_theme-supports.php"
require_once UF_LIB_PATH. "functions/uf_comments.php";
require_once UF_LIB_PATH. "functions/uf_post-thumbnail.php";
require_once UF_LIB_PATH. "functions/uf_posts.php";
require_once UF_LIB_PATH. "functions/uf_template.php";
require_once UF_LIB_PATH. "functions/uf_pagenavi.php";
require_once UF_LIB_PATH. "functions/uf_widget.php";

