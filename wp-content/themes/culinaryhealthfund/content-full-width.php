<!-- Content
================================================== -->
<div class="container">
  <?php get_template_part('features/jquery-grid/content', 'jquery-grid')?>

</div>
<div class="container internal">
  <div id="post-<?php the_ID(); ?>" <?php post_class('col-sm-12 page-content-full-width'); ?>>
      <?php echo do_action('ci_before_content'); ?>
      <?php the_content(); ?>
      <?php echo do_action('ci_after_content'); ?>
      <div class="edit"><?php edit_post_link('Edit'); ?></div>
  </div><!-- /col-sm-8 page-content -->
</div>
