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
<p id="site_name"><a href="<?php bloginfo("home"); ?>"><?php bloginfo("name"); ?></a></p>
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


