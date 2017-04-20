
jQuery(document).ready(function($){
    var scntDiv = $('#slidejs-slide');
    var i = $('#slidejs-slide div').size() + 1;
    
    $('#addSlide').live('click', function() {
        $('<div class="slide-wrap" id="slidenew"><div class="wpib-img"><label for="new_slides">New Image</label><input class="upload" type="text" name="image[]" value="" /><input class="upload-button" type="button" name="wsl-image-add" value="Upload Image" /></div><div class="detail-group"><label>Image Link</label><input type="text" id="img-link" name="img-link[]" value="" /><label>Image Description</label><textarea id="img-desc" name="img-desc[]" ></textarea><br><select name="link-target[]"><option value="select" >select</option><option value="blank">blank</option></select></div><a href="#" id="remScnt">Remove</a></div>').appendTo(scntDiv);
        i++;
        //slide_to_new();
        return false;
    });
        
    $('#remScnt').live('click', function() { 
        if( i > 0 ) {
            $(this).parents('div.slide-wrap').remove();
            i--;
        }
        return false;
    });
    
    
    $('.group').live('click',function(){
        $('.slidejs-img', this).hide();
        $('.hidden', this).removeClass('hidden');
    });
    
    $('.group').mouseenter(function(){
        $('.close-img', this).show()
    })
    
    $('.group').mouseleave(function(){
        $('.close-img', this).hide()
    })
    
    
    
});

function slide_to_new(){
    $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
        || location.hostname == this.hostname) {

      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
}