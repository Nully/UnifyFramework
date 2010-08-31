<?php
/**
 * UnifyFramework PostThumbnail support
 *
 * @TODO: suppor admin page thumbnails supports type selector.
 */
$uf_post_thumb_supports = array(
    "page", "post"
);
$uf_post_thumb_size = array(
    "width" => 200,
    "height" => 200
);
$uf_post_thumb_is_crop = false;
add_theme_support("post-thumbnails", $uf_post_thumb_supports);
set_post_thumbnail_size($uf_post_thumb_size["width"], $uf_post_thumb_size["height"], $uf_post_thumb_is_crop);

