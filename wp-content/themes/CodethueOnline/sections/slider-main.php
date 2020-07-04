<div class="banner__main">        
<div class="flexslider">
<!--<img src="echo get_template_directory_uri(); /assets/images/slider.jpg">-->
        <?php 
        if(isMobile()){ 
            echo '<ul class="slides isMobile">';
            while(have_rows( 'image_sliders_mobile' , 'option')) : the_row(); ?>
            <li class="pos-rel ct-item-main-slider"><img class="pos-rel" src="<?=get_sub_field('image','option')?>">
            <div class="ct-slider-Info">
                <div class="contentInSlider">
                    <div class="title-header">STORE : 192/2 Nguyễn Thái Bình - P12 - Tân Bình</div>
                    <div class="content-slider">"You're King In Your Way".!!!</div>
                    <div class="buttonclick">
                        <a href="https://kingshoes.vn/sale" tabindex="0">SHOP NOW <span class="fa fa-chevron-right" aria-hidden="true"></span></a>
                    </div>
                </div>
            </div>
            </li>
            <?php  endwhile; ?>
                </ul>
        <?php } else { echo '<ul class="slides">'; while(have_rows( 'image_sliders' , 'option')) : the_row(); ?><li><img src="<?=get_sub_field('image','option')?>"></li> <?php endwhile; } ?>
                            </ul>
</div>
</div>

