<?php

     /**
      * Create our custom post types here.
      * This will reference our Custmo Post Types Class
      * classes/class.Custom_Post_Types.php
      * 
      *     $CiPostKey :  your CPT's unique key ex: my_post_name_key
      * 
      *     $CiPostName : The name of your CPT, ex: My Post Name
      * 
      *     $CiPostSingleName : The singular name, ex: My Post Name
      * 
      *     $CiPostSlug : The url extension for you post, ex: my-post-name
      *     
      * 
      * 
      * EXAMPLE USAGE --------------------------------------------------------------
      * 
      * Custom_Post_Type($CiPostKey, $CiPostName, $CiPostSingleName, $CiPostSlug)
      * 
      * Add the lines below to your functions.php file,
      * make sure you path is correct
      * 
      *     require_once('classes/class.Custom_Post_Types.php');
      *     $customPostType = new Custom_Post_Types('Ci_events', 'Events', 'Event', 'Ci-event', 'post icon url');
      * 
      * Setting these variables in your functions.php file will
      * allow you to make your CPT have a Hierarchical structure, default is false
      *
      *     $customPostType->CiHierarchical = true;
      * 
      * Settings for what your CPT supports, must be an array!!!
      * 
      *     $customPostType->CiSupports = array( 'title', 'editor', 'thumbnail', 'page-attributes' );
      * 
      * @author Jeff Clark
      * 
      */


class CI_CPT {
   
    // Variables passed to the contructor
    var $CiPostKey;
    var $CiPostName;
    var $CiPostSingleName;
    var $CiPostSlug;
    var $CiPostIcon;
    var $CiPostIconStr;
    
    // More Variables
    var $CiHierarchical = false;
    var $CiSupports = array();
    
    
    
    
    /*
     * Constructor to run everything
     */
    public function __construct( $CiPostKey, $CiPostName, $CiPostSingleName, $CiPostSlug, $CiPostIcon = '' ) {
                
        $this->CiPostKey = $CiPostKey;
        $this->CiPostName = $CiPostName;
        $this->CiPostSingleName = $CiPostSingleName;
        $this->CiPostSlug = $CiPostSlug;
        $this->CiPostIcon = $CiPostIcon;

        $this->Ci_test_icon();
        
        add_action( 'init', array($this, 'Ci_create_post_type'));
        
    }
    
    
    
    /*
     *  Test if the Post Icon variable is empty or not
     */
    public function Ci_test_icon() {
        
        if( $this->CiPostIcon == '' ) {
            $this->CiPostIconStr = false;
        } else {
            $this->CiPostIconStr = get_template_directory_uri() . '/images/' . $this->CiPostIcon;
        }
    }
    
    
    
    /*
     * Lets go ahead and create our portfolio post type
     */
    public function Ci_create_post_type() {
       
        register_post_type( $this->CiPostKey,
                
                array(
                    
                    'labels' => array(
                        'name' => __( $this->CiPostName ),
                        'singular_name' => __( $this->CiPostSingleName ),
                        'add_new_item' => __('Add New ' . $this->CiPostSingleName),
                        'edit_item' => __('Edit ' . $this->CiPostSingleName),
                        'all_items' => __('All ' . $this->CiPostName),
                        'view_item' => __('View ' . $this->CiPostSingleName),
                        'search_items' => __('Search ' . $this->CiPostName ),
                        'not_found' => __('No ' . $this->CiPostName . ' found'),
                        'not_found_in_trash' => __('No ' . $this->CiPostName . ' found in trash')
                    ),
                    
                'public' => true,
                'show_ui' => true,    
                'show_in_menu' => true,
                'hierarchical' => $this->CiHierarchical,
                'rewrite' => array( 'slug' => $this->CiPostSlug ),
                'supports' => $this->CiSupports,
                'menu_icon' => $this->CiPostIconStr
                )
            
        );
           
    }
    
}