<?php
/**
 * Template Name: Full width page template (no sidebar)
 */
?>
<?php get_header(); ?>

<div id="page_<?php the_ID(); ?>" <?php post_class("page"); ?>>
<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<!-- End page_<?php the_ID(); ?> --></div>

<?php get_footer(); ?>
