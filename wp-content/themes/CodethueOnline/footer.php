<?=get_template_part('sections/subscribe');?>
<footer class="footer__main">
<div class="ct__footer">  
  <div class="container">
    <div class="row-codethue">
        <div class="col-lg-3 col-md-3 col-sm-3 col-12 mb-3">
          <div class="logo-footer"> 
            <a href="<?php echo get_home_url(); ?>"><img src="<?php echo get_theme_mod('footer_logo');/*echo get_template_directory_uri();*/ ?>" alt="<?php echo get_the_title(); ?>"></a>
          </div>
          <div class="text_footer">
            <h3>thông tin liên hệ</h3>
            <?php echo get_theme_mod('footer_text');?>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-12 mb-3">
          <div class="text_footer">
            <h3>Hỗ trợ khách hàng</h3>
            <?php echo wp_nav_menu( array('theme_location' => 'support',));?>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-12 mb-3">
          <div class="text_footer">
            <h3>chính sách</h3>
            <?php echo wp_nav_menu( array('theme_location' => 'policy-menu',));?>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-12 mb-3">
          <div class="text_footer">
            <h3>fanpage</h3>
            <?php echo get_theme_mod('footer_text_fanpage');?>
          </div>
        </div>
    </div> 
  </div>
</div>
</footer>
<!-- CART -->
<button type="button" class="btn modal--cart" data-toggle="modal" data-target="#cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> (<span class="total-count"></span>)</button>
<!-- Modal -->
<?php get_template_part('sections/cart'); ?>
<!--      -->
<button id="back-to-Top" title="Về đầu trang"></button>
<script defer> var mybutton=document.getElementById("back-to-Top");function scrollFunction(){document.body.scrollTop>20||document.documentElement.scrollTop>20?mybutton.style.display="block":mybutton.style.display="none"}window.onscroll=function(){scrollFunction();scrollMenuSticky();};var header=document.getElementById("fixed-menu"),sticky=header.offsetTop;function scrollMenuSticky(){window.pageYOffset>sticky?header.classList.add("sticky"):header.classList.remove("sticky")}function showMobileMenu(){document.getElementById("mobile__Menu").classList.toggle("Mobile__menu");}</script>
<?php wp_footer(); ?>
	</body>
</html>
