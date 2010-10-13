<?php
/**
 * UnifyFramework utility support
 */
/**
 * check PHP script file direct access ?
 *
 * @param  $filename   check target file name
 * @return Bool
 */
function uf_is_direct_acess($filename) {
    return (!empty($_SERVER["SCRIPT_FILENAME"]) && $filename === $_SERVER["SCRIPT_FILENAME"]);
}



/**
 * get post comment count
 *
 * @param  $field    String|Null   approved, awaiting_moderation, spam, total_comments
 * @return Int
 */
function uf_get_comment_count($field = null) {
    global $post;
    if(!isset($post)) {
        return 0;
    }
    $comments = get_comment_count($post->ID);
    if(is_null($field)) {
        return $comments;
    }

    $comments = apply_filters("uf_comment_count", $comments);
    return $comments[$field];
}



