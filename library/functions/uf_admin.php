<?php
/**
 * UnifyFramework Admin page scripts
 *
 */
require_once UF_LIB_PATH. "functions/admin-options.php";
require_once UF_LIB_PATH. "functions/admin-custompost.php";
require_once UF_LIB_PATH. "functions/admin-post-thumbnail.php";



/**
 * register Admin menu.
 *
 * @access protected
 * @return Void
 */
function uf_add_admin_menu() {
    if(function_exists("add_menu_page"))
        add_menu_page(__("UnifyFramework Setting page"), __("UnifyFramework"), 10, "uf_settings", "uf_admin_settings");
}
add_action("admin_menu", "uf_add_admin_menu");



/**
 * display sub page for custom posts
 *
 * @access public
 * @return Void
 */
function uf_add_admin_sub_menus() {
    if(function_exists("add_submenu_page")) {
        add_submenu_page("uf_settings", __("Custom post setting"), __("Custom Posts"), 10, "uf-custom-posts", "uf_admin_custom_post");
        add_submenu_page("uf_settings", __("Post thumbnail setting"), __("Post thumbnail"), 10, "uf-post-thumbnail", "uf_admin_post_thumbnail");
    }
}
add_action("admin_menu", "uf_add_admin_sub_menus");



/**
 * display UnifyFramework admin page style
 *
 * @access protected
 */
function uf_admin_css() {
    wp_enqueue_style("uf_admin_css", get_bloginfo("template_url"). "/css/admin.css", array(), UF_VERSION, "all");
}
add_action("admin_init", "uf_admin_css");



/**
 * Admin menu display callback
 *
 * @access protected
 * @return Void
 */
function uf_admin_settings() {
?>
<div class="wrap" id="uf_admin">
    <?php screen_icon("options-general"); ?>
    <h2><?php _e("UnifyFramework Setting page", "unify_framework"); ?></h2>
    <p><?php _e("setting UnifyFramework theme options.", "unify_framework"); ?></p>
    <div class="uf-settings">
        <form action="action" method="post">
            <?php wp_nonce_field(); ?>
            <div id="uf_option_editor_style">
                <h3><?php _e("Editor style setting"); ?></h3>
                <dl>
                    <dt><?php _e("Editor style setting.", "unify_framework"); ?></dt>
                    <dd><input type="hidden" name="uf[allow_editor_css]" value="0" />
                        <input id="uf_allow_editor_css" type="checkbox" name="uf[allow_editor_css]" value="1" />
                        <label for="uf_allow_editor_css"><?php _e("Allow custom editor style", "unify_framework"); ?></label><br />
                        <span class="caution"><?php _e("* custom editor style file path: "); ?><?php echo bloginfo("template_directory"); ?>/editor-style.css</span></dd>
                </dl>
            <!-- End uf_option_editor_style --></div>


            <div id="uf_option_comment" class="settings-comment">
                <h3><?php _e("Comment post setting.", "unify_framework"); ?></h3>
                <dl>
                    <dt><?php _e("Comment", "unify_framework"); ?></dt>
                    <dd><input type="hidden" name="uf[comment_for_page]" value="0" />
                        <input id="uf_comment_for_page" type="checkbox" name="uf[comment_for_page]" value="1"<?php if($options["comment_for_page"]) ?> />
                        <label for="uf_comment_for_page"><?php _e("Comment allwod page ?", "unify_framework"); ?></label><br />

                        <input id="uf_comment_allowd_pages" type="text" name="uf[comment_allowd_pages]" value="<?php echo $options["comment_allowd_pages"] ?>" /><br />
                        <label for="uf_comment_allowd_pages" class="caution"><?php _e("* separated 'comma' for page ID", "unify_framework"); ?></label></dd>
                </dl>
            <!-- End uf_option_comment --></div>


            <div id="uf_option_custom_header">
                <h3><?php _e("Custom header setting"); ?></h3>
                <dl>
                    <dt><?php _e("Custom header", "unify_framework"); ?></dt>
                    <dd>
                        <input type="hidden" name="uf[display_custom_header_in_front]" value="0" />
                        <input type="checkbox" id="uf_display_custom_header_in_front" name="uf[display_custom_header_in_front]" value="1" />
                        <label for="uf_display_custom_header_in_front"><?php _e("display custom header in the home page or front page ?", "unify_framework"); ?></label></dd>
                </dl>
            <!-- End uf_option_custom_header --></div>
            <p><input type="submit" name="uf_save" value="<?php _e("Save as theme options"); ?>" class="button-primary" /></p>
        </form>
    <!-- End uf-settings --></div>
<!-- End wrap --></div>
<?php
}


/**
 * Display custom post form for Admin
 *
 * @access public
 * @return Void
 */
function uf_admin_custom_post() {
?>
<div class="wrap" id="uf_admin">
    <?php screen_icon("options-general"); ?>
    <h2><?php _e("Custom post settings.", "unify_framework"); ?></h2>
    <h3><?php _e("Custom post type register field.", "unify_framework"); ?></h3>
    <?php uf_admin_get_custom_post_form(); ?>
    <hr />
    <h3><?php _e("Registerd custom post types"); ?></h3>
    <?php uf_admin_get_registerd_custom_posts(); ?>
<!-- End wrap --></div>
<?php
}



/**
 * Dsiplay Custom post type form for Admin
 *
 * @access public
 * @return Void
 */
function uf_admin_get_custom_post_form() {
?>
<form action="" method="post">
    <?php wp_nonce_field(); ?>
    <dl>
        <dt><?php _e("Description", "unify_framework"); ?></dt>
        <dd><input id="uf_custom_posts_description" type="text" name="uf_custom_posts[description]" value="" />
            <label for="uf_custom_posts_description"><?php _e("shorty custom post type description", "unify_framework"); ?></label></dd>
        <dt><?php _e("Lables", "unify_framework"); ?></dt>
        <dd>
            <input id="uf_custom_posts_name" type="text" name="uf_custom_posts[name]" value="" />
                <label for="uf_custom_posts_name"><?php _e("custom post type unique name.", "unify_framework"); ?></label><br />
            <input id="uf_custom_psots_singular_name" type="text" name="uf_custom_posts[singular_name]" value="" />
                <label for="uf_custom_psots_singular_name"><?php _e("custom post type unique singular name.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_add_new" type="text" name="uf_custom_posts[add_new]" value="" />
                <label for="uf_custom_posts_add_new"><?php _e("custom post type add new label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_add_new_item" type="text" name="uf_custom_posts[add_new_item]" value="" />
                <label for="uf_custom_posts_add_new_item"><?php _e("custom post type add new item label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_edit_item" type="text" name="uf_custom_posts[edit_item]" value="" />
                <label for="uf_custom_posts_edit_item"><?php _e("custom post type edit item label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_new_item" type="text" name="uf_custom_posts[new_item]" value="" />
                <label for="uf_custom_posts_new_item"><?php _e("custom post type new item label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_view_item" type="text" name="uf_custom_posts[view_item]" value="" />
                <label for="uf_custom_posts_view_item"><?php _e("custom post type view item label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_search_item" type="text" name="uf_custom_posts[search_items]" value="" />
                <label for="uf_custom_posts_search_item"><?php _e("custom post search item label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_not_found" type="text" name="uf_custom_posts[not_found]" value="" />
                <label for="uf_custom_posts_not_found"><?php _e("custom post search not found label.", "unify_framework"); ?></label><br />
            <input id="uf_custom_posts_not_found_in_trush" type="text" name="uf_custom_posts[not_found_in_trush]" value="" />
                <label for="uf_custom_posts_not_found_in_trush"><?php _e("custom post search not found in the trush.", "unify_framework"); ?></label><br />
        </dd>
        <dt><?php _e("Public", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[public]" value="0" />
            <input id="uf_custom_posts_public" type="checkbox" name="uf_custom_posts[public]" value="1" />
            <label for="uf_custom_posts_public"><?php _e("shown admin UI.", "unify_framework"); ?></label></dd>
        <dt><?php _e("Search form", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[exclude_from_search]" value="0" />
            <input id="uf_custom_posts_exclude_form_search" type="checkbox" name="uf_custom_posts[exclude_from_search]" value="1" />
            <label for="uf_custom_posts_exclude_form_search"><?php _e("exclude custom post type in search form.", "unify_framework"); ?></label></dd>
        <dt><?php _e("Show UI", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[show_ui]" value="0" />
            <input id="uf_custom_posts_show_ui" type="checkbox" name="uf_custom_posts[show_ui]" value="1" />
            <label for="uf_custom_posts_show_ui"><?php _e("Whether to generate a default UI for managing this post type.", "unify_framework"); ?></label></dd>
        <dt><?php _e("Capability Type", "unify_framework"); ?></dt>
        <dd><select id="uf_custom_posts_capability_type" name="uf_custom_posts[capability_type]">
                <option value="page"><?php _e("Page"); ?></option>
                <option value="post"><?php _e("Post"); ?></option>
            </select>
            <label for="uf_custom_posts_capability_type"><?php _e("The post type to use for checking read, edit, and delete capabilities.", "unify_framework"); ?></label></dd>
        <dt><?php _e("Hierarchical", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[hierarchical]" value="0" />
            <input id="uf_custom_posts_herarchical" type="checkbox" name="uf_custom_posts[hierarchical]" value="1" />
            <label for="uf_custom_posts_herarchical"><?php _e("this post type have a hieralchical."); ?></label></dd>
        <dt><?php _e("Supports", "unify_framework"); ?></dt>
        <dd>
            <input type="hidden" name="uf_custom_posts[supports]" value="" />
            <?php foreach(array('title','editor','author','thumbnail','excerpt','comments') as $field): ?>
            <input id="uf_custom_posts_supports_<?php echo $field; ?>" type="checkbox" name="uf_custom_posts[supports][]" value="<?php echo $field; ?>" />&nbsp;<label for="uf_custom_posts_supports_<?php echo $field; ?>"><?php _e(ucfirst($field)); ?></label>
            <?php endforeach; ?>
        </dd>
        <dt><?php _e("Export", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[can_export]" value="0" />
            <input id="uf_custom_posts_can_export" type="checkbox" name="uf_custom_posts[can_export]" value="1" />
            <label for="uf_custom_posts_can_export"><?php _e("this post type including WPExport ?", "unify_framework"); ?></label></dd>
        <dt><?php _e("Nav Menus", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[show_in_nav_menus]" value="0" />
            <input id="uf_custom_posts_show_in_nav_menus" type="checkbox" name="uf_custom_posts[show_in_nav_menus]" value="1" />
            <label for="uf_custom_posts_show_in_nav_menus"><?php _e("this custom post type including custom nav menus ?"); ?></label></dd>
    </dl>
    <p><input type="submit" name="uf_custom_post_save" value="<?php _e("Save as custom post"); ?>" class="button-primary" /></p>
</form>
<?php
}



/**
 * Display registerd custom posts
 *
 * @access public
 * @return Void
 */
function uf_admin_get_registerd_custom_posts() {
?>
<p><?php _e("No in registerd", "unify_framework"); ?></p>
<?php
}



/**
 * display theme support post-thumbnail
 *    post-thumbnail support WordPress version 2.9.x
 *
 * @access protected
 * @return Void
 */
function uf_admin_post_thumbnail() {
?>
<div class="wrap" id="uf_admin">
    <?php screen_icon("options-general"); ?>
    <h2><?php _e("Post thumbnail setting", "unify_framework"); ?></h2>
<!-- End uf_admin --></div>
<?php
}



