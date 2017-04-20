<!-- Footer
================================================== -->
<?php echo do_action('ci_before_footer'); ?>
<footer>
    <div class="container">
		<div class="col-md-6">
        	<?php wp_nav_menu(array('menu' => 'footer')); ?>
        	<p>&copy; Culinary Health Fund</p>
            <ul>
            	<li>111 Address Street, Las Vegas, NV 010101</li>   |   
                <li>Phone: 702-555-1212</li>   |   
                <li>Fax: 702-555-1213</li>
            </ul>
        </div>
        <div class="col-md-6 sponsors">
        	<ul>
            	<li><a href=""><img src="<?php bloginfo('template_directory'); ?>/images/logo-culinary.png" /></a></li>
                <li><a href=""><img src="<?php bloginfo('template_directory'); ?>/images/logo-pension.png" /></a></li>
                <li><a href=""><img src="<?php bloginfo('template_directory'); ?>/images/logo-musicians.png" /></a></li>
                <li><a href=""><img src="<?php bloginfo('template_directory'); ?>/images/logo-iatsel.png" /></a></li>
            </ul>
        </div>
    </div>
</footer>
<?php echo do_action('ci_after_footer'); ?>

<?php wp_footer(); ?>
</body>
</html>
