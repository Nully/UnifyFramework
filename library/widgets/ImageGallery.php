<?php
class UnifyFramework_Widget_ImageGallery extends UnifyFramework_Widget_WidgetBase {
    const MAX_SHOW_COUNT = 20;
    const SHOW_TITLE = "show_title";
    const HIDE_TITLE = "hide_title";
    const POS_AFTER  = "pos_after";
    const POS_BEFORE = "pos_before";
    const ORDER_ID   = "id";
    const ORDER_MENU_ORDER    = "menu_order";
    const ORDER_ID_MENU_ORDER = "id_menu_order";


    protected $defaults = array(
        "title"      => "Simple Gallery Image",
        "show_count" => 8,
        "show_title" => self::SHOW_TITLE,
        "title_pos"  => self::POS_AFTER,
        "order"      => "DESC",
        "orderby"    => self::ORDER_ID_MENU_ORDER,
        "image_type" => "medium",
        "anim_speed" => 600,
        "interval"   => 2000,
    );


    /**
     * jQuery Plugin jQuery cycle Pugin effects
     *
     * @access protected
     * @var    Array
     */
    protected $slide_effects = array(
        "blindX", "blindY", "blindZ",
        "cover", "curtainX", "curtainY",
        "fade", "fadeZoom",
        "growX", "growY",
        "scrollUp", "scrollDown", "scrollLeft",
        "scrollRight", "scrollHorz", "scrollVert",
        "shuffle", "slideX", "slideY", "toss",
        "turnUp", "turnDown", "turnLeft", "turnRight",
        "uncover", "wipe", "zoom",
    );


    public function __construct() {
        parent::__construct(false, "UF ImageGallery", array(
            "desciprition" => __("view in simply image gallery.", UF_TEXTDOMAIN)
        ));
    }


    public function  widget($args, $instance) {
        $args = (object)$args;
        $instance = (object) wp_parse_args($instance, $this->defaults);

        switch($instance->order) {
            case self::ORDER_ID_MENU_ORDER:
                $order = "ID,menu_order";
                break;
            case self::ORDER_MENU_ORDER:
                $order = "menu_order";
                break;
            case self::ORDER_ID:
            default:
                $order = "ID";
                break;
        }

        $r = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'orderby'        => $order,
            'order'          => $instance->orderby,
            'numberposts'    => $instance->show_count,
        );

        $images = get_posts($r);

        echo $args->before_widget, $args->before_title, $instance->title, $args->after_title;
?>

<?php if(count($images) > 0): ?>
<?php foreach($images as $key => $image): ?>
<?php echo wp_get_attachment_image($image->ID, $instance->image_type); ?>
<?php endforeach; ?>
<?php else: ?>
<p><?php _e("Image Not found.", UF_TEXTDOMAIN); ?></p>
<?php endif; ?>

<?php

        echo $args->after_widget;
    }


    public function update($new_instance, $old_instance) {
        $new_instance = array_filter("esc_attr", $new_instance);

        if((int)$new_instance["anim_time"] < 50)
            $new_instance["anim_time"] = 50;

        if((int)$new_instance["interval"] < 50)
            $new_instance["interval"] = 50;

        return $new_instance;
    }


    public function form($instance) {
        $instance = (object)wp_parse_args($instance, $this->defaults);
        $image_types = $this->_get_image_types();
?>
<p>
<label for="<?php echo $this->get_field_id("title"); ?>"><?php _e("Title", UF_TEXTDOMAIN); ?></label><br />
<input class="widefat" type="text" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_id("title"); ?>" value="<?php echo esc_attr($instance->title); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id("show_count"); ?>"><?php _e("Show count", UF_TEXTDOMAIN); ?></label><br />
<select id="<?php echo $this->get_field_id("show_count"); ?>" name="<?php echo $this->get_field_name("show_count"); ?>">
<?php for($i = 1; $i < self::MAX_SHOW_COUNT; $i ++): ?>
<option value="<?php echo $i; ?>"<?php echo ($instance->show_count == $i) ? ' selected="selected"': ""; ?>><?php echo $i; ?></option>
<?php endfor; ?>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id("image_type"); ?>"><?php _e("Image type", UF_TEXTDOMAIN); ?></label><br />
<select id="<?php echo $this->get_field_id("image_type"); ?>" name="<?php echo $this->get_field_name("image_type"); ?>" class="widefat">
<?php foreach($image_types as $label => $type): ?>
<option value="<?php echo $label; ?>"<?php echo ($instance->image_type == $label ? ' selected="selected"': ""); ?>><?php echo esc_attr__($label, UF_TEXTDOMAIN); ?> (<?php echo $type["width"]; ?>x<?php echo $type["height"]; ?>)</option>
<?php endforeach; ?>
</select>
</p>


<p>
<label for="<?php echo $this->get_field_id("effect"); ?>"><?php _e("Image Effect", UF_TEXTDOMAIN); ?></label><br />
<select class="widefat" id="<?php echo $this->get_field_id("effetct"); ?>" name="<?php echo $this->get_field_name("effetct"); ?>">
<?php foreach($this->slide_effects as $eff): ?>
<option value="<?php echo $eff; ?>"><?php echo $eff; ?></option>
<?php endforeach; ?>
</select><br />
<small><?php _e(sprintf("Effect type detail is show %s", '<a href="http://www.malsup.com/jquery/cycle/">jQuery Cycle Plugin</a>'), UF_TEXTDOMAIN); ?></small>
</p>


<p>
<label for="<?php echo $this->get_field_id("anim_speed"); ?>"><?php _e("Animation Speed", UF_TEXTDOMAIN); ?></label><br />
<input class="widefat" type="text" id="<?php echo $this->get_field_id("anim_speed"); ?>" name="<?php echo $this->get_field_id("anim_speed"); ?>" value="<?php echo esc_attr($instance->anim_speed); ?>" /><br />
<small><?php _e("Animation speed is over the <em>50ms</em>.", UF_TEXTDOMAIN); ?></small>
</p>

<p>
<label for="<?php echo $this->get_field_id("interval"); ?>"><?php _e("Interval Time", UF_TEXTDOMAIN); ?></label><br />
<input class="widefat" type="text" id="<?php echo $this->get_field_id("interval"); ?>" name="<?php echo $this->get_field_id("interval"); ?>" value="<?php echo esc_attr($instance->interval); ?>" /><br />
<small><?php _e("Interval time is over the <em>50ms</em>."); ?></small>
</p>
<?php
    }


    /**
     * registerd Image sizes
     *
     * @access private
     * @return Array
     */
    private function _get_image_types() {
        global $_wp_additional_image_sizes;

        $sizes = array(
            "thumbnail" => array( "width"  => get_option("thumbnail_size_w"), "height" => get_option("thumbnail_size_h") ),
            "medium"    => array( "width"  => get_option("medium_size_w"), "height" => get_option("medium_size_h") ),
            "large"     => array( "width"  => get_option("large_size_w"), "height" => get_option("large_size_h") ),
        );

        $add_sizes = array();
        if(isset($_wp_additional_image_sizes))
            $add_sizes = $_wp_additional_image_sizes;

        $merged = array_merge($sizes, $add_sizes);
        return $merged;
    }
}

