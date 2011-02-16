<?php
/**
 * UF_TEXTDOMAIN
 */
define("UF_TEXTDOMAIN", "unify_framework");
/**
 * UF_VERSION
 */
define("UF_VERSION", 1.0);
/**
 * UF_SUPPORT_VERSION
 */
define("UF_SUPPORT_VERSION", "3.0");
/**
 * UF_LIB_PATH
 */
define("UF_LIB_PATH", dirname(__FILE__));
/**
 * UF_OPTION_WIDGET
 */
define("UF_OPTION_WIDGET", "uf_widgets");
/**
 * UF_OPTION_CUSTOM_MENU
 */
define("UF_OPTION_CUSTOM_MENU", "uf_custom_menus");
/**
 * HEADER_TEXTCOLOR
 */
define("HEADER_TEXTCOLOR", "FFFFFF");
/**
 * HEADER_IMAGE
 */
define("HEADER_IMAGE", "%s/img/headers/cherryblossom.jpg");
/**
 * HEADER_IMAGE_WIDTH
 */
define("HEADER_IMAGE_WIDTH", apply_filters("uf_header_image_width", 978));
/**
 * HEADER_IMAGE_HEIGHT
 */
define("HEADER_IMAGE_HEIGHT", apply_filters("uf_header_image_height", 240));
/**
 * BACKGROUND_COLOR
 */
define("BACKGROUND_COLOR", "f7f7f7");
/**
 * Title separators
 */
$uf_title_separators = apply_filters("uf_title_separators", array(
    "lt" => '&lt;',
    "gt" => '&gt;',
    "raquo" => '&raquo;',
    "laquo" => '&raquo;',
    "pipe"  => " | ",
));

