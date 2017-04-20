<?php get_header(); ?>
<!-- Single Page Content
    ================================================== -->
    <div class="container internal">
        <div class="col-md-8 col-md-push-3 col-md-offset-1 page-content">
            <?php wp_link_pages(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class('post-wrap'); ?>>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php echo CI_Theme_Options::ci_get_featured_image(); // Blog post featured image ?>
                <?php CI_Theme_Options::ci_get_meta(); // Blog post meta data ?>
                <div class="entry-contents">
                    <?php the_content(); ?>
                </div>
                <?php comments_template(); ?>
                <?php endwhile; else : ?>
                    <h2 class="blog-title">No post was found</h2>
                <?php endif; ?>
            </div>
        </div>
        <?php get_sidebar(); ?>
    </div>
<?php get_footer(); ?>
