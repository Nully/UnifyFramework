<div class="pager">
<?php if(function_exists("wp_pagenavi")): ?>
<?php wp_pagenavi(); ?>
<?php else: if($wp_query->max_num_pages > 1): ?>
    <span class="previous-page"><?php previous_posts_link(__('<span class="pager-meta">&laquo;</span> Older posts', UF_TEXTDOMAIN)); ?></span>
    <span class="next-page"><?php next_posts_link(__('Newer posts <span class="pager-meta">&raquo;</span>', UF_TEXTDOMAIN)); ?></span>
<?php endif; endif; ?>
</div>
