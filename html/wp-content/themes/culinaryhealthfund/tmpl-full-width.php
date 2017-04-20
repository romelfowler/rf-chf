<?php
/*
 * Template Name: Full Width
 */

get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post();  ?>
        <?php echo get_template_part('content', 'full-width'); ?>
    <?php endwhile; else: ?>
        <p><?php _e('Sorry, this page does not exist.', 'gravity'); ?></p>
<?php endif; ?>
    
<?php get_footer(); ?>
