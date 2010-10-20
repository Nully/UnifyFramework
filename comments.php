<?php /* UnifyFramework Comment template. */

// Do not delete these lines
if (uf_is_direct_acess('comments.php')) {
    wp_die(__('Please do not load this page directly. Thanks!', "unify_framework"));
}

if(post_password_required()): ?>
<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", "unify_framework"); ?></p>
<?php return;
endif; ?>


<!-- You can start editing here. -->
<?php
/**
 * Display comment list.
 *
 */
if(have_comments()) : ?>
    <h3 id="comment-title" class="comment-title"><?php comments_number(__('No Comments', "unify_framework"), __('1 Comment', "unify_framework"), __('%s Comments', "unify_framework")); ?></h3>

    <ol class="commentlist"><?php wp_list_comments(); ?>
    </ol>
    <?php if($wp_query->max_num_pages >= 2): ?>
    <div id="uf-pagenavi">
        <span class="prev-post"><?php previous_comments_link() ?></span>
        <span class="next-post"><?php next_comments_link() ?></span>
    <!-- End uf-pagenavi --></div>
    <?php endif; ?>

    <?php /* Pingback's */ ?>
	<?php if ( ! empty($comments_by_type['pings']) ) : ?>
	<h5><?php _e('Trackbacks / Pings', 'unify_framework') ?></h5>
	<ol><?php wp_list_comments('type=pings'); ?></ol>
	<?php endif; ?>


<?php else: ?>
    <?php if ('open' == $post->comment_status) : ?>

    <?php else : // comments are closed ?>
        <p class="nocomments"><?php _e("Comments are closed.", "unify_framework"); ?></p>
    <?php endif; ?>
<?php endif; ?>


<?php
/**
 * comment form.
 *
 */
if ('open' == $post->comment_status) : ?>
    <?php uf_trackback_field(); ?>
    <?php uf_comment_form(); ?>
<?php endif; // if open comment_status ? ?>


