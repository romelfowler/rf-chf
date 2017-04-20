<?php
require_once(get_template_directory().'/classes/class-ci-cpt.php');

class CI_Testimonials extends CI_CPT {
    
    public $ciPostKey = 'testimonials';
    public $ciPostName = 'Testimonials';
    public $ciPostSingleName = 'Testimonial';
    public $ciPostSlug = 'testimonial';
    
    
    public function __construct(){
        parent::__construct($this->ciPostKey, $this->ciPostName, $this->ciPostSingleName, $this->ciPostSlug);
        $this->CiSupports = array('title', 'editor', 'thumbnail', 'revisions');
        add_shortcode('ci_testimonials', 'ci_get_testimonials');
    }
    
    public function ci_get_testimonials($count = 2){
        $args = array(
            'post_type' => 'testimonials',
            'posts_per_page' => $count
        );
        
        $testimonails = new WP_Query($args);
        
        if($testimonails->have_posts()) {
            $html = '<div class="row">';
            while($testimonails->have_posts()): $testimonails->the_post();
                $html .= '<div class="testimonial col-sm-6">';
                $html .= '<div class="col-sm-4">'.get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'img-circle')).'</div>';
                $html .= '<div class="col-sm-8">'.get_the_content().'</div>';
                $html .= '</div>';
            endwhile;
            $html .= '</div>';
        } else {
            $html = 'Sorry we have no Testimonials at this time.';
        }
        
        echo $html;
        
    }
}

new CI_Testimonials;