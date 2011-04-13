<?php
/**
 * UnifyFramework theme admin scripts.
 * 
 * @package UnifyFramework
 */

/**
 * add admin menus
 * 
 * @return Void
 * @action admin_menu
 */
wp_enqueue_style("dashboard");
add_action("admin_menu", "uf_admin_add_menu");
function uf_admin_add_menu() {
    if(function_exists("add_menu_page")) {
        add_menu_page( __("UnifyFramework theme admin page", UF_TEXTDOMAIN), __("Theme Admin", UF_TEXTDOMAIN), 10, "uf-admin", "uf_admin_general_admin" );
    }

    if(function_exists("add_submenu_page")) {
        add_submenu_page( "uf-admin", __("UnifyFramework thtme admin General", UF_TEXTDOMAIN), __("General"), 10, "uf-admin-general", "uf_admin_general_admin" );
        add_submenu_page( "uf-admin", __("UnifyFramework thtme admin Widgets", UF_TEXTDOMAIN), __("Widgets"), 10, "uf-admin-widgets", "uf_admin_widgets_admin" );
        add_submenu_page( "uf-admin", __("UnifyFramework thtme admin Custom menu", UF_TEXTDOMAIN), __("Custom Menu"), 10, "uf-admin-custom-menu", "uf_admin_custom_menu_admin" );
        add_submenu_page( "uf-admin", __("UnifyFramework thtme admin Post thumbnail", UF_TEXTDOMAIN), __("Post Thumbnail"), 10, "uf-admin-post-thumbnail", array( "UnifyFramework_Admin_PostThumbnail", "form" ) );
        add_submenu_page( "uf-admin", __("UnifyFramework thtme admin Editor style", UF_TEXTDOMAIN), __("Editor Style"), 10, "uf-admin-editor-style", array( "UnifyFramework_Admin_EditorStyle", "form" ) );
    }
}


/**
 * display admin notice updated.
 * 
 * @return Void
 * @action admin_notices
 */
function uf_admin_notice_update() {
?>
<div class="faded updated">
    <p><?php _e("Updated theme options", UF_TEXTDOMAIN); ?></p>
</div>
<?php
}


/**
 * display admin notice error
 * 
 * @return Void
 * @action admin_notices
 */
function uf_admin_notice_error() {
?>
<div class="error">
    <p><?php _e("No updated.", UF_TEXTDOMAIN); ?></p>
</div>
<?php
}



