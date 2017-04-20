<?php get_header(); ?>
<!-- Blog Content
    ================================================== -->
    <div class="container hero">
    <img src = "wp-content/uploads/2014/05/chf-search-marquee.jpg">
    </div>
    <br><br>
    <div class="container internal">

      <div class="col-md-12 page-content">
                <?php if(is_search()) : echo '<h2> <strong>Search Results</strong> </h2> <hr>'; endif; ?>
                <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                    <?php

                    echo get_template_part('content', 'post');

                    ?>
                <?php endwhile; ?>
                <div>
                    <nav class="pagination">
                        <?php if (function_exists("jdev_pagination")) : jdev_pagination();
                        endif
                        ?>
                    </nav>
                </div> <!-- /span12 -->
                <?php else : ?>
                    <p> Sorry, no search results where found. </p>
                <?php endif; ?>
      </div><!-- /col-sm-8 page-content -->
      <?php #get_sidebar(); ?>
    </div>
<?php get_footer(); ?>
