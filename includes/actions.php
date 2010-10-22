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
 * Action custom header before.
 * custom header image before action.
 *
 * @access protected
 * @return Void
 */
function uf_action_custom_header_before() {
}
add_action("uf_custom_header_before", "uf_action_custom_header_before");



/**
 * Action custom header after.
 * custom header image after action.
 *
 * @access protected
 * @return Void
 */
function uf_action_custom_header_after() {
}
add_action("uf_custom_header_after", "uf_action_custom_header_after");



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





/**
 * UnifyFramework Comments actions
 *
 */
/**
 * Action trackback field.
 *   comment field enabled display trackback, do action trackback_field.
 *
 * @access protected
 * @return Void
 */
function uf_action_trackback_field() {
    do_action("trackback_field");
}
add_action("uf_trackback_field", "uf_action_trackback_field");



/**
 * Action comment form before.
 *   wraped native WordPress action hook, comment_form_before
 *
 * @access protected
 * @return Void
 */
function uf_action_comment_form_before() {
    do_action("comment_form_before");
}
add_action("uf_comment_form_before", "uf_action_comment_form_before");



/**
 * Action comment form Must login before.
 *   comment_registration is enabled action hook.
 *
 * @access protected
 * @return Void
 */
function uf_action_comment_form_must_log_in_before() {
    do_action("comment_form_must_log_in_before");
}
add_action("uf_comment_form_must_log_in_before", "uf_action_comment_form_must_log_in_before");



/**
 * Action comment form must login after.
 *   comment_registration is enabled action hook.
 *
 * @access protected
 * @return Void
 */
function uf_action_comment_form_must_log_in_after() {
    do_action("comment_form_must_log_in_after");
}
add_action("uf_comment_form_must_log_in_after", "uf_action_comment_form_must_log_in_after");



/**
 * Action comment form logged in before.
 *   comment form already logged in before action hook.
 *
 * @access protected
 * @return Void
 */
function uf_action_comment_form_logged_in_before() {
    do_action("comment_form_logged_in_before");
}
add_action("uf_comment_form_logged_in_before", "uf_action_comment_form_logged_in_before");



/**
 * Action comment form logged in after.
 *   comment form already logged in after action hook.
 *
 * @access protected
 * @return Void
 */
function uf_action_comment_form_logged_in_after() {
    do_action("comment_form_logged_in_after");
}
add_action("uf_comment_form_logged_in_after", "uf_action_comment_form_logged_in_after");



/**
 * Action comment form top.
 *   start comment form action hook.
 *
 * @access protected
 * @return Void
 */
function uf_action_comment_form_top() {
    do_action("comment_form_top");
}
add_action("uf_comment_form_top", "uf_action_comment_form_top");



/**
 * Action comment form before input fields.
 *   comment form before display fields action hook.
 *
 * @access protected
 * @return Void
 */
function uf_action_comment_form_before_fields() {
    do_action("comment_form_before_fields");
}
add_action("uf_comment_form_before_fields", "uf_action_comment_form_before_fields");



/**
 * Action comment form after input fields.
 *   wraped comment_form_after_fields action hook.
 *
 * @access protected
 * @return Void
 */
function uf_action_comment_form_after_fields() {
    do_action("comment_form_after_fields");
}
add_action("uf_comment_form_after_fields", "uf_action_comment_form_after_fields");



/**
 * Action comment form bottom.
 *  comment form fields bottom aciton hook.
 *
 * @access protected
 * @return Void
 */
function uf_action_comment_form_bottom() {
    do_action("comment_form_bottom");
}
add_action("uf_comment_form_bottom", "uf_action_comment_form_bottom");



/**
 * Action comment form after.
 *   comment form closing form tag action hook.
 *
 * @access protected
 * @return Void
 */
function uf_action_comment_form_after() {
    do_action("comment_form_after");
}
add_action("uf_comment_form_after", "uf_action_comment_form_after");





/**
 * UnifyFramework admin action hooks.
 *
 */
/**
 * admin page custom header style
 *
 * @access protected
 * @return Void
 */
function uf_admin_custom_image_header_css() {
?>
<style type="text/css" media="all">
    .appearance_page_custom-header #headimg {
        border: 1px solid #CECECE !important;
    }
</style>
<?php
}

