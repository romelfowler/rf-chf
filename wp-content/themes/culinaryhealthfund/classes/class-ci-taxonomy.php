<?php

     /*
     * Create our Taxonomies
     * Create a new instance of our customTaxonomy Class and pass it the parameters needed to create
     * a new Taxonomy. It takes 4 parameters. Must be using the Ci plugin
     * 
     * Custom_Taxonomy($ciTaxKey, $ciPostType, $ciTaxTitle, $ciTaxSlug)
     * 
     * require_once('classes/class.Custom_Taxonomy.php'); 
     * $customTaxonomy = new Custom_Taxonomy( 'zoo_event_types', 'ci_events', 'Event Types', 'zoo-event-types', 'post');
     * 
     * @author Jeff Clark
     *  
     */
     


class CI_Taxonomy {
    
    //establish some variables
    var $ciTaxKey;
    var $ciPostType;
    var $ciTaxTitle;
    var $ciTaxSlug;
    
    
    
    //create our construct function to run our hooks and filters
    public function __construct($ciTaxKey, $ciPostType, $ciTaxTitle, $ciTaxSlug) {
        
        $this->ciTaxKey = $ciTaxKey;
        $this->ciPostType = $ciPostType;
        $this->ciTaxTitle = $ciTaxTitle;
        $this->ciTaxSlug = $ciTaxSlug;
                
        add_action( 'init', array( $this, 'ci_create_taxonomy') );
        
    }
    
    
    
    //create our taxonomy
    public function ci_create_taxonomy() {
        
        register_taxonomy( 
                $this->ciTaxKey, 
                $this->ciPostType,
                array(
                    'hierarchical' => true,
                    'label' => $this->ciTaxTitle,
                    'query_var' => true,
                    'rewrite' => array( 'slug' => $this->ciTaxSlug )
                )
         );
        
    }
    
    
}

?>
