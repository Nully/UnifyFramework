<?php
/**
 * UnifyFramework document title support
 */
$uf_support_separators = array(
    0 => "&gt;",
    1 => "&lt;",
    2 => " &laquo; ",
    3 => " &raquo; ",
    4 => " - ",
    5 => " | ",
    6 => " : ",
);
function uf_titel() {
    global $post, $paged, $page, $uf_support_separators;
    $separator = $uf_support_separators[get_option("uf_doctitle_separator", 2)];

    $title = "<title>";
    if(_uf_exists_seo_plugins()) {
        $title = get_bloginfo("name");
    }
    else {
        $page = uf_get_current_page_to_string();
        switch(strtolower($page)) {
            case "search":
                $title = sprintf(__("Search result for : %s", "uf"), get_search_query());

                if($paged >= 2) {
                    $title .= sptrinf(__(" %s Page of %s", "uf"), $separator, $paged);
                }
                $title .= " {$separator} ". get_bloginfo("name");
                break;
            case "post":
                $title .= single_post_title(null, false);
                if(!$title) {
                    $title .= get_the_title();
                }
                break;
            case "category":
                $title .= single_cat_title(null, false);
                break;
            case "tag":
                $title .= single_tag_title();
                break;
            case "day":
                $title .= get_the_time("Y m d");
                break;
            case "month":
                $title .= get_the_time("Y m");
                break;
            case "year":
                $title .= get_the_time("Y");
                break;
            case "404":
                $title .= sprintf(__("404 - Page not found", "uf"));
                break;
            default:
                $title .= get_bloginfo("name"). " {$separator} ". get_bloginfo("description");
                break;
        }
        if($paged >= 2 || $page >= 2) {
            $title .= sprintf(__(" %s Page of %s", "uf"), $separator, $paged);
        }
    }
    $title .= " {$separator} ". get_bloginfo("name");
    $title .= "</title>\n";

    echo $title;
}


/**
 * is installed SEO plugins ?
 *
 * @return Bool
 */
function _uf_exists_seo_plugins() {
    $seo_plugins = array(
        "class" => array(
            "All_in_One_SEO_Pack", "Platinum_SEO_Pack"
        ),
        "method" => array(
        )
    );

    foreach($seo_plugins as $type => $vars) {
        foreach($seo_plugins[$type] as $var) {
            if(function_exists($var) || class_exists($var)) {
                return true;
            }
        }
    }
    return false;
}
