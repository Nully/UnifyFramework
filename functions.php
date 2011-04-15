<?php
/**
 * UnifyFramework Theme function
 */
/**
 * @UF_BASE_PATH
 */
define("UF_BASE_PATH", dirname(__FILE__));
/**
 * @UF_INC_PATH
 */
define("UF_INC_PATH", UF_BASE_PATH. "/inc");


require_once UF_INC_PATH. "/class-plugin.php";
require_once UF_INC_PATH. "/class-posttype.php";
require_once UF_INC_PATH. "/class-widget.php";
require_once UF_INC_PATH. "/class-post_thumbnail.php";


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
