<?php
/**
 * UnifyFramework actions script
 */
/**
 * wp_head wrapped header action
 *
 * @access public
 */
function uf_head() {
    wp_head();
    do_action("uf_head");
}



/**
 * wp_footer wrapped footer actoin
 *
 * @access public
 */
function uf_footer() {
    wp_footer();
    do_action("uf_footer");
}


/**
 * activated UnifyFramework theme action
 *
 * @access public
 */
function uf_activate_theme() {
    global $pagenow;
    if(is_admin() && $pagenow == "themes.php" && isset($_GET["activated"])) {
        do_action("uf_theme_activated");
    }
}
add_action("init", "uf_activate_theme");

