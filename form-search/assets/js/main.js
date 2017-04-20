
$(document).ready(function(){
  // Retrieve the input field text and reset the count to zero


    $("#filter").keyup(function(){
      var filter = $(this).val();
      var count = 0;


        // Loop through the comment list
        $(".commentlist li").each(function(){
            // If the list item does not contain the text phrase fade it out
            if (($(this).text().search(new RegExp(filter, "i")) < 0) ) {
                $(this).fadeOut();
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $('div.excerpt').fadeOut(500);
                $('ul.commentlist').fadeIn().animate({'opacity': '1'});
                $(this).show();
                count++;
            }

        }); // End of commentList li function



    }); // End of #filter function


});
