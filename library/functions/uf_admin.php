<?php
/**
 * UnifyFramework Admin page scripts
 *
 */
/**
 * register Admin menu.
 *
 * @access protected
 * @return Void
 */
function uf_add_admin_menu() {
    if("function_exists")
        add_menu_page(__("UnifyFramework Setting page"), __("UnifyFramework Setting"), 10, "uf_settings", "uf_admin_settings");
}
add_action("admin_menu", "uf_add_admin_menu");



/**
 * Admin menu display callback
 *
 * @access protected
 * @return Void
 */
function uf_admin_settings() {
?>
<div class="wrap">
    <?php screen_icon("options-general"); ?>
    <h2><?php _e("UnifyFramework Setting page", "unify_framework"); ?></h2>
    <p><?php _e("setting UnifyFramework theme options.", "unify_framework"); ?></p>
    <div class="uf-settings">
        <ul id="uf_option_navi">
            <li><a href="#uf_general_options"><?php _e("Setting a options", "unify_framework"); ?></a></li>
        </ul>
        <div id="uf_general_options" class="setting-general">
            <h3><?php _e("ContentTitle", "unify_framework"); ?></h3>
        <!-- End setting-general --></div>
    <!-- End uf-settings --></div>
<!-- End wrap --></div>
<?php
}





