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
        add_submenu_page("uf_settings", __("Custom post settings"), __("Custom Posts"), 10, "uf-custom-posts", "uf_admin_custom_post");
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
<div class="wrap">
    <?php screen_icon("options-general"); ?>
    <h2><?php _e("UnifyFramework Setting page", "unify_framework"); ?></h2>
    <p><?php _e("setting UnifyFramework theme options.", "unify_framework"); ?></p>
    <div class="uf-settings">
        <form action="action" method="post">
            <?php wp_nonce_field(); ?>
            <div id="uf_option_comment" class="settings-comment">
                <h3><?php _e("Comment post setting.", "unify_framework"); ?></h3>
                <p>setting a comment post.</p>
                <dl>
                    <dt>
                        <input type="hidden" name="uf[comment_for_page]" value="0" />
                        <input type="checkbox" name="uf[comment_for_page]" value="1"<?php if($options["comment_for_page"]) ?> /><br />
                        <input type="text" name="uf[comment_allowd_pages]" value="<?php echo $options["comment_allowd_pages"] ?>" /><br />
                        <span><?php _e("* separated 'comma' for page ID", "unify_framework"); ?></span>
                    </dt>
                    <dd><?php _e("Comment allwod page ?", "unify_framework"); ?></dd>
                    <dt>
                        <input type="hidden" name="uf[display_custom_header_in_front]" value="0" />
                        <input type="checkbox" name="uf[display_custom_header_in_front]" value="1" />
                    </dt>
                    <dd><?php _e("display custom header in the home page or front page ?", "unify_framework"); ?></dd>
                </dl>
            <!-- End setting-general --></div>
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
    register_post_type($post_type);
?>
<div class="wrap">
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
        <dd><input type="text" name="uf_custom_post[description]" value="" /><br />
            <span><?php _e("custom post type description", "unify_framework"); ?></span></dd>
        <dt><?php _e("Lables", "unify_framework"); ?></dt>
        <dd><span><?php _e("labels settings", "unify_framework"); ?></span><br />
            <input type="text" name="uf_custom_posts[name]" value="" />
                <span><?php _e("custom post type unique name.", "unify_framework"); ?></span><br />
            <input type="text" name="uf_custom_posts[singular_name]" value="" />
                <span><?php _e("custom post type unique singular name.", "unify_framework"); ?></span><br />
            <input type="text" name="uf_custom_posts[add_new]" value="" />
                <span><?php _e("custom post type add new label.", "unify_framework"); ?></span><br />
            <input type="text" name="uf_custom_posts[add_new_item]" value="" />
                <span><?php _e("custom post type add new item label.", "unify_framework"); ?></span><br />
            <input type="text" name="uf_custom_posts[edit_item]" value="" />
                <span><?php _e("custom post type edit item label.", "unify_framework"); ?></span><br />
            <input type="text" name="uf_custom_posts[new_item]" value="" />
                <span><?php _e("custom post type new item label.", "unify_framework"); ?></span><br />
            <input type="text" name="uf_custom_posts[view_item]" value="" />
                <span><?php _e("custom post type view item label.", "unify_framework"); ?></span><br />
            <input type="text" name="uf_custom_posts[search_items]" value="" />
                <span><?php _e("custom post search item label.", "unify_framework"); ?></span><br />
            <input type="text" name="uf_custom_posts[not_found]" value="" />
                <span><?php _e("custom post search not found label.", "unify_framework"); ?></span><br />
            <input type="text" name="uf_custom_posts[not_found_in_trush]" value="" />
                <span><?php _e("custom post search not found in the trush.", "unify_framework"); ?></span><br />
        </dd>
        <dt><?php _e("Public", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[public]" value="0" />
            <input type="checkbox" name="uf_custom_posts[public]" value="1" /><br />
            <span><?php _e("shown admin UI.", "unify_framework"); ?></span></dd>
        <dt><?php _e("Search form", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[exclude_from_search]" value="0" />
            <input type="checkbox" name="uf_custom_posts[exclude_from_search]" value="1" /><br />
            <span><?php _e("exclude custom post type in search form.", "unify_framework"); ?></span></dd>
        <dt><?php _e("Show UI", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[show_ui]" value="0" />
            <input type="checkbox" name="uf_custom_posts[show_ui]" value="1" /><br />
            <span><?php _e("Whether to generate a default UI for managing this post type.", "unify_framework"); ?></span></dd>
        <dt><?php _e("Capability Type", "unify_framework"); ?></dt>
        <dd><select name="uf_custom_posts[capability_type]">
                <option value="page"><?php _e("Page"); ?></option>
                <option value="post"><?php _e("Post"); ?></option>
            </select><br />
            <span><?php _e("The post type to use for checking read, edit, and delete capabilities.", "unify_framework"); ?></span></dd>
        <dt><?php _e("Hierarchical", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[hierarchical]" value="0" />
            <input type="checkbox" name="uf_custom_posts[hierarchical]" value="1" /><br />
            <span><?php _e("this post type have a hieralchical."); ?></span></dd>
        <dt><?php _e("Supports", "unify_framework"); ?></dt>
        <dd>
            <input type="hidden" name="uf_custom_posts[supports][]" value="" />
            <?php foreach(array('title','editor','author','thumbnail','excerpt','comments') as $field): ?>
            <input type="checkbox" name="wp_custom_posts[supports][]" value="<?php echo $field; ?>" />&nbsp;<?php _e(ucfirst($field)); ?>
            <?php endforeach; ?>
        </dd>
        <dt><?php _e("Export", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uc_custom_posts[can_export]" value="0" />
            <input type="checkbox" name="uc_custom_posts[can_export]" value="1" /><br />
            <span><?php _e("this post type including WPExport ?", "unify_framework"); ?></span></dd>
        <dt><?php _e("Nav Menus", "unify_framework"); ?></dt>
        <dd><input type="hidden" name="uf_custom_posts[show_in_nav_menus]" value="0" />
            <input type="checkbox" name="uf_custom_posts[show_in_nav_menus]" value="1" /><br />
            <span><?php _e("this custom post type including custom nav menus ?"); ?></span></dd>
    </dl>
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




