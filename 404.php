<?php /* unifyFramework 404 template. */ ?>
<?php get_header(); ?>

<div id="main-contents" class="<?php echo uf_get_contents_class(); ?>">
    <?php if(!have_posts()): ?>
    <div class="post">
        <h2 class="post_title"><?php printf(__("Post are not found.", "unify_framework")); ?></h2>
        <p><?php printf(__("the request post is not found. try, search might find it.", "unify_framework")); ?></p>
        <?php get_search_form(); ?>
    <!-- End post --></div>
    <?php endif; ?>
<!-- End main-contents --></div>
<?php get_footer(); ?>