<?php
class UnifyFramework_Admin_EditorStyle extends UnifyFramework_Admin_Abstract {

    public static function notices() {
        if($_GET["uf_editor_style_update_success"]) {
            $msg = sprintf(
                '<div class="updated fade success"><p>%1$s</p></div>',
                __("update Editor style options.", UF_TEXTDOMAIN)
            );
        }
        else if($_GET["uf_editor_style_update_error"]){
            $msg = sprintf(
                '<div class="error"><p>%1$s</p></div>',
                __("no updated Editor style options.", UF_TEXTDOMAIN)
            );
        }

        echo $msg;
    }


    public static function update_options() {
        global $plugin_page;

        if(!$_POST["uf_editor_style_update"])
            return;

        $options = array(
            "which" => $_POST["uf_editor_style_which"],
        );

        if(update_option("uf_editor_style", $options)) {
            $state = "success";
        }
        else {
            $state = "error";
        }

        if(isset($_POST["editor_styles"])) {
            if(self::put_editor_buffer($_POST["editor_styles"])) {
                $state = "success";
            }
        }

        $url = admin_url("admin.php?page={$plugin_page}&uf_editor_style_update_{$state}=1");
        wp_redirect($url);
        exit;
    }


    public static function get_options() {
        $options = get_option("uf_editor_style", array(
            "which" => "yes"
        ));

        return $options;
    }


    public static function form() {
        $options = self::get_options();
?>
<div class="wrap">
<?php screen_icon("options-general"); ?>
<h2><?php _e("Editor style setting", UF_TEXTDOMAIN); ?></h2>

<div class="metabox-holder">

<form action="" method="post">
<?php wp_nonce_field(); ?>

<div class="uf-admin postbox">
    <h3 class="uf-admin-title hndle"><?php _e("Enable editor style", UF_TEXTDOMAIN); ?></h3>
    <div class="inside">
        <p><input type="radio" id="enable_editor_style" name="uf_editor_style_which" value="yes"<?php echo ($options["which"] == "yes" ? ' checked="checked"': ""); ?> />&nbsp;<label for="enable_editor_style"><?php _e("enable editor style", UF_TEXTDOMAIN); ?></label></p>
        <p><input type="radio" id="disable_editor_style" name="uf_editor_style_which" value="no"<?php echo ($options["which"] == "no" ? ' checked="checked"': ""); ?> />&nbsp;<label for="disable_editor_style"><?php _e("disable editor style", UF_TEXTDOMAIN); ?></label></p>
    <!-- End inside --></div>
<!-- End uf-admin --></div>

<?php if(self::exists_editor_style()): ?>
<div class="uf-admin postbox">
    <h3 class="uf-admin-title hndle"><?php _e("Style editor", UF_TEXTDOMAIN); ?></h3>
    <div class="inside">
        <textarea name="editor_styles" style="width: 100%; height: 400px;" cols="30" rows="10"><?php echo self::get_editor_buffer(); ?></textarea>
    <!-- End inside --></div>
<!-- End uf-admin --></div>
<?php endif; ?>

<p><input type="submit" id="uf_editor_style_update" name="uf_editor_style_update" value="<?php _e("Update options", UF_TEXTDOMAIN); ?>" class="button-primary" /></p>
</form>
<!-- End metabox holder --></div>

<!-- End wrap --></div>
<?php
    }


    /**
     * Exists editor style file ?
     *
     * @access protected
     * @return Bool
     */
    protected static function exists_editor_style() {
        return file_exists(get_template_directory(). "/editor-style.css");
    }


    /**
     * get editor style buffer
     *
     * @access protected
     * @return String
     */
    protected static function get_editor_buffer() {
        if(!self::exists_editor_style())
            return;

        $buffer = null;
        $fp = @fopen(get_template_directory(). "/editor-style.css", "r");

        if(!$fp)
            return __("editor-style.css is not found.", UF_TEXTDOMAIN);

        flock($fp, LOCK_SH);
            while($tmp_buff = fgets($fp, 2048)) {
                $buffer .= $tmp_buff;
            }
        flock($fp, LOCK_UN);
        fclose($fp);

        return $buffer;
    }


    /**
     * put editor style buffer
     *
     * @access protected
     * @return Bool
     */
    protected static function put_editor_buffer($buffer) {
        $fp = @fopen(get_template_directory(). "/editor-style.css", "w");

        if(!$fp)
            return __("editor-style.css is not found.", UF_TEXTDOMAIN);

        $buffer = stripcslashes($buffer);
        flock($fp, LOCK_EX);
        $res = fputs($fp, $buffer);
        flock($fp, LOCK_UN);
        fclose($fp);

        return $res > 0 ? true: false;
    }
}

add_action("admin_notices", array( "UnifyFramework_Admin_EditorStyle", "notices" ));
add_action("admin_init",    array( "UnifyFramework_Admin_EditorStyle", "update_options" ));
