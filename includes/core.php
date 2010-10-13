<?php
class UF_Core {}



/**
 * Load UnifyFramework extended Extensions
 *
 * @access public
 * @return Void
 */
function uf_load_extensions() {
    $theme_options = uf_get_theme_option();

    // enable CustomPost
    if($theme_options["extensions"]["extension_custom_post"]) {
        if(!isset($uf_custompost)) {
            global $uf_custompost;
            $uf_custompost = &new UF_CustomPost();
        }
    }

    // enable PostThumbnail
    if($theme_options["extensions"]["extension_post_thumbnail"]) {
        if(!isset($uf_postthumbnail)) {
            global $uf_postthumbnail;
            $uf_postthumbnail = &new UF_PostThumbnail();
        }
    }
}
add_action("uf_init", "uf_load_extensions");



/**
 * get UnifyFramework theme options
 *
 * @access public
 * @return Array
 */
function uf_get_theme_option() {
    $options = get_option("uf_theme_options");
    if(empty($options))
        $options = array();

    return $options;
}



/**
 * update UnifyFramework theme options
 *
 * @access public
 * @return Void
 */
function uf_update_theme_option() {
    $options = array(
        "allow_editor_css"     => $_POST["allow_editor_css"],
        "comment_for_page"     => $_POST["comment_for_page"],
        "comment_allowd_pages" => $_POST["comment_allowd_pages"],
        "show_custom_header_in_front" => $_POST["show_custom_header_in_front"],
        "extensions" => array(
            "extension_custom_post"    => $_POST["extension_custom_post"],
            "extension_post_thumbnail" => $_POST["extension_post_thumbnail"],
        ),
    );

    $options = uf_parse_to_bool_deep($options);
    update_option("uf_theme_options", $options);
}



/**
 * delete UnifyFramework theme options
 *
 * @access public
 * @return Void
 */
function uf_delete_theme_options() {
    delete_option("uf_theme_options");
}



/**
 * get post thumbnail options
 *
 * @access public
 * @return Array
 */
function uf_get_post_thumbnail_options() {
    $options = get_option("uf_post_thumbnail_options");
    if(empty($options))
        $options = array();

    return $options;
}



/**
 * update post thumbnail options
 *
 * @access public
 * @return Void
 */
function uf_update_post_thumbnail_options() {
    $options = array(
        "post_thumb_enable" => $_POST["post_thumb_enable"],
        "uf_post_thumb_support_type" => $_POST["uf_post_thumb_support_type"],
        "post_thumb_width"  => $_POST["post_thumb_width"],
        "post_thumb_height" => $_POST["post_thumb_height"]
    );

    $options = uf_deep_esc_attr($options);
    $options = uf_parse_to_bool_deep($options);
    update_option("uf_post_thumbnail_options", $options);
}



/**
 * string number to boolean cast
 *
 * @access public
 * @param  $var   Number
 * @return Bool
 */
function uf_parse_to_bool($var) {
    if(!is_numeric($var))
        return $var;

    if($var == 0)
        return false;
    elseif($var == 1)
        return true;
    else
        return $var;
}



/**
 * deep cast String to Boolean
 *
 * @access public
 * @param  $vars    Array
 * @return Array
 */
function uf_parse_to_bool_deep($vars) {
    if(!is_array($vars))
        $vars = (array)$vars;

    foreach($vars as $name => $var) {
        if(is_array($var))
            $vars[$name] = uf_parse_to_bool_deep($var);

        if(is_numeric($var))
            $vars[$name] = uf_parse_to_bool($var);
    }
    return $vars;
}



/**
 * HTML attribute deep escape
 *
 * @access public
 * @param  $vars   Array
 * @return Array
 */
function uf_deep_esc_attr($vars) {
    if(!is_array($vars))
        $vars = (array)$vars;

    foreach($vars as $name => $var) {
        if(is_array($var)) {
            $vars[$name] = uf_deep_esc_attr($var);
        }
        else {
            $vars[$name] = esc_attr($var);
        }
    }

    return $vars;
}


