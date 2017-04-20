<?php

class CI_Subnav {
    
    public function __construct() {
        add_shortcode('wpnb_subnav', array($this, 'wpnb_get_secondary_nav'));
        add_shortcode('wpnb_subnav_menu', array($this, 'wpnb_get_secondary_nav_menu'));
        add_action('wp_enqueue_scripts', array($this, 'wpnb_include_styles'));
    }
    
    
    
    
    /* Include styles */
    public function wpnb_include_styles() {
        //wp_enqueue_style('nav-styles', WPNB_BASE_URL . 'includes/css/nav.css');
    }
    
    
    
    
    public function wpnb_get_secondary_nav($atts, $content = null){        
        extract(shortcode_atts(array(
                    'cpt' => 'cpt'
                        ), $atts));
        
        $cpt = ($cpt) ? $cpt : 'page';
        
        global $wpdb, $post;

        $ansestors = get_post_ancestors($post->ID); // Get number of ansestors
        $numAnsestors = count($ansestors); // Count number of ansestors
         
        switch($numAnsestors) {
            case 1 :
                $parent = wp_list_pages("sort_column=ID&title_li=&include=" . $post->post_parent . "&echo=0");
                $children = wp_list_pages("&sort_column=menu_order&title_li=&child_of=" . $post->post_parent . "&echo=0&depth=2");
                //$children = 'second level';
                break;
            case 2 :
                //$children = 'third level';
                $topParent = $ansestors[1]; /// get the top most parent
                
                $parent = wp_list_pages("sort_column=ID&title_li=&include=" . $topParent . "&echo=0");
                $children = wp_list_pages("&sort_column=menu_order&title_li=&child_of=" . $topParent . "&echo=0&depth=3");
                break;
            default :
                //$children = 'first level';
                $parent = wp_list_pages("sort_column=ID&title_li=&include=" . $post->ID . "&echo=0&depth=1");
                $children = wp_list_pages("sort_column=menu_order&title_li=&child_of=" . $post->ID . "&echo=0&depth=1");
                break;
            
        }
        
        
        // The output of the navigation
        if($parent){
            echo $parent;
        }
        if ($children) {
            echo '<ul class="sidebar-nav">';
            echo $children;   
            echo '</ul>';
        }
    }
    
    
    public function wpnb_get_secondary_nav_menu($atts, $content = null){
        global $post;

        extract(shortcode_atts(array(
                    'menu' => 'menu'
                        ), $atts));
        
        $menu = ($menu) ? $menu : 'primary';
        
        return wp_nav_menu(array('menu' => $menu, 'echo' => false, 'menu_class' => 'sidebar-nav', 'walker'=>new Selective_Walker()));
    }
        
}

new CI_Subnav();
