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
        <div id="container">
            <div id="header">
                <h1><a href="<?php bloginfo("home"); ?>"><?php bloginfo("name"); ?></a></h1>
                <p><?php bloginfo("description"); ?></p>
                <?php uf_nav_menu(array( "menu_class" => "menu-nav", "theme_location" => "primary" )); ?>
                <div id="custom-header-image"><?php uf_custom_header(); ?></div>
            <!-- End header --></div>
            <div id="contents">
                <?php if(uf_has_sidebar(__("Left Sidebar"))): ?><?php uf_get_sidebar(__("Left Sidebar")); ?><?php endif; ?>
                <div id="main-contents"></div>
                <?php if(uf_has_sidebar(__("Right Sidebar"))): ?><?php uf_get_sidebar(__("Right Sidebar")); ?><?php endif; ?>
            <!-- End contents --></div>
        <!-- End container --></div>
    </body>
    <?php wp_footer(); ?>
</html>