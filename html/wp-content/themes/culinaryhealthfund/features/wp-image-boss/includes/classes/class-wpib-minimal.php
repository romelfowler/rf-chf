<?php

/* WPIB Minimal will return basic info for templating
 * 
 */

class WPIB_Minimal {
    
    public $img_link;
    public $img;
    public $img_desc;
    public $link_target;
    public $group_id;
    
}



    function wpib_get_object_vars( $post_id ) {
        
        $wpib_vars = new WPIB_Minimal();
        
        $id = $post_id;
        
        // Set our variables
        $wpib_vars->img = maybe_unserialize( get_post_meta( $id, '_image', true ) );
        $wpib_vars->img_link = maybe_unserialize( get_post_meta( $id, '_img_link', true ) );
        $wpib_vars->img_desc = maybe_unserialize( get_post_meta( $id, '_img_desc', true ) );    
        $wpib_vars->link_target = maybe_unserialize( get_post_meta( $id, '_link_target', true ) );
        $wpib_vars->group_id = (get_post_meta( $id, '_div_id', true )) ? get_post_meta( $id, '_div_id', true ) : 'carousel';  
        
        //var_dump($wpib_vars->img);
        return $wpib_vars;
    }