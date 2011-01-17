<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo("charset"); ?>" />
<title><?php wp_title(); ?></title>

<link href="<?php echo get_template_directory_uri(); ?>/css/unify.css" type="text/css" rel="stylesheet" />
<link href="<?php bloginfo("stylesheet_url"); ?>" type="text/css" rel="stylesheet" />

<link rel="alternate" type="application/rss+xml" href="<?php bloginfo("rss2_url"); ?>" title="<?php printf( __( '%s latest posts', 'arras' ), wp_specialchars( get_bloginfo('name'), ENT_NOQUOTES ) ); ?>" />
<link rel="alternate" type="application/rss+xml" href="<?php bloginfo("comments_rss2_url") ?>" title="<?php printf( __( '%s latest comments', 'arras' ), wp_specialchars( get_bloginfo('name'), ENT_NOQUOTES ) ); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php
if(is_singular()) {
    wp_enqueue_script('comment-reply');
}

wp_head(); ?>
</head>
<body <?php uf_body_class("unify_framework"); ?>>
<div id="container" class="container">
    <div id="header">
        <div id="header_logo">
            <?php if(is_home() || is_front_page()): ?>
            <h1 id="site_name"><?php bloginfo("name"); ?></h1>
            <?php else: ?>
            <h2 id="site_name"><?php bloginfo("name"); ?></h2>
            <?php endif; ?>
            <p id="site_description"><?php bloginfo("description"); ?></p>
        </div>

        <div id="header_search">
            <?php wp_nav_menu(array(
                "theme_location" => "global_navigation",
                "menu_id"        => "global-nav"
            )); ?>
            <?php get_search_form(); ?>
        </div>

        <div id="header_image"><?php uf_get_header_image(); ?></div>
    <!-- End header --></div>

    <div id="contents">
        <div id="main_contents" class="grid9">
            <?php if(have_posts()): while(have_posts()): the_post(); ?>
            <?php the_content(); ?>
            <?php endwhile; else: ?>
            <?php endif; ?>
        <!-- End main_contents --></div>

        <div id="right_sidebar" class="grid3 last">
            <?php get_sidebar("right"); ?>
        <!-- End right_sidebar --></div>
    <!-- End contents --></div>

    <div id="footer">
        <?php wp_nav_menu(array(
            "theme_location" => "footer_navigation"
        )); ?>
        <address><?php printf(__('Copyright &copy; %s %s, Theme by <a href="https://github.com/Nully/UnifyFramework">UnifyFramework</a>'), date("Y"), get_bloginfo("name")); ?></address>
    <!-- End footer --></div>
<!-- End container --></div>
<?php wp_footer(); ?>
</body>
</html>
