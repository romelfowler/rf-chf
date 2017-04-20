<?php

// News blog posts
// Slideshow
// Blank Space
// 3-4 CTA's

class CI_Home_Page {
    public static $options;
    
    public function __construct(){
        static::$options = get_option('ci');
    }
    
    static function ci_get_home_page(){
        if(empty(static::$options['homepage_blocks']['enabled'])) {
            static::ci_get_static_hero();
            static::ci_get_ad_block();
            return;
        }
        
        
        foreach(static::$options['homepage_blocks']['enabled'] as $enabled){
            switch($enabled){
                case 'Static Hero' :
                    static::ci_get_static_hero();
                    break;
                case 'Slider' :
                    static::ci_get_slideshow();
                    break;
                case 'Ad Block' :
                    static::ci_get_ad_block();
                    break;
                case 'CTA Block' :
                    static::ci_get_cts();
                    break;
                case 'News Block' :
                    static::ci_news_block();
                    break;
                default :
                    break;
            }
        };
    }
    
    
    /*
     * Get contents for 
     * the static hero block
     */
    public static function ci_get_static_hero(){
        $default = '<h1 class="default" align="center">Welcome to your new Theme!</h1><p align="center" class="default">This is some cools stuff about our theme you should know about.</p><p align="center" class="default"><a href="" class="btn btn-lg btn-primary default">Learn More!</a></p>';
        $content = (static::$options['ci_hero']) ? static::$options['ci_hero'] : $default;
        echo do_action('ci_before_hero');
        echo '<div class="hero-wrapper"><div class="container">';
        echo do_action('ci_before_hero_content');
        echo $content;
        echo do_action('ci_after_hero_content');
        echo '</div></div>';
        echo do_action('ci_after_hero');
    }
    
    
    /*
     * Home Page slideshow
     */
    public static function ci_get_slideshow() {
        echo do_shortcode(static::$options['ci_select_slider']);
    }
    
    
    public static function ci_get_cts() {
        $category = (static::$options['ci_cta_category']) ? static::$options['ci_cta_category'] : '';
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'category__in'   => array($category)
        );
        
        $cta = new WP_Query($args);
        
        echo '<div class="cta-block"><div class="container"><div class="row">';
        if($cta->have_posts()) {
            while($cta->have_posts()) : $cta->the_post();
                echo '<div class="col-md-4"><div class="primary-ctas">';
                echo do_shortcode( get_the_content() );
                echo '</div></div>';
            endwhile;
        } else {
            echo 'Nothing currently exists';
        }
        echo '</div></div></div>';
        wp_reset_query();
    }
    
    
    public static function ci_get_ad_block(){
        echo static::$options['ci_ad_block'];
        if(empty(static::$options['ci_ad_block']) || !static::$options['ci_ad_block'] ) {
            echo '<div class="block ci-adblock"><div class="container"><div class="row">';
            echo '<div class="col-md-9">Multipurpose business theme developed to get you off the ground fast.  Gravity is packed with features and SEO ready.</div>';
            echo '<div class="col-md-3"><a href="" class="btn btn-lg alignright">Download Now</a></div>';
            echo '</div></div></div>';
        } else {        
            echo '<div class="block ci-adblock"><div class="container">';
            echo do_shortcode(static::$options['ci_ad_block']);
            echo '</div></div>';
        }
    }
    
    
    public function ci_news_block(){
        $html = '<div class="container newsblock">';
        $html .= static::ci_get_about_copy();
        $html .= static::ci_get_blog_posts();
        $html .= '</div> <!--/container -->';
        
        echo $html;
    }
    
    
    /**
     * Get blog posts based
     * on category selected in
     * backend
     * @return type
     */
    public static function ci_get_blog_posts(){
        global $ci_excerpt_length, $ci_read_more_class;
        $ci_excerpt_length = 10;
        $ci_read_more_class = 'btn';
        $cat = (static::$options['ci_blog_posts']) ? static::$options['ci_blog_posts'] : '';
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 2,
            'category__in'   => array($cat)
        );
        
        $loop = new WP_Query($args);
        
        $html = '<div class="col-md-5">'; 
        $html .= '<h2 class="sm-title"> From The Blog </h2>';
            if($loop->have_posts()) :
                while($loop->have_posts()) : $loop->the_post();
                    $thumb = (has_post_thumbnail()) ? get_the_post_thumbnail(get_the_ID(), 'thumbnail', array('class' => 'featured-img')) : '<img src="'.get_template_directory_uri().'/images/defaults/blog-138x136.jpg" class="featured-img" width="150" />';
                    
                    $html .= '<div class="sm-post-wrap">';
                    $html .= '<div class="col-sm-4 post-thumb">';
                    $html .= '<a href="' . get_permalink() . '">' . $thumb . '</a>';
                    $html .= '</div> <!-- /col-sm-4 -->';
                    $html .= '<div class="col-sm-8">';
                    $html .= '<h4>' . get_the_title() . '</h4>';
                    $html .= '<p>' . get_the_excerpt() . '</p>';
                    $html .= '</div> <!-- /col-sm-8 -->';
                    $html .= '</div> <!-- /sm-post-wrap -->';
                endwhile;
            endif;
        $html .= '</div> <!--/col-sm-5 -->';
        wp_reset_query();
        return $html;
        
    }
    
    
    public static function ci_get_about_copy(){
        $html = '<div class="col-md-7">';
        if(!static::$options['ci-aboutus-copy']) {
            $html .= '<h3>About Us</h3> <p>We are a digital marketing consultancy focused on creating contemporary, results-driven websites and boosting your bottom line through inbound marketing and our unique blend of technical + marketing know-how.</p>';
        } else {
            $html .= static::$options['ci-aboutus-copy'];
        }
        $html .= '</div><!--/col-md-7 -->';
        return $html;
    }
    
    
}

new CI_Home_Page();