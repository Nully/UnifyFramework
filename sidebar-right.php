<?php /* unifyFramework right sidebar template. */ ?>
<?php
/**
 * if right sidebar registerd, shown right sidebar.
 *
 */
if(uf_has_sidebar("right-sidebar")): ?>
    <div id="right-sidebar" class="grid_4"><?php uf_get_sidebar("right-sidebar"); ?></div>
<?php endif; ?>
