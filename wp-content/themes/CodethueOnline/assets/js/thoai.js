jQuery(document).ready(function(){
/* Code here */  
jQuery('.ct-slider-product').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  dots: false,
  fade: true,
  asNavFor: '.slider-navi'
});
jQuery('.slider-navi').slick({
  slidesToShow: 9,
  slidesToScroll: 1,
  asNavFor: '.ct-slider-product',
  Vertical:true,
  arrows: false,
  dots: false,
  focusOnSelect: true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 9,
        slidesToScroll: 1,
        infinite: true,
        arrows: false,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 9,
        slidesToScroll: 1,
        arrows: false,
        dots: false
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 9,
        slidesToScroll: 1,
        Vertical:false,
        arrows: false,
      }
    }
  ]
});

if(jQuery('.ct-product-details .ct-slider-product').find('.slick-active')) {  
  jQuery('.ct-product-details .ct-slider-product').find('.slick-active').show();
}

jQuery(".ct-size-product li").toggle(
  function(){jQuery(this).css({"background": "#ffd600"});},
  function(){jQuery(this).css({"background": "#fff"});
}); 
/*So luong */
jQuery('.details-product .add').click(function () {
  if (jQuery(this).prev().val() < 10) {
    jQuery(this).prev().val(+jQuery(this).prev().val() + 1);
  }
});
jQuery('.details-product .sub').click(function () {
  if (jQuery(this).next().val() > 1) {
    if (jQuery(this).next().val() > 1) jQuery(this).next().val(+jQuery(this).next().val() - 1);
  }
});
/*---------------------end----------------------- */
});
