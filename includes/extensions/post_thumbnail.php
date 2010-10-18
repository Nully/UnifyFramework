<?php
/**
 * UnifyFramework PostThumbnail support
 *
 */
/**
 * uf_pt_admin_save_options
 *
 * UnifyFramework PostThumbnail option save action hook
 *
 * @access protected
 * @return Void
 */
function uf_pt_admin_save_options() {
    if(!$_POST || !$_POST["save_post_thumb_options"])
        return;

    uf_update_option("post_thumbnail", array(
        "enable" => $_POST["enable"],
        "support_type" => $_POST["support_type"],
        "width"  => $_POST["width"],
        "height" => $_POST["height"],
        "crop"   => $_POST["crop"]
    ));
}
add_action("init", "uf_pt_admin_save_options");



/**
 * uf_pt_admin_head
 *
 * UnifyFramework PostThumbnail admin panel header action hook.
 *
 * @access protected
 * @return Void
 */
function uf_pt_admin_head() {
    global $pagenow, $plugin_page;
    if($pagenow != "admin.php" || $plugin_page != "uf-cp-edit") {
        return;
    }

    wp_enqueue_style("uf-admin", get_bloginfo("template_url"). "/css/admin.css");
}
add_action("init", "uf_pt_admin_head");



/**
 * uf_pt_admin_menu
 *
 * UnifyFramework PostThumbnail admin panel admin_menu action hook.
 *
 * @access protected
 * @return Void
 */
function uf_pt_admin_menu() {
    add_submenu_page("uf-options", __("Edit Post Thumbnail setting", "unify_framework"), __("Post Thumbnail setting", "unify_framework"), 10, "uf-pt-edit", "uf_pt_admin_edit_page");
    uf_admin_add_page_nav(__("Post Thumbnail", "unify_framework"), "uf-pt-edit");
}
add_action("admin_menu", "uf_pt_admin_menu");



/**
 * UnifyFramework PostThumbnail admin setting page
 *
 * @access protected
 * @return Void
 */
function uf_pt_admin_edit_page() {
    $options = uf_get_option("post_thumbnail");
?>
<div class="wrap" id="uf_admin">
    <?php uf_admin_page_tab_nav(); ?>
    <p><?php _e("setting post thumbnail options.", "unify_framework"); ?></p>
    <form action="" method="post">
        <?php wp_nonce_field(); ?>
        <dl>
            <dt><?php _e("Enable PostThumbnail", "unify_framework"); ?></dt>
            <dd><?php uf_form_checkbox(1, array(
                "id" => "uf_post_thumb_enable", "name" => "enable",
                "label" => __("Enable PostThumbnail support.", "unify_framework"), "checked" => $options["enable"]
            )); ?></dd>

            <dt><?php _e("Support post type", "unify_framework"); ?></dt>
            <dd><?php uf_form_select(array( "page" => __("Page"), "post" => __("Post"), "all" => __("All")), array(
                "id" => "uf_post_thumb_support_type", "name" => "support_type",
                "label" => __("Choice a support post type", "unify_framework"), "value" => $options["support_type"]
            )); ?></dd>

            <dt><?php _e("Thumbnail width", "unify_framework"); ?></dt>
            <dd><?php uf_form_input("text", $options["width"] ? $options["width"] : 200, array(
                "id" => "uf_post_thumb_width", "name" => "width", "label" => __("set image width is 'px'.", "unify_framework")
            )); ?></dd>

            <dt><?php _e("Thumbnail height", "unify_framework"); ?></dt>
            <dd><?php uf_form_input("text", $options["height"] ? $options["height"] : 200, array(
                "id" => "uf_post_thumb_height", "name" => "height", "label" => __("set image height is 'px'.", "unify_framework")
            )); ?></dd>

            <dt><?php _e("Thumbnail crop", "unify_fraemwork"); ?></dt>
            <dd><?php uf_form_checkbox(1, array(
                "id" => "uf_post_thumb_crop", "name" => "crop", "label" => __("upload image crop ?", "unify_framework"),
                "checked" => !!$options["crop"]
            )); ?></dd>
        </dl>
        <p><input type="submit" name="save_post_thumb_options" value="<?php _e("Save post thumbnail options"); ?>" class="button-primary" /></p>
    </form>
<!-- End uf_admin --></div>
<?php
}



/**
 * uf_pt_init_post_thumbnail
 *
 * UnifyFramework PostThumbnail support setting.
 *
 * @access protected
 * @return Void
 */
function uf_pt_init_post_thumbanil() {
    $options = uf_get_option("post_thumbnail", array());
    if(empty($options) || $options["enable"] == false)
        return;

    $types = array();
    switch(strtolower($options["support_type"])) {
        case "page":
            $types[] = "page";
            break;
        case "post":
            $types[] = "post";
            break;
        default:
            $types = array("post", "page");
            break;
    }

    $width = (int)$options["width"];
    $height = (int)$options["height"];
    $crop = !!$options["crop"];

    if(empty($width))
        $width = 180;

    if(empty($height))
        $height = 200;

    add_theme_support("post-thumbnails", $types);
    set_post_thumbnail_size($width, $height, $crop);
}
add_action("after_setup_theme", "uf_pt_init_post_thumbanil");



