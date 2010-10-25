<?php
/**
 * UnifyFramework utility support
 */
/**
 * do Action, comment post.
 * checking comment_author meta data.
 *
 * @access protected
 * @param  $author    String    comment author name.
 * @return String
 */
function uf_check_comment_author_name($author) {
    $author = "";
    if(empty($author) && uf_get_option("theme_options", "comment_required_name")) {
        wp_die(__(
            "Comment author is required.<br />Please comment author field.", "unify_framework"
        ), __("Comment Author is required field.", "unify_framework"));
    }

    return $author;
}
add_filter("pre_comment_author_name", "uf_check_comment_author_name");



/**
 * check PHP script file direct access ?
 *
 * @param  $filename   check target file name
 * @return Bool
 */
function uf_is_direct_acess($filename) {
    return (!empty($_SERVER["SCRIPT_FILENAME"]) && $filename === $_SERVER["SCRIPT_FILENAME"]);
}



/**
 * get post comment count
 *
 * @param  $field    String|Null   approved, awaiting_moderation, spam, total_comments
 * @return Int
 */
function uf_get_comment_count($field = null) {
    global $post;
    if(!isset($post)) {
        return 0;
    }
    $comments = get_comment_count($post->ID);
    if(is_null($field)) {
        return $comments;
    }

    $comments = apply_filters("uf_comment_count", $comments);
    return $comments[$field];
}



/**
 * Display trackback URL
 *
 * @access public
 * @return Void|String
 */
function uf_trackback_field() {
    if(get_option("default_ping_status") != "open" || !uf_get_option("theme_options", "display_trackback_url", false))
        return;

    $fields = array(
        "trackback_title" => '<h3><label for="">'. __("Trackback / Ping", "unify_framework") .'</label></h3>',
        "trackback_field" => '<div class="trackback"><input type="text" value="'. get_trackback_url() .'" class="trackback-field" readonly="readonly" /></div>'
    );

    do_action("uf_trackback_field");
    echo join(PHP_EOL, apply_filters("uf_trackback_field", $fields));
}



/**
 * UnifyFramework comment form top DL tag marking.
 *
 * @access protected
 * @return Void
 */
function uf_comment_form_top_tag() {
    echo "<dl>\n";
}
add_action("uf_comment_form_top", "uf_comment_form_top_tag");



/**
 * UnifyFrmaework comment form bottom DL tag marking.
 *
 * @access public
 * @return Void
 */
function uf_comment_form_bottom_tag() {
    echo "</dl>\n";
}
add_action("uf_comment_form_bottom", "uf_comment_form_bottom_tag");



/**
 * Display comment form.
 *
 * @access public
 * @return Void
 */
function uf_comment_form() {
    global $user_identity, $id;

    $commenter = wp_get_current_commenter();

    // comment form required
    $theme_option = uf_get_option("theme_options");
    $name_req = false;
    $mail_req = false;
    if($theme_option["comment_required_name"])
        $name_req = true;
    else if(get_option("required_name_email")) {
        $name_req = true;
        $mail_req = true;
    }

    $fields = array(
        "author" => '<dt><label for="comment-author">'. __("Author") .'</label>'. ($name_req == true ? '<span class="required">* '. __("Required") .'</span>': '') .'</dt>'.
                    '<dd><input type="text" name="author" id="comment-author" value="'. esc_attr($commenter["comment_author"]) .'" tabindex="1"'. ($name_req == true ? ' class="required"': ''). ' /></dd>',
        "email"  => '<dt><label for="comment-email">'. __("Email") .'</label>'. ($mail_req == true ? '<span class="required">* '. __("Required") .'</span>': '') .'</dt>'.
                    '<dd><input type="text" name="author" id="comment-email" value="'. esc_attr($commenter["comment_author_email"]) .'" tabindex="2"'. ($mail_req == true ? ' class="required"': ''). ' /></dd>',
        "url"    => '<dt><label for="comment-url">'. __("Website") .'</label></dt>'.
                    '<dd><input type="text" name="author" id="comment-url" value="'. esc_attr($commenter["comment_author_url"]) .'" tabindex="3" /></dd>'
    );


    // Copyd WordPress 3.0 comment-template.php Sources.
	$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<dt class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label></dt>'.
                                  '<dd><div class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ). '</div>'.
                                      '<textarea id="comment-content" name="comment" cols="45" rows="8" aria-required="true"></textarea></dd>',
		'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<div id="comment-meta" class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', "unify_framework"), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</div>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a Reply' ),
		'title_reply_to'       => __( 'Leave a Reply to %s' ),
		'cancel_reply_link'    => __( 'Cancel reply' ),
		'label_submit'         => __( 'Post Comment' ),
	);
    // End copyd WordPress 3.0 comment-template.php Sources.

    $args = wp_parse_args($args, apply_filters("comment_form_defaults", $defaults));

    if(comments_open()):
    ?>
    <?php do_action("uf_comment_form_before"); ?>
    <div id="respond">
        <h3 id="reply-title"><?php comment_form_title($args["title_reply"], $args["title_reply_to"]); ?></h3>
        <?php if(get_option("comment_registration") && !is_user_logged_in()): ?>
            <?php do_action("uf_comment_form_must_log_in_before"); ?>
            <?php echo $args["must_log_in"]; ?>
            <?php do_action("uf_comment_form_must_log_in_after"); ?>

        <?php else: ?>
            <form action="<?php echo get_site_url(null, "/wp-comments-post.php"); ?>" method="post" id="<?php echo esc_attr($args["id_form"]); ?>">

                <?php if(is_user_logged_in ()): ?>
                    <?php do_action("uf_comment_form_logged_in_before"); ?>
                    <?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
                    <?php do_action( 'uf_comment_form_logged_in_after', $commenter, $user_identity ); ?>
                <?php endif; ?>

                <?php do_action("uf_comment_form_top"); ?>

                <?php if(!is_user_logged_in()): ?>
                    <?php echo $args["comment_notes_before"]; ?>
                    <?php do_action("uf_comment_form_before_fields"); ?>
                        <?php
                            foreach((array)$args["fields"] as $name => $field) {
                                echo apply_filters("comment_form_field_{$name}", $field). "\n";
                            }
                        ?>
                    <?php do_action("uf_comment_form_after_fields"); ?>

                <?php endif; ?>
                <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
                <?php echo $args["comment_notes_after"]; ?>

                <?php do_action("uf_comment_form_bottom"); ?>

                <p class="form-submit">
                    <input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
                    <?php comment_id_fields(); ?>
                </p>
                <?php do_action( 'comment_form', $post_id ); ?>
            </form>
        <?php endif;  ?>
    <!-- End respond --></div>
    <?php do_action("uf_comment_form_after"); ?>
    <?php
    endif;
}

