<?php
class UnifyFramework_Widget_SimpleQueryPosts extends UnifyFramework_Widget_WidgetBase {
    const MAX_SHOW_POSTS = 30;
    const POSITION_APPEND  = "append";
    const POSITION_PREPEND = "prepend";

    const ORDERBY_ID = "id";
    const ORDERBY_MENUORDER = "menuorder";
    const ORDERBY_ID_MENUORDER = "id_menuorder";

    /**
     * Default options
     *
     * @access protected
     * @var    Array
     */
    protected $defaults = array(
        "title"      => "Simple QueryPosts",
        "category"   => array(),
        "order"      => "DESC",
        "show_posts" => 15,
        "date_position" => self::POSITION_APPEND,
        "date_format" => "Y/m/j (D)",
        "orderby"     => self::ORDERBY_ID_MENUORDER,
    );


    public function __construct() {
        parent::__construct(false, "Simple Query Posts widget", array(
            "description" => __("Support your Coding.")
        ));
    }


    public function widget($args, $instance) {
        $args = (object)$args;
        $instance = (object)wp_parse_args($instance, $this->defaults);

        echo $args->before_widget, $args->before_title, $instance->title, $args->after_title;
        $r = array(
            'numberposts' => 5,
            'category' => 0,
            'orderby' => 'post_date',
            'order' => 'DESC',
            /*'include' => array(),
            'exclude' => array(),*/
            'post_type' => 'post',
        );

        if($instance->category) {
            $cat = (array)$instance->category;
            $r["category"] = implode(",", $art);
        }

        $r["numberposts"] = (int)$instance->show_posts;
        $r["order"] = $instance->order;
        switch($instance->orderby) {
            case self::ORDERBY_ID:
                $r["orderby"] = "ID";
                break;
            case self::ORDERBY_MENUORDER:
                $r["orderby"] = "menu_order";
                break;
            case self::ORDERBY_ID_MENUORDER:
            default:
                $r["orderby"] = "ID,menu_order";
                break;
        }
        $r["orderby"] = $instance->orderby;

        // display template tag
        $tpl = '<dt>%2$s</dt><dd>%1$s</dd>';
        if($instance->date_position == self::POSITION_PREPEND)
            $tpl = '<dt>%1$s</dt><dd>%2$s</dd>';

        $posts = get_posts($r);

?>
<dl>
    <?php foreach($posts as $post): ?>
    <?php printf($tpl, mysql2date($instance->date_format, $post->post_date), sprintf(
        __('<a href="%1$s" title="%2$s">%2$s</a>', UF_TEXTDOMAIN), get_permalink($post->ID), get_the_title($post->ID)
    )); ?>
    <?php endforeach; ?>
</dl>
<?php

        echo $args->after_widget;
    }


    public function update($new_instance, $old_instance) {
        foreach($new_instance as $name => $ins) {
            if(is_array($ins))
                $ins = array_filter("esc_attr", $ins);
            else
                $ins = esc_attr($ins);

            $new_instance[$name] = $ins;
        }

        return $new_instance;
    }


    public function form($instance) {
        $instance = (object)wp_parse_args($instance, $this->defaults);
        $categories = get_categories("orderby=ID&order=ASC");
?>
<p>
<label for="<?php echo $this->get_field_id("title"); ?>"><?php _e("Title", UF_TEXTDOMAIN); ?></label><br />
<input class="widefat" type="text" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" value="<?php echo esc_attr($instance->title); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id("categories"); ?>"><?php _e("Category", UF_TEXTDOMAIN); ?></label><br />
<span style="display: block; overflow: auto; height: 100%; max-height: 90px; border: 1px solid #CCC; padding: 2px 3px;">
<?php foreach($categories as $cat): ?>
<input type="checkbox" name="<?php echo $this->get_field_name("category[]"); ?>" value="<?php echo $cat->term_id; ?>">&nbsp;<?php echo esc_attr($cat->cat_name); ?>
<?php endforeach; ?>
</span>
<small><?php _e("do not choise category, display All posts.", UF_TEXTDOMAIN); ?></small>
</p>

<p>
<label for="<?php echo $this->get_field_id("order"); ?>"><?php _e("Order", UF_TEXTDOMAIN); ?></label><br />
<select id="<?php echo $this->get_field_id("order"); ?>" name="<?php echo $this->get_field_name("order"); ?>">
<option value="ASC"<?php echo $instance->order == "ASC" ? ' selected="selected"': ""; ?>><?php _e("ASC", UF_TEXTDOMAIN); ?></option>
<option value="DESC"<?php echo $instance->order == "DESC" ? ' selected="selected"': ""; ?>><?php _e("DESC", UF_TEXTDOMAIN); ?></option>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id("show_posts"); ?>"><?php _e("Dsiplay count", UF_TEXTDOMAIN); ?></label><br />
<select id="<?php echo $this->get_field_id("show_posts"); ?>" name="<?php echo $this->get_field_name("show_posts"); ?>">
<?php for($i = 1; $i <= self::MAX_SHOW_POSTS; $i ++): ?>
<option value="<?php echo $i; ?>"<?php echo ($instance->show_posts == $i) ? 'selected="selected"': ''; ?>><?php echo $i; ?></option>
<?php endfor; ?>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id("date_format"); ?>"><?php _e("Date format", UF_TEXTDOMAIN); ?></label><br />
<input class="widefat" type="text" id="<?php echo $this->get_field_id("date_format"); ?>" name="<?php echo $this->get_field_id("date_format"); ?>" value="<?php echo esc_attr($instance->date_format); ?>" /><br >
<small><?php _e(sprintf('supported date function, to %s.', '<a href="http://jp2.php.net/manual/function.date.php">PHP Doc</a>')); ?></small>
</p>

<p>
<label for="<?php echo $this->get_field_id("date_position"); ?>"><?php _e("Date position", UF_TEXTDOMAIN); ?></label><br />
<input type="radio" id="<?php echo $this->get_field_id("date_position_append"); ?>" name="<?php echo $this->get_field_name("date_position"); ?>" value="<?php echo self::POSITION_APPEND ?>"<?php echo ($instance->date_position == self::POSITION_APPEND ?  ' checked="checked"': ""); ?> />&nbsp;<label for="<?php echo $this->get_field_id("date_position_append") ?>"><?php _e("Append title", UF_TEXTDOMAIN); ?></label><br />
<input type="radio" id="<?php echo $this->get_field_id("date_position_prepend"); ?>" name="<?php echo $this->get_field_name("date_position"); ?>" value="<?php echo self::POSITION_PREPEND ?>"<?php echo ($instance->date_position == self::POSITION_PREPEND ?  ' checked="checked"': ""); ?> />&nbsp;<label for="<?php echo $this->get_field_id("date_position_prepend"); ?>"><?php _e("Prepend title", UF_TEXTDOMAIN); ?></label>
</p>

<p>
<label for="<?php echo $this->get_field_id("orderby"); ?>"><?php _e("Order by", UF_TEXTDOMAIN); ?></label><br />
<input type="radio" id="<?php echo $this->get_field_id("orderby_id"); ?>" name="<?php echo $this->get_field_name("orderby"); ?>" value="<?php echo self::ORDERBY_ID ?>"<?php echo ($instance->orderby == self::ORDERBY_ID ? ' checked="checked"': ""); ?> />&nbsp;<label for="<?php echo $this->get_field_id("orderby_id"); ?>"><?php _e("Order By ID", UF_TEXTDOMAIN); ?></label><br />
<input type="radio" id="<?php echo $this->get_field_id("orderby_menuorder"); ?>" name="<?php echo $this->get_field_name("orderby"); ?>" value="<?php echo self::ORDERBY_MENUORDER; ?>"<?php echo ($instance->orderby == self::ORDERBY_MENUORDER ? ' checked="checked"': ""); ?> />&nbsp;<label for="<?php echo $this->get_field_id("orderby_menuorder"); ?>"><?php _e("Order By MenuID", UF_TEXTDOMAIN); ?></label><br />
<input type="radio" id="<?php echo $this->get_field_id("orderby_id_menuorder"); ?>" name="<?php echo $this->get_field_name("orderby"); ?>" value="<?php echo self::ORDERBY_ID_MENUORDER; ?>"<?php echo ($instance->orderby == self::ORDERBY_ID_MENUORDER ? ' checked="checked"': ""); ?> />&nbsp;<label for="<?php echo $this->get_field_id("orderby_id_menuorder"); ?>"><?php _e("Order By ID, MenuOrder", UF_TEXTDOMAIN); ?></label><br />
</p>
<?php
    }
}


