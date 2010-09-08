<?php /* UnifiFramework sidebar-left template. */ ?>
<?php
/**
 * if left sidebar registerd shown left sidebar.
 *
 */
if(uf_has_sidebar("left-sidebar")): ?>
    <div id="left-sidebar" class="grid_4"><?php uf_get_sidebar("left-sidebar"); ?></div>
<?php endif; ?>
