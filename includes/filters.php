<?php
/**
 * UnifyFramework page navigation actions
 *
 */
/**
 * Filter pagenavi formats
 *
 * @access protected
 * @param  $formats    Array    page navigation formats.
 * @return Void
 */
function uf_filter_pagenavi_formats($formats) {
    return $formats;
}
add_filter("uf_pagenavi_formats", "uf_filter_pagenavi_formats");





