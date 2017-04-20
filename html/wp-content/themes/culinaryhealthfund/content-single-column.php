<!-- Content
================================================== -->
<div class="container internal">
  <div id="post-<?php the_ID(); ?>" <?php post_class('col-sm-8 page-content-single'); ?> >
      <?php echo do_action('ci_before_content'); ?>
      <?php the_content(); ?>
      <?php echo do_action('ci_after_content'); ?>
      <div class="edit"><?php edit_post_link('Edit'); ?></div>
  </div><!-- /col-sm-8 page-content -->
</div>
