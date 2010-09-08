<?php
/**
 * UnifyFramework functions support
 *
 */

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'unify_framework', TEMPLATEPATH . '/langs' );
require_once dirname(__FILE__). "/library/initialize.php";


if(file_exists(UF_LIB_PATH. "custom-functions.php")) {
    require_once UF_LIB_PATH. "custom-functions.php";
}

