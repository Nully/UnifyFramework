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



/**
 * display notice message
 *   unsupported WordPress version
 *
 * @access protected
 * @return Void
 */
function uf_unsupported_version_notice() {
    global $wp_version;
    echo '<div class="error fade">';
    echo sprintf(__("UnifyFramework is not supported this WordPress version %s."), $wp_version );
    echo "<br />";
    echo __("Upgrade your WordPress version.");
    echo "</div>";
}


