<?php
/*
 * Template Name: Home Page
 */

get_header();
?>

<div class="container-fluid marquee">
	<div class="container">
 		<?php echo do_shortcode('[wpib_slideshow id="29" speed="7000" desc="true"]'); ?>
	</div>
</div>

<div class="container-fluid types-wrap">
	<div class="container types">
    	<div class="col-md-4 participants">
        	<p class="type">participants</p>
            <p class="desc">( You and Your Family )</p>
        </div>
        <div class="col-md-4 providers">
        	<p class="type">providers</p>
            <p class="desc">( Doctors )</p>
        </div>
        <div class="col-md-4 employees">
        	<p class="type">employers</p>
            <p class="desc">( Union Properties )</p>
        </div>
    </div>
</div>

<div class="home-wrap">
    <div class="container">
        <div class="col-md-12">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>
        </div>
    </div>
    
    <div class="container enroll">
        <div class="col-md-8">
            <p>NOT ENROLLED? Enroll today for your Culinary Health Fund benefits!</p>
        </div>
        <div class="col-md-4">
            <a href=""><img src="<?php bloginfo('template_directory'); ?>/images/btn-enroll.png" /></a>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="pop-forms">
                    <h2>POPULAR FORMS</h2>
                    <?php
                    $args = array(
						'post_type' => 'page',
    					'post__in' => array(38)		
                	);		
                	?>
                    <?php $featured = new WP_Query($args); ?>
					<?php while($featured->have_posts()):$featured->the_post(); ?>
                    <?php the_content(); ?>
                    <a href=""><img src="<?php bloginfo('template_directory'); ?>/images/btn-see-more.png" /></a>
                    <?php endwhile; ?>
        			<?php wp_reset_query(); ?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="faqs">
                    <h2>FREQUENTLY ASKED QUESTIONS</h2>
                    <?php
                    $args = array(
						'post_type' => 'page',
    					'post__in' => array(40)		
                	);		
                	?>
                    <?php $featured = new WP_Query($args); ?>
					<?php while($featured->have_posts()):$featured->the_post(); ?>
                    <?php the_content(); ?>
                    <a href=""><img src="<?php bloginfo('template_directory'); ?>/images/btn-see-more.png" /></a>
                    <?php endwhile; ?>
        			<?php wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
    
<?php get_footer(); ?>
