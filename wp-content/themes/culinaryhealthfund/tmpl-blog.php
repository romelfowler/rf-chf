<?php
/*
 * Template Name: Blog
 */

get_header();
$ci = get_option('ci');
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
<!-- Blog Content
    ================================================== -->
    
    <div class="container internal">
      <div class="col-md-8 col-md-push-3 col-md-offset-1 page-content">
                <?php if(is_search()) : echo '<h2> <strong>Search Results</strong> </h2> <hr>'; endif; ?>
                <?php query_posts("cat=-".$ci['ci_cta_category']."&paged=".$paged); ?>
                <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                    <?php echo get_template_part('content', 'post'); ?>
                <?php endwhile; ?>
                <div>
                    <nav class="pagination">
                        <?php if (function_exists("jdev_pagination")) : jdev_pagination();
                        endif
                        ?>
                    </nav>
                </div> <!-- /span12 -->
                <?php else : ?>
                    <p><?php _e('Sorry, this page does not exist.', 'gravity'); ?></p>
                <?php endif; ?>
      </div><!-- /col-sm-8 page-content -->
      <?php get_sidebar(); ?>
    </div>
<?php get_footer(); ?>
