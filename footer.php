<?php /* UnifyFramework footer template. */ ?>
<?php get_sidebar("right"); ?>
<!-- End contents --></div>
<!-- End container --></div>
<div id="footer">
    <div id="footer-in" class="container_16">
        <?php if(is_active_sidebar("footer-widget")): ?>
            <?php dynamic_sidebar("footer-widget"); ?>
        <?php endif; ?>
        <?php if(is_active_sidebar("footer-widget-2")): ?>
            <?php dynamic_sidebar("footer-widget-2"); ?>
        <?php endif; ?>
        <?php if(is_active_sidebar("footer-widget-3")): ?>
            <?php dynamic_sidebar("footer-widget-3"); ?>
        <?php endif; ?>
        <?php if(is_active_sidebar("footer-widget-4")): ?>
            <?php dynamic_sidebar("footer-widget-4"); ?>
        <?php endif; ?>
        <address>Copyright © 2010 <a href="<?php bloginfo("home"); ?>"><?php bloginfo("name"); ?></a> - All Rights Reserved<br />
            Powered by WordPress & the UnifyFramework Theme by <a href="http://blog.nully.org/">Nully</a>.</address>
    <!-- End footer_in --></div>
<!-- End footer --></div>
<?php wp_footer(); ?>
</body>
</html>