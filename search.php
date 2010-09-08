<?php /* UnifyFramework search template */ ?>
<?php get_header(); ?>
<div id="main-contents" class="<?php echo uf_get_contents_class(); ?>">
    <h2 id="page-title"><?php printf(__("Search of : <span>%s</span>", "unify_framework"), get_search_query()); ?></h2>
    <?php if(have_posts()): ?>
    <p id="search-result-count"><?php printf(__("Search results of : <span>%s</span>", "unify_framework"), $wp_query->found_posts); ?></p>
    <?php while(have_posts()): the_post(); ?>
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
            <?php the_tags('| Tags: <p class="post_tags">[', "][", "]</p>"); ?>
        <!-- End post-footer-meta-<?php the_ID(); ?> --></div>
    <!-- End post-<?php the_ID(); ?> --></div>
    <?php endwhile;?>
    <?php else: ?>
    <div id="post-not-found" class="post">
        <h2 class="post_title"><?php printf(__("Search not Found.", "unify_framework")); ?></h2>
        <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'unify_framework' ); ?></p>
        <?php get_search_form(); ?>
    <!-- End post-not-found --></div>
    <?php endif; ?>
    <?php if($wp_query->max_num_pages >= 2): ?>
    <div id="uf-pagenavi" class="clearfix"><?php uf_pagenavi(); ?></div>
    <?php endif; ?>
<!-- End main-contents --></div>

<?php get_footer(); ?>