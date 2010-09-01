<?php /* UnifyFramework searchform template. */ ?>
<form id="searchform" action="<?php bloginfo("home"); ?>" method="get">
    <p><input type="text" id="s" name="s" value="<?php echo get_search_query(); ?>" /></p>
    <p><input type="submit" id="search" name="search" value="<?php _e("Search"); ?>" /></p>
</form>
