<?php
/**
 * UnifyFramework CustomHeader support
 */
/**
 * custom header default image path.
 */
define("HEADER_IMAGE", "%s/images/headers/sunset.jpg");
/**
 * default header text color
 */
define("HEADER_TEXTCOLOR", "FFFFFF");
/**
 * header image width, and height.
 */
define( 'HEADER_IMAGE_WIDTH', apply_filters( 'uf_header_image_width', 800 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'uf_header_image_height', 198 ) );

add_custom_image_header(null, "uf_admin_custom_image_header");
if(function_exists("register_default_headers")) {
    register_default_headers(array(
        "berries" => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			'description' => "Berries"
        ),
    ));
}


/**
 * admin page custom header style
 *
 */
function uf_admin_custom_image_header() {
?>
<style type="text/css" media="all">
    .appearance_page_custom-header #headimg {
        border: 1px solid #CECECE !important;
    }
</style>
<?php
}


/**
 * display custom header image by setting.
 *
 */
function uf_custom_header() {
    global $post;

    if(is_singular()) {
        if(has_post_thumbnail($post->ID)) {
            $image = wp_get_attachment_image(get_post_thumbnail_id($post->ID), "post-thumbnail");
            if($image[1] >= HEADER_IMAGE_WIDTH) {
                echo get_the_post_thumbnail($post->ID, "post-thumbnail");
            }
        }
    }
    else {
?>
<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH ?>" height="<?php echo HEADER_IMAGE_HEIGHT ?>" alt="" />
<?php
    }
}
