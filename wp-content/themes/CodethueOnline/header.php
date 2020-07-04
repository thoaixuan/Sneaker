<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta property="og:image" content="<?php echo esc_url($featured_img_url); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
    <link rel="shortcut icon" href="<?php echo get_site_icon_url();?>" type="image/x-icon"/>
    <link rel="icon" href="<?php echo get_site_icon_url();?>" type="image/x-icon"/>
    <?php wp_head(); ?>
</head>
<body class="scroll__chrome">
<header>
<div class="header">    
    <div class="top--bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right center-mobile">
                    <p class="user-check d-inline"> <a href=""><i class="fa fa-users" aria-hidden="true"></i> Check User</a></p>
					<p class="hotline-top d-inline"> <i class="fa fa-phone hover--primary__Color"></i> Hotline: <a href="tel:0909300746">0909300746</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="navigation pos-rel" id="fixed-menu">
        <div class="container-fluid">
            <div class="navigation__column left">
                <div class="header__logo">
                    <?php  $custom_logo_id = get_theme_mod( 'custom_logo' );  $image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); ?>
                    <a href="<?php echo get_home_url(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title(); ?>"></a>
                </div>
            </div>
            <!-- menu-->
            <div class="navigation__column center mobile-hide">
                <div class="main__menu d-inline-block">
                <?php
                if(!isMobile()){ 
                 $mobilemenu=wp_nav_menu(array(
                    'menu' => 'Main Menu', 
                    'container_id' => 'cssmenu', 
                    'walker' => new CSS_Menu_Maker_Walker()
                    ));}
                ?>
                </div>
            </div>
            <!--Cart-->
            <div class="navigation__column right">
                <div class="d-inline-block header__right"><?php echo get_search_form();?></div>
            </div>
            <div class="navigation__column menu--mobile d-none text--center" onclick="showMobileMenu()">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
        </div>  
        <?php if(isMobile()){ ?>
            <div id="mobile__Menu" class="d-none">
                <?php wp_nav_menu(array(
                    'menu' => 'Main Menu', 
                    'container_id' => 'cssmenu', 
                    'walker' => new CSS_Menu_Maker_Walker()
                    ));/*echo do_shortcode('[get_menu menu="Main Menu"]');*/ ?></div>
        <?php } ?>
    </div>
</div>
</header>
