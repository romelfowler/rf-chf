<?php

class CI_Theme_Options {
    
    public static $options;
    
    public function __construct() {
        static::$options = get_option('ci');
        add_action('wp_head', array($this, 'ci_head_hook'));
        add_action('wp_footer', array($this, 'ci_footer_hook'));
        add_action( 'login_enqueue_scripts', array($this, 'ci_login_logo' ));   
            
    }
    
    
    /* =========================================================================
     * General Options
     * ========================================================================*/
    
    /*
     * Logo Option
     */
    static function ci_get_theme_logo(){
        $logo = (!empty(static::$options['ci_logo_upload']['url'])) ? '<img src="'.static::$options['ci_logo_upload']['url'].'" alt="'.get_bloginfo('url').'" />' : get_bloginfo('name');
        return '<a href="'.home_url('/').'" class="navbar-brand">'.$logo.'</a>';
    }
    
    
    /*
     * Login Logo
     */
    public function ci_login_logo() {
        if(empty(static::$options['ci_logo_upload']['url'])) 
            return;
        
        $logo = static::$options['ci_logo_upload']['url']; ?>
        <style type="text/css">
            body.login div#login h1 a {
                background-image: url(<?php echo $logo ?>);
                padding-bottom: 0;
                background-size: 65%;
                width: 100%;
            }
        </style>        
    <?php }
    
    /* =========================================================================
     * Header Options
     * ========================================================================*/
    /*
     * Fixed header on scroll
     */
    static function ci_header_class($padding = false){           
        
        $class = (static::$options['ci_header_position']) ? 'navbar-static-top' : 'navbar-static-top';
        if($padding) {
            if($class == 'navbar-fixed-top' && !static::$options['ci_default_header']) {
                $class = '0px';
            } elseif($class == 'navbar-fixed-top' && static::$options['ci_default_header']) {
                $class = '18px';
            } else {
                $class = '0px';
            }
        }
        
        return $class;
    }
    
    /*
     * Show and hide page headers
     */
    static function ci_page_headers(){
        if(!static::$options['ci_default_header'] || is_home() || is_front_page() )
            return;
        
        if(function_exists('get_field') && get_field('ci-image-header')) {
                $img = get_field('ci-image-header');
        } else {
            $img = static::$options['ci_default_header_img']['url'];
        }
        
        return '<div class="ci-image-header"><img src="'.$img.'"/></div>';
    }
    
    
    /* =========================================================================
     * Home Page Options
     * ========================================================================*/
    static function ci_hero_content(){
        $default = '<div class="default-wraper"><h1 class="default">Welcome to your new Theme!</h1><p class="default">This is some cools stuff about our theme you should know about.</p><a href="" class="btn btn-lg btn-primary default">Learn More</a></div>';
        $content = (static::$options['ci_hero']) ? static::$options['ci_hero'] : $default;
        return $content;
    }
    

    /* =========================================================================
     * Blog Options
     * ========================================================================*/
    
    /*
     * Blog Featured Image
     */
    static function ci_get_featured_image(){
        global $post;
        if(!static::$options['ci_blog_featured_img'])
            return;
        
        $featured_img = (has_post_thumbnail()) ? get_the_post_thumbnail($post->ID, 'full', array('class' => 'featured-img')) : '<img src="'.get_template_directory_uri().'/images/defaults/blog-826x305.jpg" class="featured-img" />';
        
        return '<div class="featured-img-wrap"><a href="'.get_permalink() . '">'.$featured_img.'</a></div>';

    }
    
    
    /*
     * Blog Learn More Button
     * 
     * view functions.php for helper code
     */
    static function ci_get_learn_more(){
        $text = (static::$options['ci_learn_more_text']) ? static::$options['ci_learn_more_text'] : 'Continue Reading &rarr;';
        return '<p><a class="btn btn-primary btn-lg" href="' . esc_url(get_permalink()) . '">' . __($text, 'codeless') . '</a></p>';
    }
    
    
    /*
     * Toggle between excerpt
     * and content for blog posts
     */
    static function ci_blog_display(){
        //ci_blog_display
        if(static::$options['ci_blog_display'] == true) {
            return get_the_content();
        } else {
            return get_the_excerpt();
        }
    }
    
    
    /*
     * Blog Meta Data
     */
    static function ci_get_meta(){
        if(!static::$options['ci_blog_meta'])
            return;

        echo '<div class="meta"><ul><li><i class="fa fa-user"></i> ' . get_the_author() . '</li> <li><i class="fa fa-calendar"></i>  ' . get_the_time('M d, Y') . '</li><li><i class="fa fa-comment"></i> ' .  get_comments_number() . ' Comments</li></ul></div>';
    }
    
    
    /* =========================================================================
     * Footer Options
     * ========================================================================*/
    
    /*
     * Below Footer Navigation
     */
    static function ci_below_footer_copy(){
        if(!static::$options['ci_copyrights'])
            return;
        
        return '<div class="copyright">'.static::$options['ci_copyrights'].'</div>';
    }
    
    
    /* =========================================================================
     * Social Options
     * ========================================================================*/
    static function ci_get_social(){
        $social = array(
            'facebook' => static::$options['ci_social_facebook'], 
            'twitter' => static::$options['ci_social_twitter'],
            'linkedin' => static::$options['ci_social_linkedin'],
            'google' => static::$options['ci_social_google']
            );

        if(!empty($social)) {
            $html = '<div class="social">';
            foreach($social as $key => $value) {
                if($value != '') { 
                    $html .= '<li><a href="'.$value.'" id="'.$key.'" target="_blank"></a></li>';
                }
            }
            $html .= '</div>';
        }
        
        return $html;
    }

    
    /* =========================================================================
     * Scripts and Styles
     * ========================================================================*/
    
    
    /*
     * wp_head hook data
     * styles ext
     */
    public function ci_head_hook(){
        
        $body_padding = static::ci_header_class(true);
        
        // this works and ready for custom styles
        $background_color = (static::$options['ci_background_color']) ? static::$options['ci_background_color'] : '';

        /* Fonts */
        $font_size = (static::$options['ci_font_size']) ? static::$options['ci_font_size'] : '';
        $header_bg_color = (static::$options['ci_header_background_color']) ? static::$options['ci_header_background_color'] : '';
        $link_color = (static::$options['ci_link_color']) ? static::$options['ci_link_color'] : '';
        
        /* Breadcrumbs */
        $bc_link_color = (static::$options['ci_breadcrumb-links']) ? static::$options['ci_breadcrumb-links'] : '';

        /* Blog */
        $btn_color = (static::$options['ci_button_color']) ? static::$options['ci_button_color'] : '';
        $btn_bg_color = (static::$options['ci_button_bg_color']) ? static::$options['ci_button_bg_color'] : '';
        $btn_hover_color = (static::$options['ci_button_hover_bg']) ? static::$options['ci_button_hover_bg'] : '';
        $nav_bg = (static::$options['ci_nav_bgs']) ? static::$options['ci_nav_bgs'] : '';
        $bread_bg = (static::$options['ci_breadcrumbs_bg_color']) ? static::$options['ci_breadcrumbs_bg_color'] : '';
        
        $footer_bg = (static::$options['ci_footer_bg_color']) ? static::$options['ci_footer_bg_color'] : '';
        $footer_color = (static::$options['ci_footer_color']) ? static::$options['ci_footer_color'] : '';
        ?>
        <style type="text/css">
            body {
                background-color: <?php echo $background_color; ?>;          
                padding-top: <?php echo $body_padding; ?>;
            }
            
            .navbar-inverse {
                background-color: <?php echo $header_bg_color; ?>;
            }

            .btn-primary:hover, .btn-primary:focus, .btn:hover, .btn:active, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary, 
            .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .pagination a:hover, .pagination span.current, .reply a:hover {
                background: <?php echo $btn_hover_color; ?>;
            }
            
            header .menu li a:hover, header .menu li ul.children li a:hover, .menu li ul.sub-menu li a:hover {
                color: <?php echo $nav_bg['hover']; ?>;
                text-decoration: none;
            }
            
            header .menu li.current_page_item a, header .menu li.current_page_parent a, header .menu li ul.children li.current_page_item a, .menu li a, header .menu li ul.sub-menu li.current_page_item a {
                color: <?php echo $nav_bg['active']; ?>;
                text-decoration: none;
            }
            
            a.btn, a.btn-primary, input[type="submit"], 
            .pagination a, .pagination span, .reply a, .navbar-inverse .navbar-toggle .icon-bar  {
                background-color: <?php echo $btn_bg_color ?>;
                color: <?php echo $btn_color ?> !important;
            }
            
            a, a:visited, .primary-ctas i, .navbar-inverse .navbar-brand, .navbar-inverse .navbar-brand:focus {
                color: <?php echo $link_color['regular']; ?>;
            }
            
            a:hover, .navbar-inverse .navbar-brand:hover {
                color: <?php echo $link_color['hover']; ?>;
            }
            
            .ci-breadcrumbs, .testimonials {
                background: <?php echo $bread_bg; ?>
            }
            
            .ci-breadcrumbs a, .breadcrumbs {
                color: <?php echo $bc_link_color['regular']; ?>
            }
            
            .ci-breadcrumbs a:hover {
                color: <?php echo $bc_link_color['hover']; ?>
            }
            
            .ci-breadcrumbs span.current {
                color: <?php echo $bc_link_color['active']; ?>
            }
            
            footer {
                background: <?php echo $footer_bg; ?>;
                color: <?php echo $footer_color; ?>;
            }
            
            footer a, footer a:visited, footer a:active, footer .menu li a {
                color: <?php echo $footer_color; ?>;
            }
            
            footer a:hover, footer .menu li a:hover {
                color: <?php echo $nav_bg['hover']; ?>;
            }
            
         </style>
         <?php
      
    }
    
    
    /*
     * wp_footer hook data
     * tracking ext
     */
    public function ci_footer_hook(){
        if(!static::$options['ci_tracking_code'])
            return;
        
        echo '<script>' . static::$options['ci_tracking_code'] . '</script>';
    }
}

new CI_Theme_Options();