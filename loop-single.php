<div id="contents" class="grid9">
<?php if(have_posts()): the_post(); ?>

<div id="post_<?php the_ID(); ?>" <?php post_class("post"); ?>>
    <h1 class="post-title"><?php the_title(); ?></h1>
    <?php uf_posted_on(); ?>
    <div class="post-content"><?php the_content(); ?></div>

<?php $images = get_children(array( "post_parent" => get_the_ID(), "post_type" => "attachment", "post_mime_type" => "image", "orderby" => "menuorder", "order" => "ASC", "numberposts" => 999 )); ?>
<?php if("gallery" == get_post_format(get_the_ID()) && count($images) > 0): ?>
    <div class="gallery-thumbails">
        <ul><?php foreach($images as $image): ?>
            <li><?php echo wp_get_attachment_link($image->ID, "thumbnail"); ?></li>
        <?php endforeach; ?></ul>
    <!-- End gallery thumbnails --></div>
<?php endif; ?>
    <?php uf_post_meta(); ?>
<!-- End post_<?php the_ID(); ?> --></div>

<?php comments_template(); ?>

<?php if(get_the_author_meta("description")): ?>
    <div id="author_<?php echo get_the_author_meta("user_login"); ?>" class="author-detail">
        <div class="author-avatar">
            <?php echo get_avatar(get_the_author_meta("user_email"), apply_filters("uf_author_avatar_bio_size", 60)); ?>
        <!-- End author avatar --></div>
        <h2 class="author-name"><?php printf(esc_attr__("About %s", UF_TEXTDOMAIN), get_the_author_meta("display_name")); ?></h2>
        <div class="author-description"><?php the_author_meta("description"); ?></div>
        <p class="author-posts-link"><?php echo get_author_posts_url(get_the_author_meta("id")) ?></p>
    <!-- End author detail --></div>
<?php endif; ?>

<?php get_template_part("partial/pagenav"); ?>

<?php endif; ?>
<!-- End contents --></div>