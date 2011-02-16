<?php
class UnifyFramework_Admin_PostThumbnail extends UnifyFramework_Admin_Abstract {
    protected $defaults = array(
        "uf_thumb_width" => HEADER_IMAGE_WIDTH,
        "uf_thumb_height" => HEADER_IMAGE_HEIGHT,
    );


    public static function notices() {
        if($_GET["uf_post_thumb_update_option_success"]) {
            $msg = sprintf(
                '<div class="updated fade success"><p>%1$s</p></div>',
                __("success Update options.", UF_TEXTDOMAIN)
            );
        }
        elseif($_GET["uf_post_thumb_update_option_error"]) {
            $msg = sprintf(
                '<div class="updated fade success"><p>%1$s</p></div>',
                __("failuer Update options.", UF_TEXTDOMAIN)
            );
        }

        echo $msg;
    }


    public static function save_options() {
        global $plugin_page;
        if(!$_POST["uf_post_thumb_update"])
            return;

        $options = array(
            "which"     => $_POST["uf_post_thumb_which"],
            "support"   => $_POST["uf_post_thumb_support"],
            "width"     => $_POST["uf_thumbnail_width"],
            "height"    => $_POST["uf_thumbnail_height"],
            "crop"      => $_POST["uf_thumbnail_crop"],
        );

        if(!$options["width"] && defined("HEADER_IMAGE_WIDTH"))
            $options["width"] = HEADER_IMAGE_WIDTH;

        if(!$options["height"] && defined("HEADER_IMAGE_HEIGHT"))
            $options["height"] = HEADER_IMAGE_HEIGHT;

        $options = array_filter($options, "esc_attr");

        $state = "error";
        if(update_option("uf_post_thumbnail", $options)) {
            $state = "success";
        }

        $url = admin_url("admin.php?page={$plugin_page}&uf_post_thumb_update_option_{$state}=1");
        wp_redirect($url);
        exit;
    }


    public static function get_options() {
        $options = get_option("uf_post_thumbnail", array(
            "which"     => 1,
            "support"   => "post,page",
            "width"     => HEADER_IMAGE_WIDTH,
            "height"    => HEADER_IMAGE_HEIGHT,
            "crop"      => "no",
        ));

        return $options;
    }


    public static function form() {
        $options = self::get_options();
?>
<div class="wrap">
<?php screen_icon("options-general"); ?>
<h2><?php _e("Post thumbnail settings", UF_TEXTDOMAIN); ?></h2>
<p><?php _e("post thumbnail support setting.", UF_TEXTDOMAIN); ?></p>

<form action="" method="post">
<?php wp_nonce_field(); ?>
<div class="metabox-holder">
<div class="uf-admin postbox">
    <h3 class="uf-admin-title hndle"><?php _e("Enable post thumbnail", UF_TEXTDOMAIN); ?></h3>
    <div class="inside">
        <p><input type="radio" id="enable_post_thumb" name="uf_post_thumb_which" value="yes"<?php echo ($options["which"] == "yes" ? ' checked="checked"': ""); ?> />&nbsp;<label for="enable_post_thumb"><?php _e("enable post thumbnail", UF_TEXTDOMAIN); ?></label></p>
        <p><input type="radio" id="disable_post_thumb" name="uf_post_thumb_which" value="no"<?php echo ($options["which"] == "no" ? ' checked="checked"': ""); ?> />&nbsp;<label for="disable_post_thumb"><?php _e("disable post thumbnail", UF_TEXTDOMAIN); ?></label></p>
    <!-- End inside --></div>
<!-- End uf-admin --></div>

<div class="uf-admin postbox">
    <h3 class="uf-admin-title hndle"><?php _e("Enable post thumbnail target", UF_TEXTDOMAIN); ?></h3>
    <div class="inside">
        <p><input type="radio" id="support_post_page" name="uf_post_thumb_support" value="post,page"<?php echo ($options["support"] == "post,page" ? ' checked="checked"': ""); ?> />&nbsp;<label for="support_post_page"><?php _e("support post and page", UF_TEXTDOMAIN); ?></label></p>
        <p><input type="radio" id="support_page" name="uf_post_thumb_support" value="page"<?php echo ($options["support"] == "page" ? ' checked="checked"': ""); ?> />&nbsp;<label for="support_page"><?php _e("support page", UF_TEXTDOMAIN); ?></label></p>
        <p><input type="radio" id="support_post" name="uf_post_thumb_support" value="post"<?php echo ($options["support"] == "post" ? ' checked="checked"': ""); ?> />&nbsp;<label for="support_post"><?php _e("support post", UF_TEXTDOMAIN); ?></label></p>
    <!-- End inside --></div>
<!-- End uf-admin --></div>

<div class="uf-admin postbox">
    <h3 class="uf-admin-title hndle"><?php _e("Post thumbnail image size", UF_TEXTDOMAIN); ?></h3>
    <div class="inside">
        <p><label for="uf_thumbnail_width"><?php _e("Thumbnail width", UF_TEXTDOMAIN); ?></label>&nbsp;<input type="text" id="uf_thumbnail_width" name="uf_thumbnail_width" value="<?php echo esc_attr($options["width"]); ?>" />px</p>
        <p><label for="uf_thumbnail_height"><?php _e("Thumbnail height", UF_TEXTDOMAIN); ?></label>&nbsp;<input type="text" id="uf_thumbnail_height" name="uf_thumbnail_height" value="<?php echo esc_attr($options["height"]); ?>" />px</p>
        <p><em><?php _e("Default image size is HEADER_IMAGE_WIDTH and HEADER_IMAGE_HEIGHT.", UF_TEXTDOMAIN); ?></em></p>
    <!-- End inside --></div>
<!-- End uf-admin --></div>

<div class="uf-admin postbox">
    <h3 class="uf-admin-title hndle"><?php _e("Croping", UF_TEXTDOMAIN); ?></h3>
    <div class="inside">
        <p><input type="radio" id="uf_thumbnail_crop_yes" name="uf_thumbnail_crop" value="yes"<?php echo ($options["crop"] == "yes" ? ' checked="checked"': ""); ?> />&nbsp;<label for="uf_thumbnail_crop_yes"><?php _e("crop thumbnail image", UF_TEXTDOMAIN); ?></label></p>
        <p><input type="radio" id="uf_thumbnail_crop_no" name="uf_thumbnail_crop" value="no"<?php echo ($options["crop"] == "no" ? ' checked="checked"': ""); ?> />&nbsp;<label for="uf_thumbnail_crop_no"><?php _e("do not crop thumbnail image", UF_TEXTDOMAIN); ?></label></p>
        <p><em><?php _e("do not crop select, image size justify resize.", UF_TEXTDOMAIN); ?></em></p>
    <!-- End inside --></div>
<!-- End uf-admin --></div>

<p><input type="submit" name="uf_post_thumb_update" value="<?php _e("Update options", UF_TEXTDOMAIN); ?>" class="button-primary" /></p>
<!-- End metabox holder --></div>
</form>
<!-- End wrap --></div>
<?php
    }
}

add_action("admin_notices", array( "UnifyFramework_Admin_PostThumbnail", "notices" ));
add_action("admin_init", array( "UnifyFramework_Admin_PostTHumbnail", "save_options" ));

