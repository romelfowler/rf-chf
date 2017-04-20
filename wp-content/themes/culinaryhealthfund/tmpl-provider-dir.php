<?php
/*
 * Template Name: Provider Directory
 */

get_header();
?>
<div class="container hero">
<?php the_post_thumbnail(); ?>
</div>

<div class="internal-wrap">
    <div class="container internal">

        <div class="fixed_height_sidenav col-md-3">
            <div class="sidenav">
                <?php //echo do_shortcode('[wpnb_subnav_menu menu="Sub Nav"]'); ?>
                <?php echo wp_nav_menu(array('menu' => 'Sub Nav', 'echo' => false, 'menu_class' => 'sidebar-nav') ); ?>
            </div>

           <?php include_once('sidebar-cta-'. $currentLanguage . '.php'); ?>

        </div>
        <div class="col-md-9">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>
        </div>


        <div class="col-md-9">

        <?php

        	include_once('provider/index.php');
        ?>
        </div>



    </div>
</div>
</div>


<?php get_footer(); ?>
