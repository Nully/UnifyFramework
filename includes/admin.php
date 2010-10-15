<?php
/**
 * UnifyFramework Admin page scripts
 *
 */
function uf_admin_save_options() {
    if($_POST["save_option"]) {
        uf_update_option("theme_options", array(
            "allow_editor_css"     => $_POST["allow_editor_css"],
            "comment_for_page"     => $_POST["comment_for_page"],
            "comment_allowd_pages" => $_POST["comment_allowd_pages"],
            "show_custom_header_in_front" => $_POST["show_custom_header_in_front"],
            "extensions" => array(
                "custom_post"    => $_POST["custom_post"],
                "post_thumbnail" => $_POST["post_thumbnail"],
            ),
        ));
    }
}
add_action("uf_init", "uf_admin_save_options", 0);



/**
 * admin_init action hook
 *
 * @access protected
 * @return Void
 */
function uf_admin_init() {
    global $pagenow, $plugin_page;
    if($pagenow != "themes.php")
        return;

    wp_enqueue_style("uf_admin_css", get_bloginfo("template_url"). "/css/admin.css", array(), UF_VERSION, "all");
}
add_action("admin_init", "uf_admin_init");



/**
 * admin_head action hook
 *
 * @access protected
 * @return Void
 */
function uf_admin_head() {
}
add_action("admin_head", "uf_admin_head");



/**
 * admin_menu action hook
 *
 * @access protected
 * @return Void
 */
function uf_admin_submenu() {
    add_menu_page(__("UnifyFramework setting pages", "unify_framework"), __("Theme Options", "unify_framework"), 10, "uf-options", "uf_admin_setting");
    //if(function_exists("add_submenu_page"))
        //add_submenu_page("themes.php", __("UnifyFramework setting pages", "unify_framework"), __("Theme Options", "unify_framework"), 10, "uf-admin", "uf_admin_setting");
}
add_action("admin_menu", "uf_admin_submenu");



/**
 * admin submenu action hook
 *   display theme admin panel.
 * @access protected
 * @return Void
 */
function uf_admin_setting() {
    $options = uf_get_option("theme_options");
?>
<div class="wrap" id="uf_admin">
    <?php screen_icon("options-general"); ?>
    <h2><?php _e("UnifyFramework setting page", "unify_framework"); ?></h2>
    <p><?php _e("setting UnifyFramework theme options.", "unify_framework"); ?></p>
    <form action="" method="post">
        <?php wp_nonce_field(); ?>
        <h3><?php _e("Editor style setting"); ?></h3>
        <dl>
            <dt><?php _e("Editor style setting.", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array(
                "id" => "uf_allow_editor_css", "name" => "allow_editor_css","label" => __("Allow custom editor style", "unify_framework"),
                "checked" => $options["allow_editor_css"]
            )); ?><br />
            <span class="caution"><?php _e("* custom editor style file path: "); ?><?php echo bloginfo("template_directory"); ?>/editor-style.css</span></dd>
        </dl>

        <h3><?php _e("Comment post setting.", "unify_framework"); ?></h3>
        <dl>
            <dt><?php _e("Comment", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array(
                "id" => "uf_comment_for_page", "name" => "comment_for_page", "label" => __("Comment allwod page ?", "unify_framework"),
                "checked" => $options["comment_for_page"]
            )); ?><br />
            <?php uf_form_input("text", $options["comment_allowd_pages"], array( "id" => "uf_comment_allowd_pages", "name" => "comment_allowd_pages" )); ?><br />
            <label for="uf_comment_allowd_pages" class="caution"><?php _e("* separated 'comma' for page ID", "unify_framework"); ?></label></dd>
        </dl>

        <h3><?php _e("Custom Image header setting"); ?></h3>
        <dl>
            <dt><?php _e("Custom ImageHeader", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array(
                "id" => "uf_display_custom_header_in_front", "name" => "show_custom_header_in_front", "label" => __("display custom header in the home page or front page ?", "unify_framework"),
                "checked" => $options["show_custom_header_in_front"]
            )); ?></dd>
        </dl>

        <h3><?php _e("Extensions", "unify_framework"); ?></h3>
        <dl>
            <dt><?php _e("CustomPost extension", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array(
                "id" => "uf_extension_custom_post", "name" => "custom_post", "label" => __("Enable theme support custom post type.", "unify_framework"),
                "checked" => $options["extensions"]["custom_post"]
            )); ?><br />
            <span class="caution"><?php _e("* is installed Custom Post Type UI, this extension always disable."); ?></span><br />

            <?php uf_form_checkbox(1, array(
                "id" => "uf_extension_post_thumbnail", "name" => "post_thumbnail", "label" => __("Enable theme support post thumbnail."),
                "checked" => $options["extensions"]["post_thumbnail"]
            )); ?></dd>
        </dl>
        <p><input type="submit" name="save_option" value="<?php _e("Save options"); ?>" class="button-primary" /></p>
    </form>
<!-- End wrap --></div>
<?php
}



/**
 * Display custom post form for Admin
 *
 * @access public
 * @return Void
 */
/*
function uf_admin_page_custom_post() {
    if($_GET["uf_cp_edit_id"]) {
        $options = uf_get_custom_post($_GET["uf_cp_edit_id"]);
    }
?>
<h3><?php _e("Custom post type register field.", "unify_framework"); ?></h3>
<form action="" method="post">
    <?php wp_nonce_field(); ?>
    <?php uf_form_input("hidden", wp_create_nonce(), array( "name" => "uf_admin_nonce" )); ?>
    <dl>
        <dt><?php _e("Custom post type name", "unify_framework"); ?></dt>
        <dd><?php uf_form_input("text", "", array(
            "id" => "uf_custom_posts_post_type_name", "name" => "uf_custom_posts_post_type_name", "label" => __("unique custom post name")
        )); ?></dd>

        <dt><?php _e("Description", "unify_framework"); ?></dt>
        <dd><?php uf_form_input("text", "", array(
            "id" => "uf_custom_posts_description", "name" => "uf_custom_posts[description]", "label" => __("shorty custom post type description", "unify_framework")
        )); ?></dd>

        <dt><?php _e("Labels", "unify_framework"); ?></dt>
        <dd><?php uf_form_input("text", "", array(
            "id" => "uf_custom_posts_name", "name" => "uf_custom_posts[name]", "label" => __("custom post type unique name.", "unify_framework")
        )); ?><br />
        <?php uf_form_input("text", "", array(
            "id" => "uf_custom_psots_singular_name", "name" => "uf_custom_posts[singular_name]", "label" => __("custom post type unique singular name.", "unify_framework")
        )); ?></dd>

        <dt><?php _e("Public", "unify_framework"); ?></dt>
        <dd><?php uf_form_checkbox(1, array(
            "id" => "uf_custom_posts_public", "name" => "uf_custom_posts[public]", "label" => __("shown admin UI.", "unify_framework")
        )); ?></dd>

        <dt><?php _e("Search form", "unify_framework"); ?></dt>
        <dd><?php uf_form_checkbox(1, array(
            "id" => "uf_custom_posts_exclude_form_search", "name" => "uf_custom_posts[exclude_from_search]", "label" => __("exclude custom post type in search form.", "unify_framework")
        )); ?></dd>

        <dt><?php _e("Show UI", "unify_framework"); ?></dt>
        <dd><?php uf_form_checkbox(1, array(
            "id" => "uf_custom_posts_show_ui", "name" => "uf_custom_posts[show_ui]", "label" => __("Whether to generate a default UI for managing this post type.", "unify_framework")
        )); ?></dd>

        <dt><?php _e("Capability Type", "unify_framework"); ?></dt>
        <dd><?php uf_form_select(array( "page" => __("Page"), "post" => __("Post")), array(
            "id" => "uf_custom_posts_capability_type", "name" => "uf_custom_posts[capability_type]", "label" => __("The post type to use for checking read, edit, and delete capabilities.", "unify_framework"),
            "value" => ""
        )); ?></dd>

        <dt><?php _e("Hierarchical", "unify_framework"); ?></dt>
        <dd><?php uf_form_checkbox(1, array(
            "id" => "uf_custom_posts_herarchical", "name" => "uf_custom_posts[hierarchical]", "label" => __("this post type have a hieralchical.")
        )); ?></dd>

        <dt><?php _e("Supports", "unify_framework"); ?></dt>
        <dd>
            <?php uf_form_input("hidden", "", array( "name" => "uf_custom_posts[supports]" )); ?>
            <?php foreach(array('Title','Editor','Author','Thumbnail','Excerpt','Comments') as $field): ?>
                <?php uf_form_checkbox($field, array( "id" => "uf_custom_posts_supports_". strtolower($field), "name" => "uf_custom_posts[supports][]", "label" => __($field), "show_hidden" => false )); ?>
            <?php endforeach; ?>
        </dd>

        <dt><?php _e("Export", "unify_framework"); ?></dt>
        <dd><?php uf_form_checkbox(1, array(
            "id" => "uf_custom_posts_can_export", "name" => "uf_custom_posts[can_export]", "label" => __("this post type including WPExport ?", "unify_framework")
        )); ?></dd>

        <dt><?php _e("Nav Menus", "unify_framework"); ?></dt>
        <dd><?php uf_form_checkbox(1, array(
            "id" => "uf_custom_posts_show_in_nav_menus", "name" => "uf_custom_posts[show_in_nav_menus]", "label" => __("this custom post type including custom nav menus ?")
        )); ?></dd>
    </dl>
    <p><input type="submit" name="uf_custom_post_save" value="<?php _e("Save as custom post"); ?>" class="button-primary" /></p>
</form>
<hr />
<h3><?php _e("Registerd custom post types"); ?></h3>
<?php uf_admin_get_registerd_custom_posts(); ?>
<?php
}
add_action("uf_admin_page_custom-post", "uf_admin_page_custom_post");
*/


/**
 * Display registerd custom posts
 *
 * @access public
 * @return Void
 */
/*
function uf_admin_get_registerd_custom_posts() {
    $custom_posts = uf_get_custom_posts();
?>
<?php if(empty($custom_posts)): ?>
    <p><?php _e("No in registerd", "unify_framework"); ?></p>
<?php else: ?>
    <table border="0" cellpadding="0" cellspacing="0" class="widefat">
        <thead>
            <tr>
                <th><?php _e("ID", "unify_framework"); ?></th>
                <th><?php _e("CustomPost name", "unify_framework"); ?></th>
                <th><?php _e("Actions", "unify_framework"); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th><?php _e("ID", "unify_framework"); ?></th>
                <th><?php _e("CustomPost name", "unify_framework"); ?></th>
                <th><?php _e("Actions", "unify_framework"); ?></th>
            </tr>
        </tfoot>
    </table>
<?php endif; ?>
<?php
}
*/


/**
 * display theme support post-thumbnail
 *    post-thumbnail support WordPress version 2.9.x
 *
 * @access protected
 * @return Void
 */
/*
function uf_admin_page_post_thumbnail() {
?>
<h3><?php _e("Post thumbnail setting", "unify_framework"); ?></h3>
<?php
}
add_action("uf_admin_page_post-thumbnail", "uf_admin_page_post_thumbnail");
*/


