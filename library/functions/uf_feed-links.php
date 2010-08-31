<?php
/**
 * UnifyFramework AutomaticFeedLinks support
 */
if($uf_is_wp_version_under_3) {
    automatic_feed_links(true);
}
else {
    add_theme_support("automatic-feed-links");
}

