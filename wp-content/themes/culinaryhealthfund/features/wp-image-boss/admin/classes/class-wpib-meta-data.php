<?php
/**
 * Description of Slide_Js_Create is
 * to create each slide with Name, Text, Image,
 * Thumnail and Link
 *
 * @author Jeff Clark
 */

class WPIB_Meta_Data {
    
    public $migration = false;
    
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'wpib_meta_box'));
        add_action('publish_wpib-images', array($this, 'wpib_save_fields'));
        
    }
    
    
    public function wpib_migration_update(){
        if($this->migration) {
            $args = array(
                'post_type' => 'wpib-images',
                'posts_per_page' => -1,
            );

            $loop = new WP_Query($args);

            while($loop->have_posts()) : $loop->the_post();
                $slide_img = maybe_unserialize( get_post_meta(get_the_ID(), '_image', true ) );
                $slide_link = maybe_unserialize( get_post_meta( get_the_ID(), '_img_link', true ) );

                $count = 0;
                $newImgs = array();
                $newLinks = array();

                foreach($slide_img as $key => $img){
                    $newImgs[] = str_replace($this->dev_url, $this->migration_url, $img );

                }

    //            foreach($slide_link as $key => $link){
    //                $newLinks[] = str_replace($this->dev_url, $this->migration_url, $link );
    //            }

                $newImgs = maybe_serialize($newImgs);
                //$newLinks = maybe_serialize($newLinks);

                update_post_meta(get_the_ID(), '_image', $newImgs);
                //update_post_meta(get_the_ID(), '_img_link', $newlinks);

            endwhile;
        }

    }

    
    
    /**
     * Setup a meta box for our slides
     */
    public function wpib_meta_box(){
          add_meta_box( 
                'wpib-images',
                __( 'WP Image Boss', 'wpib' ),
                array($this, 'wpib_meta_box_content'),
                'wpib-images',
                'normal',
                'high'
            );
          
    }
    
    
    
    
    /**
     * Slideshow images, links,
     * and position.
     * 
     * @global type $post 
     */
    public function wpib_meta_box_content(){
        global $post;
        
        $count = 0;
        
        
        $div_id = maybe_unserialize( get_post_meta( $post->ID, '_div_id', true ) );
        $slide_img = maybe_unserialize( get_post_meta( $post->ID, '_image', true ) );
        $slide_link = maybe_unserialize( get_post_meta( $post->ID, '_img_link', true ) );
        $img_desc = maybe_unserialize( get_post_meta( $post->ID, '_img_desc', true ) );
        $link_target = maybe_unserialize( get_post_meta( $post->ID, '_link_target', true ) );
        
      
        
        echo '<script>
                    jQuery(document).ready(function($){
                        $(function() {
                            $( "#sortable" ).sortable();
                            $( "#tabs" ).tabs();
                        });   
                    });
              </script>';
        
        echo '<div id="tabs">
                <ul>
                  <li><a href="#tabs-1">Images</a></li>
                  <li><a href="#tabs-2">Settings</a></li>
                  <li><a href="#tabs-3">Shortcode</a></li>
                </ul>';
        echo '<div class="newslide" id="addSlide"><a href="#slidenew">add new</a></div>';        
        
        echo '<div id="tabs-1">';
        echo '<div id="slidejs-slide">';
        echo '<ul id="sortable">';
        if($slide_img) {
            foreach($slide_img as $type){
                $selected = ($link_target[$count] == 'blank') ? 'selected' : '';
                // image upload                 
                echo '<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
                echo '<div class="slide-wrap">';
                
                    echo '<div class="wpib-img">';
                        echo '<span class="group"><span class="close-img">&nbsp;</span><label for="new_slides" class="hidden">Slide Url</label><input class="upload hidden" type="text" name="image[]" value="'.$slide_img[$count].'" />';
                        echo '<input class="upload-button hidden" type="button" name="wsl-image-add" value="Upload Image" />';
                        echo '<img src="'.esc_attr($slide_img[$count]).'" class="slidejs-img"></span>';
                    echo '</div>';
                    
                    echo '<div class="detail-group">';  
                        
                        // Image Link
                        echo '<label>Image Link</label>';
                        echo '<input type="text" id="img-link" name="img-link[]" value="'.esc_url($slide_link[$count]).'" />';
                    
                        // Image Description
                        echo '<label>Image Description</label>';
                        echo '<textarea id="img-desc" name="img-desc[]" >'.wp_kses_post($img_desc[$count]).'</textarea>'; /* TODO FIX ERROR IF EMPTY */
                        
                        // link Target
                        echo '<br>';
                        echo '<select name="link-target[]">';
                        echo '<option value="select" >select</option>';
                        echo '<option value="blank" '. $selected .' >blank</option>';
                        echo '</select>';
                    echo '</div>';
                    
                    echo '<a href="#" id="remScnt">Remove</a>';
                
                echo '</div></li>';
                

                $count++;
            }
        }
        echo '</div></ul>';
        
        echo '<label>Unique ID ( use this if running mutliple slideshows per page )</label><br>';
        echo '<input type="text" id="div-id" name="div-id" value="'.esc_attr($div_id).'" /><br>';

        echo '<h2 class="new-slide button"><a href="#" id="addSlide">Add New Slide</a></h2>';

        echo '</div>'; // end tab1
        
        echo '<div id="tabs-2">';
        
            $this->wpib_meta_box_settings_content();

        echo '</div>';
        
        echo '<div id="tabs-3">';
            $this->wpib_meta_box_shortcode_content();
            $this->wpib_migration_update();
        echo '</div>';
        
        echo '</div>'; // end tabs
        
        
        
    }
    
    
    
    /**
     * Generates the shortcode to
     * be used in our themes.
     * 
     * @global type $post 
     */
    public function wpib_meta_box_shortcode_content(){
        global $post;
        echo '<div class="slide-js-options" style="font-size: 14px">';
        echo '<h1><strong>WP Image Boss Shortcodes</strong></h1>';
        echo '<p>The slideshow takes a number of paramters, please review them below.</p>';
        echo '<p><strong>desc:</strong> ( boolean )</p>';
        echo '<p><strong>arrows:</strong> ( boolean )</p>';
        echo '<p><strong>speed:</strong> default is 4000</p>';
        echo '<pre>[wpib_slideshow id="'.$post->ID.'"]</pre>';
        
        echo '<h2><strong>Random Images Shortcode</strong></h2>';
        echo '<pre>[wpib_random id="'.$post->ID.'"]</pre>';
        
        echo '<h2><strong> Image Array Shortcode</strong></h2>';
        echo '<p>To exclude images from list, use excl="0, 1" in your shortcode</p>';
        echo '<p>excl is a comma seperated string where 0 is the first image in the list.</p>';
        echo '<pre>[wpib_imagelist id="'.$post->ID.'" excl="0"]</pre>';
        echo '</div>';

    }
    
    
    
    /**
     * Slideshow options from.
     * 
     * @global type $post 
     */
    public function wpib_meta_box_settings_content(){
        global $post;
        
        $slide_types = get_post_meta($post->ID, '_slide-types', true);
        
        echo '<div class="slide-js-options" style="font-size: 14px">';
        echo '<h1><strong>Settings</strong></h1>';
        echo '</div>';

    }
    

    
    
    /**
     * Save all fields generated
     * through the slideshow plugin.
     * 
     * @global type $post 
     */
    public function wpib_save_fields(){
        global $post;

        
        if( $_POST ) { 
            foreach( $_POST['img-desc'] as $key => $value ) {
                $img_desc[] = $value;
            } 
            
            update_post_meta($post->ID, '_img_desc', $img_desc);
            
            foreach( $_POST['image'] as $key => $value ) {
                $slide_img[] = $value;
            }
            
            update_post_meta( $post->ID, '_image', $slide_img ); 

            
            foreach( $_POST['img-link'] as $key => $value ) {
                $slide_link[] = $value;
            }
            
            update_post_meta( $post->ID, '_img_link', $slide_link ); 
            
            if(!empty($_POST['div-id']))  {
                $div_id = $_POST['div-id'];
      
                update_post_meta( $post->ID, '_div_id', $div_id); 
            }
            
            foreach( $_POST['link-target'] as $key => $value ) {
                $link_target[] = $value;
            }
            update_post_meta( $post->ID, '_link_target', $link_target );

        }
    }
    
}
