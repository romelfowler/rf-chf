<?php
/*
 * Template Name: Email Test
 */

get_header();
?>
<div class="container hero">
<?php the_post_thumbnail(); ?>
</div>

<div class="internal-wrap">
    <div class="container internal">
        <div class="col-md-3">
            <div class="sidenav">
                <?php //echo do_shortcode('[wpnb_subnav_menu menu="Sub Nav"]'); ?>
                <?php echo wp_nav_menu(array('menu' => 'Sub Nav', 'echo' => false, 'menu_class' => 'sidebar-nav') ); ?>
            </div>
            <a class="cta enrollment-cta" href="https://secure.abpa.com/export/participant/en/index.php?lang=eng" target="_blank">enrollment</a>
            <a class="cta pharmacy-cta" href="/participants/list-of-doctors/">find a pharmacy</a>
            <a class="cta faq-cta" href="/useful-materials/frequently-asked-questions/">faq's</a>
        </div>
        <div class="col-md-9">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>
        </div>
        
        
        <div class="col-md-9">
        
        <?php
        	include_once('provider/emailtest.php');
        ?>
        </div>
        
        
        
    </div>
</div>
</div>


<?php get_footer(); ?>





