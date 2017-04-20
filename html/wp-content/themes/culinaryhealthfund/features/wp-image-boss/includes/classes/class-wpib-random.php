<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class WPIB_Random {
    
    
    
    public function __construct() {
        //create our random image shortcode
        add_shortcode('wpib_random', array($this, 'wpib_randomize_shortcode'));
    }
    
    
    
    
    public function wpib_randomize_shortcode($atts, $content = null) {
        global $post;
        
        ob_start();
        extract(shortcode_atts(array(
                    'id' => 'id',
                        ), $atts));
         
        // Get our images
        $slide_img = maybe_unserialize( get_post_meta( $id, '_image', true ) );
        
        // Get our links
        $slide_link = maybe_unserialize( get_post_meta( $id, '_img_link', true ) );
        
        
        // Count number of image in the array
        $count = count($slide_img) - 1;
        
        // Loop through our images for output in random order
        $get_slide = rand(0, $count);
        
        // HTML for output of our random image
        $html = '<a href="'.$slide_link[$get_slide].'"><img src="'.$slide_img[$get_slide].'" /></a>';
        
        $output = ob_get_clean();
        
        return $html . $output;
    }
    
}


/* Initialize WPIB Random */
new WPIB_Random();