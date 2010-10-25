<?php /* unifyFramework right sidebar template. */ ?>
<?php
/**
 * if right sidebar registerd, shown right sidebar.
 *
 */
?>
<div id="right-sidebar" class="grid_4">
<?php if(!dynamic_sidebar("right-sidebar")): ?>
    <div class="widget widget_search">
        <?php get_search_form(); ?>
    <!-- End Search --></div>

    <div class="widget widget_calendar">
        <h3 class="widget-title"><?php _e("Calendar", "unify_framework"); ?></h3>
        <div class="calendar_wrap"><?php get_calendar(); ?></div>
    <!-- End Calendar --></div>

    <div class="widget widget_archive">
        <h3 class="widget-title"><?php _e("Archive", "unify_framework"); ?></h3>
        <ul>
        <?php get_archives(); ?>
        </ul>
    <!-- End Archive --></div>

    <div class="widget widget_categories">
        <h3 class="widget-title"><?php _e("Categories", "unify_framework"); ?></h3>
        <ul><?php wp_list_categories("title_li="); ?></ul>
    <!-- End category --></div>

    <div class="widget widget_tag_cloud">
        <h3 class="widget-title"><?php _e("TagCloud", "unify_framework"); ?></h3>
        <div><?php wp_tag_cloud(); ?></div>
    <!-- End TagCloud --></div>
<?php endif; ?>
</div>
