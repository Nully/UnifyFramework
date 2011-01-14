<div id="left_sidebar">
<?php if(!dynamic_sidebar("left-sidebar")): ?>
    <div class="widget widget-archive">
        <h3 class="widget-title"><?php _e("Archives"); ?></h3>
        <ul class="archive-items">
        <?php wp_get_archives(); ?>
        </ul>
    <!-- End widget --></div>

    <div class="widget widget-categories">
        <h3 class="widget-title"><?php _e("Categories"); ?></h3>
        <ul class="category-items">
        <?php wp_list_categories(); ?>
        </ul>
    <!-- End widget --></div>

    <div class="widget widget-calendar">
        <h3 class="widget-title"><?php _e("Calendar"); ?></h3>
        <div class="carendar">
            <?php get_calendar(); ?>
        <!-- End calendar --></div>
    <!-- End widget --></div>
<?php endif; ?>
<!-- End left_sidebar --></div>