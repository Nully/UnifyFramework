<?php
/**
 * 
 */
function uf_admin_general_admin() {
    $separators = array(
        "&lt;", "&gt;", "&laquo;", "&raquo;", " | "
    );
?>
<div class="wrap">
<?php screen_icon("themes"); ?>
<h2><?php _e("General"); ?></h2>
<p><?php _e("UnifyFramework general option setting.", UF_TEXTDOMAIN); ?></p>

<form action="" method="post">
<div class="metabox-holder">
<div class="uf-admin postbox">
    <h3 class="uf-admin-title hndle"><span><?php _e("Titles"); ?></span></h3>
    <div class="inside">
        <p><?php _e("Document title separator.", UF_TEXTDOMAIN); ?></p>
        <?php foreach($separators as $sep): ?>
        <input type="radio" id="name" name="name" value="<?php $sep; ?>" />&nbsp;<?php echo $sep; ?>
        <?php endforeach; ?>
    <!-- End inside --></div>
<!-- End uf-admin --></div>

<!-- End metabox-holder --></div>
<p><input type="submit" name="save_general_option" value="<?php _e("Save general options", UF_TEXTDOMAIN); ?>" class="button-primary" /></p>
</form>
<!-- End wrap --></div>
<?php
}

