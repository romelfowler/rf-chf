<?php
/*
 * Template Name: Home Page (Tagalog)
 */

get_header();
?>
 
<div class="container-fluid marquee">
	<div class="container">
 		<?php echo do_shortcode('[wpib_slideshow id="5" speed="7000" desc="true"]'); ?>
	</div>
</div>

<div class="container-fluid types-wrap">
	<div class="container types">
    	<div class="col-md-4 participants">
        	<p class="type"><a href="participants">KASAPI</a></p>
            <p class="desc"><a href="participants">( Ikaw at ang Iyong Pamilya )</a></p>
        </div>
        <div class="col-md-4 providers">
        	<p class="type"><a href="providers">TAGAPAGBIGAY LUNAS</a></p>
            <p class="desc"><a href="providers">( Mga Manggagamot )</a></p>
        </div>
        <div class="col-md-4 employees">
        	<p class="type"><a href="employers">PINAGTATRABAHUHAN</a></p>
            <p class="desc"><a href="employers">( Mga Ari-aria’ng may Unyon )</a></p>
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
            <p>HINDI NAKATALA?  Magpatala ngayon para sa iyong mga benepisyo sa Culinary Health Fund! </p>
        </div>
        <div class="col-md-4">
            <a href="https://secure.abpa.com/export/participant/en/index.php?lang=eng" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/btn-enrolltoday-TAG.png" /></a>
        </div>
    </div>
    <div class="container enroll">
        <div class="col-md-8">
            <p>Kailangan mo ba’ng gumawa nang Sarili’ng-Pagbabayad? I-klik dito.</p>
        </div>
        <div class="col-md-4">
            <a href="https://secure.abpa.com/export/participant/en/index.php?lang=eng" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/btn-selfpay-tagalog.png" /></a>
        </div>
    </div>
    
     <div class="container enroll">
        <div class="col-md-8">
            <p>Nais mo ba'ng makita ang iyong mga paghahabol/pagiging karapat-dapat? I-klik dito.</p>
        </div>
        <div class="col-md-4">
            <a href="https://secure.abpa.com/export/participant/en/index.php?lang=eng" target="_blank"><img src="http://tag.culinaryhealthfund.org/wp-content/uploads/sites/3/2015/10/Eligibility-Claims-TAG.png" /></a>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="pop-forms">
                    <h2>MGA POPULAR NA PORMA</h2>
                    <?php
                    $args = array(
						'post_type' => 'page',
    					'post__in' => array(161)		
                	);		
                	?>
                    <?php $featured = new WP_Query($args); ?>
					<?php while($featured->have_posts()):$featured->the_post(); ?>
                    <?php the_content(); ?>
                    <a href="useful-materials/forms-documents/"><img src="<?php bloginfo('template_directory'); ?>/images/btn-seemore-TAG.png" /></a>
                    <?php endwhile; ?>
        			<?php wp_reset_query(); ?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="faqs">
                    <h2>MADALAS ITANONG</h2>
                    <?php
                    $args = array(
						'post_type' => 'page',
    					'post__in' => array(166)		
                	);		
                	?>
                    <?php $featured = new WP_Query($args); ?>
					<?php while($featured->have_posts()):$featured->the_post(); ?>
                    <?php the_content(); ?>
                    <a href="useful-materials/frequently-asked-questions/"><img src="<?php bloginfo('template_directory'); ?>/images/btn-seemore-TAG.png" /></a>
                    <?php endwhile; ?>
        			<?php wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
    
<?php get_footer(); ?>
