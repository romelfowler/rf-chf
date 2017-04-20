<!-- Footer
================================================== -->
<?php echo do_action('ci_before_footer'); ?>
<footer>

    <div class="col-md-12 sponsors">
      <ul>
          <li><a href="http://www.culinaryunion226.org/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/logo-culinary.png" /></a></li>
            <li><a href="http://www.culinarypension.org/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/logo-pension.png" /></a></li>
            <li><a href="http://musicianslasvegas369.com/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/logo-musicians.png" /></a></li>
            <li><a href="http://www.iatselocal720.com/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/logo-iatsel.png" /></a></li>
            <li><a href="https://www.uniteherehealth.org/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/logo-uhh.png" /></a></li>
            <li><a href="http://herelocal165.org/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/logo-local165.png" /></a></li>
        </ul>
    </div>
    <?php wp_nav_menu(array('menu' => 'footer')); ?>

    <div class="container">
		<div class="col-md-6">
        	<p>&copy; Culinary Health Fund</p>
            <ul>
            	<li>1901 Las Vegas Blvd. South, Suite 107, Las Vegas, NV 89104</li>   |
                <li>Phone: 702-733-9938</li>   |
                <li>Fax: 702-733-0989</li>
            </ul>
            <i id="facebook" class="fa fa-facebook-square" aria-hidden="true"><a href="https://www.facebook.com/CulinaryHealthFund" target="_blank"></a></i>

        </div>
    </div>


</footer>
<?php echo do_action('ci_after_footer'); ?>

<?php wp_footer(); ?>

</body>
</html>
