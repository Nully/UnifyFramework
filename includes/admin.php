<?php
/**
 * UnifyFramework Admin page scripts
 *
 */
function uf_admin_save_options() {
    if($_POST["save_option"]) {
        uf_update_option("theme_options", array(
            "allow_editor_css"      => $_POST["allow_editor_css"],
            "comment_required_name" => $_POST["comment_required_name"],
            "comment_for_page"      => $_POST["comment_for_page"],
            "comment_allowd_pages"  => $_POST["comment_allowd_pages"],
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
 * admin_menu action hook
 *
 * @access protected
 * @return Void
 */
function uf_admin_submenu() {
    add_menu_page(__("UnifyFramework setting pages", "unify_framework"), __("Theme Options", "unify_framework"), 10, "uf-options", "uf_admin_setting");
    uf_admin_add_page_nav(__("Theme Options", "unify_framework"), "uf-options");
}
add_action("admin_menu", "uf_admin_submenu");



/**
 * Register admin theme option global navigation stack.
 *
 * @access public
 * @param  $label    String    menu text label
 * @param  $page     String    admin theme option setting Query 'page' name.
 * @return Bool|String  registerd page slug name.
 */
global $uf_admin_page_navs;
$uf_admin_page_navs = array();
function uf_admin_add_page_nav($label, $page) {
    global $uf_admin_page_navs;

    if(isset($uf_admin_page_navs[$page]))
        return false;

    $uf_admin_page_navs[$page] = array(
        "label" => $label
    );

    return $page;
}



/**
 * UnifyFramework admin page Navigation tab
 *
 * @access public
 * @return Void
 */
function uf_admin_page_tab_nav() {
    global $plugin_page, $uf_admin_page_navs;

    $base_url = get_admin_url(null, "admin.php");
?>
<?php screen_icon("options-general"); ?>
<h2>
    <?php foreach($uf_admin_page_navs as $name => $nav): ?>
    <a href="<?php echo $base_url; ?>?page=<?php echo $name; ?>" class="nav-tab<?php echo ($plugin_page == $name) ? " nav-tab-active": ""; ?>"><?php echo $nav["label"]; ?></a>
    <?php endforeach; ?>
</h2>
<?php
}



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
    <?php uf_admin_page_tab_nav(); ?>
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
                "id" => "uf_comment_required_name", "name" => "comment_required_name", "label" => __("name only required.", "unify_framework"),
                "checked" => $options["comment_required_name"]
            )); ?></dd>
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





