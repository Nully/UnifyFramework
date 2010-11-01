<?php
/**
 * UnifyFramework theme supports scripts
 *
 */
/**
 * UnifyFramework CustomPost support
 *
 *
 * What is CustomPost ?
 *  Introduced in 3.0, 'the original post type' feature can be added.
 *  In most cases to use this feature, 'tagging' is freed from a terrible source code control.
 *  For more information please check the following URL from.
 *                                             (Translated by google translate.)
 * WordPress Codex: http://wpdocs.sourceforge.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_post_type
 * wpExtreme:       http://wpxtreme.jp/how-to-use-custom-post-types-in-wordpress-3-0-beta1
 */
/**
 * put your code here.
 */
/**
 * Sample.
 * Only uses custom post type 'book'.
 *
 * add_action("init", "my_custom_post_book");
 * function my_custom_post_book() {
 *     register_post_type("book", array(
 *         "labels" => array(
 *             "name"          => "Book",
 *             "singular_name" => "Book",
 *             "add_new"       => "Add a new Book",
 *         ),
 *         'public' => true,
 *         'publicly_queryable' => true,
 *         'show_ui' => true,
 *         'query_var' => true,
 *         'rewrite' => true,
 *         'capability_type' => 'post',
 *         'hierarchical' => false,
 *         'menu_position' => null,
 *         'supports' => array('title','editor','author','thumbnail','excerpt','comments')
 *     ));
 * }
 */
/**
 * Add custom menu.
 *
 */
if(function_exists("register_nav_menu")) {
    // for WordPress 3.0 supported.
    add_theme_support("nav-menus");
    # register_nav_menu("Global menu", "Global navigation.");
    # register_nav_menu("FooterNav", "Footer navigation");
    # unregister_nav_menu("Primary nav menu");
}



/**
 * Custom background
 *
 */
if(function_exists("add_custom_background")) {
    add_custom_background();
}



/**
 * custom header default image path.
 */
define("HEADER_IMAGE", "%s/images/headers/maiko.jpg");
/**
 * default header text color
 */
define("HEADER_TEXTCOLOR", "FFFFFF");
/**
 * header image width, and height.
 */
define( 'HEADER_IMAGE_WIDTH', apply_filters( 'uf_header_image_width', 940 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'uf_header_image_height', 200 ) );

add_custom_image_header(null, "uf_admin_custom_image_header_css");
if(function_exists("register_default_headers")) {
    register_default_headers(array(
        "maiko" => array(
			'url' => '%s/images/headers/maiko.jpg',
			'thumbnail_url' => '%s/images/headers/maiko-thumb.jpg',
			'description' => __("Maiko", "unify_framework")
        ),
        "cherryblossom" => array(
			'url' => '%s/images/headers/cherryblossom.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossom-thumb.jpg',
			'description' => __("Cherryblossom", "unify_framework")
        ),
        "fern" => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumb.jpg',
			'description' => __("Fern", "unify_framework")
        ),
        "path" => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumb.jpg',
			'description' => __("Path", "unify_framework")
        ),
    ));
}



/**
 * display custom header image by setting.
 *
 */
function uf_custom_header() {
    global $post;


    do_action("uf_custom_header_before");
    // show_custom_header_in_front option enabled not display header image.
    $options = uf_get_option("theme_options");
    if((is_home() || is_front_page()) && !$options["show_custom_header_in_front"])
        return;


    if(current_theme_supports("post-thumbnails") && is_singular() && has_post_thumbnail($post->ID)) {
        $image = wp_get_attachment_image(get_post_thumbnail_id($post->ID), "post-thumbnail");
        if($image[1] >= HEADER_IMAGE_WIDTH) {
            echo get_the_post_thumbnail($post->ID, "post-thumbnail");
        }
    }
    else {
?>
<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH ?>" height="<?php echo HEADER_IMAGE_HEIGHT ?>" alt="" />
<?php
    }
    do_action("uf_custom_header_after");
}



/**
 * theme supported EditorStyle register.
 *
 * @access protected
 * @return Void
 */
function uf_theme_support_editor_style() {
    $options = uf_get_option("theme_options");
    if(!$options["allow_editor_css"])
        return;

    if(function_exists("add_editor_style")) {
        add_editor_style("editor-style.css");
    }
    else {
        add_theme_support("editor-style");
        add_action("mce_css", "uf_theme_support_override_css");
    }
}
add_action("admin_init", "uf_theme_support_editor_style");



/**
 * override TinyMCE editor style
 *
 * @since 1.0-Beta
 * @return String
 */
function uf_theme_support_override_css($mce_css) {
    if(!empty($mce_css)) {
        return $mce_css;
    }

    $url = get_bloginfo("template_url");
    $url = rtrim($url, "/"). "/editor-style.css";

    $url = apply_filters("uf_override_mce_css", $url);

    return $url;
}




