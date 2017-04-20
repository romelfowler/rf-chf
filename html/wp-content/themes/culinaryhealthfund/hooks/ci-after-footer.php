<?php


add_action('ci_after_footer', 'ci_sticky_header');
function ci_sticky_header(){
    $options = get_option('ci');
    if(!$options['ci_header_position'])
        return;
    
    if(wp_is_mobile())
        return;
    ?>
    <script type='text/javascript'>
    // Sticky Header
    var lastScrollTop = 200;
    jQuery(window).scroll(function(event){
       var st = jQuery(this).scrollTop();
       if (st > lastScrollTop){
           // downscroll code
           jQuery('.navbar').removeClass('navbar-static-top');
           jQuery('.navbar').addClass('navbar-fixed-top');

       } else {
          // upscroll code
           jQuery('.navbar').removeClass('navbar-fixed-top');
           jQuery('.navbar').addClass('navbar-static-top');
       }
    });
    </script>
    <?php
}

