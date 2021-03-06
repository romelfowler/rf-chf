<?php

include($_SERVER['DOCUMENT_ROOT'] .'/wp-content/themes/culinaryhealthfund/includes/init.inc.php');

$urlPiece = explode(".", $_SERVER['HTTP_HOST']);
$urlPieceLength = count($urlPiece);
$currentLanguage = $urlPiece[0];

if ($_POST['language']) {
	 if ($_SERVER['PHP_ENV'] =="staging") {

                $siteURL['english'] = 'http://www.staging.culinaryhealthfund.org';
                $siteURL['spanish'] = 'http://esp.staging.culinaryhealthfund.org';
        } else {
                $siteURL['english'] = 'http://www.culinaryhealthfund.org';
                $siteURL['spanish'] = 'http://esp.culinaryhealthfund.org';
        }


	switch ($_POST['language']) {

		case 'www':
			redirect($siteURL['english']);
			die;
		break;

		case 'esp':
			redirect($siteURL['spanish']);
			die;
		break;

		case 'tag':
			//header('Location: ' . $siteURL['tagalog']);
		break;
	}

}

$languagesArr = array("www" => "English",
					  "esp" => "Spanish"
					  );


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
    <head profile="http://gmpg.org/xfn/11">

        <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/bootstrap/css/bootstrap.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-<?php echo $currentLanguage;?>.css" type="text/css" media="screen" />
        <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory');?>/images/CHF-logo.ico">

        <!-- DO NOT INCLUDE JAVASCRIPT HERE, ALL JAVASCRIPT NEEDS TO BE INCLUDE PROPERLY -->
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

        <?php do_action('ci_favicon'); ?>

        <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
        <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
        <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />

           <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <!--[if lt IE 9]>
                <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie8.css" />
        <![endif]-->

        <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

        <?php wp_head(); ?>
        </head>

        <body <?php body_class('body'); ?> >

        <!-- Header
        ================================================== -->
        <header>

        	<div class="container roof hidden-sm hidden-xs">

				<form method="post" action="<?php echo $_SERVER['REDIRECT_URL']; ?>">
            	<div class="row">
                    <span id="language">select a language</span>
                    <select name="language" style="width:150px;" onchange="this.form.submit();">
                        <?php echo getFormOptions($languagesArr, $currentLanguage); ?>
                    </select>
                </div>
                </form>

                <div class="row">

                	<?php include_once('header-top-' . $currentLanguage . '.php'); ?>

                    <div class="roof-search">
						<?php get_search_form(); ?>
                    </div>
                </div>
            </div>
            <div class="navbar-wrapper">
                <div class="navbar navbar-inverse <?php echo CI_Theme_Options::ci_header_class(); ?>" role="navigation">
                    <div class="container">
                    	<?php echo CI_Theme_Options::ci_get_theme_logo(); ?>
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <?php wp_nav_menu(array('menu' => 'Main')); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?php echo do_action('ci_after_header'); ?>
