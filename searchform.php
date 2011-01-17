<form action="<?php bloginfo("home"); ?>" method="post" class="search-form">
    <p><input type="text" id="s" name="s" value="<?php echo esc_attr($s); ?>" class="search-form-text" />
        <input type="submit" id="" name="" value="<?php _e("Search"); ?>" class="search-form-submit" /></p>
</form>
