<div id="main_contents" class="grid9">
<?php if(!have_posts()): ?>
<div id="post_0" class="post">
    <h2 class="post-title"><?php _e("Posts Not Found", UF_TEXTDOMAIN); ?></h2>
    <div class="post-content">
        <p><?php _e("Post are not found.<br />try again search this form.", UF_TEXTDOMAIN); ?></p>
        <?php get_search_form(); ?>
    <!-- End post content --></div>
<!-- End post_0 --></div>
<?php endif; ?>


<?php if(is_archive()): ?>
<?php if(is_day()): ?>
    <p class="page-title"><?php printf(__('Day archives: <em>%s</em>'), get_the_date()); ?></p>
<?php elseif(is_month()): ?>
    <p class="page-title"><?php printf(__("Month archives: <em>%s</em>"), get_the_date("Y/m")); ?></p>
<?php elseif(is_year()): ?>
    <p class="page-title"><?php printf(__("Year archives: <em>%s</em>"), get_the_date("Y")); ?></p>
<?php elseif(is_tag()): ?>
    <p class="page-title"><?php _e('Tag: ', UF_TEXTDOMAIN); ?><em><?php single_tag_title(); ?></em></p>
<?php elseif(is_category()): ?>
    <p class="page-title"><?php _e('Category: ', UF_TEXTDOMAIN); ?><em><?php single_cat_title(); ?></em></p>
<?php else: ?>
    <p class="page-title"><?php _e("Blog archives", UF_TEXTDOMAIN); ?></p>
<?php endif; ?>
<?php endif; ?>


<?php
/**
 * Have posts loop start
 */
?>
<?php while(have_posts()): the_post(); ?>
<div id="post_<?php the_ID(); ?>" <?php post_class("post"); ?>>

<?php if("aside" == get_post_format($post->ID)): ?>
<h2 class="post-title"><?php the_title(); ?></h2>
<?php uf_posted_on(); ?>
<div class="post-content"><?php the_content(); ?></div>
<p class="post-format-link more-aside-link"><a href="<?php echo get_post_format_link("aside"); ?>"><?php _e("Read more aside contents &raquo;", UF_TEXTDOMAIN); ?></a></p>


<?php elseif("gallery" == get_post_format ($post->ID)): ?>
<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php $images = get_posts(array( "post_parent" => $post->ID, "numberposts" => 999, "post_type" => "attachment", "post_mime_type" => "image", "orderby" => "menu_order", "order" => "ASC" )); ?>
<?php if(count($images)): ?>
    <div class="post-gallery-thumbnail">
        <?php
            $counts = count($images);
            $image = array_shift($images);
            $src = wp_get_attachment_image($image->ID, "thumbnail");
        ?>
        <a href="<?php the_permalink(); ?>"><?php echo $src; ?></a>
    <!-- End post gallery thumbnail --></div>
    <div class="post-gallery-comments">
        <p><em><?php printf(_n('this gallery has contain %1$s Photo', 'this gallery has contain %1$s Photos', $counts, UF_TEXTDOMAIN), $counts); ?></em></p>
    </div>
<?php endif; ?>
<div class="post-content"><?php the_excerpt(); ?></div>
<p class="post-format-link more-gallery-link"><a href="<?php echo get_post_format_link("gallery"); ?>"><?php _e("Read more galleries. &raquo;", UF_TEXTDOMAIN); ?></a></p>


<?php elseif("status" == get_post_format($post->ID)): ?>
<h2 class="post-title"><?php the_title(); ?></h2>
<div class="post-content"><?php the_excerpt(); ?></div>
<p class="post-format-link more-status-link"><a href="<?php echo get_post_format_link("status"); ?>"><?php _e("Read more status posts &raquo;", UF_TEXTDOMAIN); ?></a></p>


<?php else: ?>
<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php uf_posted_on(); ?>
<div class="post-content">
<?php if(has_excerpt()): ?>
    <?php the_excerpt(); ?>
<?php else: ?>
    <?php the_content(__("Read more &raquo;", UF_TEXTDOMAIN)); ?>
<?php endif; ?>
</div>
<?php endif; ?>
<?php uf_post_meta(); ?>

<!-- End post_<?php the_ID(); ?> --></div>
<?php endwhile; ?>

<?php get_template_part("partial/pagenav"); ?>
<!-- End main_contents --></div>
