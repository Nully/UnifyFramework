<?php
/**
 * UnifyFramework theme template scripts.
 * 
 * @package UnifyFramework
 */

/**
 * display body class
 * 
 * @param  $class   String|Array
 * @return Void
 * @filter body_class, uf_body_class
 */
function uf_body_class($class = null) {
    echo 'class="'. join(" ", uf_get_body_class($class)) .'"';
}


/**
 * get body class
 * 
 * @param  $class String|Array
 * @return Array
 * @filter body_class, uf_body_class
 */
function uf_get_body_class($class = null) {
    global $is_IE, $is_IIS, $is_NS4, $is_apache, $is_chrome, $is_gecko,
            $is_iis7, $is_iphone, $is_lynx, $is_macIE, $is_opera,
            $is_trash, $is_winIE, $is_main_site;

    $base_class = get_body_class($class);

    $additional_class = array();
    if($is_IE) $additional_class [] = "ie";
    if($is_II) $additional_class [] = "iis";
    if($is_NS4) $additional_class [] = "ns4";
    if($is_apache) $additional_class [] = "apache";
    if($is_chrome) $additional_class [] = "chrome";
    if($is_gecko) $additional_class [] = "gecko";
    if($is_iis7) $additional_class [] = "iis7";
    if($is_iphone) $additional_class [] = "iphone";
    if($is_lynx) $additional_class [] = "lynx";
    if($is_macIE) $additional_class [] = "mac-ie";
    if($is_opera) $additional_class [] = "opera";
    if($is_trash) $additional_class [] = "trash";
    if($is_winIE) $additional_class [] = "win-ie";
    if(isset($is_main_site) && $is_main_site) $additional_class [] = "main-site";

    $classes = array_merge($base_class, $additional_class);
    return apply_filters("uf_body_class", $classes);
}

