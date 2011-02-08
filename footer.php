<!-- End contents --></div>

<div id="footer" class="clearfix">
<?php get_sidebar("footer"); ?>
<div id="footer_nav">
<?php wp_nav_menu(array(
    "container"       => false,
    "theme_location" => "footer_navi",
)); ?>
<address><?php printf(__('Copyright &copy; %s %s, Theme by <a href="https://github.com/Nully/UnifyFramework">UnifyFramework</a>'), date("Y"), get_bloginfo("name")); ?></address>
</div>
<!-- End footer --></div>
<!-- End inner_container --></div>
<!-- End container --></div>
<?php wp_footer(); ?>
</body>
</html>