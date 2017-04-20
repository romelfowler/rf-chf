<?php
include($_SERVER['DOCUMENT_ROOT'] .'/wp-content/themes/culinaryhealthfund/includes/init.inc.php');
?>
<div class="container hero">
<?php the_post_thumbnail(); ?>
</div>

<div class="internal-wrap">
    <div class="container internal">
        <div class="col-md-3">
            <div class="sidenav hidden-sm hidden-xs">
                <?php //echo do_shortcode('[wpnb_subnav_menu menu="Sub Nav"]'); ?>
                <?php echo wp_nav_menu(array('menu' => 'Sub Nav', 'echo' => false, 'menu_class' => 'sidebar-nav') ); ?>
            </div>
            <div class="hidden-sm hidden-xs">
            	<?php include_once('sidebar-cta-'. $currentLanguage . '.php'); ?>
            </div>
        </div>
        <div class="col-md-9">
            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?>
        </div>
		<div class="sidenav hidden-lg hidden-md visible-sm visible-xs">
		    <?php //echo do_shortcode('[wpnb_subnav_menu menu="Sub Nav"]'); ?>
		    <?php echo wp_nav_menu(array('menu' => 'Sub Nav', 'echo' => false, 'menu_class' => 'sidebar-nav') ); ?>
		</div>
    </div>
</div>

<div class="hidden-lg hidden-md visible-sm visible-xs">
	<?php include_once('sidebar-cta-'. $currentLanguage . '.php'); ?>
</div>
