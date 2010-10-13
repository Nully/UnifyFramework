<?php
/**
 * UnifiFramework Widgets support
 *
 */
if(function_exists("register_sidebar")) {
    // for left sidebar
    register_sidebar(array(
		'name'          => __("Left Sidebar"),
		'id'            => "left-sidebar",
		'description'   => __("UnifyFramework left sidebar."),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => "</div>\n",
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => "</h3>\n",
    ));

    // for right sidebar
    register_sidebar(array(
		'name'          => __("Right Sidebar"),
		'id'            => "right-sidebar",
		'description'   => __("UnifyFramework right sidebar."),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => "</div>\n",
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => "</h3>\n",
    ));

    // register footer sidebars.
    uf_register_sidebars(4, array(
        "name"        => __("Footer Sidebar %s"),
        "id"          => "footer-widget",
        "description" => __("for Footer widgets"),
		'before_widget' => '<div id="%1$s" class="widget %2$s grid_4">',
		'after_widget'  => "</div>\n",
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => "</h4>\n",
    ));
}


/**
 * WordPress 2.9.x version, has bug for register_sidebars().
 * uses overload register_sidebars
 *
 * @access public
 * @param  $count   Int    sidebar regist loop count
 * @param  $args    Array  sidebar options
 */
function uf_register_sidebars($count = 1, $args = array()) {
    global $wp_registered_sidebars;
    if(empty($count)) {
        $count = 1;
    }

    for($i = 1; $i <= $count; $i ++) {
        $_args = $args;

        if($count > 1) {
            $_args["name"] = (isset($args["name"]) ? sprintf($args["name"], $i) : sprintf(__("Sidebar %s"), $i));
        }
        else {
            $_args["name"] = (isset($args["name"]) ? $args["name"] : __("Sidebar"));
        }

        if(!isset($args["id"])) {
            $_args["id"] = "sidebar";
        }

        $n = count($wp_registered_sidebars);
        $_args["id"] = $_args["id"] . "-". $i;

        register_sidebar($_args);
    }
}


/**
 * get sidebar
 *
 */
function uf_get_sidebar($name) {
    return dynamic_sidebar($name);
}


/**
 * has right sidebar ?
 */
function uf_has_sidebar($name) {
    return is_active_sidebar($name);
}


/**
 * get right sidebar
 *
 */
function uf_get_right_sidebar() {
    if(!uf_has_sidebar("right-sidebar")) {
        return;
    }
    dynamic_sidebar("right-sidebar");
}


/**
 * get left sidebar
 *
 */
function uf_get_left_sidebar() {
    if(!uf_has_sidebar("left-sidebar")) {
        return;
    }
    dynamic_sidebar("left-sidebar");
}

