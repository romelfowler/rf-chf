<?php

class CI_Grid {
    
    public function __construct() {
        add_shortcode('one_third', array($this, 'ci_one_third'));
        add_shortcode('two_third', array($this, 'ci_two_third'));
        add_shortcode('one_half', array($this, 'ci_one_half'));
        add_shortcode('row', array($this, 'ci_row'));
    }
    
    
    
    /**
     * One Third Div for Twitter Bootstrap
     * 
     * @param type $atts
     * @param type $content
     * @return type
     */
    public function ci_one_third( $atts, $content = null ){
        return '<div class="col-sm-4">'.do_shortcode($content).'</div>';
    }
    
    
    
    /**
     * Two Third Div for Twitter Bootstrap
     * 
     * @param type $atts
     * @param type $content
     * @return type
     */
    public function ci_two_third( $atts, $content = null ){
        return '<div class="col-sm-8">'.do_shortcode($content).'</div>';
    }
    
    
    
    /**
     * One Half Div for Twitter Bootstrap
     * 
     * @param type $atts
     * @param type $content
     * @return type
     */
    public function ci_one_half( $atts, $content = null ){
        return '<div class="col-sm-6">'.do_shortcode($content).'</div>';
    }
    
    
    
    /**
     * Row Div for Twitter Bootstrap
     * 
     * @param type $atts
     * @param type $content
     * @return type
     */
    public function ci_row( $atts, $content = null ){
        return '<div class="row">'.do_shortcode($content).'</div>';
    }
}

new CI_Grid();