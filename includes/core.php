<?php
class UF_Core {}



/**
 * get UnifyFramework options
 *
 * @access public
 * @param  $alias   String        option field alias name
 * @param  $field   String|Null   option alias field name ($options[$alias][$field])
 * @param  $default Mix           return default value
 * @return Mix
 */
function uf_get_option($alias, $field = null, $default = array()) {
    do_action("uf_get_option");

    do_action("uf_get_option", $alias, $field, $default);
    $options = get_option("uf_theme_options", $default);

    // no have options
    if(empty($options))
        return $default;

    // no have option alias
    if(!isset($options[$alias]))
        return $default;

    // empty field name return a options in alias data
    if(empty($field))
        return $options[$alias];

    // have a field name, return single value
    if(isset($options[$alias][$field]))
        return $options[$alias][$field];

    return $default;
}



/**
 * save|update UnifyFramework theme options
 *
 * @access public
 * @param  $alias   String   option field alias name
 * @param  $data    Mix      option data
 * @return Bool
 */
function uf_update_option($alias, $data) {
    $options = get_option("uf_theme_options");

    if(empty($options))
        $options = array();

    $data = uf_deep_esc_attr($data);
    $data = uf_parse_to_bool_deep($data);
    $options[$alias] = $data;
    do_action("uf_update_option", $options);
    return update_option("uf_theme_options", $options);
}



/**
 * get UnifyFramework theme support, Custom Post Type multi options data.
 *
 * @access public
 * @param  $default  Array  not have option, return default value
 * @return Mix
 */
function uf_get_custom_post_options($default = array()) {
    $options = uf_get_option("custom_posts");
    if(empty($options))
        return $default;

    return $options;
}



/**
 * get UnifyFramework theme support, Custom Post type single option data
 *
 * @access public
 * @return Mix
 */
function uf_get_custom_post_option($id, $default = array()) {
    $options = uf_get_custom_post_options();
    do_action("uf_pre_get_custom_post_option", $id);

    if(empty($options))
        return $default;

    if(!isset($options[$id]))
        return $default;

    apply_filters("uf_pre_get_custom_post_option", $options);
    return $options[$id];
}



/**
 * save|update UnifyFramework theme support, Custom Post Type options
 *
 * @access public
 * @param  $data  Array
 * @param  $id    Int|Null
 * @return Bool
 */
function uf_update_custom_post_option($data, $id = null) {
    $options = uf_get_custom_post_options(array());
    apply_filters("uf_pre_update_custom_post_option", $options);

    if(!is_null($id) && is_numeric($id)) {
        $options[$id] = $data;
    }
    else {
        $keys = array_keys($options);
        if(empty($keys))
            $col_id = 1;
        else
            $col_id  = array_pop($keys) + 1;

        $options[$col_id] = $data;
    }

    apply_filters("uf_after_update_custom_post_option", $options);
    return uf_update_option("custom_posts", $options);
}



/**
 * delete UnifyFramework theme support, Custom Post Type option
 *
 * @access public
 * @param  $id
 * @return Bool
 */
function uf_delete_custom_post($id) {
    if(!$id)
        return false;

    $id = (int)$id;
    $options = uf_get_custom_post_options();
    if(!isset($options[$id]))
        return false;

    unset($options[$id]);
    uf_update_option("custom_posts", $options);
    return true;
}



/**
 * get registerd UnifyFramework theme support, CustomTaxonomy
 *
 * @access public
 * @param  $id     Int   fetch target position number.
 * @preturn Array
 */
function uf_get_custom_tax($id) {
    $options = uf_get_option("custom_taxonomy", $id);
    return apply_filters("uf_get_custom_tax", $options);
}



/**
 * get registerd UnifyFramework theme support, CustomTaxonomies.
 *
 * @access public
 * @return Array
 */
function uf_get_custom_taxes() {
    $options = uf_get_option("custom_taxonomy");
    return apply_filters("uf_get_custom_taxes", $options);
}



/**
 * save|update UnifyFramework theme support, CustomTaxonomy.
 *
 * @access public
 * @param  $option     Array     save option data array
 * @param  $id         Int|Null  save position number.
 * @return Bool
 */
function uf_update_custom_tax($option, $id = null) {
    $options = uf_get_option("custom_taxonomy");
    if(empty($options))
        $options = array();

    $id = (int)$id;
    if($id <= 0) {
        $keys = array_keys($options);
        $col_id = (empty($keys) ? 1: array_pop($keys) + 1);
        $options[$col_id] = $option;
    }
    else {
        $options[$id] = $option;
    }

    $options = apply_filters("uf_update_custom_tax", $options);
    uf_update_option("custom_taxonomy", $options);
    return true;
}



/**
 * delete UnifyFramework theme support, CustomTaxonomy
 *
 * @access public
 * @param  $id     Int   delete target col ID
 * @return Bool
 */
function uf_delete_custom_tax($id) {
    $options = uf_get_option("custom_taxonomy");

    if(empty($options))
        return true;

    if(!isset($options[$id]))
        return false;

    unset($options[$id]);

    return uf_update_option("custom_taxonomy", $options);
}



/**
 * string number to boolean cast
 *
 * @access public
 * @param  $var   Number
 * @return Bool
 */
function uf_parse_to_bool($var) {
    if(!is_numeric($var))
        return $var;

    if($var == 0)
        return false;
    elseif($var == 1)
        return true;
    else
        return $var;
}



/**
 * deep cast String to Boolean
 *
 * @access public
 * @param  $vars    Array
 * @return Array
 */
function uf_parse_to_bool_deep($vars) {
    if(!is_array($vars))
        $vars = (array)$vars;

    foreach($vars as $name => $var) {
        if(is_array($var))
            $vars[$name] = uf_parse_to_bool_deep($var);

        if(is_numeric($var))
            $vars[$name] = uf_parse_to_bool($var);
    }
    return $vars;
}



/**
 * HTML attribute deep escape
 *
 * @access public
 * @param  $vars   Array
 * @return Array
 */
function uf_deep_esc_attr($vars) {
    if(!is_array($vars))
        $vars = (array)$vars;

    foreach($vars as $name => $var) {
        if(is_array($var)) {
            $vars[$name] = uf_deep_esc_attr($var);
        }
        elseif(!is_bool($var)) {
            $vars[$name] = esc_attr($var);
        }
    }

    return $vars;
}


