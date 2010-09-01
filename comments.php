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
<?php if(have_comments()) : ?>
    <h3 id="comment-title" class="comment-title"><?php comments_number(__('No Comments', "unify_framework"), __('1 Comment', "unify_framework"), __('% Comments', "unify_framework")); ?></h3>

    <ol class="commentlist">
    <?php wp_list_comments(); ?>
    </ol>
    <p id="pager">
        <span class="previous"><?php previous_comments_link() ?></span>
        <span class="next"><?php next_comments_link() ?></span>
    </p>
<?php else: ?>
    <?php if ('open' == $post->comment_status) : ?>

    <?php else : // comments are closed ?>
        <p class="nocomments"><?php _e("Comments are closed.", "unify_framework"); ?></p>
    <?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>
<div id="respond">
    <h3><?php comment_form_title( __('Please Comment', "unify_framework"), __("Reply to %s", "unify_framework") ); ?></h3>
    <div id="cancel-comment-reply">
        <small><?php cancel_comment_reply_link(); ?></small>
    <!-- End cancel-comment-reply --></div>

    <?php if(get_option('comment_registration') && !$user_ID): ?>
        <p><?php sprintf(__('You must be <a href="%s/wp-login.php?redirect_to=%s">logged in</a> to post a comment.', "unifi_framework"), get_option('siteurl'), urlencode(get_permalink())); ?></p>
    <?php else : ?>

        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
        <?php if ($user_ID) : ?>
            <p><?php echo sprintf(__(
                'logged in as <a href="%s/wp-admin/profile.php">%s</a>. (<a href="%s" title="Log out of this account">logged out</a>)', "unify_framework"
            ), get_option("siteurl"), $user_identity, wp_logout_url(get_permalink()));?></p>
        <?php else : ?>

            <dl>
                <dt><label for="comment-author"><?php _e("Name"); ?> : </label></dt>
                <dd><input type="text" id="comment-author" name="author" value="<?php echo $comment_author; ?>" tabindex="1" />&nbsp;<?php _e('Required'); ?></dd>
                <dt><label for="comment-email"><?php _e("Email"); ?> : </label></dt>
                <dd><input type="text" id="comment-email" name="email" value="<?php echo $comment_author_email; ?>" tabindex="2" />&nbsp;<?php _e('Required'); ?></dd>
                <dt><label for="comment-url"><?php _e("Name"); ?> : </label></dt>
                <dd><input type="text" id="comment-url" name="url" value="<?php echo $comment_author_url; ?>" tabindex="3" /></dd>
            </dl>
        <?php endif; ?>

            <p class="comment-tag"><?php _e("Valid tags are"); ?> : <?php echo allowed_tags(); ?></p>
            <p><?php comment_id_fields(); ?>
            <textarea id="comment-content" name="comment" cols="180" rows="10" tabindex="4"></textarea></p>
            <p><input name="submit" type="submit" id="submit" value="<?php _e('Submit comment'); ?>" /></p>
            <?php do_action('comment_form', $post->ID); ?>
        </form>
    <!-- End respond --></div>
    <?php endif; // registerd or logged in user ? ?>
<?php endif; // if open comment_status ? ?>

