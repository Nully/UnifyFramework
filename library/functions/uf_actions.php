<?php
/**
 * UnifyFramework actions script
 */
/**
 * wp_head wrapped header action
 *
 * @access public
 */
function uf_head() {
    wp_head();
    do_action("uf_head");
}



/**
 * wp_footer wrapped footer actoin
 *
 * @access public
 */
function uf_footer() {
    wp_footer();
    do_action("uf_footer");
}


/**
 * activated UnifyFramework theme action
 *
 * @access public
 */
function uf_activate_theme() {
    global $pagenow;
    if(is_admin() && $pagenow == "themes.php" && isset($_GET["activated"])) {
        do_action("uf_theme_activated");
    }
}
add_action("init", "uf_activate_theme");



/**
 * display notice message
 *   failed database table creating.
 *
 * @access protected
 * @return Void
 */
function uf_notice_table_create_failed() {
?>
<div class="error fade">
    <p><strong><?php _e("Error!!", "unify_framework"); ?></strong></p>
    <p><?php _e("database creating failed. retry theme activate.", "unify_framework"); ?></p>
</div>
<?php
}



/**
 * deep escape Attribute values
 *
 * @access public
 * @param  $data   Array    reference by Array data
 * @param  $func   String   execute escape function
 * @return Bool
 */
function uf_esc_attr_deep(&$data, $func) {
    if(!is_array($data))
        $data = (array)$data;

    foreach($data as $name => $value) {
        //var_dump($name, $value);
        if(is_array($value)) {
            $data[$name] = &uf_esc_attr_deep(&$value, $func);
            continue;
        }
        $data[$name] = &call_user_func($func, &$value);
    }
    return $data;
}



