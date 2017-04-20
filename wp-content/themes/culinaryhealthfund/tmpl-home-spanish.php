<?php
/*
 * Template Name: Home Page (Spanish)
 */

get_header();
?>
<?php do_action('slideshow_deploy', '3489'); ?>





<div class="container-fluid types-wrap">
	<div class="container types">
    	<div class="col-md-4 participants">
        	<p class="type"><a href="participants">PARTICIPANTES</a></p>
            <p class="desc"><a href="participants">( Usted y su familia )</a></p>
        </div>
        <div class="col-md-4 providers">
        	<p class="type"><a href="providers">PROVEEDORES</a></p>
            <p class="desc"><a href="providers">( Doctores )</a></p>
        </div>
        <div class="col-md-4 employees">
        	<p class="type"><a href="employers">EMPLEADORES</a></p>
            <p class="desc"><a href="employers">( Propiedades de la Unión Culinaria )</a></p>
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



    <div class="enroll">

    <div class="row">
      <div class="container">
        <div class="col-sm-10">
          <p>¿NO ESTA INSCRITO? ¡Inscríbase hoy para recibir sus beneficios del Culinary Health Fund!</p>
          <p>¿Quiere hacer un Auto-Pago? </p>
          <p>¿Quiere checar sus reclamos o elegibilidad?</p>
        </div>
        <div class="col-sm-6 btn-lg btn-warning">
          <a href="https://secure.abpa.com/export/participant/en/index.php?lang=eng" target="_blank">Haga clic aquí.</a>
        </div>
      </div>
    </div>

    </div>



    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="pop-forms">
                    <h2>FORMULARIOS POPULARES</h2>
                    <?php
                    $args = array(
						'post_type' => 'page',
    					'post__in' => array(510)
                	);
                	?>
                    <?php $featured = new WP_Query($args); ?>
					<?php while($featured->have_posts()):$featured->the_post(); ?>
                    <?php the_content(); ?>
                    <a href="useful-materials/forms-documents/"><img src="<?php bloginfo('template_directory'); ?>/images/btn-seemore-ESP.png" /></a>
                    <?php endwhile; ?>
        			<?php wp_reset_query(); ?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="faqs">
                    <h2>PREGUNTAS FRECUENTES</h2>
                    <?php
                    $args = array(
						'post_type' => 'page',
    					'post__in' => array(508)
                	);
                	?>
                    <?php $featured = new WP_Query($args); ?>
					<?php while($featured->have_posts()):$featured->the_post(); ?>
                    <?php the_content(); ?>
                    <a href="useful-materials/frequently-asked-questions/"><img src="<?php bloginfo('template_directory'); ?>/images/btn-seemore-ESP.png" /></a>
                    <?php endwhile; ?>
        			<?php wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
