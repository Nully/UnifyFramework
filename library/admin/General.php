<?php
/**
 * Do action admin_init save theme mod
 *
 * @action admin_init
 */
add_action("admin_init", "uf_admin_general_init");
function uf_admin_general_init() {
    if(!isset($_POST["do_save"]))
        return;

    if(!isset($_POST["uf_post_format"]))
        $formats = array();
    else
        $formats = $_POST["uf_post_format"];

    set_theme_mod("title_set", $_POST["uf_title_sep"]);
    set_theme_mod("post_formats", $formats);

    add_action("admin_notices", "uf_admin_general_notices");
}


/**
 * Display admin notice
 *
 * @return Void
 * @action admin_notice
 */
function uf_admin_general_notices() {
?>
<div class="updated faded">
<p><?php _e("updated theme options.", UF_TETDOMAIN); ?></p>
</div>
<?php
}


/**
 * UnifyFramework theme admin General options
 *
 * @action admin_menu
 */
function uf_admin_general_admin() {
    $separators = uf_admin_general_get_title_seps();
?>
<div class="wrap">
<?php screen_icon("themes"); ?>
<h2><?php _e("General"); ?></h2>
<p><?php _e("UnifyFramework general option setting.", UF_TEXTDOMAIN); ?></p>

<form action="" method="post">
<?php wp_nonce_field(); ?>
<div class="metabox-holder">
<div class="uf-admin postbox">
    <h3 class="uf-admin-title hndle"><?php _e("Titles"); ?></h3>
    <div class="inside">
        <p><?php _e("Document title separator.", UF_TEXTDOMAIN); ?></p>
        <?php foreach($separators as $sep): ?>
        <input type="radio" id="name" name="uf_title_sep" value="<?php $sep; ?>" />&nbsp;<?php echo $sep; ?>
        <?php endforeach; ?>
    <!-- End inside --></div>
<!-- End uf-admin --></div>


<div class="uf-admin postbox">
    <h3 class="uf-admin-title hndle"><?php _e("Post Formats"); ?></h3>
    <div class="inside">
        <p><?php _e("Supported post format", UF_TEXTDOMAIN); ?></p>
        <p>
        <?php foreach(_uf_admin_general_get_post_formats() as $format): ?>
        <input type="checkbox" id="post-format-<?php
            echo esc_attr($format);
        ?>" name="uf_post_format[<?php
            echo esc_attr($format);
        ?>]" value="1" /><label for="post-format-<?php
            echo esc_attr($format);
        ?>"><?php
            _e($format, UF_TEXTDOMAIN);
        ?></label>
        <?php endforeach; ?>
        </p>
    <!-- End inside --></div>
<!-- End uf-admin --></div>


<!-- End metabox-holder --></div>
<p><input type="submit" name="do_save" value="<?php _e("Save general options", UF_TEXTDOMAIN); ?>" class="button-primary" /></p>
</form>
<!-- End wrap --></div>
<?php
}


/**
 * Get title separators
 *
 * @return  Array
 * @filters uf_admin_general_get_title_seps
 */
function _uf_admin_general_get_title_seps() {
    $separators = array(
        "&lt;", "&gt;", "&laquo;", "&raquo;", " | "
    );
    $separators = apply_filters("uf_admin_general_get_title_seps", $separators);

    return $separators;
}


/**
 * Get supported post formats
 * post-format is WordPress version 3.1 over support start.
 *
 * @return Array
 */
function _uf_admin_general_get_post_formats() {
    return array(
        "aside", "chat", "gallery", "image", "link", "quote",
        "status", "video"
    );
}


