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
                "custom_post"       => $_POST["custom_post"],
                "custom_taxonomies" => $_POST["custom_taxonomies"],
                "post_thumbnail"    => $_POST["post_thumbnail"],
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

        <?php uf_admin_postbox(__("Editor style setting"), array(array(
            "label" => __("Editor style setting.", "unify_framework"),
            "field" => uf_form_checkbox(1, array(
                "id" => "uf_allow_editor_css", "name" => "allow_editor_css",
                "label" => __("Allow custom editor style", "unify_framework"),
                "checked" => $options["allow_editor_css"],
            ), false),
            "extra" => sprintf(__("* custom editor style file path: %s"), get_bloginfo("template_directory"). "/editor-style.css")
        ))); ?>


        <?php uf_admin_postbox(__("Comment post setting.", "unify_framework"), array(
            array(
                "label" => __("Required field setting", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_comment_required_name", "name" => "comment_required_name",
                    "label" => __("name only required.", "unify_framework"),
                    "checked" => $options["comment_required_name"]
                ), false)
            ),
            array(
                "label" => __("Comment allowd page setting", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_comment_for_page", "name" => "comment_for_page",
                    "label" => __("Comment allwod page ?", "unify_framework"),
                    "checked" => $options["comment_for_page"]
                ), false). "<br />".
                uf_form_input("text", $options["comment_allowd_pages"], array(
                    "id" => "uf_comment_allowd_pages", "name" => "comment_allowd_pages",
                ), false),
                "extra" => __("* separated 'comma' for page ID", "unify_framework")
            )
        )); ?>


        <?php uf_admin_postbox(__("Custom Image header setting", "unify_framework"), array(
            array(
                "label" => __("Custom ImageHeader", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_display_custom_header_in_front", "name" => "show_custom_header_in_front",
                    "label" => __("display custom header in the home page or front page ?", "unify_framework"),
                    "checked" => $options["show_custom_header_in_front"]
                ), false),
            )
        )); ?>


        <?php uf_admin_postbox(__("Extensions", "unify_framework"), array(
            array(
                "label" => __("CustomPost extension", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_extension_custom_post", "name" => "custom_post",
                    "label" => __("Enable theme support custom post type.", "unify_framework"),
                    "checked" => $options["extensions"]["custom_post"]
                ), false),
                "extra" => __("* is installed Custom Post Type UI, this extension always disable.", "unify_framework")
            ),
            array(
                "label" => __("CustomTaxonomies extension", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_extension_custom_tax", "name" => "custom_taxonomies",
                    "label" => __("Enable theme support custom taxonomies.", "unify_framework"),
                    "checked" => $options["extensions"]["custom_taxonomies"]
                ), false),
            ),
            array(
                "label" => __("PostThumbnail extension", "unify_framework"),
                "field" => uf_form_checkbox(1, array(
                    "id" => "uf_extension_post_thumbnail", "name" => "post_thumbnail", "label" => __("Enable theme support post thumbnail."),
                    "checked" => $options["extensions"]["post_thumbnail"]
                ), false),
            )
        )); ?>

        <p><input type="submit" name="save_option" value="<?php _e("Save options"); ?>" class="button-primary" /></p>
    </form>
<!-- End wrap --></div>
<?php
}



/**
 * uf_admin_postbox
 *
 * UnifyFramework admin panel postbox HTML display.
 *
 * @access public
 * @param  $title    String    postbox title bar
 * @param  $data     Array     postbod data array. array( "field string" => "field value" ) pair, display dl tag.
 * @param  $extra    Bool|String   postbox inside a extra comment data.
 * @return Void|String
 */
function uf_admin_postbox($title, $data = array()) {
    if(!is_array($data))
        $data = (array)$data;
?>
<div class="postbox">
    <h3 class="hndle"><?php echo $title; ?></h3>
    <div class="inside">
        <table border="0" cellpadding="0" cellspacing="0">
            <?php foreach($data as $pair): ?>
            <tr>
                <th><?php echo $pair["label"]; ?></th>
                <td><?php echo $pair["field"]; ?>
                    <?php if($pair["extra"]): ?>
                    <br />
                    <span class="caution"><?php echo $pair["extra"]; ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <!-- End inside --></div>
<!-- End postbox --></div>
<?php
}



