<?php

class JDev_Accordion {
    
    public function __construct() {
        add_shortcode('accordion-wrap', array($this, 'jdev_accordion_wrap'));
        add_shortcode('accordion', array($this, 'jdev_accordion_title'));
        // Include jquery ui files
        add_action('wp_enqueue_scripts', array($this, 'jdev_include_accordion_js'));
    }
    
    
    public function jdev_include_accordion_js(){
            wp_enqueue_script('jquery-ui-accordion');
            wp_enqueue_style('jquery-accordion-css', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
        }
    
    
    /**
     * Accordion JQuery UI, Wrapper
     * 
     * @param type $atts
     * @param type $content
     * @return type
     */
    public function jdev_accordion_wrap( $atts, $content = null ){
        return '<div id="accordion">'.do_shortcode($content).'</div>';
    }
    
    
    
    /**
     * Accordion JQuery UI, title
     * 
     * @param type $atts
     * @param type $content
     * @return type
     */
    public function jdev_accordion_title( $atts, $content = null ){
         extract(shortcode_atts(array(
                    'title' => 'title'
                        ), $atts));
        
        return '<h3>' . $title . '</h3><div>' . do_shortcode($content) . '</div>';
    }
}

new JDev_Accordion();