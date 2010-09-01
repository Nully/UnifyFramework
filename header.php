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
        <?php get_sidebar(); ?>
    </body>
    <?php wp_footer(); ?>
</html>