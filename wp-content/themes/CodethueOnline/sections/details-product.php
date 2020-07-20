<?php get_header(); ?>
<section class="ct-product-details pd-top-bot-20">
    <div class="container">
        <div class="row">
        <?php 
        if (have_posts()) : while(have_posts()) : the_post()
        ?>
        
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-6">
           
                <div class="col-lg-3 col-md-3 col-sm-3 mb-3">
                    
                    <div class="slider-navi">
                        <?php  while(have_rows('album-product')) : the_row();   ?>
                                    <div><img class="ct-img-item-product" src="<?=get_sub_field('image') ?>" alt=""></div>
                        <?php endwhile; ?>
                    </div>
                </div>
        
                <div class="col-lg-9 col-md-9 col-sm-9 mb-9 album-product">
                    <div class="ct-slider-product">
                    <?php  while(have_rows('album-product')) : the_row();   ?>
                                    <div><img class="ct-img-product pos-rel" src="<?=get_sub_field('image') ?>" alt="">  
                                    </div>
                    <?php endwhile; ?>
                </div>
                </div>
            </div>   
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-6">
                <div class="details-product">
                    <div class="ct-rate-product"><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star un-checked"></span></div>
                    <h1 class="text-up"><?=get_the_title()?></h1>
                    <h3 class="ps-product__price">   
                        <?php if(get_field("discount")){ echo format_Money(get_field("discount_price")).' VNĐ'; echo '<del> '.format_Money(get_field("price")).' VNĐ</del>';}else{echo format_Money(get_field("price")).' VNĐ';} ?> 
                    </h3>
                    <div class="ps-product__block ps-product__quickview">
                        <p><?=get_field("summary")?></p>
                    </div>
                    <hr>
                    <div class="ct-size-product">
                        <span class="text-up d--block text--bold">Chọn Size</span>
                        <ul>
                        <?php 
                        $values = get_field('size-products');
                        $field = get_field_object('size-products');
                        $choices = $field['choices'];
                        foreach ($choices as $value => $label) {
                           echo '<li class="size-product" data-size="'.$label.'">'.$label.'</li>';
                        }
                        ?>
                        </ul>
                    </div>
                    <hr>
                    <div id="quantity-cart">
                        <!--<button type="button" id="sub" class="sub">-</button>
                        <input type="number" readonly id="1" value="1" min="1" max="10" />
                        <button type="button" id="add" class="add">+</button>-->
                        <button data-name="<?=get_the_title()?>" data-price="<?php if(get_field("discount")){ echo get_field("discount_price");}
                        else{ echo get_field("price"); } ?>" data-size="" id="addtoCart">THÊM VÀO GIỎ HÀNG</button>
                    </div>
                    <div class="block_phone"><span class="text">Hoặc đặt mua: </span><a title="Tư vấn &amp; đặt hàng: 0909300746" href="tel:0909300746">0909300746</a> ( Tư vấn Miễn phí )
				    </div>
                    <div class="notify"><strong>Free Ship</strong> tại khu vực Hồ Chí Minh</div>
                </div>
            </div>
            <!-- info product -->
            <input id="img_product" type="hidden" value="<?php echo get_the_post_thumbnail_url();?>">
            <input id="link_product" type="hidden" value="<?php echo get_permalink(); ?>">
            <input id="size_product" type="hidden" value="">
            <!-- -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-12"> 
                <div class="details-product">
                    <?=get_field('details-product')?>
                </div>
            </div>   
        <?php endwhile; endif; ?>    
        </div>
    </div>
</section>

<?php get_footer();?>
