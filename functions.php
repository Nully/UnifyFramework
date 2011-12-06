<?php
/**
 * UnifyFramework Theme function
 */
/**
 * @UF_BASE_PATH
 */
# define("UF_BASE_PATH", dirname(__FILE__));
/**
 * @UF_INC_PATH
 */
# define("UF_INC_PATH", UF_BASE_PATH. "/inc");

/*
require_once UF_INC_PATH. "/class-plugin.php";
require_once UF_INC_PATH. "/class-posttype.php";
require_once UF_INC_PATH. "/class-widget.php";
require_once UF_INC_PATH. "/class-thumbnail.php";
require_once UF_INC_PATH. "/class-format.php";
*/
/**
 * @UNIFY_BASE_PATH
 */
define("UNIFY_BASE_PATH", dirname(__FILE__));

/**
 * UNIFY_INC_PATH
 */
define("UNIFY_INC_PATH", UNIFY_BASE_PATH. "/includes");


add_action("init", "unifyframework_init");
function unifyframework_init()
{
    require_once UNIFY_INC_PATH. "/class-dashboard.php";
    require_once UNIFY_INC_PATH. "/class-widgets.php";
    $unify_dashboard = new UnifyFramework_Admin_Dashboard();
    $unify_dashboard->register_theme_page(new UnifyFramework_Admin_Widgets());
}


