<?php /* UnifyFramework page template. */ ?>
<?php get_header(); ?>
<div id="main-contents" class="<?php echo uf_get_contents_class(); ?>">
    <?php if(have_posts()): ?><?php while(have_posts()): the_post(); ?>
    <div id="post-<?php the_ID(); ?>" class="post">
        <div id="post-header-meta-<?php the_ID(); ?>" class="post_header_meta clearfix">
            <p class="author_name"><?php the_author_link(); ?></p>
            <p class="post_date"><?php echo get_post_time("Y/m/d (D) H:i:s"); ?></p>
        <!-- End post-header-meta-<?php the_ID(); ?> --></div>
        <h2 class="post_title"><?php the_title(); ?></h2>
        <div id="post_content_<?php the_ID(); ?>" class="post_content">
            <?php the_content(); ?>
        <!-- End post_content_<?php the_ID(); ?> --></div>
        <div id="post-footer-meta-<?php the_ID(); ?>" class="post_footer_meta clearfix">
            <p class="post_comments_count">Comments: <?php echo uf_get_comment_count("approved"); ?></p>
            <?php the_tags('| Tags: <p class="post_tags">[', "][", "]</p>"); ?>
        <!-- End post-footer-meta-<?php the_ID(); ?> --></div>
    <!-- End post-<?php the_ID(); ?> --></div>
    <?php endwhile;?><?php endif; ?>
    <div id="uf-pagenavi" class="clearfix"><?php uf_pagenavi(); ?></div>
<!-- End main-contents --></div>

<?php get_footer(); ?>