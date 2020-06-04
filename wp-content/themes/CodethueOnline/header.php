<!DOCTYPE html>
<html id="no_margin" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta property="og:image" content="<?php echo esc_url($featured_img_url); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" type="image/x-icon"/>
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" type="image/x-icon"/>
	  <meta name="google-site-verification" content="Ul_FLBCKB_b31pSXU_zQSn_0d1p8nIJsiWasy7p-byw"/>
    <?php wp_head(); ?>
</head>
<body>
<header>
<div class="header">    
    <div class="top--bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <p class="user-check d-inline"> <a href="thanh-vien"><i class="fa fa-users" aria-hidden="true"></i> Check User</a></p>
					<p class="hotline-top d-inline"> <i class="fa fa-phone"></i> Hotline: <a href="tel:0909300746">0909300746</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="navigation pos-rel">
        <div class="container-fluid">
            <div class="navigation__column left">
                <div class="header__logo">
                    <?php  $custom_logo_id = get_theme_mod( 'custom_logo' );  $image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); ?>
                    <a href="<?php echo get_home_url(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title(); ?>"></a>
                </div>
            </div>
            <!-- menu-->
            <div class="navigation__column center mobile-hide">
                <div class="main__menu d-inline-block"><?php echo do_shortcode('[get_menu menu="Main Menu"]'); ?></div>
            </div>
            <!--Cart-->
            <div class="navigation__column right">
                <div class="d-inline-block header__right"><?php echo get_search_form();?></div>
            </div>
        </div>
    </div>
</div>
</header>
