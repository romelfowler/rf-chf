<?php

class CI_Font_Awesome {
    public function __construct(){
        add_shortcode('icon', array($this, 'ci_icons'));
    }
    
    public function ci_icons($atts, $content = null){
        extract(shortcode_atts(array(
                    'class' => 'class'
                        ), $atts));
        return '<i class="'.$class.'"></i>';
    }
}

new CI_Font_Awesome();
