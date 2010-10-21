<?php
/**
 * UnifyFramework page navigation actions
 *
 */
/**
 * Action pagenavi formats
 *
 * @access protected
 * @return Void
 */
function uf_action_pagenavi_formats() {
    do_action("pagenavi_formats");
}
add_action("uf_pagenavi_formats", "uf_action_pagenavi_formats");





