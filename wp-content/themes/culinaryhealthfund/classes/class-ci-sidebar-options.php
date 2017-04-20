<?php

/*
 * CI Sidebar Options allows
 * you select any sidebar for you
 * page template
 * 
 * @todo create ability for custom post types to be saved, maybe hook or variable array?
 */

class CI_Sidebar_Options {
    public function __construct() {
        /* Create Meta Box */
        add_action('add_meta_boxes', array($this, 'ci_sidebar_meta_box'));
        
        /* Save Data */
        add_action('publish_page', array($this, 'ci_sidebar_save_fields'));
        add_action('publish_post', array($this, 'ci_sidebar_save_fields'));
        add_action('publish_products', array($this, 'ci_sidebar_save_fields'));
    }

    
    
    /**
     * Setup a meta box for our slides
     */
    public function ci_sidebar_meta_box(){
          add_meta_box( 
                'page',
                __( 'Sidebars', 'ci-sidebars' ),
                array($this, 'ci_sidebar_box_content'),
                '',
                'side',
                'core'
            );
          
    }
    
       
    
    /**
     * Slideshow images, links,
     * and position.
     * 
     * @global type $post 
     */
    public function ci_sidebar_box_content(){
        global $post;
        
        $sidebars = get_post_meta( $post->ID, '_ci_sidebar', true );
        ?>
        <h4>Must be using 2 Column page template for sidebars to take effect!</h4>
        <select name="ci_sidebar">
        <?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { ?>
            <?php $selected = ($sidebars == $sidebar['id']) ? 'selected' : ''; ?>
            <option value="<?php echo $sidebar['id']; ?>" <?php echo $selected; ?>><?php echo ucwords($sidebar['name']); ?></option>
        <?php } ?>
        </select>
        <?php 
           
    }
    
    
    
    /**
     * Save all fields generated
     * through the slideshow plugin.
     * 
     * @global type $post 
     */
    public function ci_sidebar_save_fields(){
        global $post;
        if( $_POST ) { // make sure to setup the nonce
            $sidebar = $_POST['ci_sidebar'];
            update_post_meta( $post->ID, '_ci_sidebar', $sidebar); 
        }
    }
}

new CI_Sidebar_Options();