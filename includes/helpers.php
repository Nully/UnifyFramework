<?php
/**
 * UnifyFramework Helper scripts
 * 
 */
/**
 * render input element
 *
 * @access public
 * @param  $type   String   input type name
 * @param  $value  Mix      default value
 * @param  $attr   Array    HTMLAttributes
 * @return Void
 */
function uf_form_input($type, $value = null, $attr = array(), $echo = true) {
    $defaults = array( "type" => $type, "value" => (!is_array($value) ? $value: ""), "name" => "" );
    $label = "";
    if(isset($attr["label"])) {
        $label = " ". uf_form_label($attr["label"], $attr["id"], false);
        unset($attr["label"]);
    }

    $checked = false;
    if(isset($attr["checked"]) && $attr["checked"] === true) {
        $checked = ' checked="checked"';
    }
    unset($attr["checked"]);

    $input = '<input'. _uf_parse_attr($defaults, $attr). $checked .' />'. $label. PHP_EOL;
    if($echo)
        echo $input;
    else
        return $input;
}



/**
 * render textarea element
 *
 * @access public
 * @param  $value  Mix      default value
 * @param  $attr   Array    HTMLAttributes
 * @return Void
 */
function uf_form_textarea($value, $attr = array(), $echo = true) {
    $defaults = array( "cols" => 30, "rows" => 10, "name" => "" );
    $args = wp_parse_args($attr, $defaults);

    if(isset($args["label"])) {
        $label = " ". uf_form_label($args["label"], $args["id"], false);
        unset($args["label"]);
    }
    $area = '<textarea'. _uf_parse_attr($args). '>';
    if($value)
        $area .= $value;

    $area .= "</textarea>";

    if($echo)
        echo $area;
    else
        return $area;
}



/**
 * render checkbox element
 *
 * @access public
 * @param  $value    String
 */
function uf_form_checkbox($value = null, $attr = array(), $echo = true) {
    $defaults = array("type" => "checkbox", "checked" => false, "name" => "", "value" => ( !is_array($value) ? $value: "" ), "show_hidden" => true);
    $label = "";
    if(isset($attr["label"])) {
        $label = " ". uf_form_label($attr["label"], $attr["id"], false);
        unset($attr["label"]);
    }

    $args = wp_parse_args($attr, $defaults);
    if(isset($args["checked"]) && $args["checked"] === true) {
        $args["checked"] = "checked";
    }
    else {
        unset($args["checked"]);
    }

    if(isset($args["show_hidden"]) && $args["show_hidden"] == true) {
        uf_form_input("hidden", 0, array( "name" => $args["name"] ));
        unset($args["show_hidden"]);
    }

    $input = '<input'. _uf_parse_attr($args).' />'. $label. PHP_EOL;

    if($echo)
        echo $input;
    else
        return $input;
}



/**
 * render select element
 *
 * @access public
 * @param  $options   Array
 * @param  $attr      Array
 * @param  $multiple  Bool
 */
function uf_form_select($options, $attr = array(), $multiple = false, $echo = true) {
    $defaults = array( "value" => "", "name" => "" );
    $args = wp_parse_args($attr, $defaults);
    if(isset($args["value"])) {
        $selected = $args["value"];
        unset($args["value"]);
    }

    $label = "";
    if(isset($args["label"])) {
        $label = uf_form_label($args["label"], $args["id"], false);
        unset($args["label"]);
    }

    if(!is_array($options))
        $options = (array)$options;

    $select = '<select'. _uf_parse_attr($args).'>'. PHP_EOL;
        foreach($options as $value => $opt_label) {
            $select .= '<option value="'. esc_attr($value) .'"'. (($selected == $value) ? ' selected="selected"': "") .'>'. esc_attr($opt_label) .'</option>'. PHP_EOL;
        }
    $select .= "</select>". $label. PHP_EOL;

    if($echo)
        echo $select;
    else
        return $select;
}



/**
 * render HTML form label node.
 *
 * @access public
 * @param  $label   String   label text value
 * @param  $for     String   label for id string
 * @param  $echo    Bool     display label node ?
 * @return String|Void
 */
function uf_form_label($label, $for = null, $echo = true) {
    $label = sprintf('<label%2$s>%1$s</label>', $label, (!empty($for) ? _uf_parse_attr(array("for" => $for)) : ""));

    if($echo)
        echo $label;
    else
        return $label;
}



/**
 * parse HTML attributes
 *
 * @access private
 * @param  $defaults Array    default HTMLAttributes array
 * @param  $attr     Array    HTMLAttributes array
 * @return String
 */
function _uf_parse_attr($defaults, $attr = array()) {
    $args = wp_parse_args($attr, $defaults);

    $attribute = "";
    foreach($args as $name => $value) {
        if($name == "value")
            $value = esc_attr($value);

        $attribute .= ' '. $name. '="'. $value .'"';
    }
    return $attribute;
}

