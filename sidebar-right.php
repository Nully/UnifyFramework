<div id="right_sidebar">
<?php if(!dynamic_sidebar("right-sidebar")): ?>
    <div class="widget widget-searchform">
        <h3 class="widget-title"><?php _e("Search"); ?></h3>
        <?php get_search_form(); ?>
    <!-- End widget --></div>

    <div class="widget widget-archive">
        <h3 class="widget-title"><?php _e("Archive"); ?></h3>
        <ul>
        <?php wp_get_archives(); ?>
        </ul>
    <!-- End widget --></div>

    <div class="widget widget-categories">
        <h3 class="widget-title"><?php _e("Category"); ?></h3>
        <ul>
        <?php wp_list_categories("title_li="); ?>
        </ul>
    <!-- End widget --></div>

    <div class="widget widget-calendar">
        <h3 class="widget-title"><?php _e("Calendar"); ?></h3>
        <?php get_calendar(); ?>
    <!-- End widget --></div>

    <div class="widget widget-bookmark">
        <h3 class="widget-title"><?php _e("Links"); ?></h3>
        <ul class="bookmarks">
        <?php wp_list_bookmarks("title_li=&categorize=0"); ?>
        </ul>
    <!-- End widget --></div>

    <div class="widget widget-meta">
        <h3 class="widget-title"><?php _e("Meta"); ?></h3>
        <ul class="widget-meta-list">
        <?php wp_register(); ?>
        <li><?php wp_loginout(); ?></li>
        <li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo esc_attr(__('Syndicate this site using RSS 2.0')); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
        <li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php echo esc_attr(__('The latest comments to all posts in RSS')); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
        <li><a href="http://wordpress.org/" title="<?php echo esc_attr(__('Powered by WordPress, state-of-the-art semantic personal publishing platform.')); ?>">WordPress.org</a></li>
        <li><a href="http://github.com/Nully/UnifyFramework" title="<?php _e("Powerd by UnifyFramework.", UF_TEXTDOMAIN); ?>">UnifyFramework</a></li>
        <?php wp_meta(); ?>
        </ul>
    <!-- End widget --></div>
<?php endif; ?>
<!-- End right_sidebar --></div>