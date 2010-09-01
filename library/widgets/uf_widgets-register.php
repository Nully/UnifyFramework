<?php
/**
 * UnifiFramework Widgets support
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
    register_sidebars(4, array(
        "name"        => __("Footer Sidebar %s"),
        "id"          => "footer-widget",
        "description" => __("for Footer widgets"),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => "</div>\n",
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => "</h3>\n",
    ));
}

