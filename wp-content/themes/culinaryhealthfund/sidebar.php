<div class="col-md-3 col-md-pull-9 sidebar">
    <?php $sidebars = ( get_post_meta( $post->ID, '_ci_sidebar', true )) ? get_post_meta( $post->ID, '_ci_sidebar', true ) : 'sidebar-1'; ?>
    <?php if ( ! dynamic_sidebar( $sidebars ) ) : ?>

            <aside id="archives" class="widget">
                <h3 class="widget-title"><?php _e( 'Archives', 'wpstrapped' ); ?></h3>

                <ul>
                    <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
                </ul>
            </aside>

            <aside id="meta" class="widget">
                <h3 class="widget-title"><?php _e( 'Meta', 'wpstrapped' ); ?></h3>
                <ul>
                    <?php wp_register(); ?>
                    <li><?php wp_loginout(); ?></li>
                    <?php wp_meta(); ?>
                </ul>
            </aside>
    <?php endif; // end sidebar widget area ?>
</div>
