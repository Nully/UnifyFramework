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
<div id="container" >
    <div id="inner_container" class="container">
        <div id="header">
            <div id="header_logo">
                <?php if(is_home() || is_front_page()): ?>
                <h1 id="site_name"><a href="<?php bloginfo("home"); ?>"><?php bloginfo("name"); ?></a></h1>
                <?php else: ?>
                <h2 id="site_name"><a href="<?php bloginfo("home"); ?>"><?php bloginfo("name"); ?></a></h2>
                <?php endif; ?>
                <p id="site_description"><?php bloginfo("description"); ?></p>
            <!-- End header_logo --></div>

            <div id="header_search">
                <?php wp_nav_menu(array(
                       "theme_location" => "global_navi",
                   )); ?>
                <?php get_search_form(); ?>
            <!-- End header_search --></div>
        <!-- End header --></div>

        <div id="header_image"><?php uf_get_header_image(); ?></div>
        <div id="contents">
            <div id="main_contents" class="grid9">
                <?php if(have_posts()): while(have_posts()): the_post(); ?>
                <div id="post_<?php the_ID(); ?>" class="post">
                    <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php uf_posted_on(); ?>
                    <div class="post-content">
                        <?php if(has_excerpt()): ?>
                        <?php the_excerpt(); ?>
                        <?php else: ?>
                        <?php the_content(__("Read more &raquo;", UF_TEXTDOMAIN)); ?>
                        <?php endif; ?>
                    </div>
                    <?php uf_post_meta(); ?>
                <!-- End post_<?php the_ID(); ?> --></div>

                <?php if(is_singular()): ?>
                <?php comments_template(); ?>
                <?php endif; ?>
                <?php endwhile; else: ?>
                <?php endif; ?>
                <?php get_template_part("pagenav"); ?>
            <!-- End main_contents --></div>

            <div id="right_sidebar" class="grid3 last">
                <?php get_sidebar("right"); ?>
            <!-- End right_sidebar --></div>
        <!-- End contents --></div>

        <div id="footer" class="clearfix">
            <?php get_sidebar("footer"); ?>
            <div id="footer_nav">
                <?php wp_nav_menu(array(
                      "container"       => false,
                      "theme_location" => "footer_navi",
                  )); ?>
                <address><?php printf(__('Copyright &copy; %s %s, Theme by <a href="https://github.com/Nully/UnifyFramework">UnifyFramework</a>'), date("Y"), get_bloginfo("name")); ?></address>
            </div>
        <!-- End footer --></div>
    <!-- End inner_container --></div>
<!-- End container --></div>
<?php wp_footer(); ?>
</body>
</html>
