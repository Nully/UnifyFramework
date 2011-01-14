<?php
/**
 * UnifyFramework Theme function
 * 
 */
// require UnifyFramework scripts
require_once dirname(__FILE__). "/library/uf-load.php";

/**
 * WordPress native Theme Supports
 * 
 */
/**
 * CustomBackground
 * 
 */
add_custom_background($header_callback, $admin_header_callback, $admin_image_div_callback);
/**
 * Custom ImageHeader
 * 
 */
add_custom_image_header($header_callback, $admin_header_callback, $admin_image_div_callback);
/**
 * EditorStyle
 * 
 */
add_editor_style("editor-style.css");


