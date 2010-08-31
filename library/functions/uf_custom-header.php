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

