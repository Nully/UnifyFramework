<?php
/**
 * UnifyFramework Template scripts
 *
 */
/**
 * get partial loop template
 *
 * @access public
 * @param  $template_name   String  fetch target template name
 * @param  $sub_name        String  fetch target sub name
 * @return Bool
 */
function uf_get_template_part($template_name, $sub_name = null) {
    if(function_exists("get_template_part")) {
        get_template_part($template_name, $sub_name);
    }
    else {
        do_action("get_template_part_{$template_name}", $template_name, $sub_name);
        $templates = array();
        if(isset($sub_name))
            $templates[] = "{$template_name}-{$sub_name}.php";

        $templates = "{$template_name}.php";
        locate_template($templates);
    }
}






