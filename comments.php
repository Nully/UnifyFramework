<?php
    // check Direct Access.
    if(!empty($_SERVER["SCRIPT_FILENAME"]) && "comments.php" == $_SERVER["SCRIPT_FILENAME"]) {
        wp_die(__("Sorry, this page do not direct access !", UF_TEXTDOMAIN), "This page do not direct access.");
    }
?>

<div id="comment_post_box">
<?php
// Post password required message.
if(post_password_required()): ?>
<p class="required required-post-password"><?php _e("This post required password. Enter the password.", UF_TEXTDOMAIN); ?></p>
<?php return; endif; ?>

<?php if(have_comments()): ?>
    <div class="comments comments-box">
        <h3 class="comment-post-title"><?php printf( _n('1 Comment to %2$s', '%1$s Comments to %2$s', get_comments_number(), UF_TEXTDOMAIN),
             number_format_i18n(get_comments_number()), '<em>'. get_the_title(). '</em>'); ?></h3>
        <ol id="comments_list">
            <?php wp_list_comments("type=comment&callback=uf_list_comments"); ?>
        </ol>
    </div>

    <div class="trackbacks comments-box">
        <h3 class="comment-post-title"><?php printf('Trackbacks / Pings',UF_TEXTDOMAIN); ?></h3>
        <?php wp_list_comments("type=pings&uf_list_trackback"); ?>
    </div>
<?php else: ?>
    <h3 class="comment-post-title"><?php _e("No Comments/Pingbacks"); ?></h3>
    <?php if($post->comment_status == "open"): ?>
    <p><?php _e("Please post your Comment !", UF_TEXTDOMAIN); ?></p>
    <?php else: ?>
    <p><?php _e("This post closed Comment/Trackbak.", UF_TEXTDOMAIN); ?></p>
    <?php endif; ?>
<?php endif; ?>


<?php if($post->comment_status == "open"): ?>
<div id="respond">
<h4 id="reply_title"><?php comment_form_title( __("Leave a Comment", UF_TEXTDOMAIN), __("Leave a Comment to %s", UF_TEXTDOMAIN) ); ?></h4>
<form action="<?php bloginfo("home"); ?>/wp-comments-post.php" method="post" id="comment_form">
<?php comment_id_fields(); ?>
<dl id="comment_fields">
<?php if($user_ID): ?>
    <dd id="logged_in_as">
    <p><?php printf('Logged in as %2$s <a href="%1$s/wp-admin/profile.php" title="logged in %2$s">%2$s</a>', get_bloginfo("home"), $user_identity); ?></p>
    <p><a href="<?php echo wp_logout_url(); ?>"><?php _e("Log out this account.", UF_TEXTDOMAIN); ?></a></p>
    </dd>
<?php else: ?>
    <dt><label for="author"><?php _e("Name"); ?></label></dt>
    <dd><input type="text" id="author" name="author" value="<?php echo $comment_author; ?>" tabindex="1" class="text required" /></dd>
    <dt><label for="email"><?php _e("Email"); ?></label></dt>
    <dd><input type="text" id="email" name="email" value="<?php echo $comment_author_email; ?>" tabindex="2" class="text required" /></dd>
    <dt><label for="url"><?php _e("Website"); ?></label></dt>
    <dd><input type="text" id="url" name="url" value="<?php echo $comment_author_url; ?>" tabindex="3" class="text website" /></dd>
<?php endif; ?>
    <dt><label for="comment"><?php _e("Comment"); ?></label></dt>
    <dd><textarea id="comment" name="comment" cols="50" rows="10"></textarea><br />
        <p id="allowd_tags"><?php printf(__('<strong>XHTML</strong> allowd comment tags: %s'), allowed_tags()); ?></p></dd>
</dl>
<p><input type="submit" id="submit" name="submit" value="<?php _e("Submit Comment"); ?>" /><span id="cancel_reply"><?php cancel_comment_reply_link(); ?></span></p>
</form>


<!-- End respond --></div>

<?php endif; ?>
<!-- End comment_post_box --></div>
