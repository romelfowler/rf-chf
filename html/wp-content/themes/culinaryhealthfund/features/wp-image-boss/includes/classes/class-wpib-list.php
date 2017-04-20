<?php

/*
 * Class is used to list images with 
 * ability to exclude images on certain pages
 * through shortcode variable
 */

class WPIB_List {
    
    public function __construct() {
        add_shortcode('wpib_imagelist', array($this, 'wpib_image_list'));
    }
    
    
    
    
    public function wpib_image_list($atts, $content = null){
        global $post;
        
        // initiate html variable
        $html = '';
        
        ob_start();
        extract(shortcode_atts(array(
                    'id' => 'id',
                    'excl' => null,
                        ), $atts));
        
        // Get our images
        $slide_img = maybe_unserialize( get_post_meta( $id, '_image', true ) );
        
        // Get our links
        $slide_link = maybe_unserialize( get_post_meta( $id, '_img_link', true ) );
        
        // Get our links
        $img_desc = maybe_unserialize( get_post_meta( $id, '_img_desc', true ) );
        
        // Count number of image in the array
        $count = count($slide_img);
        
        // Image ids to exlcude
        $leave_out = array();
        
        // if $excl is not empty
        if($excl != null)
            $leave_out = explode(",", $excl);
        
        $countImages = 0;

        foreach($slide_img as $new_img) {
            if(!in_array($countImages, $leave_out)) {
                $content = '<div class="list-img"><a href="'.$slide_link[$countImages].'"><img src="'.$slide_img[$countImages].'" /></a></div>';
                
                if (has_filter('wpib_output')) {
                    $filterVals = array( $slide_link[$countImages], $slide_img[$countImages], $img_desc[$countImages]);
                    $html .= apply_filters('wpib_output', $filterVals);
                } else {
                    $html .= $content;
                }
            }
            
            $countImages++;
        }
  
                
        
        $output = ob_get_clean();
        
        return $html . $output;
        
    }
}


/* Initialize Image List */
new WPIB_List();