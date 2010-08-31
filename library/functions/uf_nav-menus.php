<?php
/**
 * UnifyFramework NavMenus support
 */
if(function_exists("register_nav_menus")) {
    register_nav_menus(array(
        "primary" => "Primary Navigation"
    ));
}


/**
 * WordPress core over than 3.0, callable wp_nav_menu.
 * else, callable wp_page_menu.
 *
 * wp_nav_menu
 *  menu - The menu that is desired.  Accepts (matching in order) id, slug, name. Defaults to blank.
 *  menu_class - CSS class to use for the ul element which forms the menu. Defaults to 'menu'.
 *  menu_id - The ID that is applied to the ul element which forms the menu. Defaults to the menu slug, incremented.
 *  container - Whether to wrap the ul, and what to wrap it with. Defaults to 'div'.
 *  container_class - the class that is applied to the container. Defaults to 'menu-{menu slug}-container'.
 *  container_id - The ID that is applied to the container. Defaults to blank.
 *  fallback_cb - If the menu doesn't exists, a callback function will fire. Defaults to 'wp_page_menu'.
 *  before - Text before the link text.
 *  after - Text after the link text.
 *  link_before - Text before the link.
 *  link_after - Text after the link.
 *  echo - Whether to echo the menu or return it. Defaults to echo.
 *  depth - how many levels of the hierarchy are to be included.  0 means all.  Defaults to 0.
 *  walker - allows a custom walker to be specified.
 *  theme_location - the location in the theme to be used.  Must be registered with register_nav_menu() in order to be selectable by the user.
 *
 * wp_page_menu
 *  sort_column: sort oder columns. default 'menu_order, post_title'
 *  menu_class:  wrapped div element class name, default 'menu'
 *  echo:        is direct display,  default 'true'
 *  link_before: before menu link prefx, default ''
 *  link_after:  after menu link suffix, default''
 *
 * @return String
 */
function uf_nav_menu($args = array()) {
    if(function_exists("wp_nav_menu")) {
        $menu = wp_nav_menu($args);
    }
    else {
        $menu = wp_page_menu($args);
    }
    return appy_filter("uf_nav_menu", $menu);
}
