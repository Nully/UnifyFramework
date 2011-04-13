<?php
/**
 * UnifyFramework action hooks.
 * 
 * @package UnifyFramework
 */

/**
 * the_content() filter excerpt length.
 * 
 * @return Void
 * @filter excerpt_length
 */
add_filter("excerpt_length", "uf_excerpt_length");
function uf_excerpt_length() {
    return 55;
}

