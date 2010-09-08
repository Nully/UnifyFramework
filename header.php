<?php /* UnifyFramework header template. */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="charset" content="<?php bloginfo("charset"); ?>" />
    <?php uf_titel(); ?>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php uf_css(); ?>
    <?php uf_javascript(); ?>
    <?php wp_head(); ?>
</head>
<body <?php uf_body_class(); ?>>
    <div id="container" class="container_16">
        <div id="header" class="grid_16">
            <h1><a href="<?php bloginfo("home"); ?>"><?php bloginfo("name"); ?></a></h1>
            <p id="description"><?php bloginfo("description"); ?></p>
            <div id="navigation"><?php uf_nav_menu(array( "menu_class" => "menu-nav clearfix", "theme_location" => "primary" )); ?></div>
            <div id="custom-header-image"><?php uf_custom_header(); ?></div>
        <!-- End header --></div>
        <div id="contents" class="clearfix">
        <?php get_sidebar("left"); ?>



