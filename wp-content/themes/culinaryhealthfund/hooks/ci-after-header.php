<?php

require_once(get_template_directory().'/classes/class-ci-theme-options.php');
require_once(get_template_directory().'/classes/class-ci-breadcrumbs.php');


add_action('ci_after_header', 'ci_breadcrumbs', 2);
function ci_breadcrumbs(){
    if(!is_front_page())
        new CI_Breadcrumbs();
}
