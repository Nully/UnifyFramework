<?php
/**
 * UnifyFramework Theme function
 */
/**
 * CustomBackground
 */
add_custom_background($header_callback, $admin_header_callback, $admin_image_div_callback);
/**
 * Custom ImageHeader
 */
add_custom_image_header($header_callback, $admin_header_callback, $admin_image_div_callback);
/**
 * EditorStyle
 */
// add_editor_style("editor-style.css");
/**
 * Theme support PostThumbnail
 */
// add_theme_support("post-thumbnails", array( "page", "post" ));
/**
 * Post thumbnail size
 */
// set_post_thumbnail_size(HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, false);
/**
 * require UnifyFramework scripts
 */
require_once dirname(__FILE__). "/library/uf-load.php";

