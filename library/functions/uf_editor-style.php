<?php
/**
 * UnifyFramework EditorStyle support
 */
if(function_exists("add_editor_style")) {
    add_editor_style("editor-style.css");
}
else if(function_exists("add_theme_support")) {
    add_theme_support("editor-style");
    add_action("mce_css", "overload_mce_css");
}


/**
 * overload TinyMCE editor style
 *
 * @since 1.0-Beta
 * @return String
 */
function overload_mce_css($mce_css) {
    if(!empty($mce_css)) {
        return $mce_css;
    }

    $url = get_bloginfo("template_url");
    $url = rtrim($url, "/"). "/editor-style.css";

    $url = apply_filters("overload_mce_css", $url);

    return $url;
}


