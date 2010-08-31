<?php
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






