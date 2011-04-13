<?php
class UnifyFramework_Widget_PostThumbnail extends UnifyFramework_Widget_WidgetBase {
    const MAX_SHOW_COUNT = 30;
    const NO_IMAGE_URL = "%theme_url%/img/no-image.gif";
    const DOT_BOX = "dot_box";
    const DOTS    = "dots";
    const ORDERBY_ID = "orderby_id";
    const ORDERBY_MENU_ORDER = "orderby_menu_order";
    const ORDERBY_ID_MENU_ORDER = "orderby_id_menu_order";
    const ORDER_ASC = "ASC";
    const ORDER_DESC = "DESC";


    protected $defaults = array(
        "title"             => "Post thumbnail posts",
        "use_tag"           => "h3",
        "show_count"        => 5,
        "show_tags"         => "false",
        "show_cats"         => "true",
        "show_categories"   => array(),
        "label_cat"         => 'Category',
        "label_tag"         => 'Tags',
        "label_sep"         => 'space',
        "trim_width"        => 140,
        "trim_mark"         => self::DOT_BOX,
        "orderby"           => self::ORDERBY_ID_MENU_ORDER,
        "order"             => self::ORDER_ASC,
        "no_image_url"      => self::NO_IMAGE_URL
    );


    protected $allowd_tags = array(
        "h2" => "h2",
        "h3" => "h3",
        "h4" => "h4",
        "h5" => "h5",
        "h6" => "h6",
        "p"  => "p",
    );


    protected $allowd_separators = array(
        "space" => "&nbsp;",
        "colon" => ':',
    );


    protected $allowd_trim_mark = array(
        self::DOT_BOX => "[...]",
        self::DOTS    => "...",
    );

    protected $allowd_order_by = array(
        self::ORDERBY_ID => "Order by post id",
        self::ORDERBY_MENU_ORDER => 'Order by post menu order',
        self::ORDERBY_ID_MENU_ORDER => 'Oder by post id, and menu order',
    );


    protected $allow_orders = array(
        self::ORDER_ASC  => "Order by ASC",
        self::ORDER_DESC => 'Order by DESC'
    );


    public function __construct() {
        parent::__construct(false, "Post Thumbnail posts query", array(
            "description" => "shown has post thumbnail posts."
        ));
    }


    public function widget($args, $instance) {
        $args = (object)$args;
        $instance = (object)wp_parse_args($instance, $this->defaults);
        $title_tpl = '<%1$s class="uf-widget-post-thumbnail-title"><a href="%2$s">%3$s</a></%1$s>';

        switch($instance->orderby) {
            case self::ORDERBY_ID:
                $orderby = "ID";
                break;
            case self::ORDERBY_MENU_ORDER:
                $orderby = "menu_order";
                break;
            default:
                $orderby = "ID, menu_order";
                break;
        }

        $params = array(
            "numberposts"   => $instance->show_count,
            "order"         => $instance->order,
            "orderby"       => $orderby
        );

        if(!is_array($instance->show_categories))
            $instance->show_categories = array();

        if(!empty($instance->show_categories)) {
            $params["category"] = join(",", $instance->show_categories);
        }

        $posts = get_posts($params);

        echo $args->before_widget, $args->before_title, esc_attr($instance->title), $args->after_title;
?>
<?php if(empty($posts)): ?>
<p><?php _e("Posts not found", UF_TEXTDOMAIN); ?></p>
<?php else: ?>
<?php foreach($posts as $post): ?>
<div class="uf-widget-post-thumbnail-container">
<?php printf($title_tpl, $instance->use_tag, get_permalink($post->ID), get_the_title($post->ID)); ?>
<div class="uf-widget-post-thumbnail-image-container">
<?php if(has_post_thumbnail($post->ID)): ?>
<?php get_the_post_thumbnail($post->ID, "post-thumbnail", array( "class" => "uf-widget-post-thumbnail-image" )); ?>
<?php else: ?>
<img src="<?php echo str_replace("%theme_url%", get_template_directory_uri(), $instance->no_image_url); ?>" alt="<?php echo get_the_title($post->ID); ?>" />
<?php endif; ?>
<!-- End uf post thumbnail image container --></div>
<div class="uf-widget-post-thumbnail-content"><?php echo $this->trim_contnet($post->post_content, $instance->trim_width, $instance->trim_mark); ?></div>

<?php if($instance->show_cats): ?>
<div class="uf-widget-post-thumbnail-cats">
<?php _e(esc_attr($instance->label_cat, UF_TEXTDOMAIN)); ?><?php echo $this->allowd_separators[$instance->label_sep] ?>
<span class="uf-widget-post-thumbnail-categories"><?php the_category(",", false, $post->ID); ?></span>
</div>
<?php endif; ?>

<?php if($instance->show_tags == true): ?>
<div class="uf-widget-post-thumbnail-tags">
<?php echo get_the_term_list($post->ID, "post_tag", sprintf(
    '%1$s %2$s<span class="uf-widget-post-thumbnail-tags">',
    esc_attr(__($instance->label_tag, UF_TEXTDOMAIN)), $this->allowd_separators[$instance->label_sep] ), ',', '</span>'); ?>
</div>
<?php endif; ?>
<!-- End uf widget post thumbnail container --></div>
<?php endforeach; ?>
<?php endif; ?>
<?php
        echo $instance->after_widget;
    }


    public function update($new_instance, $old_instance) {
        foreach($new_instance as $field => $instance) {
            if(is_array($instance))
                $new_instance[$field] = array_filter($instance, "esc_attr");
            else {
                if($instance === 'true')
                    $instance = true;

                if($instance === 'false')
                    $instance = false;

                $new_instance[$field] = $instance;
            }
        }

        if(!is_array($new_instance["show_categories"]))
            $new_instance["show_categories"] = array();

        if(empty($new_instance["no_image_url"]))
            $new_instance["no_image_url"] = self::NO_IMAGE_URL;

        return $new_instance;
    }


    public function form($instance) {
        if(!function_exists("has_post_thumbnail")) {
?>
<p><?php _e("Disabled PostThumbnails module. do enable PostThumbnails.", UF_TEXTDOMAIN); ?></p>
<?php
            return;
        }

        $instance = (object)wp_parse_args($instance, $this->defaults);
?>
<p>
<label for="<?php echo $this->get_field_id("title"); ?>"><?php _e("Title", UF_TEXTDOMAIN); ?></label><br />
<input type="text" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" value="<?php echo esc_attr($instance->title); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id("use_tag"); ?>"><?php _e("Title tag", UF_TEXTDOMAIN); ?></label><br />
<select id="<?php echo $this->get_field_id("use_tag"); ?>" name="<?php echo $this->get_field_name("use_tag"); ?>">
<?php foreach($this->allowd_tags as $key => $tag): ?>
<option value="<?php echo $key; ?>"<?php echo ($instance->use_tag == $key ? ' selected="selected"' : ""); ?>><?php echo $tag; ?></option>
<?php endforeach; ?>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id("show_count"); ?>"><?php _e("Show count", UF_TEXTDOMAIN); ?></label><br />
<select id="<?php echo $this->get_field_id("show_count"); ?>" name="<?php echo $this->get_field_name("show_count"); ?>">
<?php for($i = 1; $i <= self::MAX_SHOW_COUNT; $i ++): ?>
<option value="<?php echo $i; ?>"<?php echo ($instance->show_count == $i ? ' selected="selected"':""); ?>><?php echo $i; ?></option>
<?php endfor; ?>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id("show_cats") ?>"><?php _e("Show post categories", UF_TEXTDOMAIN); ?></label><br />
<input type="radio" id="<?php echo $this->get_field_id("show_cats"); ?>" name="<?php echo $this->get_field_name("show_cats"); ?>" value="true"<?php echo ($instance->show_cats == true ? ' checked="checked"': ""); ?> />
<label for="<?php echo $this->get_field_id("show_cats"); ?>"><?php _e("Show categories", UF_TEXTDOMAIN); ?></label><br />
<input type="radio" id="<?php echo $this->get_field_id("hide_cats"); ?>" name="<?php echo $this->get_field_name("show_cats"); ?>" value="false"<?php echo ($instance->show_cats == false ? ' checked="checked"': ""); ?> />
<label for="<?php echo $this->get_field_id("hide_cats"); ?>"><?php _e("Hide categories", UF_TEXTDOMAIN); ?></label>
</p>

<p>
<label for="<?php echo $this->get_field_id("show_tags") ?>"><?php _e("Show post tags", UF_TEXTDOMAIN); ?></label><br />
<input type="radio" id="<?php echo $this->get_field_id("show_tags"); ?>" name="<?php echo $this->get_field_name("show_tags"); ?>" value="true"<?php echo ($instance->show_tags == true ? ' checked="checked"': ""); ?> />
<label for="<?php echo $this->get_field_id("show_tags"); ?>"><?php _e("Show tags", UF_TEXTDOMAIN); ?></label><br />
<input type="radio" id="<?php echo $this->get_field_id("hide_tags"); ?>" name="<?php echo $this->get_field_name("show_tags"); ?>" value="false"<?php echo ($instance->show_tags == false ? ' checked="checked"': ""); ?> />
<label for="<?php echo $this->get_field_id("hide_tags"); ?>"><?php _e("Hide tags", UF_TEXTDOMAIN); ?></label>
</p>

<p>
<label for="<?php echo $this->get_field_id("show_categories"); ?>"><?php _e("Show categories", UF_TEXTDOMAIN); ?></label><br />
<span style="display: block; overflow: auto; height: 100%; min-height: 120px; padding: 2px 3px; border: 1px solid #CECECE;">
<?php foreach(get_categories("hide_empty=0") as $cat): ?>
<input type="checkbox" id="<?php echo $this->get_field_id("category_{$cat->term_id}"); ?>" name="<?php echo $this->get_field_name("show_categories]["); ?>" value="<?php echo esc_attr($cat->term_id); ?>"<?php echo (in_array($cat->term_id, $instance->show_categories) ? ' checked="checked"': ""); ?> />
<label for="<?php echo $this->get_field_id("category_{$cat->term_id}") ?>"><?php echo esc_attr($cat->name); ?></label><br />
<?php endforeach; ?>
</span>
<small><?php _e("No check category, fetch all posts.", UF_TEXTDOMAIN); ?></small>
</p>

<p>
<label for="<?php echo $this->get_field_id("label_cat"); ?>"><?php _e("Category label", UF_TEXTDOMAIN); ?></label><br />
<input type="text" id="<?php echo $this->get_field_id("label_cat"); ?>" name="<?php echo $this->get_field_name("label_cat"); ?>" value="<?php echo esc_attr($instance->label_cat); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id("label_tag"); ?>"><?php _e("Tag label", UF_TEXTDOMAIN); ?></label><br />
<input type="text" id="<?php echo $this->get_field_id("label_tag"); ?>" name="<?php echo $this->get_field_name("label_tag"); ?>" value="<?php echo esc_attr($instance->label_tag); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id("label_sep") ?>"><?php _e("Label separator", UF_TEXTDOMAIN); ?></label><br />
<select id="<?php echo $this->get_field_id("label_sep"); ?>" name="<?php echo $this->get_field_name("label_sep"); ?>">
<?php foreach($this->allowd_separators as $label => $sep): ?>
<option value="<?php echo esc_attr($label); ?>"<?php echo ($instance->label_sep == $label ? ' selected="selected"': ""); ?>><?php echo esc_attr($label); ?></option>
<?php endforeach; ?>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id("trim_width"); ?>"><?php _e("Trim width", UF_TEXTDOMAIN); ?></label><br />
<input type="text" id="<?php echo $this->get_field_id("trim_width"); ?>" name="<?php echo $this->get_field_name("trim_width"); ?>" value="<?php echo esc_attr($instance->trim_width); ?>" class="widefat" />
</p>

<p>
<label for="<?php echo $this->get_field_id("trim_mark"); ?>"><?php _e("Content trim mark", UF_TEXTDOMAIN); ?></label><br />
<select id="<?php echo $this->get_field_id("trim_mark"); ?>" name="<?php echo $this->get_field_name("trim_mark"); ?>">
<?php foreach($this->allowd_trim_mark as $key => $mark): ?>
<option value="<?php echo esc_attr($key); ?>"<?php echo ($instance->trim_mark == $key ? ' selected="selected"': ""); ?>><?php echo esc_attr($mark); ?></option>
<?php endforeach; ?>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id("orderby"); ?>"><?php _e("Order by", UF_TEXTDOMAIN); ?></label><br />
<select id="<?php echo $this->get_field_id("orderby"); ?>" name="<?php echo $this->get_field_name("orderby"); ?>" class="widefat">
<?php foreach($this->allowd_order_by as $key => $label): ?>
<option value="<?php echo esc_attr($key); ?>"<?php echo ($instance->orderby == $key ? ' selected="selected"': ""); ?>><?php echo esc_attr($label); ?></option>
<?php endforeach; ?>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id("order"); ?>"><?php _e("Sort by", UF_TEXTDOMAIN); ?></label><br />
<select id="<?php echo $this->get_field_id("order"); ?>" name="<?php echo $this->get_field_name("order"); ?>" class="widefat">
<?php foreach($this->allow_orders as $key => $order): ?>
<option value="<?php echo esc_attr($key); ?>"<?php echo ($instance->order == $key ? ' selected="selected"': ""); ?>><?php echo esc_attr($order); ?></option>
<?php endforeach; ?>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id("no_image_url"); ?>"><?php _e("No image url", UF_TEXTDOMAIN); ?></label><br />
<input type="text" id="<?php echo $this->get_field_id("no_image_url"); ?>" name="<?php echo $this->get_field_name("no_image_url"); ?>" value="<?php echo esc_attr($instance->no_image_url); ?>" class="widefat" /><br />
<small><?php _e("%theme_url% is replace theme root URI", UF_TEXTDOMAIN); ?></small>
</p>
<?php
    }


    protected function trim_contnet($content, $width, $mark) {
        $trim_mark = $this->allowd_trim_mark[$mark];
        $charset = get_option("blog_charset", "UTF-8");
        $content = mb_strimwidth($content, 0, $width, " ". $trim_mark, get_option("blog_charset"));
        return apply_filters("wp_trim_excerpt", $content);
    }
}