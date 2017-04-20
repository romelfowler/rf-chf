<?php

/**
 * Description of Slide_Js is to 
 * build the slideshow based on
 * options selected in the backend;
 *
 * @author Jeff Clark
 */

class WPIB_Images {

    
    public function __construct() {
        add_shortcode('wpib_slideshow', array($this, 'wpib_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'wpib_includes'));
    }
       
    
    
    
    public function wpib_includes(){
        //include any needed scripts
        if(!is_admin()){
            wp_enqueue_script( 'jquery' );
            //wp_enqueue_script('tb-slideshow', WPIB_BASE_URL . 'includes/js/bootstrap.js');
            wp_enqueue_script( 'jquery-mobile-swipe', WPIB_BASE_URL . 'includes/js/jquery.mobile.custom.min.js');
            wp_enqueue_script( 'jquery-fullscreen', WPIB_BASE_URL . 'includes/js/jquery.carousel.fullscreen.js', 'jquery', '10', true);
            
            //wp_enqueue_style('tb-slideshow-css', WPIB_BASE_URL . 'includes/css/bootstrap.css');
        }
    }

        
    
    
    /**
     * Slideshow output.  Generates options
     * based on the options set in the backend.
     * 
     * @global type $post
     * @param type $atts
     * @param type $content 
     */
    public function wpib_shortcode($atts, $content = null){
        
        
        
        // generate a shortcode for use?
        global $post;
        ob_start();
        extract(shortcode_atts(array(
                    'id' => 'id',
                    'desc' => 'desc',
                    'arrows' => 'arrows',
                    'speed' => false
                        ), $atts));

        
        /* SLIDESHOW OPTIONS */
        if(get_post_meta($id, '_slide-speed', true) != '' )
                $this->slide_speed = get_post_meta($id, '_slide-speed', true);
           
        $slide_img = maybe_unserialize( get_post_meta( $id, '_image', true ) );
        $slide_link = maybe_unserialize( get_post_meta( $id, '_img_link', true ) );
        $img_desc = maybe_unserialize( get_post_meta( $id, '_img_desc', true ) );
        
        $div_id = (get_post_meta( $id, '_div_id', true )) ? get_post_meta( $id, '_div_id', true ) : 'carousel';
        $html = '<div id="'.$div_id.'" class="'.$div_id.' slide carousel-fade">';
        if(count($slide_img) > 1) {
            
            $html .= '<ol class="carousel-indicators">';

            $count = 0;

            foreach($slide_img as $img){
                $class = ($count == 0) ? 'active' : '';
                $html .= '<li data-target="#'.$div_id.'" data-slide-to="'.$count.'" class="'.$class.'"></li>';
                $count++;
            }

            $html .= '</ol>';
        }
        
        $count1 = 0;
        
        $html .= '<div class="carousel-inner">';
        foreach($slide_img as $img){
            $class = ($count1 == 0) ? 'active' : '';
            $html .= '<div class="'.$class.' item">';
            $html .= '<img src="'.$slide_img[$count1].'" />';
            if($desc === 'true') {
                $html .= '<div class="carousel-caption">'.wp_kses_post($img_desc[$count1]).'</div>';
            }
            $html .= '</div>';
            $count1++;
        }
        
        $html .= '</div>';
        if($arrows === 'true') {
            $html .= '<a class="carousel-control left" href="#'.$div_id.'" data-slide="prev">&lsaquo;</a>';
            $html .= '<a class="carousel-control right" href="#'.$div_id.'" data-slide="next">&rsaquo;</a>';
        }
        $html .= '</div>';

        ?>

        <?php $interval = ($speed && $speed != '') ? $speed : 'false'; ?>
        <script>
        jQuery('document').ready(function($){
            $('.<?php echo $div_id; ?>').carousel({
                pause: true,
                interval: <?php echo $interval; ?>, 
                slide: startSlide()
              });
//              $('.carousel').css({'margin': 0, 'width': $(window).outerWidth(), 'height': $(window).outerHeight()});
//	$('.carousel .item').css({'position': 'fixed', 'width': '100%', 'height': '100%'});
//	$('.carousel-inner div.item img').each(function() {
//		var imgSrc = $(this).attr('src');
//		$(this).parent().css({'background': 'url('+imgSrc+') center center no-repeat', '-webkit-background-size': '100% ', '-moz-background-size': '100%', '-o-background-size': '100%', 'background-size': '100%', '-webkit-background-size': 'cover', '-moz-background-size': 'cover', '-o-background-size': 'cover', 'background-size': 'cover'});
//		$(this).remove();
//	});
//
//	$(window).on('resize', function() {
//		$('.carousel').css({'width': $(window).outerWidth(), 'height': $(window).outerHeight()});
//	});
              
              <?php if($desc === 'true') : ?>
              $('#primary').on("slide", function(event){
                  beforeSlide();
              });
              
              $('#primary').on("slid", function(event){
                  afterSlide();
              });
              <?php endif; ?>
        });
        
        
        function startSlide() {
                html = jQuery('#primary .active .carousel-caption').html();
                if(!html)
                    return;
                
                jQuery('.wrapit').html(html);
                jQuery('.marquee-cta').fadeIn();
        }

        // Run before slide spins
        function beforeSlide(){
                jQuery('.wrapit, .marquee-cta').animate({
                    opacity: 0.0,
                    right: "+=50px",
                });
            
                //console.log('before');
        }
        
        
        // Run after slide spins
        function afterSlide(){    
            html = jQuery('#primary .active .carousel-caption').html();
            jQuery('.wrapit').html(html);
            jQuery('.marquee-cta').animate({right: "-=50"});
            jQuery('.wrapit, .marquee-cta').animate({
                opacity: 1.0,    
            });
            
            //console.log(html);
        }
        
        <?php if($desc != 'true' && $div_id == 'primary') : ?>
            jQuery("header.header").addClass("no-desc");
        <?php endif; ?>
            
            jQuery('document').ready(function($){
                // Swipe 
               $("#<?php echo $div_id ?>").swiperight(function() {  
                 $("#<?php echo $div_id ?>").carousel('prev');  
               });  

               $("#<?php echo $div_id ?>").swipeleft(function() {  
                  $("#<?php echo $div_id ?>").carousel('next');  
               });  
           });
        </script>
  
        <?php $output = ob_get_clean(); ?> 
        
        <?php return $html . $output; ?>
        
    <?php     
    }

    
}


