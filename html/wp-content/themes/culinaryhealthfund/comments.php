<?php
 
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');
 
if ( post_password_required() ) { ?>
<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
<?php
return;
}
?>
 
<!-- You can start editing here. -->
 
<?php if ( have_comments() ) : ?>
 
<div class="commentlist">
<?php wp_list_comments( array(
        'walker' => new zipGun_walker_comment,
        'style' => 'ul',
        'callback' => null,
        'end-callback' => null,
        'type' => 'all',
        'page' => null,
        'avatar_size' => 64
    ) ); ?>
</div>

<?php else : // this is displayed if there are no comments so far ?>
 
<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
 
<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments">Comments are closed.</p>
 
<?php endif; ?>
<?php endif; ?>
 
<?php if ('open' == $post->comment_status) : ?>
 
<div id="respond">
 
<!--<h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3> -->
 
<div class="cancel-comment-reply">
<small><?php cancel_comment_reply_link(); ?></small>
</div>
 
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>
 
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
 
<?php if ( $user_ID ) : ?>
 
<p>Logged in as <?php echo $user_identity; ?>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
 
<?php else : ?>
 

 
<?php $comment_args = array('comment_field'=> '<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>'); ?>

<?php comment_form($comment_args); ?>
 
<?php endif; ?>
 
<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p> -->
 
<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
 
<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>
 
</form>
 
<?php endif; // If registration required and not logged in ?>
</div>

<div class="navigation"><?php paginate_comments_links(); ?> </div>
 
<?php endif; // if you delete this the sky will fall on your head ?>