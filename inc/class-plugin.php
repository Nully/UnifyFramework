<?php
/**
 * class-plugin.php
 */
class UF_Plugin
{
    public function __construct()
    {
        if(is_admin()) {
            wp_enqueue_style("dashboard");
            wp_enqueue_style("postbox");
            wp_enqueue_style("thickbox");
            wp_enqueue_script("dashboard");
            wp_enqueue_script("postbox");
            wp_enqueue_script("thickbox");
        }
    }


    /**
     * Override init action hook point
     */
    public function init()
    {
    }


    /**
     * Override admin_init action hook point
     */
    public function admin_init()
    {
    }


    /**
     * Override admin_menu action hook point
     */
    public function admin_menu()
    {
    }


    /**
     * render postbox
     *
     * @access public
     * @param  $title    String   metabox title
     * @param  $html     String   metabox render layout
     * @param  $desc     String   metabox description
     */
    public function render_postbox($title, $html, $desc = null)
    {
?>
<div class="postbox">
<div class="handlediv"><br /></div>
<h3 class="hndle"><?php echo esc_attr($title); ?></h3>
<div class="inside">
<?php echo $html; ?>
<?php if(!empty($desc)): ?>

<br /><small><em><?php echo $desc; ?></em></small>
<?php endif; ?>
</div>
</div>
<?php
    }


    /**
     * render metabox layout textbox
     */
    public function render_text_fields($title, $options, $name = null)
    {
        $html = "";
        $options = (array)$options;
        foreach($options as $opt) {
            $desc = "";
            if(!empty($opt["description"])) {
                $desc = '<small><em>'. $opt["description"] .'</em></small>';
            }

            $id = $opt["name"];
            if(isset($opt["name"]) && !empty($name)) {
                $id = $name. "_". $opt["name"];
                $opt["name"] = $name."[". $opt["name"] ."]";
            }

            $html .= sprintf(
                '<p><label for="%3$s">%1$s</label><br />'.
                '<input type="text" name="%2$s" value="%4$s" id="%3$s" class="widefat" />'.
                '%5$s'.
                '</p>'. "\n",
                $opt["label"], $opt["name"], $id, esc_attr($opt["var"]),
                $desc
            );

        }

        $this->render_postbox($title, $html);
    }


    /**
     * render metabox layout checkbox
     *
     * @access public
     */
    public function render_checkbox_fields($title, $options, $name, $checked = array(), $description = null)
    {
        $html = "";
        $options = (array)$options;
        $checked = (array)$checked;

        $html .= '<input type="hidden" name="'. $name .'" value="" />'. "\n";
        foreach($options as $var) {
            $html .= sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" id="%1$s_%2$s"%4$s /> %3$s'."\n",
                $name, $var["var"], $var["label"],
                (in_array($var["var"], $checked) ? ' checked="checked"': "")
            );
        }

        $this->render_postbox($title, $html, $description);
    }


    /**
     * render metabox layout radio box.
     *
     * @access public
     * @param  $title    Stinrg   postbox title
     * @param  $options  Array    radio options
     * @param  $name     String   element name attribute
     * @param  $selected Mix      element selected attribute
     * @param  $desc     String   postbox description
     */
    public function render_radio_fields($title, $options, $name, $selected = null, $desc = null) {
        $html = "";
        $options = (array)$options;
        foreach($options as $opt) {
            $html .= sprintf(
                ' <input type="radio" name="%1$s" value="%2$s" id="%1$s_%2$s"%4$s /> %3$s'. "\n",
                $name, $opt["var"], $opt["label"],
                ($selected == $opt["var"] ? ' checked="checked"': "")
            );
        }

        $this->render_postbox($title, $html, $desc);
    }



    /**
     * render metabox layout select box
     *
     *
     */
    public function render_select_fields($title, $options, $name, $selected = null, $description = null)
    {
        $html = "";
        $options = (array)$options;

        $html .= sprintf(
            '<select id="%1$s" name="%1$s">'. "\n", $name
        );
        foreach($options as $option) {
            $html .= sprintf(
                '<option value="%1$s"%3$s>%2$s</option>',
                $option["var"], $option["label"],
                ($selected == $option["var"] ? ' selected="selected"': "")

            );
        }
        $html .= "</select>\n";

        $this->render_postbox($title, $html, $description);
    }
}


