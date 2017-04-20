<?php
/**
 * Options include
 */

if ( !class_exists( 'ReduxFramework' ) && file_exists(get_template_directory() . '/admin/options/ReduxCore/framework.php' ) ) {
	require_once( get_template_directory() . '/admin/options/ReduxCore/framework.php' );
}

if ( !isset( $redux_demo ) && file_exists( get_template_directory() . '/admin/options-config.php' ) ) {
	require_once( get_template_directory() . '/admin/options-config.php' );
}

// CI Options
require_once(get_template_directory().'/classes/class-ci-theme-options.php');

// CI Home Page
require_once(get_template_directory().'/classes/class-ci-home-page.php');

// CI Shortcodes
require_once(get_template_directory().'/shortcodes/class-ci-subnav.php');
require_once(get_template_directory().'/shortcodes/class-ci-grid.php');
require_once(get_template_directory().'/shortcodes/class-ci-font-awesome.php');

require_once(get_template_directory().'/classes/class-ci-cpt.php');
require_once(get_template_directory().'/classes/class-ci-taxonomy.php');
require_once(get_template_directory().'/classes/class-ci-breadcrumbs.php');
require_once(get_template_directory().'/classes/class-ci-hooks.php');

// CI Hooks
require_once(get_template_directory().'/hooks/ci-after-header.php');
require_once(get_template_directory().'/hooks/ci-after-footer.php');
require_once(get_template_directory().'/hooks/ci-before-footer.php');

// Features
require_once(get_template_directory().'/features/wp-image-boss/wp-image-boss.php');





/**
 * Register and include twitter bootstrap
 * scripts
 */
function wpstrapped_scripts() {
	wp_register_script('bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array('jquery'));
	wp_enqueue_script('bootstrap');

	wp_enqueue_script('jquery');
	wp_enqueue_script('backstretch', get_template_directory_uri() . '/js/jquery.backstretch.js');

	/* Font Awesome */
	wp_enqueue_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
}

add_action('wp_enqueue_scripts', 'wpstrapped_scripts');
// load css into the admin pages
function mytheme_enqueue_options_style() {
    wp_enqueue_style( 'mytheme-options-style', get_template_directory_uri() . '/css/admin.css' );
}
add_filter('acf/settings/show_admin', '__return_false');


/*
 * Add theme support for post thumbnails,
 * this also allow you to add a custom
 * thumnail value,
 *
 * uncomment the add_image_size bellow
 * and change accordingly
 *
 *
 */

add_theme_support('post-thumbnails');
add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
add_theme_support( 'automatic-feed-links' );
add_theme_support('get_post_format');
add_theme_support('has_post_format');

if ( ! isset( $content_width ) )
	$content_width = 700;




/**
 * Register Our Menues for our theme, We can also add more
 * by creating a new menu uption in our array
 *
 *
 */
add_action('init', 'wpstrapped_theme_menues');

function wpstrapped_theme_menues() {

	register_nav_menu('primary', __('Primary Menu', 'wpstrapped'));
	register_nav_menu('footer', __('Footer Menu', 'wpstrapped'));
	register_nav_menu('subnav', __('Sub Nav Menu', 'wpstrapped'));
}



/**
 * Add theme support for shortcodes in widgets
 *
 *
 */
add_filter('widget_text', 'do_shortcode');



/**
 * Replaces "[...]" for our excerpt
 */
function wpstrapped_excerpt_more($more) {

	return ' &hellip;' . wpstrapped_continue_reading_link();
}

add_filter('excerpt_more', 'wpstrapped_excerpt_more');



/**
 * Creates our link for read more.
 *
 *
 */
function wpstrapped_continue_reading_link() {
	global $ci_read_more_class;
	$read_more = ($ci_read_more_class) ? $ci_read_more_class : 'btn btn-primary';
	return '<p><a class="'. $read_more .'" href="' . esc_url(get_permalink()) . '">' . __('Continue Reading', 'wpstrapped') . '</a></p>';
}



/*
 * Add comment reply javascript
 *
 *
 */

function wpstrapped_threaded_links() {
	if (is_singular()) :
		wp_enqueue_script('comment-reply');
	endif;
}

add_action('wp_head', 'wpstrapped_threaded_links');




/**
 * We need to shorten up our excerpt length here, its way to long,
 * we will do this by hooking into excerpt lenth and returning our new
 * length of 40
 *
 *
 */
function wpstrapped_custom_excerpt_length($length) {
	global $ci_excerpt_length;
	if($ci_excerpt_length) {
		return $ci_excerpt_length;
	} else {
		return 40;
	}
}

add_filter('excerpt_length', 'wpstrapped_custom_excerpt_length');




/**
 * Setup for our Widgets Area. This must be included
 * to have the ability to use the widgets area.
 *
 */
if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'Sidebar Main',
		'before_widget' => '<div class="widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<div class="widg-title"><h3>',
		'after_title' => '</h3></div>',
			)
	);


	register_sidebar(array(
		'name' => 'Sidebar 2',
		'before_widget' => '<div class="widget-area span12">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
			)
	);

	register_sidebar(array(
		'name' => 'Sidebar 3',
		'before_widget' => '<div class="widget-area span12">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
			)
	);

	register_sidebar(array(
		'name' => 'Sidebar 4',
		'before_widget' => '<div class="widget-area span12">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
			)
	);

	register_sidebar(array(
		'name' => 'Sidebar 5',
		'before_widget' => '<div class="widget-area span12">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
			)
	);

		/**
	 * Single column footer
	 * widget area
	 */
	register_sidebar(array(
		'name' => 'Footer Columns',
		'before_widget' => '<div class="widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
			)
	);
}



/**
 * Numbered Pagination
 *
 */
function jdev_pagination() {
	global $wp_query;

	$big = 999999999; // need an unlikely integer

	echo paginate_links(array(
		'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $wp_query->max_num_pages
	));
   }



	/** COMMENTS WALKER */
	class zipGun_walker_comment extends Walker_Comment {

		// init classwide variables
		var $tree_type = 'comment';
		var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

		/** CONSTRUCTOR
		 * You'll have to use this if you plan to get to the top of the comments list, as
		 * start_lvl() only goes as high as 1 deep nested comments */
		function __construct() { ?>

			<h3 id="comments-title">Comments</h3>
			<ul id="comment-list">

		<?php }

		/** START_LVL
		 * Starts the list before the CHILD elements are added. */
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 1; ?>

					<ul class="children">
		<?php }

		/** END_LVL
		 * Ends the children list of after the elements are added. */
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 1; ?>

			</ul><!-- /.children -->

		<?php }

		/** START_EL */
		function start_el( &$output, $comment, $depth, $args, $id = 0 ) {
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); ?>

			<li <?php comment_class( $parent_class ); ?> id="comment-<?php comment_ID() ?>">
				<div id="comment-body-<?php comment_ID() ?>" class="comment-body">

					<div class="comment-author vcard author">
						<div class="alignleft"><?php echo ( $args['avatar_size'] != 0 ? get_avatar( $comment, $args['avatar_size'] ) : '' ); ?></div>
						<cite class="fn n author-name"><?php echo get_comment_author() ?></cite><br>
						<div class="commentdate"><?php comment_date(); ?> <?php edit_comment_link( '(Edit)' ); ?></div>
						<div class="reply">
						<?php $reply_args = array(
							//'add_below' => $add_below,
							'depth' => $depth,
							'max_depth' => $args['max_depth'] );

						comment_reply_link( array_merge( $args, $reply_args ) );  ?>
						</div><!-- /.reply -->
					</div><!-- /.comment-author -->

					<div id="comment-content-<?php comment_ID(); ?>" class="comment-content">
						<?php if( !$comment->comment_approved ) : ?>
						<em class="comment-awaiting-moderation">Your comment is awaiting moderation.</em>

						<?php else: comment_text(); ?>
						<?php endif; ?>
					</div><!-- /.comment-content -->

				</div><!-- /.comment-body -->

		<?php }

		function end_el(&$output, $comment, $depth = 0, $args = array() ) {

			echo '</li>';

		}

		/** DESTRUCTOR
		 * I'm just using this since we needed to use the constructor to reach the top
		 * of the comments list, just seems to balance out nicely:) */
		function __destruct() {

		echo '</ul>';

		}
}

	if (!function_exists('getFormOptions')) {

		function getFormOptions($options, $default=null, $with_empty=true, $key=false)
		{
			$s_options = '';

			if ($with_empty)
			{
				$s_options .= '<option value="">Select one...</option>';
			}

			foreach ($options as $k => $v)
			{
			  $theKey = $v;
			  if ($key) {
				$theKey = $v[$key];
			  }
				$s_options .= '<option value="' . $k . '"' . getFormSelected($k, $default) . '>' . $theKey . '</option>';
			}

			return $s_options;
		}
	}

	if (!function_exists('getFormSelected')) {

		function getFormSelected($value, $default=false)
		{
			if (strlen($default) > 0)
			{
				return $value == $default ? ' selected' : '';
			}
			else
			{
				return '';
			}
		}
	}

	/*
	 * Modify comment_form output
	 *
	 */
	function modify_comment_fields($fields){
	global $comment_author;
	$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(

  'author' =>
	'<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
	'" size="30"' . $aria_req . ' /><label for="author"><small>' . __( 'Name', 'gravity' ) . '</span></label> ' .
	( $req ? '<span class="required">*</span>' : '' ) .'</p>',

  'email' =>
	'<p class="comment-form-email"><input id="email" name="email" type="text" value="' . esc_attr(	$commenter['comment_author_email'] ) .
	'" size="30"' . $aria_req . ' /><label for="email"><small>' . __( 'Email', 'gravity' ) . '</small></label> ' .
	( $req ? '<span class="required">*</span>' : '' ) .'</p>',

  'url' =>
	'<p class="comment-form-url"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
	'" size="30" /><label for="url"><small>' . __( 'Website', 'gravity' ) . '</small></label></p>'
);

	return $fields;

	}
	add_filter('comment_form_default_fields','modify_comment_fields');
