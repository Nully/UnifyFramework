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
                <?php uf_nav_menu(array( "menu_class" => "menu-nav", "theme_location" => "primary" )); ?>
                <div id="custom-header-image"><?php uf_custom_header(); ?></div>
            <!-- End header --></div>
            <div class="clear"></div>
            <div id="contents">
                <?php if(uf_has_sidebar("left-sidebar")): ?>
                    <div id="left-sidebar" class="grid_4"><?php uf_get_sidebar("left-sidebar"); ?></div>
                <?php endif; ?>


                <div id="main-contents" class="<?php echo uf_get_contents_class(); ?>">
                    <?php if(have_posts()): ?><?php while(have_posts()): the_post(); ?>
                    <div id="post-<?php the_ID(); ?>" class="post">
                        <div id="post-header-meta-<?php the_ID(); ?>" class="post_header_meta clearfix">
                            <p class="author_name"><?php the_author_link(); ?></p>
                            <p class="post_date"><?php echo get_post_time("Y/m/d (D) H:i:s"); ?></p>
                        <!-- End post-header-meta-<?php the_ID(); ?> --></div>
                        <h2 class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div id="post_content_<?php the_ID(); ?>" class="post_content">
                            <?php the_content(get_the_title()); ?>
                        <!-- End post_content_<?php the_ID(); ?> --></div>
                        <div id="post-footer-meta-<?php the_ID(); ?>" class="post_footer_meta clearfix">
                            <p class="post_comments_count">Comments: <?php echo uf_get_comment_count("approved"); ?></p>
                            <?php the_tags('| <p class="post_tags">[', "][", "]</p>"); ?>
                        <!-- End post-footer-meta-<?php the_ID(); ?> --></div>
                    <!-- End post-<?php the_ID(); ?> --></div>
                    <?php endwhile;?><?php endif; ?>
                    <?php if($wp_query->max_num_pages >= 2): ?>
                    <div id="uf-pagenavi" class="clearfix"><?php uf_pagenavi(); ?></div>
                    <?php endif; ?>
                    <?php comments_template(); ?>
                <!-- End main-contents --></div>


                <?php if(uf_has_sidebar("right-sidebar")): ?>
                    <div id="right-sidebar" class="grid_4"><?php uf_get_sidebar("right-sidebar"); ?></div>
                <?php endif; ?>
                <div class="clear"></div>
            <!-- End contents --></div>
        <!-- End container --></div>
        <div id="footer">
            <div id="footer-in" class="container_16">
                <?php if(is_active_sidebar("footer-widget")): ?>
                    <?php dynamic_sidebar("footer-widget"); ?>
                <?php endif; ?>
                <?php if(is_active_sidebar("footer-widget-2")): ?>
                    <?php dynamic_sidebar("footer-widget-2"); ?>
                <?php endif; ?>
                <?php if(is_active_sidebar("footer-widget-3")): ?>
                    <?php dynamic_sidebar("footer-widget-3"); ?>
                <?php endif; ?>
                <?php if(is_active_sidebar("footer-widget-4")): ?>
                    <?php dynamic_sidebar("footer-widget-4"); ?>
                <?php endif; ?>
                <address>Copyright © 2010 <a href="<?php bloginfo("home"); ?>"><?php bloginfo("name"); ?></a> - All Rights Reserved<br />
                    Powered by WordPress & the UnifyFramework Theme by <a href="http://blog.nully.org/">Nully</a>.</address>
            <!-- End footer_in --></div>
        <!-- End footer --></div>
    </body>
    <?php wp_footer(); ?>
</html>