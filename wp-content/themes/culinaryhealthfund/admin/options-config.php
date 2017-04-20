<?php
if (!function_exists('redux_init')) :

    function redux_init() {
        /**
          ReduxFramework Sample Config File
          For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
         * */
        /**

          Most of your editing will be done in this section.

          Here you can override default values, uncomment args and change their values.
          No $args are required, but they can be overridden if needed.

         * */
        $args = array();


        // For use with a tab example below
        $tabs = array();

        ob_start();

        $ct = wp_get_theme();
        $theme_data = $ct;
        $item_name = $theme_data->get('Name');
        $tags = $ct->Tags;
        $screenshot = $ct->get_screenshot();
        $class = $screenshot ? 'has-screenshot' : '';

        $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $ct->display('Name'));
        ?>
        <div id="current-theme" class="<?php echo esc_attr($class); ?>">
        <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                    <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                        <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                    </a>
            <?php endif; ?>
                <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
            <?php endif; ?>

            <h4>
        <?php echo $ct->display('Name'); ?>
            </h4>

            <div>
                <ul class="theme-info">
                    <li><?php printf(__('By %s', 'redux-framework-demo'), $ct->display('Author')); ?></li>
                    <li><?php printf(__('Version %s', 'redux-framework-demo'), $ct->display('Version')); ?></li>
                    <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($ct->display('Tags')); ?></li>
                </ul>
                <p class="theme-description"><?php echo $ct->display('Description'); ?></p>
        <?php
        if ($ct->parent()) {
            printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $ct->parent()->display('Name'));
        }
        ?>

            </div>

        </div>

        <?php
        $item_info = ob_get_contents();

        ob_end_clean();

        $sampleHTML = '';
        if (file_exists(dirname(__FILE__) . '/info-html.html')) {
            /** @global WP_Filesystem_Direct $wp_filesystem  */
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
        }

        // BEGIN Sample Config
        // Setting dev mode to true allows you to view the class settings/info in the panel.
        // Default: true
        $args['dev_mode'] = false;

        // Set the icon for the dev mode tab.
        // If $args['icon_type'] = 'image', this should be the path to the icon.
        // If $args['icon_type'] = 'iconfont', this should be the icon name.
        // Default: info-sign
        //$args['dev_mode_icon'] = 'info-sign';
        // Set the class for the dev mode tab icon.
        // This is ignored unless $args['icon_type'] = 'iconfont'
        // Default: null
        $args['dev_mode_icon_class'] = 'icon-large';

        // Set a custom option name. Don't forget to replace spaces with underscores!
        $args['opt_name'] = 'ci';

        // Setting system info to true allows you to view info useful for debugging.
        // Default: false
        //$args['system_info'] = true;
        // Set the icon for the system info tab.
        // If $args['icon_type'] = 'image', this should be the path to the icon.
        // If $args['icon_type'] = 'iconfont', this should be the icon name.
        // Default: info-sign
        //$args['system_info_icon'] = 'info-sign';
        // Set the class for the system info tab icon.
        // This is ignored unless $args['icon_type'] = 'iconfont'
        // Default: null
        //$args['system_info_icon_class'] = 'icon-large';

        $theme = wp_get_theme();

        $args['display_name'] = $theme->get('Name');
        //$args['database'] = "theme_mods_expanded";
        $args['display_version'] = $theme->get('Version');

        // If you want to use Google Webfonts, you MUST define the api key.
        $args['google_api_key'] = 'AIzaSyCIFSaN_hxiQVcz2SvMpfA4tMjZq_AnM1I';

        // Define the starting tab for the option panel.
        // Default: '0';
        //$args['last_tab'] = '0';
        // Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
        // If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
        // If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
        // Default: 'standard'
        //$args['admin_stylesheet'] = 'standard';
        // Setup custom links in the footer for share icons
//        $args['share_icons']['twitter'] = array(
//            'link' => 'http://twitter.com/ghost1227',
//            'title' => 'Follow me on Twitter',
//            'img' => ReduxFramework::$_url . 'assets/img/social/Twitter.png'
//        );
//        $args['share_icons']['linked_in'] = array(
//            'link' => 'http://www.linkedin.com/profile/view?id=52559281',
//            'title' => 'Find me on LinkedIn',
//            'img' => ReduxFramework::$_url . 'assets/img/social/LinkedIn.png'
//        );

        // Enable the import/export feature.
        // Default: true
        $args['show_import_export'] = false;
        // Set the icon for the import/export tab.
        // If $args['icon_type'] = 'image', this should be the path to the icon.
        // If $args['icon_type'] = 'iconfont', this should be the icon name.
        // Default: refresh
        //$args['import_icon'] = 'refresh';
        // Set the class for the import/export tab icon.
        // This is ignored unless $args['icon_type'] = 'iconfont'
        // Default: null
        $args['import_icon_class'] = 'icon-large';

        /**
         * Set default icon class for all sections and tabs
         * @since 3.0.9
         */
        $args['default_icon_class'] = 'icon-large';


        // Set a custom menu icon.
        //$args['menu_icon'] = '';
        // Set a custom title for the options page.
        // Default: Options
        $args['menu_title'] = __('Theme Options', 'redux-framework-demo');

        // Set a custom page title for the options page.
        // Default: Options
        $args['page_title'] = __('Theme Options', 'redux-framework-demo');

        // Set a custom page slug for options page (wp-admin/themes.php?page=***).
        // Default: redux_options
        $args['page_slug'] = 'wp_stapped_options';

        $args['default_show'] = true;
        $args['default_mark'] = '*';

        // Set a custom page capability.
        // Default: manage_options
        //$args['page_cap'] = 'manage_options';
        // Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
        // Default: menu
        //$args['page_type'] = 'submenu';
        // Set the parent menu.
        // Default: themes.php
        // A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        //$args['page_parent'] = 'options-general.php';
        // Set a custom page location. This allows you to place your menu where you want in the menu order.
        // Must be unique or it will override other items!
        // Default: null
        //$args['page_position'] = null;
        // Set a custom page icon class (used to override the page icon next to heading)
        //$args['page_icon'] = 'icon-themes';
        // Set the icon type. Set to "iconfont" for Elusive Icon, or "image" for traditional.
        // Redux no longer ships with standard icons!
        // Default: iconfont
        //$args['icon_type'] = 'image';
        // Disable the panel sections showing as submenu items.
        // Default: true
        //$args['allow_sub_menu'] = false;
        // Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
        $args['help_tabs'][] = array(
            'id' => 'redux-opts-1',
            'title' => __('Theme Information 1', 'redux-framework-demo'),
            'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
        );
        $args['help_tabs'][] = array(
            'id' => 'redux-opts-2',
            'title' => __('Theme Information 2', 'redux-framework-demo'),
            'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
        );

        // Set the help sidebar for the options page.                                        
        $args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');


        // Add HTML before the form.
//        if (!isset($args['global_variable']) || $args['global_variable'] !== false) {
//            if (!empty($args['global_variable'])) {
//                $v = $args['global_variable'];
//            } else {
//                $v = str_replace("-", "_", $args['opt_name']);
//            }
//            $args['intro_text'] = sprintf(__('', 'redux-framework-demo'), $v);
//        } else {
//            $args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
//        }

        // Add content after the form.
        //$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo');

        // Set footer/credit line.
        //$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'redux-framework-demo');


        $sections = array();

        //Background Patterns Reader
        $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
        $sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
        $sample_patterns = array();

        if (is_dir($sample_patterns_path)) :

            if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                $sample_patterns = array();

                while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                    if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                        $name = explode(".", $sample_patterns_file);
                        $name = str_replace('.' . end($name), '', $sample_patterns_file);
                        $sample_patterns[] = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                    }
                }
            endif;
        endif;


        $sections[] = array(
            'title' => __('General Settings', 'redux-framework-demo'),
            'header' => __('Welcome to the Simple Options Framework Demo', 'redux-framework-demo'),
            'icon_class' => 'icon-large',
            'icon' => 'fa fa-cog',
            // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
            'fields' => array(
                array(
                    'id' => 'ci_logo_upload',
                    'type' => 'media',
                    'title' => __('Logo', 'redux-framework-demo'),
                    'compiler' => 'true',
                    'subtitle' => __('Upload your logo.', 'redux-framework-demo'),
                ),
                array(
                    'id' => 'ci_favicon_upload',
                    'type' => 'media',
                    'title' => __('Favicon', 'redux-framework-demo'),
                    'compiler' => 'true',
                    'subtitle' => __('Upload your your custom site favicon.', 'redux-framework-demo'),
                ),
                array(
                    'id' => 'ci_tracking_code',
                    'type' => 'textarea',
                    'title' => __('Tracking Code', 'redux-framework-demo'),
                    'subtitle' => __('Just like a text box widget.', 'redux-framework-demo'),
                    'desc' => __('Paste your Google Analytics javascript or other tracking code here.  This code will be added before the closing tag.', 'redux-framework-demo'),
                    'validate' => 'html',
                ),
            )
        );


        $sections[] = array(
            'title' => __('Home Page', 'redux-framework-demo'),
            'header' => __('Custom settings for you home page!', 'redux-framework-demo'),
            'icon_class' => 'icon-large',
            'icon' => 'fa fa-home',
            // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
            'fields' => array(
                array(
                    'id' => 'ci_hero',
                    'type' => 'editor',
                    'title' => __('Hero Copy', 'redux-framework-demo'),
                    'subtitle' => __('Add copy for your hero space', 'redux-framework-demo'),
                    'default' => '',
                ),
                array(
                    'id' => 'ci_hero_margin',
                    'type' => 'spacing',
                    'output' => array('.hero-wrapper'), // An array of CSS selectors to apply this font style to
                    'mode' => 'margin', // absolute, padding, margin, defaults to padding
                    //'top'=>true, // Disable the top
                    'right' => false, // Disable the right
                    //'bottom' => false, // Disable the bottom
                    'left' => false, // Disable the left
                    //'all' => true, // Have one field that applies to all
                    //'units' => 'em', // You can specify a unit value. Possible: px, em, %
                    //'units_extended' => 'true', // Allow users to select any type of unit
                    'display_units' => 'false', // Set to false to hide the units if the units are specified
                    'title' => __('Hero Margin', 'redux-framework-demo'),
                    'subtitle' => __('Enter you custom hero margins', 'redux-framework-demo'),
                    //'desc' => __('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'redux-framework-demo'),
                    'default' => array('margin-top' => '50px', 'margin-bottom' => '130px')
                ),
                array(
                    'id' => 'ci_select_slider',
                    'type' => 'text',
                    'title' => __('Select A Slideshow For Your Home Page', 'redux-framework-demo'),
                    'subtitle' => __('Add your shortcode from Image Boss.', 'redux-framework-demo'),
                    //'desc'     => __('This is the description field, again good for additional info.', 'redux-framework-demo'),
                    'default' => ''
                ),
                array(
                    'id' => 'ci_ad_block',
                    'type' => 'editor',
                    'title' => __('Ad Block', 'redux-framework-demo'),
                    'subtitle' => __('Use this for whatever you want!', 'redux-framework-demo'),
                    'default' => '',
                ),
                array(
                    'id' => 'ci_cta_category',
                    'type' => 'select',
                    'data' => 'categories',
                    'title' => __('Select A Category For Home Page CTA', 'redux-framework-demo'),
                    'subtitle' => __('Choose a category for all your home page cta blocks', 'redux-framework-demo'),
                    'default' => '1'
                ),
                array(
                    'id' => 'ci-aboutus-copy',
                    'type' => 'editor',
                    'title' => __('About Copy Block', 'redux-framework-demo'),
                    'subtitle' => __('Use this for whatever you want!', 'redux-framework-demo'), 
                    //'default' => __('About Us We are a digital marketing consultancy focused on creating contemporary, results-driven websites and boosting your bottom line through inbound marketing and our unique blend of technical + marketing know-how.'),
                ),
                array(
                    'id' => 'ci_blog_posts',
                    'type' => 'select',
                    'data' => 'categories',
                    'title' => __('Select Blog Category For Home Page', 'redux-framework-demo'),
                    'subtitle' => __('Choose a category for all your home page news section', 'redux-framework-demo'),
                    'default' => '1'
                ),
                array(
                    "id" => "homepage_blocks",
                    "type" => "sorter",
                    "title" => "Homepage Layout Manager",
                    "desc" => "Organize how you want the layout to appear on the homepage",
                    "compiler" => 'true',
                    'options' => array(
                        "enabled" => array(
                            "placebo" => "placebo", //REQUIRED!
                            "heroblock" => "Static Hero",
                            "adblock" => "Ad Block",
                        ),
                        "disabled" => array(
                            "placebo" => "placebo", //REQUIRED!
                            "slider" => "Slider",
                            "cta-block" => "CTA Block",
                            "blogposts" => "News Block",
                        )
                    ),
                ),
            ),
        );



        $sections[] = array(
            'title' => __('Header', 'redux-framework-demo'),
            'header' => __('Welcome to the Simple Options Framework Demo', 'redux-framework-demo'),
            //'desc' => __('Redux Framework was created with the developer in mind. It allows for any theme developer to have an advanced theme panel with most of the features a developer would need. For more information check out the Github repo at: <a href="https://github.com/ReduxFramework/Redux-Framework">https://github.com/ReduxFramework/Redux-Framework</a>', 'redux-framework-demo'),
            'icon_class' => 'icon-large',
            'icon' => 'fa fa-bell-o',
            // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
            'fields' => array(
                array(
                    'id' => 'ci_header_position',
                    'type' => 'switch',
                    'title' => __('Fixed Header on Scroll', 'redux-framework-demo'),
                    'subtitle' => __('Toggle the fixed header when the user scrolls down the site', 'redux-framework-demo'),
                    "default" => 0,
                ),
                array(
                    'id' => 'ci_header_background_color',
                    'type' => 'color',
                    'title' => __('Header Background Color', 'redux-framework-demo'),
                    //'subtitle' => __('Pick a background color for the theme (default: #fff).', 'redux-framework-demo'),
                    'default' => '#FFFFFF',
                    'validate' => 'color',
                ),
                array(
                    'id' => 'ci_nav_font',
                    'type' => 'typography',
                    'output' => array('.menu li a', '.menu li ul.children a', '.menu li ul.sub-menu a'),
                    'title' => __('Navigation Font', 'redux-framework-demo'),
                    'subtitle' => __('Specify the navigation font properties.', 'redux-framework-demo'),
                    'google' => true,
                    'default' => array(
                        'color' => '#999999',
                        'font-size' => '18px',
                        'font-family' => 'Open Sans',
                        'font-weight' => '300',
                    ),
                ),
                array(
                    'id' => 'ci_nav_bgs',
                    'type' => 'link_color',
                    'title' => __('Navigation Current / Hover Color', 'redux-framework-demo'),
                    'subtitle' => __('Select navigation current / hover background color.', 'redux-framework-demo'),
                    //'desc' => __('This is the description field, again good for additional info.', 'redux-framework-demo'),
                    'regular' => false, // Disable Regular Color
                    //'hover' => false, // Disable Hover Color
                    //'active' => false, // Disable Active Color
                    'default' => array(
                        //'regular' => '#aaa',
                        'hover' => '#4ecefe',
                        'active' => '#4ecefe',
                    )
                ),               
                 array(
                    'id' => 'ci_breadcrumbs',
                    'type' => 'switch',
                    'title' => __('Hide and Show Breadcrumbs', 'redux-framework-demo'),
                    'subtitle' => __('Toggle if you want to show breadcrumbs', 'redux-framework-demo'),
                    "default" => 1,
                ),
                array(
                    'id' => 'ci_breadcrumbs_bg_color',
                    'type' => 'color',
                    'title' => __('Sub Header Background Color', 'redux-framework-demo'),
                    'subtitle' => __('Pick sub header background color.', 'redux-framework-demo'),
                    'default' => '#2a2a2a',
                    'validate' => 'color',
                ),
                array(
                    'id' => 'ci_breadcrumb-links',
                    'type' => 'link_color',
                    'title' => __('Breadcrumb Link Colors', 'redux-framework-demo'),
                    'subtitle' => __('Select colors for breadcrumb navigation', 'redux-framework-demo'),
                    //'desc' => __('This is the description field, again good for additional info.', 'redux-framework-demo'),
                    //'regular' => false, // Disable Regular Color
                    //'hover' => false, // Disable Hover Color
                    //'active' => false, // Disable Active Color
                    'default' => array(
                        'regular' => '#FFFFFF',
                        'hover' => '#f1f1f1',
                        'active' => '#FFFFFF',
                    )
                ),
            )
        );

        $sections[] = array(
            'icon' => 'fa fa-pencil',
            'icon_class' => 'icon-large',
            'title' => __('Styling', 'redux-framework-demo'),
            'fields' => array(
                array(
                    'id' => 'ci_background_color',
                    'type' => 'color',
                    'output' => array('body'),
                    'title' => __('Background Color', 'redux-framework-demo'),
                    'subtitle' => __('Pick a background color for the theme (default: #f1f1f1).', 'redux-framework-demo'),
                    'default' => '#FFFFFF',
                    'validate' => 'color',
                ),
                array(
                    'id' => 'ci_button_color',
                    'type' => 'color',
                    'title' => __('Button Color', 'redux-framework-demo'),
                    'subtitle' => __('Pick a color for your buttons (default: #FFF).', 'redux-framework-demo'),
                    'default' => '#FFFFFF',
                    'validate' => 'color',
                ),
                array(
                    'id' => 'ci_button_bg_color',
                    'type' => 'color',
                    'title' => __('Button Background Color', 'redux-framework-demo'),
                    'subtitle' => __('Pick a background color for your buttons (default: #b2b2b2).', 'redux-framework-demo'),
                    'default' => '#2a2a2a',
                    'validate' => 'color',
                ),
                array(
                    'id' => 'ci_button_hover_bg',
                    'type' => 'color',
                    'title' => __('Button Hover Color', 'redux-framework-demo'),
                    'subtitle' => __('Pick a background hover color for your buttons (default: #58bbe2).', 'redux-framework-demo'),
                    'default' => '#4ecefe',
                    'validate' => 'color',
                ),
            )
        );


        $sections[] = array(
            'icon' => 'fa fa-flask',
            'icon_class' => 'icon-large',
            'title' => __('Footer', 'redux-framework-demo'),
            'fields' => array(
                array(
                    'id' => 'ci_footer_bg_color',
                    'type' => 'color',
                    'output' => array('footer'),
                    'title' => __('Footer Background Color', 'redux-framework-demo'),
                    'subtitle' => __('Select footer background color (default: #999999).', 'redux-framework-demo'),
                    'default' => '#2a2a2a',
                    'validate' => 'color',
                ),
                
                array(
                    'id' => 'ci_footer_color',
                    'type' => 'color',
                    'output' => array('footer'),
                    'title' => __('Footer Font Color', 'redux-framework-demo'),
                    'subtitle' => __('Select footer font color (default: #FFFFFF).', 'redux-framework-demo'),
                    'default' => '#f1f1f1',
                    'validate' => 'color',
                ),
                array(
                    'id' => 'ci_copyrights',
                    'type' => 'editor',
                    'title' => __('Copyright Content', 'redux-framework-demo'),
                    'subtitle' => __('Use this block for whatever you want!', 'redux-framework-demo'),
                    'default' => '',
                )
            )
        );

        $sections[] = array(
            'icon' => 'fa fa-font',
            'icon_class' => 'icon-large',
            'title' => __('Fonts', 'redux-framework-demo'),
            'fields' => array(
                array(
                    'id' => 'ci_font_size',
                    'type' => 'typography',
                    'title' => __('Body Font', 'redux-framework-demo'),
                    'subtitle' => __('Specify the body font properties.', 'redux-framework-demo'),
                    'output' => array('body', 'footer a', 'footer #footerlinks .menu li a'),
                    'google' => true,
                    'default' => array(
                        'color' => '#2a2a2a',
                        'font-size' => '16px',
                        'line-height' => '20px',
                        'font-family' => 'Open Sans',
                        'font-weight' => 'Normal',
                    ),
                ),
                array(
                    'id' => 'ci_h1_font',
                    'type' => 'typography',
                    'title' => __('H1 Font', 'redux-framework-demo'),
                    'subtitle' => __('Specify the H1 font properties.', 'redux-framework-demo'),
                    'output' => array('h1'),
                    'google' => true,
                    'default' => array(
                        'color' => '#161616',
                        'font-size' => '30px',
                        'line-height' => '30px',
                        'font-family' => 'Open Sans',
                        'font-weight' => '600',
                    ),
                ),
                array(
                    'id' => 'ci_h2_font',
                    'type' => 'typography',
                    'title' => __('H2 Font', 'redux-framework-demo'),
                    'subtitle' => __('Specify the H2 font properties.', 'redux-framework-demo'),
                    'output' => array('h2'),
                    'google' => true,
                    'default' => array(
                        'color' => '#161616',
                        'font-size' => '26px',
                        'font-family' => 'Open Sans',
                        'font-weight' => '600',
                    ),
                ),
                array(
                    'id' => 'ci_h2_font_page',
                    'type' => 'typography',
                    'title' => __('H2 Page Titles', 'redux-framework-demo'),
                    'subtitle' => __('Specify the H2 Page Titles.', 'redux-framework-demo'),
                    'output' => array('h2.page-title'),
                    'google' => true,
                    'default' => array(
                        'color' => '#FFFFFF',
                        'font-size' => '26px',
                        'font-family' => 'Open Sans',
                        'font-weight' => '300',
                    ),
                ),
                array(
                    'id' => 'ci_h3_font',
                    'type' => 'typography',
                    'title' => __('H3 Font', 'redux-framework-demo'),
                    'subtitle' => __('Specify the H3 font properties.', 'redux-framework-demo'),
                    'output' => array('h3'),
                    'google' => true,
                    'default' => array(
                        'color' => '#161616',
                        'font-size' => '22px',
                        'font-family' => 'Open Sans',
                        'font-weight' => '600',
                    ),
                ),
                array(
                    'id' => 'ci_h4_font',
                    'type' => 'typography',
                    'title' => __('H4 Font', 'redux-framework-demo'),
                    'subtitle' => __('Specify the H4 font properties.', 'redux-framework-demo'),
                    'output' => array('h4'),
                    'google' => true,
                    'default' => array(
                        'color' => '#161616',
                        'font-size' => '18px',
                        'font-family' => 'Open Sans',
                        'font-weight' => '600',
                    ),
                ),
                array(
                    'id' => 'ci_h5_font',
                    'type' => 'typography',
                    'title' => __('H5 Font', 'redux-framework-demo'),
                    'subtitle' => __('Specify the H5 font properties.', 'redux-framework-demo'),
                    'output' => array('h5'),
                    'google' => true,
                    'default' => array(
                        'color' => '#161616',
                        'font-size' => '16px',
                        'font-family' => 'Open Sans',
                        'font-weight' => '500',
                    ),
                ),
                array(
                    'id' => 'ci_link_color',
                    'type' => 'link_color',
                    'title' => __('Link Color Option', 'redux-framework-demo'),
                    'subtitle' => __('Select custom link color', 'redux-framework-demo'),
                    //'desc' => __('This is the description field, again good for additional info.', 'redux-framework-demo'),
                    //'regular' => false, // Disable Regular Color
                    //'hover' => false, // Disable Hover Color
                    //'active' => false, // Disable Active Color
                    'default' => array(
                        'regular' => '#2a2a2a',
                        'hover' => '#4ecefe',
                        'active' => '#4ecefe',
                    ),
                )
            )
        );

        $sections[] = array(
            'icon' => 'fa fa-file-text-o',
            'icon_class' => 'icon-large',
            'title' => __('Blog', 'redux-framework-demo'),
            'fields' => array(
//                array(
//                    'id' => 'ci_blog_display',
//                    'type' => 'switch',
//                    'title' => __('Blog Excerpt or Content', 'redux-framework-demo'),
//                    'subtitle' => __('Toggle how your blog posts are displayed.', 'redux-framework-demo'),
//                    "default" => 1,
//                ),
                array(
                    'id' => 'ci_blog_meta',
                    'type' => 'switch',
                    'title' => __('Toggle blog post meta data.', 'redux-framework-demo'),
                    'subtitle' => __('Toggle how your blog posts are displayed.', 'redux-framework-demo'),
                    "default" => 1,
                ),
                array(
                    'id' => 'ci_blog_featured_img',
                    'type' => 'switch',
                    'title' => __('Featured Image', 'redux-framework-demo'),
                    'subtitle' => __('Toggle featured image.', 'redux-framework-demo'),
                    "default" => 1,
                ),
//                array(
//                    'id' => 'ci_learn_more_text',
//                    'type' => 'text',
//                    'title' => __('Learn More Text', 'redux-framework-demo'),
//                    'subtitle' => __('Learn more button text, default is Continue Reading.', 'redux-framework-demo'),
//                    'default' => 'Continue Reading'
//                ),
//                array(
//                    'id' => 'ci_blog_pagination',
//                    'type' => 'switch',
//                    'title' => __('Blog Pagination', 'redux-framework-demo'),
//                    'subtitle' => __('Toggle the ability to show pagination on your blog page.', 'redux-framework-demo'),
//                    "default" => 1,
//                ),
            )
        );


        $sections[] = array(
            'icon' => 'el-icon-cogs',
            'icon_class' => 'icon-large',
            'title' => __('Social', 'redux-framework-demo'),
            'fields' => array(
                array(
                    'id' => 'ci_social_facebook',
                    'type' => 'text',
                    'title' => __('Facebook Url', 'redux-framework-demo'),
                    'subtitle' => __('Enter your custom Facebook Url. Make sure to include http://', 'redux-framework-demo'),
                    'validate' => 'url',
                ),
                array(
                    'id' => 'ci_social_twitter',
                    'type' => 'text',
                    'title' => __('Twitter Url', 'redux-framework-demo'),
                    'subtitle' => __('Enter your custom Twitter Url. Make sure to include http://', 'redux-framework-demo'),
                    'validate' => 'url',
                ),
                array(
                    'id' => 'ci_social_linkedin',
                    'type' => 'text',
                    'title' => __('LinkedIn Url', 'redux-framework-demo'),
                    'subtitle' => __('Enter your custom linkedIn Url. Make sure to include http://', 'redux-framework-demo'),
                    'validate' => 'url',
                ),
                array(
                    'id' => 'ci_social_google',
                    'type' => 'text',
                    'title' => __('Google + Url', 'redux-framework-demo'),
                    'subtitle' => __('Enter your custom Google + Url. Make sure to include http://', 'redux-framework-demo'),
                    'validate' => 'url',
                ),
            )
        );


        

//        $sections[] = array(
//            'icon' => 'el-icon-info-sign',
//            'title' => __('Theme Documentation', 'redux-framework-demo'),
//            'desc' => __('
//                    <h2>WP Srapped</h2>
//                    <p>WP Strapped is a full responsive WordPress development framework and theme.  It comes packed with awesome features for developers and non developers alike making creating fully custom websites a breeze.</p>
//                    <h2> Theme Options </h2>
//                    <p>WP Strapped ships with an awesome theme options panel powered by <a href="http://reduxframework.com/" target="_blank">Redux Framework</a> an extremely powerful open source options framework for <a href="http://wordpress.org/" target="_blank">WordPress</a>.</p>
//
//<p>These options will give you the ability to change how your site looks and functions with extreme ease. To get to you options panel follow the steps bellow.</p>
//
//1.  Login to your WordPress website or blog.<br>
//2.  On the left hand side you will see Options at the very bottom of the navigation bar.<br>
//3.  Click that and you are on your way to customizing your theme!</p>
//                    <p class="description"></p>
//                    
//<h2> Page Templates </h2>
//<p>WP Strapped comes equipped with two page templates.</p>
//<p><strong>Default</strong><br>
//Default is a full page layout with no sidebars.</p>
//<p><strong>Two Column</strong><br>
//You guessed it, its a two column page template with a sidebar of your selection. We have give you the ability to apply any sidebar to you wish to this page template through our sidebar selection functionality located on the right hand side below the publish button!</p>', 'redux-framework-demo'),
//        );


//        if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
//            $tabs['docs'] = array(
//                'icon' => 'el-icon-book',
//                'icon_class' => 'icon-large',
//                'title' => __('Documentation', 'redux-framework-demo'),
//                'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
//            );
//        }

        global $ReduxFramework;
        $ReduxFramework = new ReduxFramework($sections, $args, $tabs);

        // END Sample Config
    }

    add_action('init', 'redux_init');
endif;

/**

  Custom function for filtering the sections array. Good for child themes to override or add to the sections.
  Simply include this function in the child themes functions.php file.

  NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
  so you must use get_template_directory_uri() if you want to use any of the built in icons

 * */
if (!function_exists('redux_add_another_section')):

    function redux_add_another_section($sections) {
        //$sections = array();
        $sections[] = array(
            'title' => __('Section via hook', 'redux-framework-demo'),
            'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
            'icon' => 'el-icon-paper-clip',
            'icon_class' => 'icon-large',
            // Leave this as a blank section, no options just some intro text set above.
            'fields' => array()
        );

        return $sections;
    }

    add_filter('redux/options/redux_demo/sections', 'redux_add_another_section');
// replace redux_demo with your opt_name
endif;
/**

  Filter hook for filtering the args array given by a theme, good for child themes to override or add to the args array.

 * */
if (!function_exists('redux_change_framework_args')):

    function redux_change_framework_args($args) {
        //$args['dev_mode'] = true;

        return $args;
    }

    add_filter('redux/options/redux_demo/args', 'redux_change_framework_args');
// replace redux_demo with your opt_name
endif;
/**

  Filter hook for filtering the default value of any given field. Very useful in development mode.

 * */
if (!function_exists('redux_change_option_defaults')):

    function redux_change_option_defaults($defaults) {
        $defaults['str_replace'] = "Testing filter hook!";

        return $defaults;
    }

    add_filter('redux/options/redux_demo/defaults', 'redux_change_option_defaults');
// replace redux_demo with your opt_name
endif;

/**

  Custom function for the callback referenced above

 */
if (!function_exists('redux_my_custom_field')):

    function redux_my_custom_field($field, $value) {
        print_r($field);
        print_r($value);
    }

endif;

/**

  Custom function for the callback validation referenced above

 * */
if (!function_exists('redux_validate_callback_function')):

    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        /*
          do your validation

          if(something) {
          $value = $value;
          } elseif(something else) {
          $error = true;
          $value = $existing_value;
          $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }

endif;
/**

  This is a test function that will let you see when the compiler hook occurs.
  It only runs if a field	set with compiler=>true is changed.

 * */
if (!function_exists('redux_test_compiler')):

    function redux_test_compiler($options, $css) {
        echo "<h1>The compiler hook has run!";
        //print_r($options); //Option values
        print_r($css); //So you can compile the CSS within your own file to cache
        $filename = dirname(__FILE__) . '/avada' . '.css';

        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once( ABSPATH . '/wp-admin/includes/file.php' );
            WP_Filesystem();
        }

        if ($wp_filesystem) {
            $wp_filesystem->put_contents(
                    $filename, $css, FS_CHMOD_FILE // predefined mode settings for WP files
            );
        }
    }

    add_filter('redux/options/redux_demo/compiler', 'redux_test_compiler', 10, 2);
// replace redux_demo with your opt_name
endif;


/**

  Remove all things related to the Redux Demo mode.

 * */
if (!function_exists('redux_remove_demo_options')):

    function redux_remove_demo_options() {

        // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
        remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));

        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if (class_exists('ReduxFrameworkPlugin')) {
            remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
        }
    }


	//add_action('init', 'redux_remove_demo_options');
endif;


function newIconFont() {
    wp_register_style(
        'redux-font-awesome',
        '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',
        array(),
        time(),
        'all'
    );  
    wp_enqueue_style( 'redux-font-awesome' );
}

add_action( 'redux/page/ci/enqueue', 'newIconFont' );



