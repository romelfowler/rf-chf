<?php
/**
 * Description of Slide_Js_Setup is to 
 * setup the plugin with a CPT.
 *
 * @author Jeff Clark
 */


class WPIB_Setup {
    
    var $slide_post_key = "wpib-images";
    var $slide_post_name = "Image Boss";
    var $slide_post_single_name = "Image Boss";
    var $slide_post_slug = "wpib-images";
    var $slide_supports = array('title');
    
    
    
    
    public function __construct() {
        add_action('init', array($this, 'wpib_create_custom_post_type'));
        add_action('admin_enqueue_scripts', array($this, 'wpib_include_files'));
        
        // ADDING COLUMNS TO SHOW SHORTCODE  
        add_filter('manage_wpib-images_posts_columns', array($this, 'wpib_add_cpt_column_titles'));  
        add_action('manage_wpib-images_posts_custom_column', array($this, 'wpib_add_cpt_column_content'));

    }
    
    
    
    
    public function wpib_include_files(){
        
        global $post;
        $post_type = get_post_type($post);
        
        if(is_admin() & $post_type == 'wpib-images' ){ 
            wp_enqueue_style('wpib-styles', WPIB_BASE_URL . 'admin/css/admin-style.css');
            
            /* Image Uploader */
            wp_enqueue_media(); // For new media uploader */
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('image-upload', WPIB_BASE_URL . 'admin/js/image.js');
            wp_enqueue_style( 'thickbox' );
            
            wp_enqueue_script('slide', WPIB_BASE_URL . 'admin/js/slideshow.js');
            
            
            /* Sortable Scripts */
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-sortable'); 
            wp_enqueue_script('jquery-ui-tabs');
            
            
        }
    }
    
    
    
    
    public function wpib_create_custom_post_type(){        
        register_post_type( $this->slide_post_key,                
                array(                   
                    'labels' => array(
                    'name' => __($this->slide_post_name),
                    'singular_name' => __($this->slide_post_single_name),
                    ),
                    'public' => true,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'exclude_from_search' => true,
                    'hierarchical' => false,
                    'rewrite' => array('slug' => $this->slide_post_slug),
                    'supports' => $this->slide_supports,
                )
            
        );      
    }
    
    
    
    
    public function wpib_add_cpt_column_titles($defaults){
        $defaults['short_code'] = 'Shortcode';  
        return $defaults;  
    }
    
    
    
    
    public function wpib_add_cpt_column_content($column_name){
        global $post;
        
        if ($column_name == 'short_code') {  
            echo '[wpib_slideshow id="'.$post->ID.'"]';
        }  

    }
    
    
    

}