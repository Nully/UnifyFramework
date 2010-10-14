<?php
/**
 * UnifyFramework CustomPost extension
 *
 */
class UF_CustomPost extends UF_Extension {
    function UF_CustomPost() {
        $this->UF_Extension("UF_CustomPost", __("CustomPost", "unify_framework"), __("UnifyFramewrok theme supported CustomPost", "unify_framework"));
    }


    /**
     * Initialize action hooks
     *
     * @access public
     * @return Void
     */
    function init() {
        add_action("admin_menu", array(&$this, "register_menu"));
    }



    /**
     * Register admin themes submenu
     *
     * @access public
     * @return Void
     */
    function register_menu() {
        add_submenu_page("themes.php", __("UnifyFramework CutomPost register", "unify_framework"), __("new CustomPost", "unify_framework"), 10, "uf-add-custom-post", array(&$this, "add_new"));
        add_submenu_page("themes.php", __("UnifyFramework CutomPost editor", "unify_framework"), __("edit CustomPost", "unify_framework"), 10, "uf-edit-custom-post", array(&$this, "edit"));
    }


    /**
     * Display add new CustomPost form.
     *
     * @access public
     */
    function add_new() {
    ?>
        <div class="wrap" id="uf_admin">
            <?php screen_icon("options-general"); ?>
            <h2><?php _e("Add new CustomPost", "unify_framework"); ?></h2>
            <p><?php _e("", "unify_framework"); ?></p>
        <!-- End wrap --></div>
    <?php
    }


    /**
     * Display editable Customposts
     *
     * @access public
     * @return Void
     */
    function edit() {
    ?>
        <div class="wrap" id="uf_admin">
            <?php screen_icon("options-general"); ?>
            <h2><?php _e("Edit CustomPosts", "unify_framework"); ?></h2>
            <p><?php _e("", "unify_framework"); ?></p>
        </div>
    <?php
    }
}



/**
 * UnifyFramework PostThumbnail extension
 *
 */
class UF_PostThumbnail extends UF_Extension {
    function UF_PostThumbnail() {
        $this->UF_Extension("UF_PostThumbnail", __("PostThumbnail"), __("UnifyFramework theme supported PostThumbnail"));
    }


    /**
     * Initialize action hooks
     *
     * @access public
     * @return Void
     */
    function init() {
        add_action("admin_menu", array(&$this, "register_menu"));
    }


    /**
     * Register admin themes submenu
     *
     * @access public
     * @return Void
     */
    function register_menu() {
        add_submenu_page("themes.php", __("UnifyFramework PostThumbnail settings", "unify_framework"), __("PostThumbnail", "unify_framework"), 10, "uf-post-thumbnail", array(&$this, "edit_option"));
    }


    function edit_option() {
        if(isset($_POST["save_post_thumb_options"])) {
            uf_update_option("post_thumbnail", array(
                "post_thumb_enable" => $_POST["post_thumb_enable"],
                "uf_post_thumb_support_type" => $_POST["uf_post_thumb_support_type"],
                "post_thumb_width"  => $_POST["post_thumb_width"],
                "post_thumb_height" => $_POST["post_thumb_height"]
            ));
        }
        $options = uf_get_option("post_thumbnail");
    ?>
        <div class="wrap" id="uf_admin">
            <?php screen_icon("options-general"); ?>
            <h2><?php _e("Edit PostThumbnail settings", "unify_framework"); ?></h2>
            <p><?php _e("post thumbnail setting edit.", "unify_framework"); ?></p>
            <form action="" method="post">
                <dl>
                    <dt><?php _e("Enable PostThumbnail", "unify_framework"); ?></dt>
                    <dd><?php uf_form_checkbox(1, array(
                        "id" => "uf_post_thumb_enable", "name" => "post_thumb_enable",
                        "label" => __("Enable PostThumbnail support.", "unify_framework"), "checked" => $options["post_thumb_enable"]
                    )); ?></dd>

                    <dt><?php _e("Support post type", "unify_framework"); ?></dt>
                    <dd><?php uf_form_select(array( "page" => __("Page"), "post" => __("Post"), "all" => __("All")), array(
                        "id" => "uf_post_thumb_support_type", "name" => "uf_post_thumb_support_type",
                        "label" => __("Choice a support post type"), "value" => $options["uf_post_thumb_support_type"]
                    )); ?></dd>

                    <dt><?php _e("Thumbnail width", "unify_framework"); ?></dt>
                    <dd><?php uf_form_input("text", 200, array(
                        "id" => "uf_post_thumb_width", "name" => "post_thumb_width", "label" => __("set image width is 'px'."),
                        "value" => $options["post_thumb_width"]
                    )); ?></dd>

                    <dt><?php _e("Thumbnail height", "unify_framework"); ?></dt>
                    <dd><?php uf_form_input("text", 200, array(
                        "id" => "uf_post_thumb_height", "name" => "post_thumb_height", "label" => __("set image height is 'px'."),
                        "value" => $options["post_thumb_height"]
                    )); ?></dd>
                </dl>
                <p><input type="submit" name="save_post_thumb_options" value="<?php _e("Save post thumbnail options"); ?>" class="button-primary" /></p>
            </form>
        </div>
    <?php
    }
}


