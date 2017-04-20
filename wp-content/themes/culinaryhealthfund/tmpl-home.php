<?php
/*
 * Template Name: Home Page
 */

get_header();

$imageBossID = ($_SERVER['PHP_ENV'] == 'staging') ? "1256" : "1329";

?>
<?php do_action('slideshow_deploy', '5795'); ?>






<div class="container types-wrap">
	<div class="types">
    	<div class="col-md-4 participants">
        	<p class="type"><a href="participants">PARTICIPANTS</a></p>
            <p class="desc"><a href="participants">( You and Your Family )</a></p>
        </div>
        <div class="col-md-4 providers">
        	<p class="type"><a href="providers">PROVIDERS</a></p>
            <p class="desc"><a href="providers">( Doctors )</a></p>
        </div>
        <div class="col-md-4 employees">
        	<p class="type"><a href="employers">EMPLOYERS</a></p>
            <p class="desc"><a href="employers">( Union Properties )</a></p>
        </div>
    </div>
</div>

<div class="home-wrap">
    <div class="chf_welcome container">
        <div class="col-md-12">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>
        </div>
    </div>


		<div class="enroll">

		<div class="row">
			<div class="container">
				<div class="enroll_container col-sm-12">
					<p>NOT ENROLLED? Enroll today for your Culinary Health Fund benefits!</p>
					<p>Do you need to make a Self-Pay?</p>
					<p>Do you want to check your claims / eligibility?</p>
					<a class="btn btn-lg btn-culinary" href="https://secure.abpa.com/export/participant/en/index.php?lang=eng" target="_blank">Click Here!</a>
				</div>
				<hr>
				<div class="enroll_container col-sm-12">
						<p>
							Below are some wellness classes we offer at the Culinary Health Fund.

						</p>
				</div>

			</div>
		</div>

    </div>
		<!-- enroll -->
		<div id="culinaryClasses" class="">

		<div class="row">
					<div class="chf_classes breastfeeding col-sm-4">
						<a href="http://www.culinaryhealthfund.org/participants/breastfeeding-classes/">Breastfeeding Class</a>
					</div>
					<div class="chf_classes diabetes col-sm-4">
						<a href="http://www.culinaryhealthfund.org/participants/programs-services/diabetes-classes/">Diabetes Class</a>
					</div>
					<div class="chf_classes kidney_smart col-sm-4">
						<a href="http://www.culinaryhealthfund.org/participants/programs-services/kidney-smart/">Kidney Smart Class</a>

					</div>
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
										<a href="useful-materials/forms-documents/" class="btn btn-lg btn-warning rounded">See More</a>
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
										<a href="useful-materials/frequently-asked-questions/" class="btn btn-lg btn-warning rounded">See More</a>
                    <?php endwhile; ?>
        			<?php wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
