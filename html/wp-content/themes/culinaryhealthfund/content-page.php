          
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
            <a class="cta enrollment-cta" href="">enrollment</a>
            <a class="cta pharmacy-cta" href="">find a pharmacy</a>
            <a class="cta faq-cta" href="">faq's</a>
        </div>
        <div class="col-md-9">
            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?>
        </div>
    </div>
</div>