<?php get_header(); ?>

<!-- Archive Content
    ================================================== -->

<div class="container internal">
    <div class="col-md-8 col-md-push-3 col-md-offset-1 page-content">
        <?php if (have_posts()) : ?>
            <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
            <?php /* If this is a category archive */ if (is_category()) { ?>
                <h1 class="pagetitle">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h1>
            <?php /* If this is a tag archive */
            } elseif (is_tag()) { ?>
                <h1 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h1>
            <?php /* If this is a daily archive */
            } elseif (is_day()) { ?>
                <h1 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h1>
            <?php /* If this is a monthly archive */
            } elseif (is_month()) { ?>
                <h1 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h1>
            <?php /* If this is a yearly archive */
            } elseif (is_year()) { ?>
                <h1 class="pagetitle">Archive for <?php the_time('Y'); ?></h1>
            <?php /* If this is an author archive */
            } elseif (is_author()) { ?>
                <h1 class="pagetitle">Author Archive</h1>
    <?php /* If this is a paged archive */
    } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                <h1 class="pagetitle">Blog Archives</h1>               

    <?php } ?>


            <center><hr/></center>

                <?php while (have_posts()) : the_post(); ?>

                <div class="blog-wrap">
                <?php echo CI_Theme_Options::ci_get_featured_image(); // Blog post featured image ?>
                    <h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                        <?php the_excerpt(); ?>
                        <?php CI_Theme_Options::ci_get_meta(); // Blog post meta data ?> 
                </div>

    <?php endwhile; ?>
            <div>
                <nav class="pagination">
            <?php
            if (function_exists("jdev_pagination")) : jdev_pagination();
            endif
            ?>
                </nav>
            </div> <!-- /span12 -->
<?php else : ?>
            <p> Sorry, no search results where found. </p>
<?php endif; ?>
    </div><!-- /col-sm-8 page-content -->
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>