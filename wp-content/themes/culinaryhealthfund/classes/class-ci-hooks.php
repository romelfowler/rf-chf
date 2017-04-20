<?php

class CI_Hooks {
    public static $options;
    
    public function __construct() {
        static::$options = get_option('ci');
        add_action('ci_favicon', array($this, 'ci_favicon_hook'));
    }
    
    
    /*
     * Favicon Hook
     * Action is located in header.php
     */
    public static function ci_favicon_hook(){
        if(!static::$options['ci_favicon_upload'])
            return;
        
        echo '<link rel="icon" href="'.static::$options['ci_favicon_upload']['url'].'" />';
    }
}


new CI_Hooks();