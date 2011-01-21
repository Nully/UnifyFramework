<?php
/**
 * UnifyFramework theme template scripts.
 * 
 * @package UnifyFramework
 */

/**
 * display body class
 * 
 * @param  $class   String|Array
 * @return Void
 * @filter body_class, uf_body_class
 */
function uf_body_class($class = null) {
    echo 'class="'. join(" ", uf_get_body_class($class)) .'"';
}


/**
 * get body class
 * 
 * @param  $class String|Array
 * @return Array
 * @filter body_class, uf_body_class
 */
function uf_get_body_class($class = null) {
    global $is_IE, $is_IIS, $is_NS4, $is_apache, $is_chrome, $is_gecko,
            $is_iis7, $is_iphone, $is_lynx, $is_macIE, $is_opera,
            $is_trash, $is_winIE, $is_main_site;

    $base_class = get_body_class($class);

    $additional_class = array();
    if($is_IE) $additional_class [] = "ie";
    if($is_II) $additional_class [] = "iis";
    if($is_NS4) $additional_class [] = "ns4";
    if($is_apache) $additional_class [] = "apache";
    if($is_chrome) $additional_class [] = "chrome";
    if($is_gecko) $additional_class [] = "gecko";
    if($is_iis7) $additional_class [] = "iis7";
    if($is_iphone) $additional_class [] = "iphone";
    if($is_lynx) $additional_class [] = "lynx";
    if($is_macIE) $additional_class [] = "mac-ie";
    if($is_opera) $additional_class [] = "opera";
    if($is_trash) $additional_class [] = "trash";
    if($is_winIE) $additional_class [] = "win-ie";
    if(isset($is_main_site) && $is_main_site) $additional_class [] = "main-site";

    $classes = array_merge($base_class, $additional_class);
    return apply_filters("uf_body_class", $classes);
}


/**
 * get Custom header image
 * 
 * @return  Void
 * @action  uf_before_custom_header, uf_after_custom_header
 * @filters uf_custom_header_attribs
 */
function uf_get_header_image() {
    global $post;

    do_action("uf_before_custom_header");

    if(current_theme_supports("custom-header") && is_singular() && has_post_thumbnail($post->ID)) {
        $image = wp_get_attachment_image(get_post_thumbnail_id($post->ID), "post-thumbnail");
        if($image[1] >= HEADER_IMAGE_WIDTH) {
            echo get_the_post_thumbnail($post->ID, "post-thumbnail", apply_filters("uf_custom_header_attribs", array(
                "alt" => apply_filters("the_title", $post->post_title),
                "title" => apply_filters("the_title", $post->post_title),
            )));
        }
    }
    else {
?>
<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" />
<?php
        do_action("uf_after_custom_header");
    }
}


/**
 * posted on template method.
 * 
 * @return Void
 */
function uf_posted_on() {
    global $post;
    $now_date = $post->post_date;

    if(empty($now_date))
        return;

    $ts = strtotime($now_date);
    $year = date("Y", $ts);
    $month = date("m", $ts);
    $day = date("j", $ts);
?>
<div class="posted-on">
    <span class="post-date"><?php _e("Posted On", UF_TEXTDOMAIN); ?>&nbsp;<a href="<?php echo get_day_link($year, $month, $day); ?>"><?php echo get_the_date(); ?></a></span>
    <span class="post-author">|&nbsp;<?php _e("Post Author", UF_TEXTDOMAIN); ?>&nbsp;<?php the_author_posts_link();?></span>
<!-- End posted on --></div>
<?php
}


/**
 * get post meta block.
 * 
 * @return Void
 */
function uf_post_meta() {
?>
<div class="post-meta">
    <span class="post-category"><?php _e("Category"); ?>&nbsp;<?php the_category("|"); ?></span>
    <span class="comments-link">|&nbsp;<?php comments_popup_link(__("No Comment (0)"), __("Comment (1)"), __("Comments (%s)")); ?></span>
    <?php if(is_user_logged_in()): ?>
    <span class="edit-link">|&nbsp;<a href="<?php echo get_edit_post_link(); ?>"><?php _e("Edit");?></a></span>
    <?php endif; ?>
</div>
<?php
}

