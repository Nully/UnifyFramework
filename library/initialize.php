<?php
define("UF_VERSION", "1.0-Beta");
define("UF_SUPPOR_VERSION", "2.9");
define("UF_LIB_PATH", realpath(dirname(__FILE__). "/../library"). "/");


if(version_compare(UF_SUPPOR_VERSION, $wp_version, ">=")) {
    wp_die(sprintf(
        "this WordPress version unsupported UnifyFramework.<br />\n".
        "WordPress Version: %s<br />".
        "UnifyFramework Version: %s<br />",
        $wp_version, UF_VERSION
    ));
}

/**
 * load functions directory PHP file.
 */
require_once UF_LIB_PATH. "functions/uf_utility.php";
require_once UF_LIB_PATH. "functions/uf_custom-post.php";
require_once UF_LIB_PATH. "functions/uf_editor-style.php";
require_once UF_LIB_PATH. "functions/uf_custom-header.php";
require_once UF_LIB_PATH. "functions/uf_post-thumbnail.php";
require_once UF_LIB_PATH. "functions/uf_custom-background.php";
require_once UF_LIB_PATH. "functions/uf_feed-links.php";
require_once UF_LIB_PATH. "functions/uf_nav-menus.php";
require_once UF_LIB_PATH. "functions/uf_title.php";

/**
 * load widget directory PHP file.
 */
require_once UF_LIB_PATH. "widgets/uf_widgets-register.php";

