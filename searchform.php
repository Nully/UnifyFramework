<?php /* UnifyFramework searchform template. */ ?>
<h3 class="widget-title searchtitle"><label for="search-text"><?php _e("Search"); ?></label></h3>
<form id="searchform" action="<?php bloginfo("home"); ?>" method="get">
    <p><input type="text" id="search-text" name="s" value="<?php echo get_search_query(); ?>" /></p>
    <p><input type="submit" id="search-submit" name="search" value="<?php _e("Search"); ?>" /></p>
</form>
