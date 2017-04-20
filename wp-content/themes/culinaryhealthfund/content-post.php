<div id="post-<?php the_ID(); ?>" <?php post_class('blog-wrap'); ?> >

    <?php #echo CI_Theme_Options::ci_get_featured_image(); // Blog post featured image ?>
    
    <h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
    <?php the_excerpt(); ?>
    
    
    <?php #CI_Theme_Options::ci_get_meta(); // Blog post meta data ?> 
    
    
    <p><?php #the_tags(); ?></p>
</div>
<hr>



