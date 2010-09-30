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
function uf_title() {
    global $uf_support_separators;
    $separator = $uf_support_separators[get_option("uf_doctitle_separator", 2)];
    echo apply_filters("uf_title", join($separator, uf_get_title()));
}


function uf_get_title() {
    global $paged, $page, $s, $uf_support_separators;
    $separator = $uf_support_separators[get_option("uf_doctitle_separator", 2)];

    $title = array();
    if(_uf_exists_seo_plugins ()) {
        $title[] = wp_title($separator, false);
    }
    else {
        if(is_home () || is_front_page()) {
            $title[] = apply_filters("uf_title-is_home", get_bloginfo("description"));
        }
        elseif(is_404()) {
            $title[] = __("Page not found.", "uf");
        }
        elseif(is_date() || is_archive()) {
            if(is_year()) {
                $title[] = apply_filters("uf_title-is_year", get_the_time("Y"));
            }
            if(is_month()) {
                $title[] = apply_filters("uf_title-is_day",get_the_time("F"));
            }
            if(is_day()) {
                $title[] = apply_filters("uf_title-is_day", get_the_time("d"));
            }
            // @TODO: add document title to, shown page week ?
        }
        elseif(is_search()) {
            $title[] = sprintf(__("Search results %s", "uf"), esc_attr($s));
        }
        elseif((is_single() || is_page()) && !is_front_page()) {
            $title[] = single_post_title(null, false);
        }

        if($paged > 2 || $page > 2) {
            $title[] = sprintf(__("Page %s"), max($paged, $page));
        }

        $title[] = get_bloginfo("name");
    }

    return apply_filters("uf_title", $title);
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
