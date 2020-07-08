jQuery(document).ready(function(){
  
 jQuery("#back-to-Top").on('click', function(e) {
  e.preventDefault(); jQuery('html, body').animate({scrollTop:0}, '800');
});

jQuery(window).load(function() {
    jQuery('.flexslider').flexslider({
      controlNav: false,
      directionNav: true,
      /*prevText: "Quay lại",
      nextText: "Tiếp",*/
  });
  jQuery('.flexslider2').flexslider({
    animation: "slide",
    animationLoop: false,
    itemWidth: 210,
    itemMargin: 5,
    minItems: 2,
    maxItems: 4
  });
});
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
/*Add to list array when click size*/
var listSizeCart = [];    
jQuery('.size-product').on('click', function(e){
  e.preventDefault();    
  listSizeCart.push( jQuery(this).data('size') );
  /*console.log(listSizeCart.length);*/
  deduplicate(listSizeCart);
  jQuery("#size_product").val(deduplicate(listSizeCart));
  jQuery("#addtoCart").attr('data-size',deduplicate(listSizeCart));
});
function deduplicate(arr) {
  let isExist = (arr, x) => {
    for(let i = 0; i < arr.length; i++) {
      if (arr[i] === x) return true;
    }
    return false;
  }

  let ans = [];
  arr.forEach(element => {
    if(!isExist(ans, element)) ans.push(element);
  });
  return ans;
}
/*END to list array when click size*/
jQuery(".ct-size-product li").toggle(
  function(){jQuery(this).css({"background": "#ffd600"});
  /*console.log(deduplicate(listSizeCart)); when add an value in array*/
  jQuery("#size_product").val(deduplicate(listSizeCart));
  jQuery("#addtoCart").attr('data-size',deduplicate(listSizeCart));
},
  function(){
    jQuery(this).css({"background": "#fff"});
    var removeItem = jQuery(this).text();
    listSizeCart = jQuery.grep(listSizeCart, function(value) { return value != removeItem; });
    /*console.log(deduplicate(listSizeCart)); when remove an value in array*/
    jQuery("#size_product").val(deduplicate(listSizeCart));
    jQuery("#addtoCart").attr('data-size',deduplicate(listSizeCart));
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

/*---------------------end----------------------- --------------------------------------*/
});
