<?php


    if(!defined( 'WPIB_BASE_URL' )) {
        define( 'WPIB_BASE_URL', get_template_directory_uri() . '/features/wp-image-boss/' ); 
    }
    
    
    
    /* WPIB INCLUDES */
    include_once dirname( __FILE__ ) . '/admin/classes/class-wpib-setup.php';
    include_once dirname( __FILE__ ) . '/admin/classes/class-wpib-meta-data.php';
    include_once dirname( __FILE__ ) . '/includes/classes/class-wpib-images.php';
    include_once dirname( __FILE__ ) . '/includes/classes/class-wpib-list.php';
    include_once dirname( __FILE__ ) . '/includes/classes/class-wpib-random.php';
    include_once dirname( __FILE__ ) . '/includes/classes/class-wpib-minimal.php';
    
    
    
    
    /* SLIDESHOW SETUP */
    new WPIB_Setup();
    
    /* SLIDESHOW META BOX */
    new WPIB_Meta_Data();
    
    /* SLIDESHOW SHORTCODE */
    new WPIB_Images();
    